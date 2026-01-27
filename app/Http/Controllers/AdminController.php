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
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.home', ['activeGuard' => $request->active_guard]);
    }

    public function apexStage1Approved()
    {
        // Get users where final_status = 'approved'
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
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
                    ->where('apex_1_status', 'pending');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        return view('admin.apex.stage1.pending', compact('users'));
    }


    public function apexStage1Hold()
    {
        // Get users where final_status = 'rejected'
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('apex_1_status', 'rejected');
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
        //   dd($request->all());
        $rules = [
            'admin_remark' => 'nullable|string|max:2000',
            'apex_staff_remark' => 'nullable|string|max:2000',
        ];

        if ($stage === 'chapter') {
            $rules['assistance_amount'] = 'required|numeric|min:0';
            $rules['interview_date'] = 'required|date';
        }

        $request->validate($rules);

        $workflow = $user->workflowStatus;

        if (!$workflow) {
            return back()->with('error', 'Workflow not found');
        }

        if ($stage === 'chapter') {
            $interviewCount = \App\Models\ChapterInterviewAnswer::where('user_id', $user->id)->where('workflow_id', $workflow->id)->count();
            Log::info("Chapter approval attempt - User: {$user->id}, Workflow: {$workflow->id}, Interview count: {$interviewCount}");
            if ($interviewCount < 15) {
                Log::info("Chapter approval blocked - insufficient interviews for user {$user->id}");
                return back()->with('error', 'Please submit interview answers first.');
            }
        }

        if ($workflow->current_stage !== $stage) {
            Log::info("Stage mismatch - Current: {$workflow->current_stage}, Requested: {$stage}");
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
            'apex_staff_remark' => $request->apex_staff_remark,
        ];

        // Chapter assistance amount and interview date
        if ($stage === 'chapter') {
            $updateData[$stage . '_assistance_amount'] = $request->assistance_amount;
            $updateData[$stage . '_interview_date'] = $request->interview_date;
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

    public function approveWorkingCommittee(Request $request, User $user, $stage)
    {
        // Validation for working committee specific fields
        //  dd($request->all());
        $rules = [
            'w_c_approval_remark' => 'required|string|max:2000',
            'w_c_approval_date' => 'required|date',
            'meeting_no' => 'required|string|max:255',
            'disbursement_system' => 'required|in:yearly,half_yearly',
            'approval_financial_assistance_amount' => 'required|numeric|min:0',
            'installment_amount' => 'nullable|numeric|min:0',
            'additional_installment_amount' => 'nullable|numeric|min:0',
            'repayment_type' => 'required|in:yearly,half_yearly,quarterly,monthly',
            'no_of_cheques_to_be_collected' => 'nullable|integer|min:1',
            'repayment_starting_from' => 'nullable|date',
            'remarks_for_approval' => 'nullable|string|max:2000',
        ];

        // Conditional validation based on disbursement system
        if ($request->disbursement_system === 'yearly') {
            $rules['disbursement_in_year'] = 'required|integer|min:1|max:6';
            $rules['yearly_dates'] = 'required|array|min:1';
            $rules['yearly_dates.*'] = 'required|date';
            $rules['yearly_amounts'] = 'required|array|min:1';
            $rules['yearly_amounts.*'] = 'required|numeric|min:0';
        } elseif ($request->disbursement_system === 'half_yearly') {
            $rules['disbursement_in_half_year'] = 'required|integer|min:1|max:12';
            $rules['half_yearly_dates'] = 'required|array|min:1';
            $rules['half_yearly_dates.*'] = 'required|date';
            $rules['half_yearly_amounts'] = 'required|array|min:1';
            $rules['half_yearly_amounts.*'] = 'required|numeric|min:0';
        }

        $request->validate($rules);

        $workflow = $user->workflowStatus;

        if (!$workflow) {
            return back()->with('error', 'Workflow not found');
        }

        if ($workflow->current_stage !== $stage) {
            return back()->with('error', 'Invalid stage');
        }

        // Prepare update data for workflow status
        $updateData = [
            'working_committee_status' => 'approved',
            'working_committee_updated_at' => now(),
            'working_committee_approval_remarks' => $request->w_c_approval_remark,
            'working_committee_remarks' => $request->remarks_for_approval,
            'working_committee_assistance_amount' => $request->approval_financial_assistance_amount,
            'current_stage' => 'apex_2', // Move to next stage
        ];

        // Save working committee specific data
        // Note: These fields may need to be added to the database table if they don't exist
        $workingCommitteeData = [
            'w_c_approval_remark' => $request->w_c_approval_remark,
            'w_c_approval_date' => $request->w_c_approval_date,
            'meeting_no' => $request->meeting_no,
            'disbursement_system' => $request->disbursement_system,
            'approval_financial_assistance_amount' => $request->approval_financial_assistance_amount,
            'installment_amount' => $request->installment_amount,
            'additional_installment_amount' => $request->additional_installment_amount,
            'repayment_type' => $request->repayment_type,
            'no_of_cheques_to_be_collected' => $request->no_of_cheques_to_be_collected,
            'repayment_starting_from' => $request->repayment_starting_from,
            'remarks_for_approval' => $request->remarks_for_approval,
            'processed_by' => Auth::user()->name,
        ];

        // Handle disbursement arrays
        if ($request->disbursement_system === 'yearly') {
            $workingCommitteeData['disbursement_in_year'] = $request->disbursement_in_year;
            $workingCommitteeData['yearly_dates'] = json_encode($request->yearly_dates);
            $workingCommitteeData['yearly_amounts'] = json_encode($request->yearly_amounts);
        } elseif ($request->disbursement_system === 'half_yearly') {
            $workingCommitteeData['disbursement_in_half_year'] = $request->disbursement_in_half_year;
            $workingCommitteeData['half_yearly_dates'] = json_encode($request->half_yearly_dates);
            $workingCommitteeData['half_yearly_amounts'] = json_encode($request->half_yearly_amounts);
        }

        // Update workflow status
        $workflow->update($updateData);

        // Save working committee specific data
        try {
            $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::create([
                'user_id' => $user->id,
                'w_c_approval_remark' => $request->w_c_approval_remark,
                'w_c_approval_date' => $request->w_c_approval_date,
                'meeting_no' => $request->meeting_no,
                'disbursement_system' => $request->disbursement_system,
                'disbursement_in_year' => $request->disbursement_in_year ?? null,
                'disbursement_in_half_year' => $request->disbursement_in_half_year ?? null,
                'yearly_dates' => $request->yearly_dates ?? null,
                'yearly_amounts' => $request->yearly_amounts ?? null,
                'half_yearly_dates' => $request->half_yearly_dates ?? null,
                'half_yearly_amounts' => $request->half_yearly_amounts ?? null,
                'approval_financial_assistance_amount' => $request->approval_financial_assistance_amount,
                'installment_amount' => $request->installment_amount,
                'additional_installment_amount' => $request->additional_installment_amount,
                'repayment_type' => $request->repayment_type,
                'no_of_cheques_to_be_collected' => $request->no_of_cheques_to_be_collected,
                'repayment_starting_from' => $request->repayment_starting_from,
                'remarks_for_approval' => $request->remarks_for_approval,
                'processed_by' => Auth::user()->id, // Save user ID instead of name
                'approval_status' => 'approved',
            ]);

            Log::info('Working Committee Approval Created Successfully', [
                'user_id' => $user->id,
                'approval_id' => $workingCommitteeApproval->id,
                'connection' => $workingCommitteeApproval->getConnectionName(),
            ]);

            return back()->with('success', 'Working Committee approval completed successfully');
        } catch (\Exception $e) {
            Log::error('Working Committee Approval Creation Failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Failed to save working committee approval data: ' . $e->getMessage());
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
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'chapter')
                    ->where('final_status', 'in_progress');
            });
        if (request('chapter_id')) {
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        return view('admin.chapters.stage2.pending', compact('users'));
    }

    public function chapterApproved()
    {
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('chapter_status', 'approved');
            });
        if (request('chapter_id')) {
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.approved', compact('users'));
    }

    public function chapterHold()
    {
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('chapter_status', 'rejected');
            });
        if (request('chapter_id')) {
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.chapters.stage2.hold', compact('users'));
    }

    public function chapterUserDetail(User $user)
    {
        $inter_date = ChapterInterviewAnswer::where('user_id', $user->id)->where('question_no', 1)->first();
        $data = EducationDetail::where('user_id', $user->id)->first();
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        return view('admin.chapters.stage2.user_detail', compact('user', 'data', 'inter_date'));
    }

    public function workingCommitteeApproved()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'approved');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.working_committee.approved', compact('users'));
    }

    public function workingCommitteePending()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'working_committee')
                    ->where('final_status', 'in_progress');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        return view('admin.working_committee.pending', compact('users'));
    }

    public function workingCommitteeHold()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'rejected');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();
        return view('admin.working_committee.hold', compact('users'));
    }

    public function workingCommitteeUserDetail(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();
        return view('admin.working_committee.user_detail', compact('user', 'workingCommitteeApproval'));
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
        $users = User::with('workflowStatus')->where('role', 'user')->whereHas('workflowStatus', function ($q) {
            $q->where('final_status', 'rejected');
        })->get();
        return view('admin.total_hold', compact('users'));
    }

    public function workingCommitteeStats(Request $request)
    {
        // Get statistics for working committee
        $total_applied = \App\Models\User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('current_stage', 'working_committee');
            })
            ->count();

        $approved = \App\Models\User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'approved');
            })
            ->count();

        $pending = \App\Models\User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('current_stage', 'working_committee')
                    ->where('final_status', 'in_progress');
            })
            ->count();

        $hold = \App\Models\User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'rejected');
            })
            ->count();

        $conversion = $total_applied > 0 ? round(($approved / $total_applied) * 100, 1) : 0;

        return view('admin.working_committee.stats', compact('total_applied', 'approved', 'pending', 'hold', 'conversion'));
    }

    public function chapterStats(Request $request)
    {
        if ($request->active_guard === 'chapter') {
            $chapters = collect([Auth::user()]);
        } else {
            $chapters = Chapter::all();
        }

        // Get statistics for each chapter
        $chapterStats = [];
        foreach ($chapters as $chapter) {
            $chapter_id = $chapter->id;

            $stats = [
                'chapter' => $chapter,
                'total_applied' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->count(),

                'approved' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('chapter_status', 'approved');
                    })
                    ->count(),

                'pending' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('current_stage', 'chapter')
                            ->where('final_status', 'in_progress');
                    })
                    ->count(),

                'hold' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('chapter_status', 'rejected');
                    })
                    ->count(),

                'apex_approved' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('apex_1_status', 'approved');
                    })
                    ->count(),

                'working_committee' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('current_stage', 'working_committee');
                    })
                    ->count(),

                'apex_2' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('current_stage', 'apex_2');
                    })
                    ->count(),

                'final_approved' => User::where('role', 'user')
                    ->where('chapter_id', $chapter_id)
                    ->whereHas('workflowStatus', function ($q) {
                        $q->where('final_status', 'approved');
                    })
                    ->count(),
            ];

            // Calculate conversion rates
            $stats['chapter_conversion'] = $stats['total_applied'] > 0 ? round(($stats['approved'] / $stats['total_applied']) * 100, 1) : 0;
            $stats['overall_conversion'] = $stats['total_applied'] > 0 ? round(($stats['final_approved'] / $stats['total_applied']) * 100, 1) : 0;

            $chapterStats[] = $stats;
        }

        return view('admin.chapters.stats', compact('chapterStats'));
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
            ->whereHas('workflowStatus', function ($q) {
                $q->where('apex_1_status', 'pending');
            })
            ->get();
        return view('admin.chapters.stage2.pending', compact('users')); // Reuse existing view
    }

    public function chapterWorkingCommitteePending()
    {
        $chapter_id = request('chapter_id');
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('chapter_status', 'approved')
                    ->where('working_committee_status', 'pending');
            });

        if (request('chapter_id')) {
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
            ->whereHas('workflowStatus', function ($q) {
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
            ->whereHas('workflowStatus', function ($q) {
                $q->where('chapter_status', 'approved');
            })
            ->count();

        $pending = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function ($q) {
                $q->where('current_stage', 'chapter')
                    ->where('final_status', 'in_progress');
            })
            ->count();

        $hold = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function ($q) {
                $q->where('chapter_status', 'rejected');
            })
            ->count();

        // Get recent users from this chapter who are at chapter stage
        $users = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->whereHas('workflowStatus', function ($q) {
                $q->whereIn('current_stage', ['chapter', 'working_committee', 'apex_2']);
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.chapters.stage2.user_details_each_chapter', compact('users', 'total_applied', 'approved', 'pending', 'hold', 'chapter', 'chapter_id'));
    }

    public function generateApplicationPDF(User $user)
    {
        // Load all related data
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);

        $workflow = $user->workflowStatus;
        $educationDetail = $user->educationDetail;
        $familyDetail = $user->familyDetail;
        $fundingDetail = $user->fundingDetail;
        $guarantorDetail = $user->guarantorDetail;
        $document = $user->document;

        // Generate PDF
        $pdf = Pdf::loadView('pdf.jeap-application', compact(
            'user',
            'workflow',
            'educationDetail',
            'familyDetail',
            'fundingDetail',
            'guarantorDetail',
            'document'
        ));

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Return PDF download
        $filename = 'JEAP_Application_' . $user->name . '_' . $user->id . '.pdf';
        return $pdf->stream($filename);
    }

    public function generateSummaryPDF(User $user)
    {
        // Load all related data
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);

        $workflow = $user->workflowStatus;
        $educationDetail = $user->educationDetail;
        $familyDetail = $user->familyDetail;
        $fundingDetail = $user->fundingDetail;
        $guarantorDetail = $user->guarantorDetail;
        $document = $user->document;

        // Get working committee approval data
        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();

        // Generate PDF
        $pdf = Pdf::loadView('pdf.jeap-summary', compact(
            'user',
            'workflow',
            'educationDetail',
            'familyDetail',
            'fundingDetail',
            'guarantorDetail',
            'document',
            'workingCommitteeApproval'
        ));

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Return PDF download
        $filename = 'JEAP_Summary_' . $user->name . '_' . $user->id . '.pdf';
        return $pdf->stream($filename);
    }

}
