<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ApplicationWorkflowStatus;
use App\Models\Chapter;
use App\Models\ChapterInterviewAnswer;
use App\Models\EducationDetail;

class AdminController extends Controller
{
    public function index()
    {
        //dd('Reached admin home');
        return view('admin.home');
    }

    public function apexStage1Approved()
    {
        // Get users where final_status = 'approved'
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('apex_1_status', 'approved');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.apex.stage1.approved', compact('users'));
    }

    public function apexStage1Pending()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'apex_1')
                      ->where('final_status', 'in_progress');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        return view('admin.apex.stage1.pending', compact('users'));
    }


    public function apexStage1Hold()
    {
        // Get users where final_status = 'rejected'
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('final_status', 'rejected');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.apex.stage1.hold', compact('users'));
    }

    public function apexStage1UserDetail(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        return view('admin.apex.stage1.user_detail', compact('user'));
    }

    public function approveStage(Request $request, User $user, $stage)
{
    // Validation
    $rules = [
        'admin_remark' => 'nullable|string|max:2000',
    ];

    if ($stage === 'chapter') {
        $rules['assistance_amount'] = 'required|numeric|min:0';
    }

    $request->validate($rules);

    $workflow = $user->workflowStatus;

    if (!$workflow) {
        return back()->with('error', 'Workflow not found');
    }

    if ($workflow->current_stage !== $stage) {
        return back()->with('error', 'Invalid stage');
    }

    // Prepare update fields
    $statusField = $stage . '_status';
    $updatedAtField = $stage . '_updated_at';
    $remarksField = $stage . '_approval_remarks';

    $updateData = [
        $statusField => 'approved',
        $updatedAtField => now(),
        $remarksField => $request->admin_remark,
    ];

    // Chapter assistance amount
    if ($stage === 'chapter') {
        $updateData[$stage . '_assistance_amount'] = $request->assistance_amount;
    }

    // Stage progression
    switch ($stage) {
        case 'apex_1':
            $updateData['current_stage'] = 'chapter';
            break;

        case 'chapter':
            $updateData['current_stage'] = 'working_committee';
            break;

        case 'working_committee':
            $updateData['current_stage'] = 'apex_2';
            break;

        case 'apex_2':
            $updateData['final_status'] = 'approved';
            break;

        default:
            return back()->with('error', 'Invalid stage');
    }

    $workflow->update($updateData);

    return back()->with(
        'success',
        ucfirst(str_replace('_', ' ', $stage)) . ' stage approved successfully'
    );
}


    private function checkAllStepsApproved(User $user)
    {
        // Check if all required steps are approved
        $steps = [
            'personal' => $user->submit_status === 'approved',
            'education' => $user->educationDetail && $user->educationDetail->submit_status === 'approved',
            'family' => $user->familyDetail && $user->familyDetail->submit_status === 'approved',
            'funding' => $user->fundingDetail && $user->fundingDetail->submit_status === 'approved',
            'guarantor' => $user->guarantorDetail && $user->guarantorDetail->submit_status === 'approved',
            'documents' => $user->document && $user->document->submit_status === 'approved',
            'final' => $user->document && $user->document->submit_status === 'approved', // Final uses same table as documents
        ];

        return !in_array(false, $steps, true); // Return true if all steps are true
    }

    public function rejectStage(Request $request, User $user, $stage)
    {
        $request->validate([
            'admin_remark' => 'required|string|max:2000',
            'resubmit_steps' => 'nullable|array',
            'resubmit_steps.*' => 'in:personal,education,family,funding,guarantor,documents,final',
        ]);

        $workflow = $user->workflowStatus;
        if (!$workflow) {
            return back()->with('error', 'Workflow not found');
        }

        if ($workflow->current_stage !== $stage) {
            return back()->with('error', 'Invalid stage');
        }

        $resubmitSteps = $request->input('resubmit_steps', []);

        if (!empty($resubmitSteps)) {
            // Handle selective resubmission
            $resubmissionCount = 0;
            foreach ($resubmitSteps as $step) {
                if ($step === 'personal') {
                    // Handle personal details (users table)
                    $user->update([
                        'submit_status' => 'resubmit',
                        'admin_remark' => $request->admin_remark,
                        'updated_at' => now(),
                    ]);
                    $resubmissionCount++;
                    Log::info("Personal details marked for resubmission for user {$user->id}");
                } else {
                    // Handle other steps
                    $stepTableMap = [
                        'education' => 'educationDetail',
                        'family' => 'familyDetail',
                        'funding' => 'fundingDetail',
                        'guarantor' => 'guarantorDetail',
                        'documents' => 'document',
                        'final' => 'document', // Final submission also uses document table
                    ];

                    if (isset($stepTableMap[$step])) {
                        $tableRelation = $stepTableMap[$step];
                        if ($user->$tableRelation) {
                            $user->$tableRelation->update([
                                'submit_status' => 'resubmit',
                                'admin_remark' => $request->admin_remark,
                                'updated_at' => now(),
                            ]);
                            $resubmissionCount++;
                            Log::info("Step {$step} marked for resubmission for user {$user->id}");
                        }
                    }
                }
            }

            // Update workflow stage status to rejected but keep final_status as in_progress
            $statusField = $stage . '_status';
            $rejectRemarksField = $stage . '_reject_remarks';
            $updatedAtField = $stage . '_updated_at';

            $workflow->update([
                $statusField => 'rejected',
                $rejectRemarksField => $request->admin_remark,
                $updatedAtField => now(),
                // Keep final_status as 'in_progress' for resubmission
            ]);

            return back()->with('success', "{$resubmissionCount} step(s) marked for resubmission");
        } else {
            // Complete rejection (original behavior)
            $statusField = $stage . '_status';
            $rejectRemarksField = $stage . '_reject_remarks';
            $updatedAtField = $stage . '_updated_at';

            $workflow->update([
                $statusField => 'rejected',
                $rejectRemarksField => $request->admin_remark,
                $updatedAtField => now(),
                'final_status' => 'rejected',
            ]);

            return back()->with('success', ucfirst(str_replace('_', ' ', $stage)) . " rejected");
        }
    }

    public function chapterPending()
    {
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'chapter')
                      ->where('final_status', 'in_progress');
            });
        if(request('chapter_id')){
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        return view('admin.chapters.stage2.pending', compact('users'));
    }

    public function chapterApproved()
    {
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'approved');
            });
        if(request('chapter_id')){
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.approved', compact('users'));
    }

    public function chapterHold()
    {
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'rejected');
            });
        if(request('chapter_id')){
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.hold', compact('users'));
    }

    public function chapterUserDetail(User $user)
    {
        $inter_date = ChapterInterviewAnswer::where('user_id', $user->id)->where('question_no',1)->first();
        $data = EducationDetail::where('user_id', $user->id)->first();
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        return view('admin.chapters.stage2.user_detail', compact('user','data','inter_date'));
    }

    // Chapter Interview Methods
    public function saveChapterInterview(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'workflow_id' => 'required|exists:application_workflow_statuses,id',
            'answers' => 'required|array',
            'answers.*.question_no' => 'required|integer|min:1|max:15',
            'answers.*.question_text' => 'required|string',
            'answers.*.answer_text' => 'required|string',
            'answered_by' => 'required|in:admin,chapter',
        ]);

        try {
            $savedAnswers = [];

            foreach ($request->answers as $answer) {
                $savedAnswers[] = ChapterInterviewAnswer::updateOrCreate(
                    [
                        'user_id' => $request->user_id,
                        'workflow_id' => $request->workflow_id,
                        'question_no' => $answer['question_no'],
                    ],
                    [
                        'question_text' => $answer['question_text'],
                        'answer_text' => $answer['answer_text'],
                        'answered_by' => $request->answered_by,
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Interview answers saved successfully',
                'saved_count' => count($savedAnswers)
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving chapter interview answers: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save interview answers'
            ], 500);
        }
    }

    public function getChapterInterviewAnswers($userId, $workflowId)
    {
        try {
            $answers = ChapterInterviewAnswer::where('user_id', $userId)
                ->where('workflow_id', $workflowId)
                ->orderBy('question_no')
                ->get(['question_no', 'question_text', 'answer_text', 'answered_by']);

            return response()->json($answers);

        } catch (\Exception $e) {
            Log::error('Error retrieving chapter interview answers: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to retrieve interview answers'
            ], 500);
        }
    }

    public function totalApplications()
    {
        $users = User::with('workflowStatus')->where('role', 'user')->get();
        return view('admin.total_applications', compact('users'));
    }

    public function totalHold()
    {
        $users = User::with('workflowStatus')->where('role', 'user')->whereHas('workflowStatus', function($q) { $q->where('final_status', 'rejected'); })->get();
        return view('admin.total_hold', compact('users'));
    }

    public function chapterStats()
    {
        $chapters = Chapter::all();
        return view('admin.chapters.stats', compact('chapters'));
    }

    public function chapterDetails(Chapter $chapter)
    {
        return view('admin.chapters.chapter_details', compact('chapter'));
    }

    public function chapterTotalApplied()
    {
        $chapter_id = request('chapter_id');
        $users = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.approved', compact('users')); // Reuse existing view
    }

    public function chapterDraft()
    {
        $chapter_id = request('chapter_id');
        $users = User::where('role', 'user')
    ->where('chapter_id', $chapter_id)
    ->where('application_status', 'draft')
    ->get();


        return view('admin.chapters.stage2.pending', compact('users')); // Reuse existing view
    }

    public function chapterApexPending()
    {
        $chapter_id = request('chapter_id');
        $users = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->where('submit_status', 'submited')
            ->where('application_status', 'submitted')
            ->whereHas('workflowStatus', function($q) {
                $q->where('apex_1_status', 'pending');
            })
            ->get();
        return view('admin.chapters.stage2.pending', compact('users')); // Reuse existing view
    }

    public function chapterWorkingCommitteePending()
    {
        $chapter_id = request('chapter_id');
         $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'approved')
                ->where('working_committee_status', 'pending');
            });

        if(request('chapter_id')){
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.pending', compact('users')); // Reuse existing view
    }

    public function chapterResubmit()
    {
        $chapter_id = request('chapter_id');
        $users = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function($q) {
                $q->where('apex_1_status', 'rejected');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.hold', compact('users')); // Reuse existing view
    }

    public function chapterUserDashboard()
    {
        $chapterUser = Auth::guard('chapter')->user();

      
        if (!$chapterUser) {
            return redirect()->back()->with('error', 'Chapter user not authenticated.');
        }
        $chapter_id = $chapterUser->id;
        $chapter = $chapterUser;


        // Get statistics for this chapter
        $total_applied = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->count();

        $approved = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'approved');
            })
            ->count();

        $pending = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function($q) {
                $q->where('current_stage', 'chapter')
                ->where('final_status', 'in_progress');
            })
            ->count();

        $hold = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'rejected');
            })
            ->count();

        // Get recent users from this chapter who are at chapter stage
        $users = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function($q) {
                $q->whereIn('current_stage', ['chapter', 'working_committee', 'apex_2']);
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.chapters.stage2.user_details_each_chapter', compact('users', 'total_applied', 'approved', 'pending', 'hold', 'chapter', 'chapter_id'));
    }

}
