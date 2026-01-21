<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $rules = [
            'admin_remark' => 'nullable|string|max:2000',
            'approved_steps' => 'required|array|min:1',
            'approved_steps.*' => 'in:personal,education,family,funding,guarantor,documents,final',
        ];

        // Add assistance_amount validation for chapter stage
        if ($stage === 'chapter') {
            $rules['assistance_amount'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $approvedSteps = $request->input('approved_steps', []);

        if (empty($approvedSteps)) {
            return back()->with('error', 'At least one step must be selected for approval');
        }

        $workflow = $user->workflowStatus;
        if (!$workflow) {
            return back()->with('error', 'Workflow not found');
        }

        if ($workflow->current_stage !== $stage) {
            return back()->with('error', 'Invalid stage');
        }

        // Handle selective step approval
        $approvalCount = 0;
        foreach ($approvedSteps as $step) {
            if ($step === 'personal') {
                // Handle personal details (users table)
                $user->update([
                    'submit_status' => 'approved',
                    'admin_remark' => $request->admin_remark,
                    'updated_at' => now(),
                ]);
                $approvalCount++;
                Log::info("Personal details approved for user {$user->id}");
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
                            'submit_status' => 'approved',
                            'admin_remark' => $request->admin_remark,
                            'updated_at' => now(),
                        ]);
                        $approvalCount++;
                        Log::info("Step {$step} approved for user {$user->id}");
                    }
                }
            }
        }

        // Check if all steps are approved to move to next stage
        $allStepsApproved = $this->checkAllStepsApproved($user);

        if ($allStepsApproved) {
            // Move to next stage or set final approved
            $stages = ['apex_1', 'chapter', 'working_committee', 'apex_2'];
            $currentStage = trim($workflow->current_stage);
            $currentIndex = array_search($currentStage, $stages);

            Log::info("All steps approved - moving to next stage. current_stage='{$currentStage}', stage_param='{$stage}', currentIndex={$currentIndex}");

            $statusField = $stage . '_status';
            $updatedAtField = $stage . '_updated_at';
            $approvalRemarksField = $stage . '_approval_remarks';

            $updateData = [
                $statusField => 'approved',
                $updatedAtField => now(),
                $approvalRemarksField => $request->admin_remark,
            ];

            // Add assistance_amount for chapter stage
            if ($stage === 'chapter') {
                $updateData[$stage . '_assistance_amount'] = $request->assistance_amount;
            }

            if ($currentStage === 'apex_1' && $stage === 'apex_1') {
                $updateData['current_stage'] = 'chapter';
                Log::info("Apex 1 approved - moving to chapter stage");
            } elseif ($currentStage === 'chapter' && $stage === 'chapter') {
                $updateData['current_stage'] = 'working_committee';
                Log::info("Chapter approved - moving to working_committee stage");
            } elseif ($currentStage === 'working_committee' && $stage === 'working_committee') {
                $updateData['current_stage'] = 'apex_2';
                Log::info("Working Committee approved - moving to apex_2 stage");
            } elseif ($currentStage === 'apex_2' && $stage === 'apex_2') {
                $updateData['final_status'] = 'approved';
                Log::info("Apex 2 approved - final approval granted");
            } else {
                Log::error("Invalid stage progression: current_stage='{$currentStage}', stage_param='{$stage}', currentIndex={$currentIndex}");
                return back()->with('error', 'Invalid stage progression');
            }

            Log::info("About to update workflow", $updateData);
            $workflow->update($updateData);
            $workflow->refresh(); // Refresh to get updated data
            Log::info("After update: current_stage={$workflow->current_stage}, final_status={$workflow->final_status}");

            return back()->with('success', "All steps approved successfully. " . ucfirst(str_replace('_', ' ', $stage)) . " stage completed.");
        } else {
            // Update workflow stage status to approved but keep current stage
            $statusField = $stage . '_status';
            $updatedAtField = $stage . '_updated_at';
            $approvalRemarksField = $stage . '_approval_remarks';

            $workflow->update([
                $statusField => 'approved',
                $updatedAtField => now(),
                $approvalRemarksField => $request->admin_remark,
                // Keep current_stage and final_status as is
            ]);

            return back()->with('success', "{$approvalCount} step(s) approved successfully");
        }
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
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'chapter')
                      ->where('final_status', 'in_progress');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        return view('admin.chapters.stage2.pending', compact('users'));
    }

    public function chapterApproved()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'approved');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.approved', compact('users'));
    }

    public function chapterHold()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function($q) {
                $q->where('chapter_status', 'rejected');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
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

}
