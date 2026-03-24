<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\SendBackForCorrectionMail;
use App\Mail\ThirdStageDocumentCorrectionMail;
use App\Mail\WorkingCommitteeApprovedMail;
use App\Models\ApplicationWorkflowStatus;
use App\Models\Chapter;
use App\Models\ChapterInterviewAnswer;
use App\Models\AdminNotification;
use App\Models\AdminUser;
use App\Models\ApexLeadership;
use App\Models\DisbursementSchedule;
use App\Models\EducationDetail;
use App\Models\EmpoweringDream;
use App\Models\Logs;
use App\Models\Loan_category;
use App\Models\PdcDetail;
use App\Models\User;
use App\Models\WorkingCommitteeApproval;
use App\Models\WorkingCommitteeApprovalHistory;
use App\Models\ThirdStageDocument;
use App\Traits\LogsUserActivity;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;





use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;


class AdminController extends Controller
{
    use LogsUserActivity;

    private function attachLatestLoanCategoryType($users): void
    {
        $userIds = $users->pluck('id')->filter()->values();

        if ($userIds->isEmpty()) {
            return;
        }

        $loanCategoryTable = (new Loan_category())->getTable();

        $loanCategoryByUser = Loan_category::query()
            ->select('user_id', 'type')
            ->whereIn('id', function ($query) use ($userIds, $loanCategoryTable) {
                $query->from($loanCategoryTable)
                    ->selectRaw('MAX(id)')
                    ->whereIn('user_id', $userIds)
                    ->groupBy('user_id');
            })
            ->get()
            ->mapWithKeys(function ($loanCategory) {
                return [
                    $loanCategory->user_id => strtolower(trim((string) $loanCategory->type)),
                ];
            });

        $users->each(function ($user) use ($loanCategoryByUser) {
            $user->loan_category_type = $loanCategoryByUser[$user->id] ?? null;
        });
    }

    public function index(Request $request)
    {
        // Calculate disbursement counts for dashboard
        $disbursementCounts = $this->getDisbursementCounts();
        $repaymentCounts = $this->getRepaymentCounts();
        $thirdStageCounts = $this->getThirdStageDocumentCounts();

        return view('admin.home', [
            'activeGuard' => $request->active_guard,
            'disbursementCompleted' => $disbursementCounts['completed'],
            'disbursementInProgress' => $disbursementCounts['in_progress'],
            'disbursementPending' => $disbursementCounts['pending'],
            'disbursementTodayPending' => $disbursementCounts['today_pending'],
            'disbursementUpcoming' => $disbursementCounts['upcoming'],
            'disbursementPast' => $disbursementCounts['past'],
            'disbursementTotal' => $disbursementCounts['total'],
            'repaymentCompleted' => $repaymentCounts['completed'],
            'repaymentInProgress' => $repaymentCounts['in_progress'],
            'repaymentReady' => $repaymentCounts['ready'],
            'repaymentTodayPending' => $repaymentCounts['today_pending'],
            'repaymentUpcoming' => $repaymentCounts['upcoming'],
            'repaymentPast' => $repaymentCounts['past'],
            'repaymentTotal' => $repaymentCounts['total'],
            'thirdStagePending' => $thirdStageCounts['pending'],
            'thirdStageSubmitted' => $thirdStageCounts['submitted'],
            'thirdStageApproved' => $thirdStageCounts['approved'],
            'thirdStageTotal' => $thirdStageCounts['total'],
        ]);
    }

    /**
     * Website Management Index
     */
    public function websiteIndex()
    {
        return view('admin.website.index');
    }

    /**
     * Website Home Page Management
     */
    public function websiteHome()
    {
        return view('admin.website.home');
    }

    /**
     * Website Home - Empowering Dreams Page
     */
    public function websiteHomeEmpoweringDreams()
    {
        $empoweringDreams = EmpoweringDream::orderBy('order', 'asc')->get();
        return view('admin.website.home.empowering-dreams', compact('empoweringDreams'));
    }

    /**
     * Store Empowering Dreams Data
     */
    public function storeEmpoweringDream(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'vision_description' => 'nullable|string',
            'mission' => 'nullable|string',
            'mission_description' => 'nullable|string',
            'features' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/empowering-dreams'), $imageName);
            $imagePath = 'uploads/empowering-dreams/' . $imageName;
        }

        EmpoweringDream::create([
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->vision,
            'vision_description' => $request->vision_description,
            'mission' => $request->mission,
            'mission_description' => $request->mission_description,
            'features' => $request->features,
            'image' => $imagePath,
            'order' => EmpoweringDream::max('order') + 1,
            'status' => true,
        ]);

