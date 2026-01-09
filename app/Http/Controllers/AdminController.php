<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        //dd('Reached admin home');
        return view('admin.home');
    }

    public function apexStage1Approved()
    {
        // Get users where ALL 7 forms have submit_status = 'approved' and role = 'user'
        $users = User::where('role', 'user')
            ->whereHas('familyDetail', function($q) {
                $q->where('submit_status', 'approved');
            })
            ->whereHas('educationDetail', function($q) {
                $q->where('submit_status', 'approved');
            })
            ->whereHas('fundingDetail', function($q) {
                $q->where('submit_status', 'approved');
            })
            ->whereHas('guarantorDetail', function($q) {
                $q->where('submit_status', 'approved');
            })
            ->whereHas('document', function($q) {
                $q->where('submit_status', 'approved');
            })
            ->whereHas('document', function($q) {
                $q->where('submit_status', 'approved');
            })
            ->where('submit_status', 'approved')
            ->with('familyDetail')
            ->get();
        return view('admin.apex.stage1.approved', compact('users'));
    }

    public function apexStage1Pending()
    {
        $users = User::where('role', 'user')
            ->where(function ($query) {

                // User main submit status
                $query->whereIn('submit_status', ['pending', 'submited']);

                // Education
                $query->orWhere(function ($q) {
                    $q->whereHas('educationDetail', function ($qq) {
                        $qq->where('submit_status', 'submited');
                    })->orWhereDoesntHave('educationDetail');
                });

                // Family
                $query->orWhere(function ($q) {
                    $q->whereHas('familyDetail', function ($qq) {
                        $qq->where('submit_status', 'submited');
                    })->orWhereDoesntHave('familyDetail');
                });

                // Funding
                $query->orWhere(function ($q) {
                    $q->whereHas('fundingDetail', function ($qq) {
                        $qq->where('submit_status', 'submited');
                    })->orWhereDoesntHave('fundingDetail');
                });

                // Guarantor
                $query->orWhere(function ($q) {
                    $q->whereHas('guarantorDetail', function ($qq) {
                        $qq->where('submit_status', 'submited');
                    })->orWhereDoesntHave('guarantorDetail');
                });

                // Documents
                $query->orWhere(function ($q) {
                    $q->whereHas('document', function ($qq) {
                        $qq->where('submit_status', 'submited');
                    })->orWhereDoesntHave('document');
                });

            })
            ->with([
                'educationDetail',
                'familyDetail',
                'fundingDetail',
                'guarantorDetail',
                'document'
            ])
            ->get();

        return view('admin.apex.stage1.pending', compact('users'));
    }


    public function apexStage1Hold()
    {
        // Get users who have ANY form on hold (resubmit) and role = 'user'
        $users = User::where('role', 'user')
            ->where(function($query) {
                $query->where('submit_status', 'resubmit')
                    ->orWhere(function($q) {
                        $q->whereHas('educationDetail', function($qq) {
                            $qq->where('submit_status', 'resubmit');
                        });
                    })
                    ->orWhere(function($q) {
                        $q->whereHas('familyDetail', function($qq) {
                            $qq->where('submit_status', 'resubmit');
                        });
                    })
                    ->orWhere(function($q) {
                        $q->whereHas('fundingDetail', function($qq) {
                            $qq->where('submit_status', 'resubmit');
                        });
                    })
                    ->orWhere(function($q) {
                        $q->whereHas('guarantorDetail', function($qq) {
                            $qq->where('submit_status', 'resubmit');
                        });
                    })
                    ->orWhere(function($q) {
                        $q->whereHas('document', function($qq) {
                            $qq->where('submit_status', 'resubmit');
                        });
                    });
            })
            ->with('familyDetail')
            ->get();
        return view('admin.apex.stage1.hold', compact('users'));
    }

    public function apexStage1UserDetail(User $user)
    {
        $user->load(['familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        return view('admin.apex.stage1.user_detail', compact('user'));
    }

    public function approveStep(User $user, $step)
    {
        $this->updateStepStatus($user, $step, 'approved');
        return back()->with('success', "Step {$step} approved successfully");
    }

    public function holdStep(Request $request, User $user, $step)
    {
        $request->validate([
            'admin_remark' => 'required|string|max:2000',
        ]);

        $remark = $request->input('admin_remark');
        try {
            $this->updateStepStatus($user, $step, 'resubmit', $remark);
            return back()->with('success', "Step {$step} put on hold");
        } catch (\Throwable $e) {
            Log::error('Error putting step on hold: ' . $e->getMessage());
            return back()->with('error', 'Unable to put step on hold');
        }
    }

        // Appex level approve/hold
        public function appexApprove(User $user)
        {
            try {
                $user->update([
                    'approved_by_appex' => true,
                    'appex_approved_at' => now(),
                    'approval_stage' => 'working_committee',
                ]);
                return back()->with('success', 'User approved by Appex and forwarded to Working Committee');
            } catch (\Throwable $e) {
                Log::error('Appex approve error: ' . $e->getMessage());
                return back()->with('error', 'Unable to approve by Appex');
            }
        }

        public function appexHold(Request $request, User $user)
        {
            $request->validate(['admin_remark' => 'required|string|max:2000']);
            try {
                $user->update([
                    'approved_by_appex' => false,
                    'appex_remark' => $request->input('admin_remark'),
                    'approval_stage' => 'appex',
                    'submit_status' => 'resubmit',
                ]);
                return back()->with('success', 'User put on hold by Appex');
            } catch (\Throwable $e) {
                Log::error('Appex hold error: ' . $e->getMessage());
                return back()->with('error', 'Unable to put on hold by Appex');
            }
        }

        // Working Committee approve/hold
        public function workApprove(User $user)
        {
            try {
                $user->update([
                    'approved_by_working_committee' => true,
                    'working_committee_approved_at' => now(),
                    'approval_stage' => 'chapter',
                ]);
                return back()->with('success', 'User approved by Working Committee and forwarded to Chapter');
            } catch (\Throwable $e) {
                Log::error('Work approve error: ' . $e->getMessage());
                return back()->with('error', 'Unable to approve by Working Committee');
            }
        }

        public function workHold(Request $request, User $user)
        {
            $request->validate(['admin_remark' => 'required|string|max:2000']);
            try {
                $user->update([
                    'approved_by_working_committee' => false,
                    'working_committee_remark' => $request->input('admin_remark'),
                    'approval_stage' => 'working_committee',
                    'submit_status' => 'resubmit',
                ]);
                return back()->with('success', 'User put on hold by Working Committee');
            } catch (\Throwable $e) {
                Log::error('Work hold error: ' . $e->getMessage());
                return back()->with('error', 'Unable to put on hold by Working Committee');
            }
        }

        // Chapter approve/hold
        public function chapterApprove(User $user)
        {
            try {
                $user->update([
                    'approved_by_chapter' => true,
                    'chapter_approved_at' => now(),
                    'approval_stage' => 'completed',
                    'submit_status' => 'approved',
                ]);
                return back()->with('success', 'User approved by Chapter — process completed');
            } catch (\Throwable $e) {
                Log::error('Chapter approve error: ' . $e->getMessage());
                return back()->with('error', 'Unable to approve by Chapter');
            }
        }

        public function chapterHold(Request $request, User $user)
        {
            $request->validate(['admin_remark' => 'required|string|max:2000']);
            try {
                $user->update([
                    'approved_by_chapter' => false,
                    'chapter_remark' => $request->input('admin_remark'),
                    'approval_stage' => 'chapter',
                    'submit_status' => 'resubmit',
                ]);
                return back()->with('success', 'User put on hold by Chapter');
            } catch (\Throwable $e) {
                Log::error('Chapter hold error: ' . $e->getMessage());
                return back()->with('error', 'Unable to put on hold by Chapter');
            }
        }

    private function updateStepStatus(User $user, $step, $status, $remark = null)
    {
        $modelMap = [
            // Step 1: Personal details are on the `users` table
            '1' => 'user',
            '2' => 'educationDetail',
            '3' => 'familyDetail',
            '4' => 'fundingDetail',
            '5' => 'guarantorDetail',
            '6' => 'document',
            '7' => 'document',
        ];

        if (isset($modelMap[$step])) {
            $relation = $modelMap[$step];
            $data = ['submit_status' => $status];
            if (!is_null($remark)) {
                $data['admin_remark'] = $remark;
            }

            if ($relation === 'user') {
                // Update the user row directly for Step 1
                $user->update($data);
            } else {
                // Relation may not exist; ensure it does before updating
                if ($user->$relation) {
                    $user->$relation()->update($data);
                }
            }
        }
    }
}