        return redirect()->back()->with('success', 'Data added successfully!');
    }

    /**
     * Update Empowering Dreams Data
     */
    public function updateEmpoweringDream(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'vision_description' => 'nullable|string',
            'mission' => 'nullable|string',
            'mission_description' => 'nullable|string',
            'features' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dream = EmpoweringDream::findOrFail($id);

        $imagePath = $dream->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($dream->image && file_exists(public_path($dream->image))) {
                unlink(public_path($dream->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/empowering-dreams'), $imageName);
            $imagePath = 'uploads/empowering-dreams/' . $imageName;
        }

        $dream->update([
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->vision,
            'vision_description' => $request->vision_description,
            'mission' => $request->mission,
            'mission_description' => $request->mission_description,
            'features' => $request->features,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    /**
     * Delete Empowering Dreams Data
     */
    public function deleteEmpoweringDream($id)
    {
        $dream = EmpoweringDream::findOrFail($id);

        // Delete image if exists
        if ($dream->image && file_exists(public_path($dream->image))) {
            unlink(public_path($dream->image));
        }

        $dream->delete();

        return redirect()->back()->with('success', 'Data deleted successfully!');
    }

    /**
     * Website Home - Key Instruction Page
     */
    public function websiteHomeKeyInstruction()
    {
        $keyInstructions = \App\Models\KeyInstruction::orderBy('display_order')->get();
        return view('admin.website.home.key-instruction', compact('keyInstructions'));
    }

    /**
     * Store Key Instruction
     */
    public function storeKeyInstruction(\Illuminate\Http\Request $request)
    {
        try {
            $validated = $request->validate([
                'icon' => 'nullable|file|mimes:svg,xml',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'color' => 'required|string|max:20',
                'display_order' => 'nullable|integer|min:0',
            ]);

            // Handle SVG file upload
            $iconSvg = '';
            if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
                try {
                    $file = $request->file('icon');
                    $iconSvg = file_get_contents($file->getRealPath());

                    // Modify SVG to set proper sizing
                    $iconSvg = preg_replace('/(<svg[^>]*)\s+width="[^"]*"/i', '$1', $iconSvg);
                    $iconSvg = preg_replace('/(<svg[^>]*)\s+height="[^"]*"/i', '$1', $iconSvg);
                    $iconSvg = preg_replace('/(<svg)/i', '$1 width="40" height="40"', $iconSvg);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error processing icon: ' . $e->getMessage());
                    $iconSvg = '';
                }
            } else {
                // Use a default SVG icon
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
            }

            if (!isset($validated['display_order']) || $validated['display_order'] == 0) {
                $validated['display_order'] = (\App\Models\KeyInstruction::max('display_order') ?? 0) + 1;
            }

            $keyInstruction = \App\Models\KeyInstruction::create([
                'icon' => 'custom',
                'icon_svg' => $iconSvg,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'color' => $validated['color'],
                'display_order' => $validated['display_order'],
                'is_active' => 1,
            ]);

            \Illuminate\Support\Facades\Log::info('Key Instruction created successfully: ' . $keyInstruction->id);

            return redirect()->route('admin.website.home.key-instruction')->with('success', 'Key Instruction added successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error storing key instruction: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update Key Instruction
     */
    public function updateKeyInstruction(\Illuminate\Http\Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'color' => 'required|string|max:20',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $keyInstruction = \App\Models\KeyInstruction::findOrFail($id);

        // Handle SVG file upload if a new file is uploaded
        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            try {
                $file = $request->file('icon');
                $iconSvg = file_get_contents($file->getRealPath());

                // Modify SVG to set proper sizing
                $iconSvg = preg_replace('/(<svg[^>]*)\s+width="[^"]*"/i', '$1', $iconSvg);
                $iconSvg = preg_replace('/(<svg[^>]*)\s+height="[^"]*"/i', '$1', $iconSvg);
                $iconSvg = preg_replace('/(<svg)/i', '$1 width="40" height="40"', $iconSvg);

                $keyInstruction->icon_svg = $iconSvg;
                $keyInstruction->icon = 'custom';
            } catch (\Exception $e) {
                // If there's an error, keep the existing icon
                if ($request->has('existing_icon_svg')) {
                    $keyInstruction->icon_svg = $request->input('existing_icon_svg');
                }
            }
        } elseif ($request->has('existing_icon_svg')) {
            // Keep existing icon SVG
            $keyInstruction->icon_svg = $request->input('existing_icon_svg');
        }

        $keyInstruction->title = $validated['title'];
        $keyInstruction->description = $validated['description'];
        $keyInstruction->color = $validated['color'];
        $keyInstruction->display_order = $validated['display_order'] ?? 0;
        $keyInstruction->save();

        return redirect()->route('admin.website.home.key-instruction')->with('success', 'Key Instruction updated successfully!');
    }

    /**
     * Delete Key Instruction
     */
    public function deleteKeyInstruction($id)
    {
        $keyInstruction = \App\Models\KeyInstruction::findOrFail($id);
        $keyInstruction->delete();

        return redirect()->route('admin.website.home.key-instruction')->with('success', 'Key Instruction deleted successfully!');
    }

    /**
     * Website Home - Working Committee Page
     */
    public function websiteHomeWorkingCommittee()
    {
        $workingCommittee = \App\Models\WorkingCommittee::orderBy('display_order')->get();
        return view('admin.website.home.working-committee', compact('workingCommittee'));
    }

    /**
     * Store Working Committee Member (Website)
     */
    public function storeWebsiteWorkingCommittee(\Illuminate\Http\Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'designation' => 'required|string|max:255',
                'description' => 'nullable|string',
                'display_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $photoPath = null;
            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $photo = $request->file('photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/working-committee'), $photoName);
                $photoPath = 'uploads/working-committee/' . $photoName;
            }

            if (!isset($validated['display_order']) || $validated['display_order'] == 0) {
                $validated['display_order'] = (\App\Models\WorkingCommittee::max('display_order') ?? 0) + 1;
            }

            \App\Models\WorkingCommittee::create([
                'name' => $validated['name'],
                'photo' => $photoPath,
                'designation' => $validated['designation'],
                'description' => $validated['description'] ?? '',
                'display_order' => $validated['display_order'],
                'status' => $validated['status'] ?? true,
                'show_hide' => true,
            ]);

            return redirect()->route('admin.website.home.working-committee')->with('success', 'Working Committee member added successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error storing working committee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update Working Committee Member (Website)
     */
    public function updateWebsiteWorkingCommittee(\Illuminate\Http\Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'designation' => 'required|string|max:255',
                'description' => 'nullable|string',
                'display_order' => 'nullable|integer|min:0',
                'status' => 'nullable|boolean',
            ]);

            $member = \App\Models\WorkingCommittee::findOrFail($id);

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                // Delete old photo if exists
                if ($member->photo && file_exists(public_path($member->photo))) {
                    unlink(public_path($member->photo));
                }
                $photo = $request->file('photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/working-committee'), $photoName);
                $member->photo = 'uploads/working-committee/' . $photoName;
            }

            $member->name = $validated['name'];
            $member->designation = $validated['designation'];
            $member->description = $validated['description'] ?? '';
            $member->display_order = $validated['display_order'] ?? 0;
            $member->status = $validated['status'] ?? true;
            $member->save();

            return redirect()->route('admin.website.home.working-committee')->with('success', 'Working Committee member updated successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error updating working committee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete Working Committee Member (Website)
     */
    public function deleteWebsiteWorkingCommittee($id)
    {
        try {
            $member = \App\Models\WorkingCommittee::findOrFail($id);

            // Delete photo if exists
            if ($member->photo && file_exists(public_path($member->photo))) {
                unlink(public_path($member->photo));
            }

            $member->delete();

            return redirect()->route('admin.website.home.working-committee')->with('success', 'Working Committee member deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Website Home - Empowering Future Page
     */
    public function websiteHomeEmpoweringFuture()
    {
        $empoweringDreams = EmpoweringDream::orderBy('order')->get();
        $response = response()->view('admin.website.home.empowering-future', compact('empoweringDreams'));
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');
        return $response;
    }

    /**
     * Store Empowering Future Data
     */
    public function storeEmpoweringFuture(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'vision_description' => 'nullable|string',
            'mission' => 'nullable|string',
            'mission_description' => 'nullable|string',
            'features' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/empowering-dreams'), $imageName);
            $imagePath = 'uploads/empowering-dreams/' . $imageName;
        }

        EmpoweringDream::create([
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->input('vision', ''),
            'vision_description' => $request->input('vision_description', ''),
            'mission' => $request->input('mission', ''),
            'mission_description' => $request->input('mission_description', ''),
            'features' => $request->input('features', ''),
            'image' => $imagePath,
            'order' => EmpoweringDream::max('order') + 1,
            'status' => true,
        ]);

        return redirect()->route('admin.website.home.empowering-future')->with('success', 'Data added successfully!')->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate', 'Pragma' => 'no-cache', 'Expires' => '0']);
    }

    /**
     * Update Empowering Future Data
     */
    public function updateEmpoweringFuture(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'vision' => 'nullable|string',
            'vision_description' => 'nullable|string',
            'mission' => 'nullable|string',
            'mission_description' => 'nullable|string',
            'features' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $dream = EmpoweringDream::findOrFail($id);

        $imagePath = $dream->image;
        if ($request->hasFile('image')) {
            if ($dream->image && file_exists(public_path($dream->image))) {
                unlink(public_path($dream->image));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/empowering-dreams'), $imageName);
            $imagePath = 'uploads/empowering-dreams/' . $imageName;
        }

        $dream->update([
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->input('vision', ''),
            'vision_description' => $request->input('vision_description', ''),
            'mission' => $request->input('mission', ''),
            'mission_description' => $request->input('mission_description', ''),
            'features' => $request->input('features', ''),
            'image' => $imagePath,
            'order' => $request->input('order', 0),
            'status' => $request->input('status', 1) == '1' ? true : false,
        ]);

        return redirect()->route('admin.website.home.empowering-future')->with('success', 'Data updated successfully!')->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate', 'Pragma' => 'no-cache', 'Expires' => '0']);
    }

    /**
     * Delete Empowering Future Data
     */
    public function deleteEmpoweringFuture($id)
    {
        $dream = EmpoweringDream::findOrFail($id);

        if ($dream->image && file_exists(public_path($dream->image))) {
            unlink(public_path($dream->image));
        }

        $dream->delete();

        return redirect()->route('admin.website.home.empowering-future')->with('success', 'Data deleted successfully!');
    }

    /**
     * Website Home - Achievement and Impact Page
     */
    public function websiteHomeAchievementImpact()
    {
        return view('admin.website.home.achievement-impact');
    }

    /**
     * Website Home - Photo Gallery Page
     */
    public function websiteHomePhotoGallery()
    {
        return view('admin.website.home.photo-gallery');
    }

    /**
     * Website Home - Our Testimonial Page
     */
    public function websiteHomeOurTestimonial()
    {
        return view('admin.website.home.our-testimonial');
    }

    /**
     * Website Home - Success Stories Page
     */
    public function websiteHomeSuccessStories()
    {
        return view('admin.website.home.success-stories');
    }

    /**
     * Website About Page Management
     */
    public function websiteAbout()
    {
        return view('admin.website.about');
    }

    /**
     * Website Application Page Management
     */
    public function websiteApplication()
    {
        return view('admin.website.application');
    }

    /**
     * Website Contact Page Management
     */
    public function websiteContact()
    {
        return view('admin.website.contact');
    }

    /**
     * Website Donor Page Management
     */
    public function websiteDonor()
    {
        return view('admin.website.donor');
    }

    /**
     * Website Gallery Page Management
     */
    public function websiteGallery()
    {
        return view('admin.website.gallery');
    }

    /**
     * Website University Page Management
     */
    public function websiteUniversity()
    {
        return view('admin.website.university');
    }

    /**
     * Calculate disbursement counts for dashboard
     */
    private function getDisbursementCounts()
    {
        try {
            // Get all schedule data
            $scheduleData = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->select(
                    'user_id',
                    DB::raw('COUNT(*) as total_count'),
                    DB::raw('SUM(planned_amount) as total_planned_amount')
                )
                ->groupBy('user_id')
                ->get();

            // Get disbursed amounts
            $disbursedData = DB::connection('admin_panel')
                ->table('disbursements')
                ->select('user_id', DB::raw('SUM(amount) as total_disbursed_amount'))
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');

            // Get status data
            $statusData = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->select(
                    'user_id',
                    DB::raw('COUNT(*) as total_count'),
                    DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count')
                )
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');

            // Get disbursement counts
            $disbursementCounts = DB::connection('admin_panel')
                ->table('disbursements')
                ->select('user_id', DB::raw('COUNT(*) as disbursement_count'))
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');

            $completed = 0;
            $inProgress = 0;
            $pending = 0;
            $today = now()->toDateString();

            $upcoming = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('status', 'pending')
                ->whereDate('planned_date', '>=', $today)
                ->count();

            $todayPending = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('status', 'pending')
                ->whereDate('planned_date', '=', $today)
                ->count();

            $past = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('status', 'completed')
                ->count();

            foreach ($scheduleData as $item) {
                $disbursed = $disbursedData->get($item->user_id);
                $statusInfo = $statusData->get($item->user_id);
                $disbursementCount = $disbursementCounts->get($item->user_id)->disbursement_count ?? 0;

                $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;
                $totalCount = $statusInfo->total_count ?? 0;
                $amountFullyDisbursed = ($totalDisbursedAmount >= $item->total_planned_amount);

                // Determine status
                if ($totalCount > 0 && $disbursementCount === $totalCount && $amountFullyDisbursed) {
                    $completed++;
                } elseif ($disbursementCount > 0 || $totalDisbursedAmount > 0) {
                    $inProgress++;
                } else {
                    $pending++;
                }
            }

            return [
                'completed' => $completed,
                'in_progress' => $inProgress,
                'pending' => $pending,
                'today_pending' => $todayPending,
                'upcoming' => $upcoming,
                'past' => $past,
                'total' => $completed + $inProgress + $pending
            ];
        } catch (\Exception $e) {
            return [
                'completed' => 0,
                'in_progress' => 0,
                'pending' => 0,
                'today_pending' => 0,
                'upcoming' => 0,
                'past' => 0,
                'total' => 0
            ];
        }
    }

    /**
     * Calculate repayment counts for dashboard
     */
    private function getRepaymentCounts()
    {
        try {
            $scheduleData = DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->select(
                    'user_id',
                    DB::raw('SUM(planned_amount) as total_planned_amount')
                )
                ->groupBy('user_id')
                ->get();

            $disbursedData = DB::connection('admin_panel')
                ->table('disbursements')
                ->select('user_id', DB::raw('SUM(amount) as total_disbursed_amount'))
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');

            $repaymentData = DB::connection('admin_panel')
                ->table('repayments')
                ->select('user_id', DB::raw('SUM(amount) as total_repaid_amount'))
                ->where('status', '!=', 'bounced')
                ->groupBy('user_id')
                ->get()
                ->keyBy('user_id');

            $completed = 0;
            $inProgress = 0;
            $ready = 0;

            foreach ($scheduleData as $item) {
                $disbursed = $disbursedData->get($item->user_id);
                $totalDisbursedAmount = $disbursed->total_disbursed_amount ?? 0;

                if ($totalDisbursedAmount <= 0) {
                    continue;
                }

                $repaid = $repaymentData->get($item->user_id);
                $totalRepaidAmount = $repaid->total_repaid_amount ?? 0;
                $outstandingAmount = max($totalDisbursedAmount - $totalRepaidAmount, 0);

                if ($outstandingAmount == 0) {
                    $completed++;
                } elseif ($totalRepaidAmount > 0) {
                    $inProgress++;
                } else {
                    $ready++;
                }
            }

            // Keep these aligned with Repayment section buttons/routes:
            // Upcoming => Pending repayment installments (from latest PDC cheques)
            // Past => Completed repayment installments (from latest PDC cheques)
            $upcoming = 0;
            $past = 0;
            $todayPending = 0;
            $today = now()->toDateString();

            $pdcDetailsByUser = PdcDetail::query()
                ->orderByDesc('id')
                ->get()
                ->groupBy('user_id')
                ->map(fn($items) => $items->first());

            foreach ($pdcDetailsByUser as $userId => $pdcDetail) {
                $chequeDetails = $pdcDetail->cheque_details;
                if (is_string($chequeDetails)) {
                    $decoded = json_decode($chequeDetails, true);
                    $chequeDetails = is_array($decoded) ? $decoded : [];
                }

                if (!is_array($chequeDetails) || empty($chequeDetails)) {
                    continue;
                }

                $installments = collect($chequeDetails)
                    ->filter(fn($item) => is_array($item))
                    ->map(function (array $item, int $index) {
                        return (object) [
                            'installment_no' => (int) ($item['row_number'] ?? ($index + 1)),
                            'amount' => (float) ($item['amount'] ?? 0),
                            'cheque_date' => $item['cheque_date'] ?? null,
                        ];
                    })
                    ->sortBy('installment_no')
                    ->values();

                $remainingPaidAmount = (float) ($repaymentData->get($userId)->total_repaid_amount ?? 0);

                foreach ($installments as $installment) {
                    if ($remainingPaidAmount >= $installment->amount && $installment->amount > 0) {
                        $past++;
                        $remainingPaidAmount -= $installment->amount;
                    } else {
                        $upcoming++;
                        $installmentDate = $installment->cheque_date ?? null;
                        if (!empty($installmentDate) && $installmentDate === $today) {
                            $todayPending++;
                        }
                    }
                }
            }

            return [
                'completed' => $completed,
                'in_progress' => $inProgress,
                'ready' => $ready,
                'today_pending' => $todayPending,
                'upcoming' => $upcoming,
                'past' => $past,
                'total' => $completed + $inProgress + $ready,
            ];
        } catch (\Exception $e) {
            return [
                'completed' => 0,
                'in_progress' => 0,
                'ready' => 0,
                'today_pending' => 0,
                'upcoming' => 0,
                'past' => 0,
                'total' => 0,
            ];
        }
    }

    private function getThirdStageDocumentCounts(): array
    {
        try {
            $pending = ThirdStageDocument::whereIn('status', ['pending', 'rejected'])->count();
            $submitted = ThirdStageDocument::where('status', 'submitted')->count();
            $approved = ThirdStageDocument::where('status', 'approved')->count();

            return [
                'pending' => $pending,
                'submitted' => $submitted,
                'approved' => $approved,
                'total' => $pending + $submitted + $approved,
            ];
        } catch (\Exception $e) {
            return [
                'pending' => 0,
                'submitted' => 0,
                'approved' => 0,
                'total' => 0,
            ];
        }
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

        $this->attachLatestLoanCategoryType($users);

        return view('admin.apex.stage1.approved', compact('users'));
    }

    public function apexStage1Pending()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'apex_1')
                    ->where('apex_1_status', 'pending')->whereNull('apex_1_reject_remarks');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $this->attachLatestLoanCategoryType($users);

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

        $this->attachLatestLoanCategoryType($users);
        return view('admin.apex.stage1.hold', compact('users'));
    }

    public function apexStage1Resubmitted()
    {
        // Get users where apex_1_status = 'pending' but have admin remarks indicating resubmission
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('apex_1_status', 'pending')
                    ->whereNotNull('apex_1_reject_remarks');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $this->attachLatestLoanCategoryType($users);

        return view('admin.apex.stage1.pending', compact('users'));
    }

    public function apexStage1UserDetail(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        $loanCategory = \App\Models\Loan_category::where('user_id', $user->id)->latest()->first();
        return view('admin.apex.stage1.user_detail', compact('user', 'loanCategory'));
    }

    public function approveStage(Request $request, User $user, $stage)
    {
        // Validation
        //   dd($request->all());
        $rules = [
            'admin_remark' => 'nullable|string',
            'apex_staff_remark' => 'nullable|string',
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
            if ($interviewCount < 14) {
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
                $updateData['current_stage'] = 'apex_2';
                // Apex 2 approval also updates PDC status
                $pdcDetail = \App\Models\PdcDetail::where('user_id', $user->id)->first();
                if ($pdcDetail) {
                    $pdcDetail->update([
                        'status' => 'approved',
                        'admin_approve_remark' => $request->admin_remark,
                        'processed_by' => Auth::id(),
                    ]);
                }
                $updateData['current_stage'] = 'account';
                break;

            default:
                return back()->with('error', 'Invalid stage');
        }

        $workflow->update($updateData);

        // Log admin action
        $this->logUserActivity(
            processType: "{$stage}_approval",
            processAction: 'approved',
            processDescription: $request->admin_remark ?? 'No remarks',
            module: "{$stage}_action",
            oldValues: null,
            newValues: null,
            additionalData: [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'stage' => $stage,
                'admin_remark' => $request->admin_remark,
                'apex_staff_remark' => $request->apex_staff_remark,
                'previous_stage' => $workflow->current_stage,
                'new_stage' => $updateData['current_stage'] ?? $workflow->current_stage
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: Auth::id(),
            actorName: Auth::user()->name,
            actorRole: Auth::user()->role
        );


        return back()->with(
            'success',
            ucfirst(str_replace('_', ' ', $stage)) . ' stage approved successfully'
        );
    }

    public function approveWorkingCommittee(Request $request, User $user, $stage)
    {
        //dd($request->all());
        $rules = [
            'w_c_approval_remark' => 'required|string',
            'w_c_approval_date' => 'required|date',
            'meeting_no' => 'required|string|max:255',
            'disbursement_system' => 'required|in:yearly,half_yearly',
            'approval_financial_assistance_amount' => 'required|numeric|min:0',
            'installment_amount' => 'required',
            'no_of_months' => 'required',
            'total' => 'required',
            'additional_installment_amount' => 'required|numeric|min:0',
            'repayment_type' => 'required|in:yearly,half_yearly,quarterly,monthly',
            'no_of_cheques_to_be_collected' => 'required|integer|min:1',
            'repayment_starting_from' => 'required|date',
            'remarks_for_approval' => 'required|string|max:2000',
            'can_be_jito_member' => 'nullable|in:yes,no',
            'jito_member_date' => 'nullable|date',
            'can_be_jeap_donor' => 'nullable|in:yes,no',
            'jeap_donor_date' => 'nullable|date',
            'disbursement_in_year' => 'required|integer|min:1|max:6',
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
            // 'installment_amount' => json_encode($request->installment_amount),
            // 'no_of_months'=>json_encode($request->no_of_months),
            // 'total'=>json_encode($request->total),
            'installment_amount' => $request->installment_amount,
            'no_of_months' => $request->no_of_months,
            'total' => $request->total,
            'additional_installment_amount' => $request->additional_installment_amount,
            'repayment_type' => $request->repayment_type,
            'no_of_cheques_to_be_collected' => $request->no_of_cheques_to_be_collected,
            'repayment_starting_from' => $request->repayment_starting_from,
            'remarks_for_approval' => $request->remarks_for_approval,
            'can_be_jito_member' => $request->can_be_jito_member,
            'jito_member_date' => $request->can_be_jito_member === 'yes' ? $request->jito_member_date : null,
            'can_be_jeap_donor' => $request->can_be_jeap_donor,
            'jeap_donor_date' => $request->can_be_jeap_donor === 'yes' ? $request->jeap_donor_date : null,
            'processed_by_name' => Auth::user()->name,
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
                'yearly_dates' => $request->yearly_dates,
                'yearly_amounts' => $request->yearly_amounts,
                'half_yearly_dates' => $request->half_yearly_dates,
                'half_yearly_amounts' => $request->half_yearly_amounts,
                'approval_financial_assistance_amount' => $request->approval_financial_assistance_amount,
                'installment_amount' => $request->installment_amount,
                'no_of_months' => $request->no_of_months,
                'total' => $request->total,
                'additional_installment_amount' => $request->additional_installment_amount,
                'repayment_type' => $request->repayment_type,
                'no_of_cheques_to_be_collected' => $request->no_of_cheques_to_be_collected,
                'repayment_starting_from' => $request->repayment_starting_from,
                'remarks_for_approval' => $request->remarks_for_approval,
                'can_be_jito_member' => $request->can_be_jito_member,
                'jito_member_date' => $request->can_be_jito_member === 'yes' ? $request->jito_member_date : null,
                'can_be_jeap_donor' => $request->can_be_jeap_donor,
                'jeap_donor_date' => $request->can_be_jeap_donor === 'yes' ? $request->jeap_donor_date : null,
                'processed_by_name' => Auth::user()->name,
                'processed_by' => Auth::user()->id,
                'approval_status' => 'approved',
            ]);

            $this->logUserActivity(
                processType: 'Working_Committee_Approval',
                processAction: 'approved',
                processDescription: $request->w_c_approval_remark ?? 'No remarks',
                module: 'working_committee_approval',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'approval_id' => $workingCommitteeApproval->id,
                    'stage' => $stage,
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'admin_remark' => $request->w_c_approval_remark,
                    'previous_stage' => $workflow->current_stage,
                    'new_stage' => 'apex_2'
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );




            // Send approval email with sanction letter attachment to the user
            try {
                Mail::to($user->email)->send(new WorkingCommitteeApprovedMail($user));
                Log::info("Working Committee Approved email sent to user {$user->id} ({$user->email}) with sanction letter attachment");
            } catch (\Exception $e) {
                Log::error("Failed to send Working Committee Approved email to user {$user->id}: " . $e->getMessage());
            }

            return back()->with('success', 'Working Committee approval completed successfully. Email with sanction letter sent to student.');
        } catch (\Exception $e) {
            // Log approval creation failure
            $this->logUserActivity(
                processType: 'Working_Committee_Approval_Failed',
                processAction: 'failed',
                processDescription: 'Working Committee approval creation failed',
                module: 'admin_action',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'stage' => $stage,
                    'admin_id' => Auth::id(),
                    'admin_name' => Auth::user()->name,
                    'error' => $e->getMessage(),
                    'request_data' => $request->except(['_token']),
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );

            return back()->with('error', 'Failed to save working committee approval data: ' . $e->getMessage());
        }
    }
    public function updateWorkingCommittee(Request $request, User $user)
    {
        $validated = $request->validate([
            'w_c_approval_date'                 => 'required|date',
            'meeting_no'                        => 'required|string|max:50',
            'approval_financial_assistance_amount' => 'required|numeric|min:0',
            'disbursement_system'               => 'required|in:yearly,half_yearly',
            'yearly_dates.*'                    => 'nullable|date',
            'yearly_amounts.*'                  => 'nullable|numeric',
            'half_yearly_dates.*'               => 'nullable|date',
            'half_yearly_amounts.*'             => 'nullable|numeric',
            'installment_amount.*'              => 'nullable|numeric',
            'no_of_months.*'                    => 'nullable|integer',
            'total'                             => 'nullable|array',
            'total.*'                           => 'nullable|numeric',
            'additional_installment_amount'     => 'nullable|numeric',
            'no_of_cheques_to_be_collected'     => 'nullable|integer',
            'repayment_type'                    => 'nullable|string',
            'repayment_starting_from'           => 'nullable|date',
            'w_c_approval_remark'               => 'required|string',
            'remarks_for_approval'              => 'nullable|string',
            'can_be_jito_member'               => 'nullable|in:yes,no',
            'jito_member_date'                 => 'nullable|date',
            'can_be_jeap_donor'                => 'nullable|in:yes,no',
            'jeap_donor_date'                  => 'nullable|date',
        ]);

        $totals = [];

        foreach ($request->input('installment_amount', []) as $index => $amount) {
            $months = $request->input("no_of_months.$index", 0);
            $totals[] = $amount * $months;
        }

        $validated['total'] = $totals;
        $validated['jito_member_date'] = ($request->can_be_jito_member === 'yes') ? $request->jito_member_date : null;
        $validated['jeap_donor_date'] = ($request->can_be_jeap_donor === 'yes') ? $request->jeap_donor_date : null;
        $existingApproval = $user->workingCommitteeApproval;

        if ($existingApproval) {
            $validated['disbursement_system'] = $request->disbursement_system ?? $existingApproval->disbursement_system;

            if ($validated['disbursement_system'] === 'yearly') {
                $validated['disbursement_in_year'] = $request->input(
                    'disbursement_in_year',
                    $existingApproval->disbursement_in_year
                );
                $validated['yearly_dates'] = array_values($request->input(
                    'yearly_dates',
                    (array) $existingApproval->yearly_dates
                ));
                $validated['yearly_amounts'] = array_values($request->input(
                    'yearly_amounts',
                    (array) $existingApproval->yearly_amounts
                ));
                $validated['disbursement_in_half_year'] = $existingApproval->disbursement_in_half_year;
                $validated['half_yearly_dates'] = (array) $existingApproval->half_yearly_dates;
                $validated['half_yearly_amounts'] = (array) $existingApproval->half_yearly_amounts;
            }

            if ($validated['disbursement_system'] === 'half_yearly') {
                $validated['disbursement_in_half_year'] = $request->input(
                    'disbursement_in_half_year',
                    $existingApproval->disbursement_in_half_year
                );
                $validated['half_yearly_dates'] = array_values($request->input(
                    'half_yearly_dates',
                    (array) $existingApproval->half_yearly_dates
                ));
                $validated['half_yearly_amounts'] = array_values($request->input(
                    'half_yearly_amounts',
                    (array) $existingApproval->half_yearly_amounts
                ));
                $validated['disbursement_in_year'] = $existingApproval->disbursement_in_year;
                $validated['yearly_dates'] = (array) $existingApproval->yearly_dates;
                $validated['yearly_amounts'] = (array) $existingApproval->yearly_amounts;
            }
        }

        $this->validateCompletedDisbursementSchedules($user, $validated);

        DB::connection('admin_panel')->transaction(function () use ($user, $validated) {
            $approval = $user->workingCommitteeApproval ?? new \App\Models\WorkingCommitteeApproval(['user_id' => $user->id]);
            $originalSnapshot = $approval->exists ? $this->buildWorkingCommitteeApprovalHistorySnapshot($approval) : null;

            $approval->fill($validated);
            $changedFields = $approval->exists ? array_keys($approval->getDirty()) : [];
            $approval->save();

            if ($approval->wasRecentlyCreated === false && !empty($changedFields) && $originalSnapshot !== null) {
                $history = WorkingCommitteeApprovalHistory::create(array_merge($originalSnapshot, [
                    'user_id' => $user->id,
                    'working_committee_approval_id' => $approval->id,
                    'edited_by' => Auth::id(),
                    'changed_fields' => $changedFields,
                ]));

                $this->createWorkingCommitteeUpdateNotifications($user, $approval, $history);
            }

            $this->syncWorkingCommitteeDisbursementSchedules($user, $approval);
        });

        // Also update workflowStatus if needed (approval_remarks, updated_at, etc.)

        return redirect()->back()->with('success', 'Working Committee decision updated successfully.');
    }

    public function updateWorkingCommitteeDisbursementDates(Request $request, User $user)
    {
        $approval = $user->workingCommitteeApproval;

        if (!$approval) {
            return redirect()->back()->with('error', 'Working Committee approval not found.');
        }

        $validated = $request->validate([
            'date_update_mode' => 'required|in:disbursement_dates',
            'yearly_dates' => 'nullable|array|min:1',
            'yearly_dates.*' => 'nullable|date',
            'half_yearly_dates' => 'nullable|array|min:1',
            'half_yearly_dates.*' => 'nullable|date',
        ]);

        if ($approval->disbursement_system === 'yearly') {
            $validated['yearly_dates'] = array_values($request->input('yearly_dates', []));

            if (count($validated['yearly_dates']) !== count((array) $approval->yearly_dates)) {
                throw ValidationException::withMessages([
                    'yearly_dates' => 'Only the existing disbursement dates can be updated here.',
                ]);
            }
        }

        if ($approval->disbursement_system === 'half_yearly') {
            $validated['half_yearly_dates'] = array_values($request->input('half_yearly_dates', []));

            if (count($validated['half_yearly_dates']) !== count((array) $approval->half_yearly_dates)) {
                throw ValidationException::withMessages([
                    'half_yearly_dates' => 'Only the existing disbursement dates can be updated here.',
                ]);
            }
        }

        DB::connection('admin_panel')->transaction(function () use ($user, $approval, $validated) {
            $originalSnapshot = $this->buildWorkingCommitteeApprovalHistorySnapshot($approval);

            $proposedApproval = new \App\Models\WorkingCommitteeApproval($approval->toArray());
            $proposedApproval->yearly_dates = $approval->disbursement_system === 'yearly'
                ? ($validated['yearly_dates'] ?? [])
                : $approval->yearly_dates;
            $proposedApproval->half_yearly_dates = $approval->disbursement_system === 'half_yearly'
                ? ($validated['half_yearly_dates'] ?? [])
                : $approval->half_yearly_dates;

            $this->validateCompletedDisbursementSchedules($user, $proposedApproval);

            $approval->fill([
                'yearly_dates' => $approval->disbursement_system === 'yearly'
                    ? ($validated['yearly_dates'] ?? [])
                    : $approval->yearly_dates,
                'half_yearly_dates' => $approval->disbursement_system === 'half_yearly'
                    ? ($validated['half_yearly_dates'] ?? [])
                    : $approval->half_yearly_dates,
            ]);

            $changedFields = array_keys($approval->getDirty());
            $approval->save();

            if (!empty($changedFields)) {
                WorkingCommitteeApprovalHistory::create(array_merge($originalSnapshot, [
                    'user_id' => $user->id,
                    'working_committee_approval_id' => $approval->id,
                    'edited_by' => Auth::id(),
                    'changed_fields' => $changedFields,
                ]));
            }

            $this->syncWorkingCommitteeDisbursementSchedules($user, $approval);
        });

        return redirect()->back()->with('success', 'Disbursement dates updated successfully.');
    }

    private function syncWorkingCommitteeDisbursementSchedules(User $user, \App\Models\WorkingCommitteeApproval $approval): void
    {
        $workflowStatus = ApplicationWorkflowStatus::where('user_id', $user->id)->first();

        if (!$workflowStatus) {
            return;
        }

        $plannedSchedules = $this->buildWorkingCommitteePlannedSchedules($approval);

        if (empty($plannedSchedules)) {
            return;
        }

        $scheduleQuery = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $user->id);

        $existingSchedules = (clone $scheduleQuery)
            ->orderBy('installment_no')
            ->get()
            ->values();

        $completedInstallmentNumbers = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->pluck('installment_no')
            ->map(fn($installmentNo) => (int) $installmentNo)
            ->all();

        $pendingInstallmentNumbers = [];

        foreach ($plannedSchedules as $index => $plannedSchedule) {
            $installmentNo = $index + 1;

            if (in_array($installmentNo, $completedInstallmentNumbers, true)) {
                continue;
            }

            $pendingInstallmentNumbers[] = $installmentNo;

            DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->updateOrInsert(
                    [
                        'user_id' => $user->id,
                        'installment_no' => $installmentNo,
                    ],
                    [
                        'workflow_status_id' => $workflowStatus->id,
                        'planned_date' => $plannedSchedule['planned_date'],
                        'planned_amount' => $plannedSchedule['planned_amount'],
                        'status' => 'pending',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
        }

        if (!empty($pendingInstallmentNumbers)) {
            DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('user_id', $user->id)
                ->whereNotIn('installment_no', $completedInstallmentNumbers)
                ->whereNotIn('installment_no', $pendingInstallmentNumbers)
                ->delete();
        } else {
            DB::connection('admin_panel')
                ->table('disbursement_schedules')
                ->where('user_id', $user->id)
                ->whereNotIn('installment_no', $completedInstallmentNumbers)
                ->delete();
        }
    }

    private function validateCompletedDisbursementSchedules(User $user, $approvalData): void
    {
        $completedSchedules = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('installment_no')
            ->get();

        if ($completedSchedules->isEmpty()) {
            return;
        }

        $approval = $approvalData instanceof \App\Models\WorkingCommitteeApproval
            ? $approvalData
            : new \App\Models\WorkingCommitteeApproval($approvalData);

        $proposedSchedules = $this->buildWorkingCommitteePlannedSchedules($approval);

        foreach ($completedSchedules as $completedSchedule) {
            $index = ((int) $completedSchedule->installment_no) - 1;
            $proposedSchedule = $proposedSchedules[$index] ?? null;

            if (!$proposedSchedule) {
                throw ValidationException::withMessages([
                    'disbursement_system' => 'Completed disbursement installments cannot be removed from the approval.',
                ]);
            }

            $sameDate = (string) $completedSchedule->planned_date === (string) $proposedSchedule['planned_date'];
            $sameAmount = round((float) $completedSchedule->planned_amount, 2) === round((float) $proposedSchedule['planned_amount'], 2);

            if (!$sameDate || !$sameAmount) {
                throw ValidationException::withMessages([
                    'disbursement_system' => 'This disbursement is already disbursed, so its completed installment row cannot be changed.',
                ]);
            }
        }
    }

    private function buildWorkingCommitteePlannedSchedules(\App\Models\WorkingCommitteeApproval $approval): array
    {
        $schedules = [];

        if ($approval->disbursement_system === 'yearly') {
            $yearlyAmounts = (array) $approval->yearly_amounts;

            foreach ((array) $approval->yearly_dates as $index => $plannedDate) {
                $plannedAmount = (float) ($yearlyAmounts[$index] ?? 0);

                if (!$plannedDate || $plannedAmount <= 0) {
                    continue;
                }

                $schedules[] = [
                    'planned_date' => $plannedDate,
                    'planned_amount' => $plannedAmount,
                ];
            }
        } elseif ($approval->disbursement_system === 'half_yearly') {
            $halfYearlyAmounts = (array) $approval->half_yearly_amounts;

            foreach ((array) $approval->half_yearly_dates as $index => $plannedDate) {
                $plannedAmount = (float) ($halfYearlyAmounts[$index] ?? 0);

                if (!$plannedDate || $plannedAmount <= 0) {
                    continue;
                }

                $schedules[] = [
                    'planned_date' => $plannedDate,
                    'planned_amount' => $plannedAmount,
                ];
            }
        }

        if (!empty($schedules)) {
            return $schedules;
        }

        if ($approval->repayment_starting_from && (float) $approval->approval_financial_assistance_amount > 0) {
            return [[
                'planned_date' => $approval->repayment_starting_from->format('Y-m-d'),
                'planned_amount' => (float) $approval->approval_financial_assistance_amount,
            ]];
        }

        return [];
    }

    private function buildWorkingCommitteeApprovalHistorySnapshot(\App\Models\WorkingCommitteeApproval $approval): array
    {
        return [
            'old_approval_financial_assistance_amount' => $approval->approval_financial_assistance_amount,
            'old_meeting_no' => $approval->meeting_no,
            'old_w_c_approval_date' => optional($approval->w_c_approval_date)->format('Y-m-d'),
            'old_disbursement_system' => $approval->disbursement_system,
            'old_disbursement_in_year' => $approval->disbursement_in_year,
            'old_disbursement_in_half_year' => $approval->disbursement_in_half_year,
            'old_yearly_dates' => $approval->yearly_dates,
            'old_yearly_amounts' => $approval->yearly_amounts,
            'old_half_yearly_dates' => $approval->half_yearly_dates,
            'old_half_yearly_amounts' => $approval->half_yearly_amounts,
            'old_installment_amount' => $approval->installment_amount,
            'old_no_of_months' => $approval->no_of_months,
            'old_total' => $approval->total,
            'old_additional_installment_amount' => $approval->additional_installment_amount,
            'old_repayment_type' => $approval->repayment_type,
            'old_repayment_starting_from' => optional($approval->repayment_starting_from)->format('Y-m-d'),
            'old_no_of_cheques_to_be_collected' => $approval->no_of_cheques_to_be_collected,
            'old_w_c_approval_remark' => $approval->w_c_approval_remark,
            'old_remarks_for_approval' => $approval->remarks_for_approval,
            'old_can_be_jito_member' => $approval->can_be_jito_member,
            'old_jito_member_date' => optional($approval->jito_member_date)->format('Y-m-d'),
            'old_can_be_jeap_donor' => $approval->can_be_jeap_donor,
            'old_jeap_donor_date' => optional($approval->jeap_donor_date)->format('Y-m-d'),
        ];
    }

    private function createWorkingCommitteeUpdateNotifications(
        User $user,
        \App\Models\WorkingCommitteeApproval $approval,
        WorkingCommitteeApprovalHistory $history
    ): void {
        $title = 'Working Committee amount updated';
        $message = sprintf(
            '%s working committee new amount has been sanctioned. Old amount: Rs. %s. New amount: Rs. %s. Please check.',
            $user->name,
            number_format((float) ($history->old_approval_financial_assistance_amount ?? 0), 2, '.', ''),
            number_format((float) ($approval->approval_financial_assistance_amount ?? 0), 2, '.', '')
        );

        $actionUrl = route('admin.working_committee.user.detail', ['user' => $user->id]);
        $createdBy = Auth::id();
        $rows = [];

        foreach (AdminUser::query()->select('id')->get() as $recipient) {
            $rows[] = [
                'recipient_role' => 'admin',
                'recipient_id' => $recipient->id,
                'user_id' => $user->id,
                'working_committee_approval_id' => $approval->id,
                'history_id' => $history->id,
                'title' => $title,
                'message' => $message,
                'action_url' => $actionUrl,
                'created_by' => $createdBy,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (
            ApexLeadership::query()
                ->where('status', true)
                ->where('show_hide', true)
                ->select('id')
                ->get() as $recipient
        ) {
            $rows[] = [
                'recipient_role' => 'apex',
                'recipient_id' => $recipient->id,
                'user_id' => $user->id,
                'working_committee_approval_id' => $approval->id,
                'history_id' => $history->id,
                'title' => $title,
                'message' => $message,
                'action_url' => $actionUrl,
                'created_by' => $createdBy,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($rows)) {
            AdminNotification::insert($rows);
        }
    }

    private function insertDisbursementSchedules(int $userId, int $workflowStatusId, array $plannedSchedules): void
    {
        if (empty($plannedSchedules)) {
            return;
        }

        $rows = [];

        foreach ($plannedSchedules as $index => $plannedSchedule) {
            $rows[] = [
                'user_id' => $userId,
                'workflow_status_id' => $workflowStatusId,
                'installment_no' => $plannedSchedule['installment_no'] ?? ($index + 1),
                'planned_date' => $plannedSchedule['planned_date'],
                'planned_amount' => $plannedSchedule['planned_amount'],
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->insert($rows);
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
        // Load all required relationships
        $user->load(['educationDetail', 'familyDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        $request->validate([
            'admin_remark' => 'required|string',
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

        /* ================= APEX 2 REJECT (CORRECTION FLOW) ================= */
        if ($stage === 'apex_2') {
            $workflow->update([
                'apex_2_status'          => 'rejected',
                'apex_2_reject_remarks' => $request->admin_remark,
                'apex_2_updated_at'     => now(),

                // stay on same stage
                'current_stage'         => 'apex_2',
                'final_status'          => 'in_progress',
            ]);

            $pdcdetails = PdcDetail::where('user_id', $user->id)->first();
            if ($pdcdetails) {
                $pdcdetails->update([
                    'status'        => 'rejected',
                    'admin_reject_remark'  => $request->admin_remark,
                    'processed_by'  => Auth::id(),
                ]);
            }

            // Log admin action
            // $this->logUserActivity(
            //     processType: ucfirst(str_replace('_', ' ', $stage)) . ' Send Back for Correction',
            //     processAction: 'Send Back For Correction',
            //     processDescription: $request->admin_remark ?? 'No remarks',
            //     module: $stage . '_action',
            //     oldValues: null,
            //     newValues: null,
            //     additionalData: [
            //         'user_id' => $user->id,
            //         'user_name' => $user->name,
            //         'stage' => $stage,
            //         'admin_remark' => $request->admin_remark,
            //         'previous_stage' => $workflow->current_stage,
            //         'new_stage' => 'apex_2',
            //         'final_status' => 'in_progress'
            //     ],

            //     // 🎯 TARGET → Shivam
            //     targetUserId: $user->id,

            //     // 👮 ACTOR → Ramesh
            //     actorId: Auth::id(),
            //     actorName: Auth::user()->name,
            //     actorRole: Auth::user()->role
            // );

            // Log admin action
            $this->logUserActivity(
                processType: "{$stage}_rejected",
                processAction: 'rejected',
                processDescription: $request->admin_remark ?? 'No remarks',
                module: "{$stage}_action",
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'stage' => $stage,
                    'admin_remark' => $request->admin_remark,
                    'apex_staff_remark' => $request->apex_staff_remark,
                    'previous_stage' => $workflow->current_stage,
                    'new_stage' => $updateData['current_stage'] ?? $workflow->current_stage
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );

            return back()->with(
                'success',
                'Apex Stage 2 rejected and sent for correction'
            );
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

            // Send email notification to user only for apex_1 stage
            if ($stage === 'apex_1') {
                try {
                    Mail::to($user->email)->send(new SendBackForCorrectionMail($user, $request->admin_remark));
                    Log::info("Send Back For Correction email sent to user {$user->id} ({$user->email}) for apex_1 stage");
                } catch (\Exception $e) {
                    Log::error("Failed to send Send Back For Correction email to user {$user->id} for apex_1 stage: " . $e->getMessage());
                }
            }
            // // Log admin action
            // $this->logUserActivity(
            //     processType: 'admin_rejection',
            //     processAction: 'rejected',
            //     processDescription: "Rejected {$stage} stage for user {$user->name} (ID: {$user->id}) - selective resubmission",
            //     module: 'admin_action',
            //     oldValues: null,
            //     newValues: null,
            //     additionalData: [
            //         'user_id' => $user->id,
            //         'user_name' => $user->name,
            //         'stage' => $stage,
            //         'admin_remark' => $request->admin_remark,
            //         'resubmit_steps' => $resubmitSteps,
            //         'resubmission_count' => $resubmissionCount,
            //         'previous_stage' => $workflow->current_stage,
            //         'final_status' => 'in_progress'
            //     ],

            //     // 🎯 TARGET → Shivam
            //     targetUserId: $user->id,

            //     // 👮 ACTOR → Ramesh
            //     actorId: Auth::id(),
            //     actorName: Auth::user()->name,
            //     actorRole: Auth::user()->role
            // );


            // Log admin action
            $this->logUserActivity(
                processType: ucfirst(str_replace('_', ' ', $stage)) . ' Send Back for Correction',
                processAction: 'Send Back For Correction',
                processDescription: $request->admin_remark ?? 'No remarks',
                module: $stage . '_action',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'stage' => $stage,
                    'admin_remark' => $request->admin_remark,
                    'previous_stage' => $workflow->current_stage,
                    'new_stage' => 'apex_2',
                    'final_status' => 'in_progress'
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );

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

            // Log admin action
            // Log admin action
            $this->logUserActivity(
                processType: ucfirst(str_replace('_', ' ', $stage)) . ' Send Back for Correction',
                processAction: 'Send back for correction',
                processDescription: $request->admin_remark ?? 'No remarks',
                module: $stage . '_action',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'stage' => $stage,
                    'admin_remark' => $request->admin_remark,
                    'previous_stage' => $workflow->current_stage,
                    'new_stage' => 'apex_2',
                    'final_status' => 'in_progress'
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );

            return back()->with('success', ucfirst(str_replace('_', ' ', $stage)) . " rejected");
        }
    }


    public function holdStage(Request $request, User $user, $stage)
    {
        $request->validate([
            'admin_remark'   => 'required|string|max:2000',
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
            // Handle selective hold (resubmission required)
            $holdCount = 0;

            foreach ($resubmitSteps as $step) {
                if ($step === 'personal') {
                    $user->update([
                        'submit_status' => 'hold',
                        'admin_remark'  => $request->admin_remark,
                        'updated_at'    => now(),
                    ]);
                    $holdCount++;

                    Log::info("Personal details marked on hold for user {$user->id}");
                } else {
                    $stepTableMap = [
                        'education'  => 'educationDetail',
                        'family'     => 'familyDetail',
                        'funding'    => 'fundingDetail',
                        'guarantor'  => 'guarantorDetail',
                        'documents'  => 'document',
                        'final'      => 'document',
                    ];

                    if (isset($stepTableMap[$step])) {
                        $relation = $stepTableMap[$step];

                        if ($user->$relation) {
                            $user->$relation->update([
                                'submit_status' => 'hold',
                                'admin_remark'  => $request->admin_remark,
                                'updated_at'    => now(),
                            ]);
                            $holdCount++;

                            Log::info("Step {$step} marked on hold for user {$user->id}");
                        }
                    }
                }
            }

            // Update workflow stage status → hold (keep final_status in_progress)
            $statusField        = $stage . '_status';
            $holdRemarksField   = $stage . '_hold_remarks';
            $updatedAtField     = $stage . '_updated_at';

            $workflow->update([
                $statusField      => 'hold',
                $holdRemarksField => $request->admin_remark,
                $updatedAtField   => now(),
                // final_status remains in_progress
            ]);

            // // Log admin action
            // $this->logUserActivity(
            //     processType: 'admin_hold',
            //     processAction: 'held',
            //     processDescription: "Put {$stage} stage on hold for user {$user->name} (ID: {$user->id}) - selective hold",
            //     module: 'admin_action',
            //     oldValues: null,
            //     newValues: null,
            //     additionalData: [
            //         'user_id' => $user->id,
            //         'user_name' => $user->name,
            //         'stage' => $stage,
            //         'admin_remark' => $request->admin_remark,
            //         'resubmit_steps' => $resubmitSteps,
            //         'hold_count' => $holdCount,
            //         'previous_stage' => $workflow->current_stage,
            //         'final_status' => 'in_progress'
            //     ],

            //     // 🎯 TARGET → Shivam
            //     targetUserId: $user->id,

            //     // 👮 ACTOR → Ramesh
            //     actorId: Auth::id(),
            //     actorName: Auth::user()->name,
            //     actorRole: Auth::user()->role
            // );

            // Log admin action
            $this->logUserActivity(
                processType: "{$stage}_hold",
                processAction: 'hold',
                processDescription: $request->admin_remark ?? 'No remarks',
                module: "{$stage}_action",
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'stage' => $stage,
                    'admin_remark' => $request->admin_remark,
                    'apex_staff_remark' => $request->apex_staff_remark,
                    'previous_stage' => $workflow->current_stage,
                    'new_stage' => $updateData['current_stage'] ?? $workflow->current_stage
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );

            return back()->with('success', "{$holdCount} step(s) marked on hold");
        } else {
            // Full hold (entire stage)
            $statusField      = $stage . '_status';
            $holdRemarksField = $stage . '_hold_remarks';
            $updatedAtField   = $stage . '_updated_at';

            $workflow->update([
                $statusField      => 'hold',
                $holdRemarksField => $request->admin_remark,
                $updatedAtField   => now(),
                'final_status'    => 'hold',
            ]);

            // Log admin action
            $this->logUserActivity(
                processType: 'admin_hold',
                processAction: 'held',
                processDescription: "Completely put {$stage} stage on hold for user {$user->name} (ID: {$user->id})",
                module: 'admin_action',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'stage' => $stage,
                    'admin_remark' => $request->admin_remark,
                    'previous_stage' => $workflow->current_stage,
                    'final_status' => 'hold'
                ],

                // 🎯 TARGET → Shivam
                targetUserId: $user->id,

                // 👮 ACTOR → Ramesh
                actorId: Auth::id(),
                actorName: Auth::user()->name,
                actorRole: Auth::user()->role
            );

            return back()->with(
                'success',
                ucfirst(str_replace('_', ' ', $stage)) . ' put on hold'
            );
        }
    }




    public function unholdWorkingCommittee(Request $request, User $user)
    {


        $workflow = $user->workflowStatus;
        if (!$workflow) {
            return back()->with('error', 'Workflow not found');
        }

        if ($workflow->working_committee_status !== 'hold') {
            return back()->with('error', 'Application is not on hold');
        }

        // Update workflow status to unhold - reset to pending and in_progress
        $workflow->update([
            'working_committee_status' => 'pending',
            'working_committee_updated_at' => now(),
            'final_status' => 'in_progress',
        ]);

        Log::info('Working Committee application unheld', [
            'user_id' => $user->id,
            'unheld_by' => Auth::user()->name,
        ]);

        $this->logUserActivity(
            processType: 'Working_Committee_Unhold',
            processAction: 'Unhold',
            processDescription: $request->w_c_approval_remark ?? 'No remarks',
            module: 'working_committee_unhold',
            oldValues: null,
            newValues: null,
            additionalData: [
                'approval_id' => Auth::id(),
                'stage' => 'working commitee unhold',
                'user_id' => $user->id,
                'user_name' => $user->name,
                'admin_remark' => $request->w_c_approval_remark,
                'previous_stage' => $workflow->current_stage,
                'new_stage' => 'apex_2'
            ],

            // 🎯 TARGET → Shivam
            targetUserId: $user->id,

            // 👮 ACTOR → Ramesh
            actorId: Auth::id(),
            actorName: Auth::user()->name,
            actorRole: Auth::user()->role
        );

        return back()->with('success', 'Application unheld successfully. Status reset to pending.');
    }

    public function chapterPending()
    {
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'chapter')
                    ->where('final_status', 'in_progress')
                    ->where('chapter_status', 'pending');
            });
        if (request('chapter_id')) {
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $this->attachLatestLoanCategoryType($users);

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

        $this->attachLatestLoanCategoryType($users);
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


        $this->attachLatestLoanCategoryType($users);
        return view('admin.chapters.stage2.hold', compact('users'));
    }

    public function chapterUserDetail(User $user)
    {
        $inter_date = ChapterInterviewAnswer::where('user_id', $user->id)->where('question_no', 1)->first();
        $data = EducationDetail::where('user_id', $user->id)->first();
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        $loanCategory = \App\Models\Loan_category::where('user_id', $user->id)->latest()->first();



        return view('admin.chapters.stage2.user_detail', compact('user', 'data', 'inter_date', 'loanCategory'));
    }

    public function workingCommitteeApproved()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'approved');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $this->attachLatestLoanCategoryType($users);
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

        $this->attachLatestLoanCategoryType($users);

        return view('admin.working_committee.pending', compact('users'));
    }

    public function workingCommitteeHold()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'hold');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $this->attachLatestLoanCategoryType($users);
        return view('admin.working_committee.hold', compact('users'));
    }

    public function workingCommitteeReject()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('working_committee_status', 'rejected');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $loanCategoryByUser = Loan_category::whereIn('user_id', $users->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('user_id')
            ->pluck('type', 'user_id');

        $users->each(function ($user) use ($loanCategoryByUser) {
            $user->loan_category_type = $loanCategoryByUser[$user->id] ?? null;
        });
        return view('admin.working_committee.hold', compact('users'));
    }

    public function workingCommitteeUserDetail(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);
        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();
        $completedDisbursementSchedules = DB::connection('admin_panel')
            ->table('disbursement_schedules')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('installment_no')
            ->get(['installment_no', 'planned_date', 'planned_amount', 'status']);
        // dd($workingCommitteeApproval);
        $loanCategory = \App\Models\Loan_category::where('user_id', $user->id)->latest()->first();
        $approvalHistories = DB::connection('admin_panel')
            ->table('working_committee_approval_histories as h')
            ->leftJoin('admin_users as au', 'au.id', '=', 'h.edited_by')
            ->where('h.user_id', $user->id)
            ->orderByDesc('h.created_at')
            ->get([
                'h.*',
                'au.name as edited_by_name',
                'au.email as edited_by_email',
            ]);

        return view('admin.working_committee.user_detail', compact('user', 'workingCommitteeApproval', 'loanCategory', 'completedDisbursementSchedules', 'approvalHistories'));
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

        $this->attachLatestLoanCategoryType($users);
        return view('admin.chapters.stage2.approved', compact('users')); // Reuse existing view
    }

    public function chapterDraft()
    {
        $chapter_id = request('chapter_id');
        $users = User::where('role', 'user')
            ->where('chapter_id', $chapter_id)
            ->where('application_status', 'draft')
            ->get();

        $this->attachLatestLoanCategoryType($users);
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

        $this->attachLatestLoanCategoryType($users);
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
        $this->attachLatestLoanCategoryType($users);
        return view('admin.chapters.stage2.pending', compact('users')); // Reuse existing view
    }

    public function chapterWorkingCommitteeApproved()
    {
        $chapter_id = request('chapter_id');
        $query = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('chapter_status', 'approved')
                    ->where('working_committee_status', 'approved');
            });

        if (request('chapter_id')) {
            $query->where('chapter_id', request('chapter_id'));
        }
        $users = $query->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $this->attachLatestLoanCategoryType($users);
        return view('admin.chapters.stage2.approved', compact('users')); // Reuse existing view
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

        $this->attachLatestLoanCategoryType($users);
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

        $allDisbursements = DB::connection('admin_panel')
            ->table('disbursements')
            ->where('user_id', $user->id)
            ->orderBy('disbursement_date')
            ->get();

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
            'document',
            'allDisbursements'
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

    // public function generateShortSummaryPDF(User $user)
    // {
    //     // Load relations
    //     $user->load([
    //         'workflowStatus',
    //         'educationDetail',
    //         'disbursementSchedules.disbursement', // IMPORTANT
    //         'repayments'
    //     ]);

    //     $workflow = $user->workflowStatus;
    //     $educationDetail = $user->educationDetail;

    //     // Working committee
    //     $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();

    //     // =========================
    //     // 🔹 DISBURSEMENT DATA
    //     // =========================
    //     $disbursementSchedules = $user->disbursementSchedules
    //         ->sortBy('installment_no')
    //         ->values();

    //     $disbursements = $disbursementSchedules
    //         ->map(function ($schedule) {
    //             return $schedule->disbursement;
    //         })
    //         ->filter()
    //         ->values();

    //     $paidDisbursementSchedules = $disbursementSchedules
    //         ->filter(fn($schedule) => (bool) $schedule->disbursement)
    //         ->values();

    //     $totalDisbursed = $disbursements->sum('amount');

    //     // First disbursement
    //     $firstDisbursement = $disbursements->sortBy('disbursement_date')->first();
    //     $firstSchedule = $disbursementSchedules->first();

    //     // =========================
    //     // 🔹 REPAYMENT DATA
    //     // =========================
    //     $repayments = $user->repayments
    //         ->sortBy('payment_date')
    //         ->values();

    //     $paidRepayments = $repayments->filter(function ($repayment) {
    //         return strtolower(trim((string) $repayment->status)) === 'paid';
    //     });

    //     $totalRepaid = $paidRepayments->sum('amount');

    //     // =========================
    //     // 🔹 REPAYMENT SUMMARY (NEW LOGIC)
    //     // =========================

    //     // Only paid repayments (sorted)
    //     $paidRepayments = $repayments
    //         ->filter(function ($r) {
    //             return strtolower(trim((string)$r->status)) === 'paid';
    //         })
    //         ->sortBy('payment_date')
    //         ->values();



    //     // =========================
    //     // 🔹 COMBINED REPAYMENT SCHEDULE
    //     // =========================

    //     // =========================
    //     // 🔹 PHASE-WISE SUMMARY (FINAL)
    //     // =========================

    //     $repaymentRows = [];

    //     $installmentAmounts = $workingCommitteeApproval->installment_amount ?? [];
    //     $monthsArray = $workingCommitteeApproval->no_of_months ?? [];
    //     $totalsArray = $workingCommitteeApproval->total ?? [];

    //     $startDate = \Carbon\Carbon::parse($workingCommitteeApproval->repayment_starting_from);


    //     // Running outstanding
    //     $totalExpected = array_sum($totalsArray); // 300000
    //     $runningOutstanding = $totalExpected;

    //     // Paid repayments
    //     $payments = $repayments
    //         ->filter(fn($r) => strtolower(trim($r->status)) === 'paid')
    //         ->sortBy('payment_date')
    //         ->values();

    //     $totalPaid = $payments->sum('amount');

    //     $runningOutstanding = $totalDisbursed;

    //     $currentDate = $startDate->copy();

    //     $totalExpected = array_sum($totalsArray);

    //     foreach ($totalsArray as $index => $totalAmount) {

    //         $months = (int) ($monthsArray[$index] ?? 0);

    //         // Calculate how much paid falls into this phase
    //         $phasePaid = 0;

    //         foreach ($payments as $payment) {
    //             if (
    //                 $payment->payment_date >= $currentDate &&
    //                 $payment->payment_date < $currentDate->copy()->addMonths($months)
    //             ) {

    //                 $phasePaid += $payment->amount;
    //             }
    //         }

    //         $runningOutstanding -= $phasePaid;

    //         $repaymentRows[] = [
    //             'date' => $currentDate->copy(),
    //             'expected' => (float) $totalAmount,
    //             'paid' => $phasePaid,
    //             'outstanding' => max($runningOutstanding, 0),
    //         ];

    //         // Move to next phase start date
    //         $currentDate->addMonths($months);
    //     }

    //     // Total paid
    //     $totalPaid = $repayments
    //         ->filter(fn($r) => strtolower(trim($r->status)) === 'paid')
    //         ->sum('amount');

    //     $pdcInstallments = $this->getPdcInstallmentsWithStatus($user);

    //     // Outstanding
    //     $outstanding = $totalExpected - $totalPaid;

    //     // =========================
    //     // 🔹 PASS TO VIEW
    //     // =========================
    //     $pdf = Pdf::loadView('pdf.jeap-short-summary', compact(
    //         'user',
    //         'workflow',
    //         'educationDetail',
    //         'workingCommitteeApproval',
    //         'disbursements',
    //         'disbursementSchedules',
    //         'paidDisbursementSchedules',
    //         'firstDisbursement',
    //         'firstSchedule',
    //         'repayments',
    //         'pdcInstallments',
    //         'totalDisbursed',
    //         'totalRepaid',
    //         'outstanding',
    //         'repaymentRows',
    //         'totalPaid',
    //         'totalExpected'
    //     ));

    //     $pdf->setPaper('a4', 'portrait');

    //     return $pdf->stream('JEAP_Short_Summary_' . $user->id . '.pdf');
    // }

    public function generateShortSummaryPDF(User $user)
    {
        // Load relations
        $user->load([
            'workflowStatus',
            'educationDetail',
            'disbursementSchedules.disbursement',
            'repayments'
        ]);

        $workflow = $user->workflowStatus;
        $educationDetail = $user->educationDetail;

        // Working committee
        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();

        // =========================
        // 🔹 DISBURSEMENT DATA
        // =========================
        $disbursementSchedules = $user->disbursementSchedules
            ->sortBy('installment_no')
            ->values();

        $disbursements = $disbursementSchedules
            ->map(fn($schedule) => $schedule->disbursement)
            ->filter()
            ->values();


        $paidDisbursementSchedules = $disbursementSchedules
            ->filter(fn($schedule) => (bool) $schedule->disbursement)
            ->values();

        $totalDisbursed = $disbursements->sum('amount');

        $firstDisbursement = $disbursements->sortBy('disbursement_date')->first();
        $firstSchedule = $disbursementSchedules->first();

        // =========================
        // 🔹 REPAYMENT DATA
        // =========================
        $repayments = $user->repayments
            ->sortBy('payment_date')
            ->values();

        // =========================
        // 🔹 PHASE-WISE REPAYMENT SUMMARY
        // =========================

        // Safe array handling (in case casting not applied)
        $installmentAmounts = is_array($workingCommitteeApproval->installment_amount)
            ? $workingCommitteeApproval->installment_amount
            : json_decode($workingCommitteeApproval->installment_amount, true);

        $monthsArray = is_array($workingCommitteeApproval->no_of_months)
            ? $workingCommitteeApproval->no_of_months
            : json_decode($workingCommitteeApproval->no_of_months, true);

        $totalsArray = is_array($workingCommitteeApproval->total)
            ? $workingCommitteeApproval->total
            : json_decode($workingCommitteeApproval->total, true);

        // Start date
        $startDate = \Carbon\Carbon::parse($workingCommitteeApproval->repayment_starting_from);

        // ✅ TOTAL EXPECTED (IMPORTANT)
        $totalExpected = array_sum($totalsArray);

        // Paid repayments
        $payments = $repayments
            ->filter(fn($r) => strtolower(trim($r->status)) === 'paid')
            ->sortBy('payment_date')
            ->values();

        $totalPaid = $payments->sum('amount');

        // Running outstanding starts from TOTAL EXPECTED
        $runningOutstanding = $totalExpected;

        $repaymentRows = [];
        $currentDate = $startDate->copy();

        $remainingPayments = $payments->values();


        foreach ($totalsArray as $index => $totalAmount) {

            $months = (int) ($monthsArray[$index] ?? 0);

            $expected = (float) $totalAmount;
            $phasePaid = 0;

            $paymentDate = null; // ✅ track payment date

            while ($remainingPayments->isNotEmpty() && $expected > 0) {

                $payment = $remainingPayments->shift(); // full object

                if (!$paymentDate) {
                    $paymentDate = $payment->payment_date; // ✅ first payment date
                }

                if ($payment->amount <= $expected) {
                    $phasePaid += $payment->amount;
                    $expected -= $payment->amount;
                } else {
                    $phasePaid += $expected;

                    // push remaining back
                    $remainingPayments->prepend((object)[
                        'amount' => $payment->amount - $expected,
                        'payment_date' => $payment->payment_date
                    ]);

                    $expected = 0;
                }
            }

            $runningOutstanding -= $phasePaid;

            $repaymentRows[] = [
                // ✅ IMPORTANT CHANGE HERE
                'date' => $phasePaid > 0
                    ? \Carbon\Carbon::parse($paymentDate)
                    : $currentDate->copy(),

                'expected' => (float) $totalAmount,
                'paid' => $phasePaid,
                'outstanding' => max($runningOutstanding, 0),
            ];

            $currentDate->addMonths($months);
        }

        // Final outstanding
        $outstanding = $totalExpected - $totalPaid;

        // =========================
        // 🔹 OTHER DATA
        // =========================
        $pdcInstallments = $this->getPdcInstallmentsWithStatus($user);

        // =========================
        // 🔹 PASS TO VIEW
        // =========================
        $pdf = Pdf::loadView('pdf.jeap-short-summary', compact(
            'user',
            'workflow',
            'educationDetail',
            'workingCommitteeApproval',
            'disbursements',
            'disbursementSchedules',
            'paidDisbursementSchedules',
            'firstDisbursement',
            'firstSchedule',
            'repayments',
            'pdcInstallments',
            'totalDisbursed',
            'repaymentRows',
            'totalPaid',
            'totalExpected',
            'outstanding'
        ));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('JEAP_Short_Summary_' . $user->id . '.pdf');
    }

    public function generateFinancialClosurePDF(User $user)
    {
        $user->load(['repayments']);

        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();

        $userNumber = $user->application_no;

        if (!$workingCommitteeApproval) {
            abort(404, 'Approval data not found');
        }

        $totalsArray = is_array($workingCommitteeApproval->total)
            ? $workingCommitteeApproval->total
            : json_decode($workingCommitteeApproval->total, true);

        $totalExpected = array_sum($totalsArray);

        $payments = $user->repayments
            ->filter(fn($r) => strtolower(trim($r->status)) === 'paid');

        $totalPaid = $payments->sum('amount');

        // ❗ Closure check
        if ($totalPaid < $totalExpected) {
            return back()->with('error', 'Loan is not fully repaid yet.');
        }

        // ✅ Closure date = LAST payment date
        $closureDate = $payments->sortByDesc('payment_date')->first()->payment_date;

        $pdf = Pdf::loadView('pdf.financial-closure-report', [
            'user' => $user,
            'totalExpected' => $totalExpected,
            'totalPaid' => $totalPaid,
            'closureDate' => $closureDate,
            'approval' => $workingCommitteeApproval,
            'userNumber' => $userNumber
        ]);

        return $pdf->stream('Financial_Closure_Report_' . $user->id . '.pdf');
    }
    public function viewSanctionLetter(User $user)
    {
        // Load all related data
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);

        $educationDetail = $user->educationDetail;
        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();

        // Check if user is approved at working committee level
        if (!$workingCommitteeApproval || $workingCommitteeApproval->approval_status !== 'approved') {
            return redirect()->back()->with('error', 'Sanction letter is only available for working committee approved applications.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('pdf.jeap-sanction-letter', compact('user', 'educationDetail', 'workingCommitteeApproval'));

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Return PDF download/stream
        $filename = 'JEAP_Sanction_Letter_' . $user->name . '_' . $user->id . '.pdf';
        return $pdf->stream($filename);
    }









    public function apexStage2Approved()
    {
        // Get users where final_status = 'approved'
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('apex_2_status', 'approved');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $loanCategoryByUser = Loan_category::whereIn('user_id', $users->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('user_id')
            ->pluck('type', 'user_id');

        $users->each(function ($user) use ($loanCategoryByUser) {
            $user->loan_category_type = $loanCategoryByUser[$user->id] ?? null;
        });
        return view('admin.apex.stage2.approved', compact('users'));
    }

    public function apexStage2Pending()
    {
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('current_stage', 'apex_2')
                    ->where('apex_2_status', 'pending')->whereNull('apex_2_reject_remarks');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $loanCategoryByUser = Loan_category::whereIn('user_id', $users->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('user_id')
            ->pluck('type', 'user_id');

        $users->each(function ($user) use ($loanCategoryByUser) {
            $user->loan_category_type = $loanCategoryByUser[$user->id] ?? null;
        });

        return view('admin.apex.stage2.pending', compact('users'));
    }


    public function apexStage2Hold()
    {
        // Get users where final_status = 'rejected'
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($q) {
                $q->where('apex_2_status', 'rejected')
                    ->where('current_stage', 'apex_2');;
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $loanCategoryByUser = Loan_category::whereIn('user_id', $users->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('user_id')
            ->pluck('type', 'user_id');

        $users->each(function ($user) use ($loanCategoryByUser) {
            $user->loan_category_type = $loanCategoryByUser[$user->id] ?? null;
        });
        return view('admin.apex.stage2.hold', compact('users'));
    }

    public function apexStage2Resubmitted()
    {
        // Get users where apex_1_status = 'pending' but have admin remarks indicating resubmission
        $users = User::where('role', 'user')
            ->whereHas('workflowStatus', function ($query) {
                $query->where('apex_2_status', 'pending')
                    ->whereNotNull('apex_2_reject_remarks')
                    ->where('current_stage', 'apex_2');
            })
            ->with(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document'])
            ->get();

        $loanCategoryByUser = Loan_category::whereIn('user_id', $users->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('user_id')
            ->pluck('type', 'user_id');

        $users->each(function ($user) use ($loanCategoryByUser) {
            $user->loan_category_type = $loanCategoryByUser[$user->id] ?? null;
        });

        return view('admin.apex.stage2.pending', compact('users'));
    }

    public function apexStage2UserDetail(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document']);

        // Load PDC details
        $pdcDetail = \App\Models\PdcDetail::where('user_id', $user->id)->first();
        $loanCategory = \App\Models\Loan_category::where('user_id', $user->id)->latest()->first();
        $courierDocumentChecklist = $this->getUploadedCourierDocumentChecklist($user, $loanCategory);

        // Load edit bank detail request if exists
        $editBankDetailRequest = \App\Models\EditBankDetailRequest::where('user_id', $user->id)->latest()->first();

        return view('admin.apex.stage2.user_detail', compact('user', 'pdcDetail', 'loanCategory', 'editBankDetailRequest', 'courierDocumentChecklist'));
    }

    /**
     * Approve Edit Bank Detail Request
     */
    public function approveEditBankDetailRequest(Request $request, User $user)
    {
        $editRequest = \App\Models\EditBankDetailRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$editRequest) {
            return response()->json([
                'success' => false,
                'message' => 'No pending request found'
            ], 404);
        }

        $editRequest->update([
            'status' => 'approved',
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request approved successfully! User can now edit bank details.'
        ]);
    }

    /**
     * Reject Edit Bank Detail Request
     */
    public function rejectEditBankDetailRequest(Request $request, User $user)
    {
        $request->validate([
            'admin_remark' => 'required|string|max:2000',
        ]);

        $editRequest = \App\Models\EditBankDetailRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$editRequest) {
            return response()->json([
                'success' => false,
                'message' => 'No pending request found'
            ], 404);
        }

        $editRequest->update([
            'status' => 'rejected',
            'admin_remark' => $request->admin_remark,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request rejected successfully!'
        ]);
        return view('admin.apex.stage2.user_detail', compact('user', 'pdcDetail', 'loanCategory', 'courierDocumentChecklist'));
    }

    public function storeCourierReceive(Request $request, User $user)
    {
        $request->validate([
            'courier_received_by' => 'required|string|max:255',
            'courier_received_date' => 'required|date',
        ]);

        $pdcDetail = PdcDetail::where('user_id', $user->id)->first();

        if (!$pdcDetail) {
            return back()->with('error', 'PDC details not found.');
        }

        $oldValues = $pdcDetail->only([
            'courier_received_by',
            'courier_received_date',
            'courier_receive_status',
            'courier_receive_hold_remark',
            'courier_receive_processed_by',
            'courier_receive_processed_at',
            'courier_receive_verified_documents',
            'status',
            'admin_reject_remark',
        ]);

        $pdcDetail->update([
            'courier_received_by' => $request->courier_received_by,
            'courier_received_date' => $request->courier_received_date,
            'courier_receive_status' => 'pending',
            'courier_receive_hold_remark' => null,
            'courier_receive_processed_by' => null,
            'courier_receive_processed_at' => null,
            'courier_receive_verified_documents' => null,
            'status' => 'submitted',
            'admin_reject_remark' => null,
        ]);

        $newValues = $pdcDetail->fresh()->only([
            'courier_received_by',
            'courier_received_date',
            'courier_receive_status',
            'courier_receive_hold_remark',
            'courier_receive_processed_by',
            'courier_receive_processed_at',
            'courier_receive_verified_documents',
            'status',
            'admin_reject_remark',
        ]);

        $actor = Auth::user();
        if ($actor) {
            $this->logUserActivity(
                processType: 'courier_receive',
                processAction: 'saved',
                processDescription: 'Courier receive details saved',
                module: 'pdc',
                oldValues: $oldValues,
                newValues: $newValues,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ],
                targetUserId: $user->id,
                actorId: $actor->id,
                actorName: $actor->name,
                actorRole: $actor->role
            );
        }

        return back()->with('success', 'Courier receive details saved successfully.');
    }

    public function reviewCourierReceive(Request $request, User $user)
    {
        $request->validate([
            'courier_action' => 'required|in:approve,hold',
            'courier_receive_hold_remark' => 'nullable|string|max:2000',
        ]);

        $pdcDetail = PdcDetail::where('user_id', $user->id)->first();

        if (!$pdcDetail) {
            return back()->with('error', 'PDC details not found.');
        }

        if (!$pdcDetail->courier_received_by || !$pdcDetail->courier_received_date) {
            return back()->with('error', 'Please save courier receive details before approval or hold.');
        }

        if ($request->courier_action === 'hold') {
            $request->validate([
                'courier_receive_hold_remark' => 'required|string|max:2000',
            ]);

            $oldValues = $pdcDetail->only([
                'courier_receive_status',
                'courier_receive_hold_remark',
                'courier_receive_processed_by',
                'courier_receive_processed_at',
                'courier_receive_verified_documents',
                'status',
                'admin_reject_remark',
            ]);

            $pdcDetail->update([
                'courier_receive_status' => 'hold',
                'courier_receive_hold_remark' => $request->courier_receive_hold_remark,
                'courier_receive_processed_by' => Auth::id(),
                'courier_receive_processed_at' => now(),
                'courier_receive_verified_documents' => null,
                'status' => 'correction_required',
                'admin_reject_remark' => $request->courier_receive_hold_remark,
            ]);

            $newValues = $pdcDetail->fresh()->only([
                'courier_receive_status',
                'courier_receive_hold_remark',
                'courier_receive_processed_by',
                'courier_receive_processed_at',
                'courier_receive_verified_documents',
                'status',
                'admin_reject_remark',
            ]);

            $actor = Auth::user();
            if ($actor) {
                $this->logUserActivity(
                    processType: 'courier_receive',
                    processAction: 'hold',
                    processDescription: $request->courier_receive_hold_remark,
                    module: 'pdc',
                    oldValues: $oldValues,
                    newValues: $newValues,
                    additionalData: [
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'verified_documents' => [],
                    ],
                    targetUserId: $user->id,
                    actorId: $actor->id,
                    actorName: $actor->name,
                    actorRole: $actor->role
                );
            }

            try {
                Mail::to($user->email)->send(new SendBackForCorrectionMail($user, $request->courier_receive_hold_remark));
                Log::info("Courier receive hold email sent to user {$user->id} ({$user->email})");
            } catch (\Exception $e) {
                Log::error("Failed to send courier receive hold email to user {$user->id}: " . $e->getMessage());
            }

            return back()->with('success', 'Courier receive marked as hold and mail sent to the student.');
        }

        $loanCategory = \App\Models\Loan_category::where('user_id', $user->id)->latest()->first();
        $uploadedDocuments = $this->getUploadedCourierDocumentChecklist($user->loadMissing('document'), $loanCategory);
        $expectedDocuments = collect($uploadedDocuments)->pluck('label')->values()->all();
        $approvedDocuments = collect($request->input('courier_verified_documents', []))
            ->filter(fn($value) => is_string($value) && $value !== '')
            ->values()
            ->all();

        if (empty($expectedDocuments)) {
            throw ValidationException::withMessages([
                'courier_verified_documents' => 'No uploaded documents were found for courier approval.',
            ]);
        }

        sort($expectedDocuments);
        sort($approvedDocuments);

        // Filter out 'Other' from expected documents (it's optional for approval)
        $requiredDocuments = array_filter($expectedDocuments, function ($doc) {
            return strtolower(trim($doc)) !== 'other';
        });
        $requiredDocuments = array_values($requiredDocuments);

        // Check if all required documents (except 'Other') are selected
        $missingDocuments = array_diff($requiredDocuments, $approvedDocuments);

        if (!empty($missingDocuments)) {
            throw ValidationException::withMessages([
                'courier_verified_documents' => 'Please select all documents except "Other" for approving. Missing: ' . implode(', ', $missingDocuments),
            ]);
        }

        $oldValues = $pdcDetail->only([
            'courier_receive_status',
            'courier_receive_hold_remark',
            'courier_receive_processed_by',
            'courier_receive_processed_at',
            'courier_receive_verified_documents',
            'status',
            'admin_reject_remark',
        ]);

        $pdcDetail->update([
            'courier_receive_status' => 'approved',
            'courier_receive_hold_remark' => null,
            'courier_receive_processed_by' => Auth::id(),
            'courier_receive_processed_at' => now(),
            'courier_receive_verified_documents' => $approvedDocuments,
            'status' => $pdcDetail->status === 'approved' ? 'approved' : 'submitted',
            'admin_reject_remark' => null,
        ]);

        $newValues = $pdcDetail->fresh()->only([
            'courier_receive_status',
            'courier_receive_hold_remark',
            'courier_receive_processed_by',
            'courier_receive_processed_at',
            'courier_receive_verified_documents',
            'status',
            'admin_reject_remark',
        ]);

        $actor = Auth::user();
        if ($actor) {
            $this->logUserActivity(
                processType: 'courier_receive',
                processAction: 'approved',
                processDescription: 'Courier receive approved',
                module: 'pdc',
                oldValues: $oldValues,
                newValues: $newValues,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'verified_documents' => $approvedDocuments,
                ],
                targetUserId: $user->id,
                actorId: $actor->id,
                actorName: $actor->name,
                actorRole: $actor->role
            );
        }

        return back()->with('success', 'Courier receive approved successfully.');
    }

    // =====================================================
    // Third Stage Document Methods
    // =====================================================

    public function thirdStageDocumentPending()
    {
        $users = User::where('role', 'user')
            ->whereHas('thirdStageDocument', function ($q) {
                $q->whereIn('status', ['pending', 'rejected']);
            })
            ->with(['thirdStageDocument', 'workflowStatus'])
            ->get();

        return view('admin.third_stage_documents.pending', compact('users'));
    }

    public function thirdStageDocumentSubmitted()
    {
        $users = User::where('role', 'user')
            ->whereHas('thirdStageDocument', function ($q) {
                $q->where('status', 'submitted');
            })
            ->with(['thirdStageDocument', 'workflowStatus'])
            ->get();

        return view('admin.third_stage_documents.submitted', compact('users'));
    }

    public function thirdStageDocumentApproved()
    {
        $users = User::where('role', 'user')
            ->whereHas('thirdStageDocument', function ($q) {
                $q->where('status', 'approved');
            })
            ->with(['thirdStageDocument', 'workflowStatus'])
            ->get();

        return view('admin.third_stage_documents.approved', compact('users'));
    }

    public function thirdStageDocumentUserDetail(User $user)
    {
        $user->load(['thirdStageDocument', 'workflowStatus']);
        return view('admin.third_stage_documents.user_detail', compact('user'));
    }

    public function approveThirdStageDocument(Request $request, User $user)
    {
        $request->validate([
            'admin_remark' => 'nullable|string|max:2000',
        ]);

        $thirdStageDocument = ThirdStageDocument::where('user_id', $user->id)->first();
        if (!$thirdStageDocument) {
            return back()->with('error', 'Third stage documents not found.');
        }

        if ($thirdStageDocument->status !== 'submitted') {
            return back()->with('error', 'Only submitted documents can be approved.');
        }

        $thirdStageDocument->update([
            'status' => 'approved',
            'admin_remark' => $request->admin_remark,
            'approved_at' => now(),
            'processed_by' => Auth::id(),
        ]);

        return back()->with('success', 'Third stage documents approved successfully.');
    }

    public function sendBackThirdStageDocument(Request $request, User $user)
    {
        $request->validate([
            'admin_remark' => 'required|string|max:2000',
        ]);

        $thirdStageDocument = ThirdStageDocument::where('user_id', $user->id)->first();
        if (!$thirdStageDocument) {
            return back()->with('error', 'Third stage documents not found.');
        }

        $thirdStageDocument->update([
            'status' => 'rejected',
            'admin_remark' => $request->admin_remark,
            'rejected_at' => now(),
            'processed_by' => Auth::id(),
        ]);

        try {
            Mail::to($user->email)->send(new ThirdStageDocumentCorrectionMail($user, $request->admin_remark));
        } catch (\Throwable $e) {
            Log::error('Third stage correction email failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        return back()->with('success', 'Third stage documents sent back for correction.');
    }

    public function generateThirdStageDocumentPDF(User $user)
    {
        $user->load(['thirdStageDocument', 'disbursementSchedules.disbursement']);

        $thirdStageDocument = $user->thirdStageDocument;

        if (!$thirdStageDocument) {
            return back()->with('error', 'Third stage documents not found.');
        }

        if ($thirdStageDocument->status !== 'approved') {
            return back()->with('error', 'PDF can only be generated after third stage documents are approved.');
        }

        $workingCommitteeApproval = WorkingCommitteeApproval::where('user_id', $user->id)->first();

        $schedules = $user->disbursementSchedules
            ->sortBy(fn ($schedule) => $schedule->installment_no ?? 0)
            ->values();

        $firstSchedule = $schedules->first();
        $secondSchedule = $schedules->where('installment_no', 2)->first() ?? $schedules->skip(1)->first();

        $firstDisbursementAmount = $this->resolveThirdStageScheduleAmount($firstSchedule);
        $secondDisbursementAmount = $this->resolveThirdStageScheduleAmount($secondSchedule);

        $pdf = Pdf::loadView('pdf.third-stage-documents', [
            'user' => $user,
            'thirdStageDocument' => $thirdStageDocument,
            'workingCommitteeApproval' => $workingCommitteeApproval,
            'firstDisbursementAmount' => $firstDisbursementAmount,
            'secondDisbursementAmount' => $secondDisbursementAmount,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Third_Stage_Documents_' . $user->id . '.pdf');
    }

    private function resolveThirdStageScheduleAmount($schedule): float
    {
        if (!$schedule) {
            return 0.0;
        }

        $amount = optional($schedule->disbursement)->amount ?? $schedule->planned_amount ?? 0;

        return (float) $amount;
    }

    // =====================================================
    // PDC (Cheque) Stage Methods
    // =====================================================

    public function pdcPending()
    {
        $users = User::where('role', 'user')
            ->whereHas('pdcDetail', function ($q) {
                $q->where('status', 'submitted')
                    ->where('courier_receive_status', 'approved');
            })
            ->with(['pdcDetail', 'workflowStatus'])
            ->get();
        return view('admin.pdc.pending', compact('users'));
    }

    public function pdcApproved()
    {
        $users = User::where('role', 'user')
            ->whereHas('pdcDetail', function ($q) {
                $q->where('status', 'approved');
            })
            ->with(['pdcDetail', 'workflowStatus'])
            ->get();
        return view('admin.pdc.approved', compact('users'));
    }

    public function pdcHold()
    {
        $users = User::where('role', 'user')
            ->whereHas('pdcDetail', function ($q) {
                $q->whereIn('status', ['correction_required', 'rejected']);
            })
            ->with(['pdcDetail', 'workflowStatus'])
            ->get();
        return view('admin.pdc.hold', compact('users'));
    }

    public function pdcUserDetail(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document', 'pdcDetail']);
        return view('admin.pdc.user_detail', compact('user'));
    }

    public function approvePdc(Request $request, User $user)
    {
        $request->validate([
            'admin_remark' => 'nullable|string|max:2000',
        ]);

        $pdcDetail = \App\Models\PdcDetail::where('user_id', $user->id)->first();

        if (!$pdcDetail) {
            return back()->with('error', 'PDC details not found');
        }

        if (!$this->isCourierReceiveApproved($pdcDetail)) {
            return back()->with('error', 'Courier receive approval is required before processing PDC details.');
        }

        $oldValues = $pdcDetail->only([
            'status',
            'admin_remark',
            'processed_by',
        ]);

        $pdcDetail->update([
            'status' => 'approved',
            'admin_remark' => $request->admin_remark,
            'processed_by' => Auth::id(),
        ]);

        $newValues = $pdcDetail->fresh()->only([
            'status',
            'admin_remark',
            'processed_by',
        ]);

        // Update workflow status
        $workflow = $user->workflowStatus;
        if ($workflow) {
            $workflow->update([
                'current_stage' => 'pdc',
                'final_status' => 'approved',
            ]);
        }

        $actor = Auth::user();
        if ($actor) {
            $this->logUserActivity(
                processType: 'pdc',
                processAction: 'approved',
                processDescription: $request->admin_remark ?? 'PDC approved',
                module: 'pdc',
                oldValues: $oldValues,
                newValues: $newValues,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ],
                targetUserId: $user->id,
                actorId: $actor->id,
                actorName: $actor->name,
                actorRole: $actor->role
            );
        }

        return back()->with('success', 'PDC approved successfully');
    }

    public function sendBackPdc(Request $request, User $user)
    {
        $request->validate([
            'admin_remark' => 'required|string|max:2000',
        ]);

        $pdcDetail = \App\Models\PdcDetail::where('user_id', $user->id)->first();

        if (!$pdcDetail) {
            return back()->with('error', 'PDC details not found');
        }

        if (!$this->isCourierReceiveApproved($pdcDetail)) {
            return back()->with('error', 'Courier receive approval is required before processing PDC details.');
        }

        $oldValues = $pdcDetail->only([
            'status',
            'admin_remark',
            'processed_by',
        ]);

        $pdcDetail->update([
            'status' => 'correction_required',
            'admin_remark' => $request->admin_remark,
            'processed_by' => Auth::id(),
        ]);

        $newValues = $pdcDetail->fresh()->only([
            'status',
            'admin_remark',
            'processed_by',
        ]);

        $actor = Auth::user();
        if ($actor) {
            $this->logUserActivity(
                processType: 'pdc',
                processAction: 'correction_required',
                processDescription: $request->admin_remark,
                module: 'pdc',
                oldValues: $oldValues,
                newValues: $newValues,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ],
                targetUserId: $user->id,
                actorId: $actor->id,
                actorName: $actor->name,
                actorRole: $actor->role
            );
        }

        return back()->with('success', 'PDC sent back for correction');
    }

    /**
     * Show the edit form for PDC details
     */
    public function editPdc(User $user)
    {
        $user->load(['workflowStatus', 'familyDetail', 'educationDetail', 'fundingDetail', 'guarantorDetail', 'document', 'pdcDetail']);

        if (!$user->pdcDetail) {
            return back()->with('error', 'PDC details not found');
        }

        if (!$this->isCourierReceiveApproved($user->pdcDetail)) {
            return back()->with('error', 'Courier receive approval is required before editing PDC details.');
        }

        $actor = Auth::user();
        if ($actor) {
            $this->logUserActivity(
                processType: 'pdc',
                processAction: 'edit_view',
                processDescription: 'PDC edit page opened',
                module: 'pdc',
                oldValues: null,
                newValues: null,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ],
                targetUserId: $user->id,
                actorId: $actor->id,
                actorName: $actor->name,
                actorRole: $actor->role
            );
        }

        // Load Working Committee Approval details
        $workingCommitteeApproval = \App\Models\WorkingCommitteeApproval::where('user_id', $user->id)->first();

        // Get bank details from fundingDetail for autofill
        $bankDetails = null;
        if ($user->fundingDetail) {
            $bankDetails = [
                'bank_name' => $user->fundingDetail->bank_name ?? '',
                'ifsc' => $user->fundingDetail->ifsc_code ?? '',
                'account_number' => $user->fundingDetail->account_number ?? '',
                'branch_name' => $user->fundingDetail->branch_name ?? '',
            ];
        }

        $lockedPdcInstallments = $this->getLockedPdcInstallments($user);

        return view('admin.pdc.edit', compact('user', 'workingCommitteeApproval', 'bankDetails', 'lockedPdcInstallments'));
    }

    /**
     * Update PDC details
     */
    public function updatePdc(Request $request, User $user)
    {
        $request->validate([
            'first_cheque_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cheque_details' => 'required|array',
            'cheque_details.*.parents_jnt_ac_name' => 'required|string|max:255',
            'cheque_details.*.cheque_date' => 'required|date',
            'cheque_details.*.amount' => 'required|numeric|min:0',
            'cheque_details.*.bank_name' => 'required|string|max:255',
            'cheque_details.*.ifsc' => 'required|string|max:11',
            'cheque_details.*.account_number' => 'required|string|max:20',
            'cheque_details.*.cheque_number' => 'required|string|max:20',
        ]);

        $pdcDetail = \App\Models\PdcDetail::where('user_id', $user->id)->first();

        if (!$pdcDetail) {
            return back()->with('error', 'PDC details not found');
        }

        if (!$this->isCourierReceiveApproved($pdcDetail)) {
            return back()->with('error', 'Courier receive approval is required before updating PDC details.');
        }

        $oldValues = $pdcDetail->only([
            'first_cheque_image',
            'cheque_details',
            'status',
            'processed_by',
        ]);

        $normalizedChequeDetails = collect($request->cheque_details)
            ->values()
            ->map(function ($cheque, $index) {
                $cheque['row_number'] = $index + 1;
                return $cheque;
            })
            ->all();

        $this->validateLockedPdcChequeDetails(
            $pdcDetail->cheque_details,
            $normalizedChequeDetails,
            $this->getLockedPdcInstallments($user)
        );

        // Handle file upload if new image is provided
        $chequeImagePath = $pdcDetail->first_cheque_image;

        if ($request->hasFile('first_cheque_image')) {
            // Delete old image if exists
            if ($pdcDetail->first_cheque_image && file_exists(public_path($pdcDetail->first_cheque_image))) {
                unlink(public_path($pdcDetail->first_cheque_image));
            }

            // Upload new image
            $file = $request->file('first_cheque_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('pdc_cheques'), $filename);
            $chequeImagePath = 'pdc_cheques/' . $filename;
        }

        // Update PDC details
        $pdcDetail->update([
            'first_cheque_image' => $chequeImagePath,
            'cheque_details' => json_encode($normalizedChequeDetails),
            'status' => 'submitted', // Reset status to submitted for review
            'processed_by' => Auth::id(),
        ]);

        $newValues = $pdcDetail->fresh()->only([
            'first_cheque_image',
            'cheque_details',
            'status',
            'processed_by',
        ]);

        $actor = Auth::user();
        if ($actor) {
            $this->logUserActivity(
                processType: 'pdc',
                processAction: 'updated',
                processDescription: 'PDC details updated',
                module: 'pdc',
                oldValues: $oldValues,
                newValues: $newValues,
                additionalData: [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                ],
                targetUserId: $user->id,
                actorId: $actor->id,
                actorName: $actor->name,
                actorRole: $actor->role
            );
        }

        return redirect()->route('admin.apex.stage2.user.detail', $user)
            ->with('success', 'PDC details updated successfully');
    }

    private function getPdcInstallmentsWithStatus(User $user, bool $onlyPaidOrPartial = false)
    {
        $pdcDetail = PdcDetail::query()
            ->where('user_id', $user->id)
            ->latest('id')
            ->first();

        if (!$pdcDetail) {
            return collect();
        }

        $chequeDetails = $pdcDetail->cheque_details;

        if (is_string($chequeDetails)) {
            $decoded = json_decode($chequeDetails, true);
            $chequeDetails = is_array($decoded) ? $decoded : [];
        }

        if (!is_array($chequeDetails)) {
            return collect();
        }

        $installments = collect($chequeDetails)
            ->filter(fn($item) => is_array($item))
            ->map(function (array $item, int $index) {
                return (object) [
                    'installment_no' => (int) ($item['row_number'] ?? ($index + 1)),
                    'parents_jnt_ac_name' => $item['parents_jnt_ac_name'] ?? null,
                    'cheque_date' => $item['cheque_date'] ?? null,
                    'amount' => (float) ($item['amount'] ?? 0),
                    'bank_name' => $item['bank_name'] ?? null,
                    'ifsc' => $item['ifsc'] ?? null,
                    'account_number' => $item['account_number'] ?? null,
                    'cheque_number' => $item['cheque_number'] ?? null,
                ];
            })
            ->sortBy('installment_no')
            ->values();

        $remainingPaidAmount = (float) DB::connection('admin_panel')
            ->table('repayments')
            ->where('user_id', $user->id)
            ->where('status', '!=', 'bounced')
            ->sum('amount');

        $annotated = $installments->map(function ($installment) use (&$remainingPaidAmount) {
            if ($remainingPaidAmount >= $installment->amount && $installment->amount > 0) {
                $installment->status = 'paid';
                $remainingPaidAmount -= $installment->amount;
            } elseif ($remainingPaidAmount > 0 && $installment->amount > 0) {
                $installment->status = 'partial';
                $remainingPaidAmount = 0;
            } else {
                $installment->status = 'pending';
            }

            return $installment;
        });

        if ($onlyPaidOrPartial) {
            return $annotated->whereIn('status', ['paid', 'partial'])->values();
        }

        return $annotated->values();
    }

    private function getLockedPdcInstallments(User $user)
    {
        return $this->getPdcInstallmentsWithStatus($user, true);
    }

    private function isCourierReceiveApproved(?PdcDetail $pdcDetail): bool
    {
        return $pdcDetail && $pdcDetail->courier_receive_status === 'approved';
    }

    private function getUploadedCourierDocumentChecklist(User $user, ?Loan_category $loanCategory = null): array
    {
        $document = $user->document;

        if (!$document) {
            return [];
        }

        $applicableDocuments = $this->getCourierDocumentDefinitions($user, $loanCategory);

        return array_values(array_filter($applicableDocuments, function (array $item) use ($document) {
            $field = $item['field'];
            return !empty($document->{$field});
        }));
    }

    private function getCourierDocumentDefinitions(User $user, ?Loan_category $loanCategory = null): array
    {
        $loanCategory = $loanCategory ?: Loan_category::where('user_id', $user->id)->latest()->first();
        $isBelowOneLakh = $loanCategory && $loanCategory->type === 'below';

        if ($isBelowOneLakh) {
            return [
                ['field' => 'ssc_cbse_icse_ib_igcse', 'label' => 'SSC Marksheet'],
                ['field' => 'hsc_diploma_marksheet', 'label' => 'HSC / Diploma Marksheet'],
                ['field' => 'graduate_post_graduate_marksheet', 'label' => 'Graduation Marksheet (Only for Post Graduation Applicant)'],
                ['field' => 'admission_letter_fees_structure', 'label' => 'College - Fees Structure'],
                ['field' => 'pan_applicant', 'label' => 'Pancard - Applicant'],
                ['field' => 'aadhaar_applicant', 'label' => 'Aadhaar card - Applicant'],
                ['field' => 'jain_sangh_certificate', 'label' => 'Jain Sangh Certificate of Applicant'],
                ['field' => 'jito_group_recommendation', 'label' => 'Recommendation of JITO Member'],
                ['field' => 'electricity_bill', 'label' => 'Electricity Bill Latest'],
                ['field' => 'aadhaar_father_mother', 'label' => 'Aadhar card - Father / Mother / Guardian'],
                ['field' => 'pan_father_mother', 'label' => 'Pancard - Father / Mother / Guardian'],
                ['field' => 'form16_salary_income_father', 'label' => 'Form no.16 / Salary Slip of Father'],
                ['field' => 'bank_statement_father_12months', 'label' => 'Bank Statement of Father Last 1 year'],
                ['field' => 'other_documents', 'label' => 'Others'],
            ];
        }

        if ($user->financial_asset_type === 'foreign_finance_assistant' && $user->financial_asset_for === 'post_graduation') {
            return [
                ['field' => 'ssc_cbse_icse_ib_igcse', 'label' => 'SSC / CBSE / ICSE / IB / IGCSE Marksheet'],
                ['field' => 'hsc_diploma_marksheet', 'label' => 'HSC / Diploma Marksheet'],
                ['field' => 'graduate_post_graduate_marksheet', 'label' => 'Graduation Marksheet'],
                ['field' => 'admission_letter_fees_structure', 'label' => 'Admission Letter / Fees Structure'],
                ['field' => 'passport_applicant', 'label' => 'Passport - Applicant'],
                ['field' => 'visa_applicant', 'label' => 'Visa - Applicant'],
                ['field' => 'aadhaar_applicant', 'label' => 'Aadhaar card - Applicant'],
                ['field' => 'pan_applicant', 'label' => 'PAN card - Applicant'],
                ['field' => 'student_bank_details_statement', 'label' => 'Student Bank Details / Statement'],
                ['field' => 'jito_group_recommendation', 'label' => 'JITO Group Recommendation'],
                ['field' => 'jain_sangh_certificate', 'label' => 'Jain Sangh Certificate'],
                ['field' => 'electricity_bill', 'label' => 'Electricity Bill'],
                ['field' => 'itr_acknowledgement_father', 'label' => 'ITR Acknowledgement - Father'],
                ['field' => 'itr_computation_father', 'label' => 'ITR Computation - Father'],
                ['field' => 'form16_salary_income_father', 'label' => 'Form 16 / Salary Income - Father'],
                ['field' => 'bank_statement_father_12months', 'label' => 'Bank Statement - Father (12 months)'],
                ['field' => 'bank_statement_mother_12months', 'label' => 'Bank Statement - Mother (12 months)'],
                ['field' => 'aadhaar_father_mother', 'label' => 'Aadhaar - Father / Mother'],
                ['field' => 'pan_father_mother', 'label' => 'PAN - Father / Mother'],
                ['field' => 'guarantor1_aadhaar', 'label' => 'Guarantor 1 Aadhaar'],
                ['field' => 'guarantor1_pan', 'label' => 'Guarantor 1 PAN'],
                ['field' => 'guarantor2_aadhaar', 'label' => 'Guarantor 2 Aadhaar'],
                ['field' => 'guarantor2_pan', 'label' => 'Guarantor 2 PAN'],
                ['field' => 'student_handwritten_statement', 'label' => 'Student Handwritten Statement'],
                ['field' => 'proof_funds_arranged', 'label' => 'Proof of Funds Arranged'],
                ['field' => 'other_documents', 'label' => 'Other Documents'],
                ['field' => 'extra_curricular', 'label' => 'Extra Curricular Documents'],
            ];
        }

        if ($user->financial_asset_type === 'domestic' && $user->financial_asset_for === 'post_graduation') {
            return [
                ['field' => 'ssc_cbse_icse_ib_igcse', 'label' => 'SSC / CBSE / ICSE / IB / IGCSE Marksheet'],
                ['field' => 'hsc_diploma_marksheet', 'label' => 'HSC / Diploma Marksheet'],
                ['field' => 'graduate_post_graduate_marksheet', 'label' => 'Graduation Marksheet'],
                ['field' => 'admission_letter_fees_structure', 'label' => 'Admission Letter / Fees Structure'],
                ['field' => 'aadhaar_applicant', 'label' => 'Aadhaar card - Applicant'],
                ['field' => 'pan_applicant', 'label' => 'PAN card - Applicant'],
                ['field' => 'student_bank_details_statement', 'label' => 'Student Bank Details / Statement'],
                ['field' => 'jito_group_recommendation', 'label' => 'JITO Group Recommendation'],
                ['field' => 'jain_sangh_certificate', 'label' => 'Jain Sangh Certificate'],
                ['field' => 'electricity_bill', 'label' => 'Electricity Bill'],
                ['field' => 'itr_acknowledgement_father', 'label' => 'ITR Acknowledgement - Father'],
                ['field' => 'itr_computation_father', 'label' => 'ITR Computation - Father'],
                ['field' => 'form16_salary_income_father', 'label' => 'Form 16 / Salary Income - Father'],
                ['field' => 'bank_statement_father_12months', 'label' => 'Bank Statement - Father (12 months)'],
                ['field' => 'bank_statement_mother_12months', 'label' => 'Bank Statement - Mother (12 months)'],
                ['field' => 'aadhaar_father_mother', 'label' => 'Aadhaar - Father / Mother'],
                ['field' => 'pan_father_mother', 'label' => 'PAN - Father / Mother'],
                ['field' => 'guarantor1_aadhaar', 'label' => 'Guarantor 1 Aadhaar'],
                ['field' => 'guarantor1_pan', 'label' => 'Guarantor 1 PAN'],
                ['field' => 'guarantor2_aadhaar', 'label' => 'Guarantor 2 Aadhaar'],
                ['field' => 'guarantor2_pan', 'label' => 'Guarantor 2 PAN'],
                ['field' => 'student_handwritten_statement', 'label' => 'Student Handwritten Statement'],
                ['field' => 'proof_funds_arranged', 'label' => 'Proof of Funds Arranged'],
                ['field' => 'other_documents', 'label' => 'Other Documents'],
                ['field' => 'extra_curricular', 'label' => 'Extra Curricular Documents'],
            ];
        }

        return [
            ['field' => 'ssc_cbse_icse_ib_igcse', 'label' => 'SSC / CBSE / ICSE / IB / IGCSE Marksheet'],
            ['field' => 'hsc_diploma_marksheet', 'label' => 'HSC / Diploma Marksheet'],
            ['field' => 'admission_letter_fees_structure', 'label' => 'Admission Letter / Fees Structure'],
            ['field' => 'aadhaar_applicant', 'label' => 'Aadhaar card - Applicant'],
            ['field' => 'pan_applicant', 'label' => 'PAN card - Applicant'],
            ['field' => 'student_bank_details_statement', 'label' => 'Student Bank Details / Statement'],
            ['field' => 'jito_group_recommendation', 'label' => 'JITO Group Recommendation'],
            ['field' => 'jain_sangh_certificate', 'label' => 'Jain Sangh Certificate'],
            ['field' => 'electricity_bill', 'label' => 'Electricity Bill'],
            ['field' => 'itr_acknowledgement_father', 'label' => 'ITR Acknowledgement - Father'],
            ['field' => 'itr_computation_father', 'label' => 'ITR Computation - Father'],
            ['field' => 'form16_salary_income_father', 'label' => 'Form 16 / Salary Income - Father'],
            ['field' => 'bank_statement_father_12months', 'label' => 'Bank Statement - Father (12 months)'],
            ['field' => 'bank_statement_mother_12months', 'label' => 'Bank Statement - Mother (12 months)'],
            ['field' => 'aadhaar_father_mother', 'label' => 'Aadhaar - Father / Mother'],
            ['field' => 'pan_father_mother', 'label' => 'PAN - Father / Mother'],
            ['field' => 'guarantor1_aadhaar', 'label' => 'Guarantor 1 Aadhaar'],
            ['field' => 'guarantor1_pan', 'label' => 'Guarantor 1 PAN'],
            ['field' => 'guarantor2_aadhaar', 'label' => 'Guarantor 2 Aadhaar'],
            ['field' => 'guarantor2_pan', 'label' => 'Guarantor 2 PAN'],
            ['field' => 'student_handwritten_statement', 'label' => 'Student Handwritten Statement'],
            ['field' => 'proof_funds_arranged', 'label' => 'Proof of Funds Arranged'],
            ['field' => 'other_documents', 'label' => 'Other Documents'],
            ['field' => 'extra_curricular', 'label' => 'Extra Curricular Documents'],
        ];
    }

    private function validateLockedPdcChequeDetails($existingChequeDetails, array $proposedChequeDetails, $lockedInstallments): void
    {
        if ($lockedInstallments->isEmpty()) {
            return;
        }

        if (is_string($existingChequeDetails)) {
            $decoded = json_decode($existingChequeDetails, true);
            $existingChequeDetails = is_array($decoded) ? $decoded : [];
        }

        $existingByInstallment = collect($existingChequeDetails)
            ->filter(fn($item) => is_array($item))
            ->mapWithKeys(function (array $item, int $index) {
                $installmentNo = (int) ($item['row_number'] ?? ($index + 1));
                return [$installmentNo => $item];
            });

        $proposedByInstallment = collect($proposedChequeDetails)
            ->mapWithKeys(function (array $item, int $index) {
                return [($index + 1) => $item];
            });

        foreach ($lockedInstallments as $lockedInstallment) {
            $installmentNo = (int) $lockedInstallment->installment_no;
            $existing = $existingByInstallment->get($installmentNo);
            $proposed = $proposedByInstallment->get($installmentNo);

            if (!$existing || !$proposed) {
                throw ValidationException::withMessages([
                    'cheque_details' => "Repayment already exists for installment {$installmentNo}, so that cheque entry cannot be removed.",
                ]);
            }

            $fieldsToCompare = [
                'parents_jnt_ac_name',
                'cheque_date',
                'bank_name',
                'ifsc',
                'account_number',
                'cheque_number',
            ];

            foreach ($fieldsToCompare as $field) {
                if ((string) ($existing[$field] ?? '') !== (string) ($proposed[$field] ?? '')) {
                    throw ValidationException::withMessages([
                        'cheque_details' => "Repayment already exists for installment {$installmentNo}, so that cheque entry cannot be edited.",
                    ]);
                }
            }

            if (round((float) ($existing['amount'] ?? 0), 2) !== round((float) ($proposed['amount'] ?? 0), 2)) {
                throw ValidationException::withMessages([
                    'cheque_details' => "Repayment already exists for installment {$installmentNo}, so that cheque amount cannot be edited.",
                ]);
            }
        }
    }

    /**
     * Show logs for the current user
     */
    public function showLogs($user)
    {
        $user = Auth::user();
        $logs = Logs::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.logs', compact('logs'));
    }

    /**
     * Show logs for a specific user (admin view)
     */
    public function showUserLogs(User $user)
    {
        // dd($user);
        $logs = Logs::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.logs', compact('logs', 'user'));
    }

    /**
     * Log admin actions for audit trail
     */
    private function logAdminAction($adminUser, $action, $description, $metadata = [])
    {
        Logs::create([
            'user_id' => $adminUser->id,
            'user_name' => $adminUser->name,
            'user_role' => $adminUser->role,
            'activity_type' => 'admin_action',
            'description' => $description,
            'metadata' => json_encode($metadata),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
