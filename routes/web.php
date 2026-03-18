<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisbursementController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\DonorAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonorWebController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\JitoJeapBankController;
use App\Http\Controllers\SubcastController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\ApexLeadershipController;
use App\Http\Controllers\WorkingCommitteeController;
use App\Http\Controllers\InitiativeController;
use App\Http\Controllers\AccountantController;
use App\Http\Controllers\AdminNotificationController;

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\WebsiteController;


Route::get('/login', function () {
    return view('auth.login');
});

// Donor Auth Routes
Route::prefix('donor')->name('donor.')->group(function () {
    Route::get('/login', [DonorAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [DonorAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [DonorAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [DonorAuthController::class, 'register'])->name('register.submit');
    Route::post('/logout', [DonorAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:donor')->group(function () {
        Route::get('/dashboard', [DonorAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/step1', [DonorWebController::class, 'step1'])->name('step1');
        Route::post('/step1', [DonorWebController::class, 'storestep1'])->name('step1.store');
        Route::get('/get-zones/{state}', [DonorWebController::class, 'getZones'])->name('get.zones');
        Route::get('/get-chapters/{zone_id}', [DonorWebController::class, 'getChapters'])->name('get.chapters');

        Route::get('/step2', [DonorWebController::class, 'step2'])->name('step2');
        Route::post('/step2', [DonorWebController::class, 'storestep2'])->name('step2.store');

        Route::get('/step3', [DonorWebController::class, 'step3'])->name('step3');
        Route::post('/step3', [DonorWebController::class, 'storestep3'])->name('step3.store');

        Route::get('/step4', [DonorWebController::class, 'step4'])->name('step4');
        Route::post('/step4', [DonorWebController::class, 'storestep4'])->name('step4.store');

        Route::get('/step5', [DonorWebController::class, 'step5'])->name('step5');
        Route::post('/step5', [DonorWebController::class, 'storestep5'])->name('step5.store');

        Route::get('/step6', [DonorWebController::class, 'step6'])->name('step6');
        Route::post('/step6', [DonorWebController::class, 'storestep6'])->name('step6.store');

        Route::get('/step7', [DonorWebController::class, 'step7'])->name('step7');
        Route::post('/step7', [DonorWebController::class, 'storestep7'])->name('step7.store');

        Route::get('/step8', [DonorWebController::class, 'step8'])->name('step8');
        Route::post('/step8', [DonorWebController::class, 'storestep8'])->name('step8.store');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes - Protected by admin middleware
Route::middleware(['admin', 'auth.active'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminController::class, 'index'])->name('home');

    // Apex Stage 1 Forms
    Route::get('/apex-stage1/approved', [AdminController::class, 'apexStage1Approved'])->name('apex.stage1.approved');
    Route::get('/apex-stage1/pending', [AdminController::class, 'apexStage1Pending'])->name('apex.stage1.pending');
    Route::get('/apex-stage1/hold', [AdminController::class, 'apexStage1Hold'])->name('apex.stage1.hold');
    Route::get('/apex-stage1/user/{user}', [AdminController::class, 'apexStage1UserDetail'])->name('apex.stage1.user.detail');
    Route::get('/apex-stage1/resubmitted', [AdminController::class, 'apexStage1Resubmitted'])->name('apex.stage1.resubmitted');

    // Chapter Forms
    Route::get('/chapter/approved', [AdminController::class, 'chapterApproved'])->name('chapter.approved');
    Route::get('/chapter/pending', [AdminController::class, 'chapterPending'])->name('chapter.pending');
    Route::get('/chapter/hold', [AdminController::class, 'chapterHold'])->name('chapter.hold');
    Route::get('/chapter/user/{user}', [AdminController::class, 'chapterUserDetail'])->name('chapter.user.detail');

    // Working Committee Forms
    Route::get('/working-committee/approved', [AdminController::class, 'workingCommitteeApproved'])->name('working_committee.approved');
    Route::get('/working-committee/pending', [AdminController::class, 'workingCommitteePending'])->name('working_committee.pending');
    Route::get('/working-committee/hold', [AdminController::class, 'workingCommitteeHold'])->name('working_committee.hold');
    Route::get('/working-committee/reject', [AdminController::class, 'workingCommitteeReject'])->name('working_committee.reject');



    Route::get('/working-committee/user/{user}', [AdminController::class, 'workingCommitteeUserDetail'])->name('working_committee.user.detail');
    Route::post('/working-committee/user/{user}/approve/{stage}', [AdminController::class, 'approveWorkingCommittee'])->name('working_committee.user.approve');
    Route::post('/working-committee/user/{user}/unhold', [AdminController::class, 'unholdWorkingCommittee'])->name('working_committee.user.unhold');

    // NEW: Update (edit/save) Working Committee decision
    Route::patch('admin/working-committee/users/{user}/update', [AdminController::class, 'updateWorkingCommittee'])
        ->name('working_committee.user.update');

    // Approval workflow endpoints
    Route::post('/user/{user}/approve/{stage}', [AdminController::class, 'approveStage'])->name('user.approve');
    Route::post('/user/{user}/reject/{stage}', [AdminController::class, 'rejectStage'])->name('user.reject');
    Route::post('/user/{user}/hold/{stage}', [AdminController::class, 'holdStage'])->name('user.hold');

    // Chapter Interview endpoints
    Route::post('/chapter/interview/save', [AdminController::class, 'saveChapterInterview'])->name('chapter.interview.save');
    Route::get('/chapter/interview/answers/{user}/{workflow}', [AdminController::class, 'getChapterInterviewAnswers'])->name('chapter.interview.answers');

    // Total Applications
    Route::get('/total-applications', [AdminController::class, 'totalApplications'])->name('total.applications');
    Route::get('/total-hold', [AdminController::class, 'totalHold'])->name('total.hold');

    // Apex Leadership Routes
    Route::resource('apex', ApexLeadershipController::class);
    Route::post('apex/{apex}/toggle-status', [ApexLeadershipController::class, 'toggleStatus'])->name('apex.toggle-status');

    // Working Committee Routes
    Route::resource('committee', WorkingCommitteeController::class);

    // Zone Routes
    Route::resource('zones', ZoneController::class);

    // Website Management Routes
    Route::get('/website', [AdminController::class, 'websiteIndex'])->name('website.index');
    Route::get('/website/home', [AdminController::class, 'websiteHome'])->name('website.home');
    
    // Home Sub-Pages Routes
    Route::get('/website/home/empowering-dreams', [AdminController::class, 'websiteHomeEmpoweringDreams'])->name('website.home.empowering-dreams');
    Route::post('/website/home/empowering-dreams', [AdminController::class, 'storeEmpoweringDream'])->name('website.home.empowering-dreams.store');
    Route::put('/website/home/empowering-dreams/{id}', [AdminController::class, 'updateEmpoweringDream'])->name('website.home.empowering-dreams.update');
    Route::delete('/website/home/empowering-dreams/{id}', [AdminController::class, 'deleteEmpoweringDream'])->name('website.home.empowering-dreams.delete');
    Route::get('/website/home/key-instruction', [AdminController::class, 'websiteHomeKeyInstruction'])->name('website.home.key-instruction');
    Route::post('/website/home/key-instruction', [AdminController::class, 'storeKeyInstruction'])->name('website.home.key-instructions.store');
    Route::put('/website/home/key-instruction/{id}', [AdminController::class, 'updateKeyInstruction'])->name('website.home.key-instructions.update');
    Route::delete('/website/home/key-instruction/{id}', [AdminController::class, 'deleteKeyInstruction'])->name('website.home.key-instructions.delete');
    Route::get('/website/home/working-committee', [AdminController::class, 'websiteHomeWorkingCommittee'])->name('website.home.working-committee');
    Route::post('/website/home/working-committee', [AdminController::class, 'storeWebsiteWorkingCommittee'])->name('website.home.working-committee.store');
    Route::put('/website/home/working-committee/{id}', [AdminController::class, 'updateWebsiteWorkingCommittee'])->name('website.home.working-committee.update');
    Route::delete('/website/home/working-committee/{id}', [AdminController::class, 'deleteWebsiteWorkingCommittee'])->name('website.home.working-committee.delete');
    Route::get('/website/home/empowering-future', [AdminController::class, 'websiteHomeEmpoweringFuture'])->name('website.home.empowering-future');
    Route::post('/website/home/empowering-future', [AdminController::class, 'storeEmpoweringFuture'])->name('website.home.empowering-future.store');
    Route::put('/website/home/empowering-future/{id}', [AdminController::class, 'updateEmpoweringFuture'])->name('website.home.empowering-future.update');
    Route::delete('/website/home/empowering-future/{id}', [AdminController::class, 'deleteEmpoweringFuture'])->name('website.home.empowering-future.delete');
    Route::get('/website/home/achievement-impact', [AdminController::class, 'websiteHomeAchievementImpact'])->name('website.home.achievement-impact');
    Route::post('/website/home/achievement-impact', [AdminController::class, 'storeAchievementImpact'])->name('website.home.achievement-impact.store');
    Route::put('/website/home/achievement-impact/{id}', [AdminController::class, 'updateAchievementImpact'])->name('website.home.achievement-impact.update');
    Route::delete('/website/home/achievement-impact/{id}', [AdminController::class, 'deleteAchievementImpact'])->name('website.home.achievement-impact.delete');
    Route::get('/website/home/photo-gallery', [AdminController::class, 'websiteHomePhotoGallery'])->name('website.home.photo-gallery');
    Route::post('/website/home/photo-gallery', [AdminController::class, 'storePhotoGallery'])->name('website.home.photo-gallery.store');
    Route::put('/website/home/photo-gallery/{id}', [AdminController::class, 'updatePhotoGallery'])->name('website.home.photo-gallery.update');
    Route::delete('/website/home/photo-gallery/{id}', [AdminController::class, 'deletePhotoGallery'])->name('website.home.photo-gallery.delete');
    Route::get('/website/home/our-testimonial', [AdminController::class, 'websiteHomeOurTestimonial'])->name('website.home.our-testimonial');
    Route::post('/website/home/our-testimonial', [AdminController::class, 'storeOurTestimonial'])->name('website.home.our-testimonials.store');
    Route::put('/website/home/our-testimonial/{id}', [AdminController::class, 'updateOurTestimonial'])->name('website.home.our-testimonials.update');
    Route::delete('/website/home/our-testimonial/{id}', [AdminController::class, 'deleteOurTestimonial'])->name('website.home.our-testimonials.delete');
    Route::get('/website/home/success-stories', [AdminController::class, 'websiteHomeSuccessStories'])->name('website.home.success-stories');
    Route::post('/website/home/success-stories', [AdminController::class, 'storeSuccessStory'])->name('website.home.success-stories.store');
    Route::put('/website/home/success-stories/{id}', [AdminController::class, 'updateSuccessStory'])->name('website.home.success-stories.update');
    Route::delete('/website/home/success-stories/{id}', [AdminController::class, 'deleteSuccessStory'])->name('website.home.success-stories.delete');
    
    Route::get('/website/about', [AdminController::class, 'websiteAbout'])->name('website.about');
    Route::get('/website/application', [AdminController::class, 'websiteApplication'])->name('website.application');
    Route::get('/website/contact', [AdminController::class, 'websiteContact'])->name('website.contact');
    Route::get('/website/donor', [AdminController::class, 'websiteDonor'])->name('website.donor');
    Route::get('/website/be-donor', [AdminController::class, 'websiteBeDonor'])->name('website.be-donor');
    Route::post('/website/be-donor', [AdminController::class, 'storeBeDonorDetail'])->name('website.be-donor.store');
    Route::put('/website/be-donor/{id}', [AdminController::class, 'updateBeDonorDetail'])->name('website.be-donor.update');
    Route::delete('/website/be-donor/{id}', [AdminController::class, 'deleteBeDonorDetail'])->name('website.be-donor.delete');
    Route::get('/website/our-donor', [AdminController::class, 'websiteOurDonor'])->name('website.our-donor');
    Route::get('/website/gallery', [AdminController::class, 'websiteGallery'])->name('website.gallery');
    Route::get('/website/university', [AdminController::class, 'websiteUniversity'])->name('website.university');
    Route::post('/website/university', [AdminController::class, 'storeUniversity'])->name('website.university.store');
    Route::put('/website/university/{id}', [AdminController::class, 'updateUniversity'])->name('website.university.update');
    Route::delete('/website/university/{id}', [AdminController::class, 'deleteUniversity'])->name('website.university.delete');
    Route::post('/website/university/{id}/toggle-status', [AdminController::class, 'toggleUniversityStatus'])->name('website.university.toggle-status');
    
    Route::get('/website/course', [AdminController::class, 'websiteCourse'])->name('website.course');
    Route::post('/website/course', [AdminController::class, 'storeCourse'])->name('website.course.store');
    Route::put('/website/course/{id}', [AdminController::class, 'updateCourse'])->name('website.course.update');
    Route::delete('/website/course/{id}', [AdminController::class, 'deleteCourse'])->name('website.course.delete');
    
    Route::get('/website/college', [AdminController::class, 'websiteCollege'])->name('website.college');
    Route::post('/website/college', [AdminController::class, 'storeCollege'])->name('website.college.store');
    Route::put('/website/college/{id}', [AdminController::class, 'updateCollege'])->name('website.college.update');
    Route::delete('/website/college/{id}', [AdminController::class, 'deleteCollege'])->name('website.college.delete');

    // Chapter Statistics
    Route::get('/chapters/stats', [AdminController::class, 'chapterStats'])->name('chapters.stats');
    Route::get('/working-committee/stats', [AdminController::class, 'workingCommitteeStats'])->name('working_committee.stats');
    Route::get('/chapters/{chapter}/details', [AdminController::class, 'chapterDetails'])->name('chapter.details');

    // Chapter Status Lists
    Route::get('/chapters/total-applied', [AdminController::class, 'chapterTotalApplied'])->name('chapter.total-applied');
    Route::get('/chapters/draft', [AdminController::class, 'chapterDraft'])->name('chapter.draft');
    Route::get('/chapters/apex-pending', [AdminController::class, 'chapterApexPending'])->name('chapter.apex-pending');
    Route::get('/chapters/working-committee-pending', [AdminController::class, 'chapterWorkingCommitteePending'])->name('chapter.working-committee-pending');
    Route::get('/chapters/working-committee-approved', [AdminController::class, 'chapterWorkingCommitteeApproved'])->name('chapter.working-committee-approved');

    // Apex Stage 2 Forms
    Route::get('/apex-stage2/approved', [AdminController::class, 'apexStage2Approved'])->name('apex.stage2.approved');
    Route::get('/apex-stage2/pending', [AdminController::class, 'apexStage2Pending'])->name('apex.stage2.pending');
    Route::get('/apex-stage2/hold', [AdminController::class, 'apexStage2Hold'])->name('apex.stage2.hold');
    Route::get('/apex-stage2/user/{user}', [AdminController::class, 'apexStage2UserDetail'])->name('apex.stage2.user.detail');
    Route::get('/apex-stage2/resubmitted', [AdminController::class, 'apexStage2Resubmitted'])->name('apex.stage2.resubmitted');

    // PDC/Cheque Details Forms
    Route::get('/pdc/pending', [AdminController::class, 'pdcPending'])->name('pdc.pending');
    Route::get('/pdc/approved', [AdminController::class, 'pdcApproved'])->name('pdc.approved');
    Route::get('/pdc/hold', [AdminController::class, 'pdcHold'])->name('pdc.hold');
    Route::get('/pdc/user/{user}', [AdminController::class, 'pdcUserDetail'])->name('pdc.user.detail');
    Route::post('/pdc/user/{user}/approve', [AdminController::class, 'approvePdc'])->name('pdc.approve');
    Route::post('/pdc/user/{user}/send-back', [AdminController::class, 'sendBackPdc'])->name('pdc.send-back');

    // PDC Edit functionality
    Route::get('/pdc/edit/{user}', [AdminController::class, 'editPdc'])->name('pdc.edit');
    Route::put('/pdc/update/{user}', [AdminController::class, 'updatePdc'])->name('pdc.update');


    Route::get('/chapters/resubmit', [AdminController::class, 'chapterResubmit'])->name('chapter.resubmit');

    // Chapter User Dashboard
    Route::get('/chapter/dashboard', [AdminController::class, 'chapterUserDashboard'])->name('chapter.user.dashboard');

    // Generate Application PDF
    Route::get('/user/{user}/generate-pdf', [AdminController::class, 'generateApplicationPDF'])->name('user.generate.pdf');

    // Generate Summary PDF
    Route::get('/user/{user}/generate-summary-pdf', [AdminController::class, 'generateSummaryPDF'])->name('user.generate.summary.pdf');

    // View Sanction Letter
    Route::get('/user/{user}/sanction-letter', [AdminController::class, 'viewSanctionLetter'])->name('user.sanction.letter');

    // Chapter Routes
    Route::resource('chapters', ChapterController::class);

    // Pincode Routes
    Route::resource('pincodes', PincodeController::class);

    // Initiative Routes
    Route::resource('initiatives', InitiativeController::class);

    // Bank Routes
    Route::resource('banks', BankController::class);

    // Jito Jeap Bank Routes
    Route::resource('jito-jeap-banks', JitoJeapBankController::class);

    // Disbursement Routes
    Route::get('/disbursement', [DisbursementController::class, 'index'])->name('disbursement.index');
    Route::get('/disbursement/user/{user}', [DisbursementController::class, 'show'])->name('disbursement.show');
    Route::post('/disbursement/store', [DisbursementController::class, 'store'])->name('disbursement.store');

    // Repayment Routes
    Route::get('/repayments', [RepaymentController::class, 'index'])->name('repayments.index');
    Route::get('/repayments/completed', [RepaymentController::class, 'completed'])->name('repayments.completed');
    Route::get('/repayments/in-progress', [RepaymentController::class, 'inProgress'])->name('repayments.in_progress');
    Route::get('/repayments/ready', [RepaymentController::class, 'ready'])->name('repayments.ready');
    Route::get('/repayments/export', [RepaymentController::class, 'export'])->name('repayments.export');
    Route::get('/repayments/upcoming', [RepaymentController::class, 'upcoming'])->name('repayments.upcoming');
    Route::get('/repayments/past', [RepaymentController::class, 'past'])->name('repayments.past');
    Route::get('/repayments/export/{period}', [RepaymentController::class, 'exportPeriod'])->name('repayments.export_period');
    Route::get('/repayments/user/{user}', [RepaymentController::class, 'show'])->name('repayments.show');
    Route::post('/repayments/user/{user}', [RepaymentController::class, 'store'])->name('repayments.store');

    // Accountant Routes
    Route::resource('accountants', AccountantController::class);

    // Donor Routes
    Route::resource('donors', DonorController::class);
    Route::get('/donor-dashboard', [DonorController::class, 'dashboard'])->name('donors.dashboard');
    Route::get('/donor-dashboard/{donor}', [DonorController::class, 'dashboardShow'])->name('donors.dashboard.show');

    // General Donors Routes
    Route::get('/general-donor-dashboard', [DonorController::class, 'generalDonorsDashboard'])->name('general-donors.dashboard');
    Route::get('/general-donor-dashboard/{donor}', [DonorController::class, 'generalDonorShow'])->name('general-donors.show');

    Route::put('/donor-dashboard-update/{donor}', [DonorController::class, 'updatedonor'])->name('donors.updatedonor');
    Route::put('/donor-payment-update/{donor}', [DonorController::class, 'updatePayment'])->name('donors.updatepayment');

    // Donor conversion routes
    Route::post('/donors/{donor}/convert-to-general', [DonorController::class, 'convertToGeneral'])->name('donors.convertToGeneral');
    Route::post('/donors/{donor}/create-commitment', [DonorController::class, 'createCommitment'])->name('donors.createCommitment');

    // Disbursement Filtered Routes
    Route::get('/disbursement/completed', [DisbursementController::class, 'completed'])->name('disbursement.completed');
    Route::get('/disbursement/in-progress', [DisbursementController::class, 'inProgress'])->name('disbursement.in_progress');
    Route::get('/disbursement/pending', [DisbursementController::class, 'pending'])->name('disbursement.pending');
    Route::get('/disbursement/upcoming', [DisbursementController::class, 'upcoming'])->name('disbursement.upcoming');
    Route::get('/disbursement/past', [DisbursementController::class, 'past'])->name('disbursement.past');
    Route::get('/disbursement/export/{period}', [DisbursementController::class, 'exportSchedules'])->name('disbursement.export');

    // Subcast Routes
    Route::resource('subcasts', SubcastController::class);

    // Logs Routes
    Route::get('/logs/', [AdminController::class, 'showUserLogs'])->name('logs');
    Route::get('/logs/user/{user}', [AdminController::class, 'showUserLogs'])->name('user.logs');
    Route::post('/notifications/{notification}/read', [AdminNotificationController::class, 'read'])->name('notifications.read');
});

// User Routes - Protected by auth and user middleware
Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/home', [UserController::class, 'index'])
            ->name('home');

        Route::get('/loan/apply/{type}', [UserController::class, 'applyLoan'])
            ->name('loanapply');
        Route::get('/Step1', [UserController::class, 'step1'])
            ->name('step1');
        Route::post('/Step1Store/', [UserController::class, 'step1store'])
            ->name('step1.store');

        Route::get('/Step2', [UserController::class, 'step2'])
            ->name('step2');
        // Route::post('/Step2Store/', [UserController::class, 'step2store'])
        //     ->name('step2.store');


        Route::post('/Step2UGStore/', [UserController::class, 'step2UGstore'])
            ->name('step2ug.store');
        Route::post('/Step2PGStore/', [UserController::class, 'step2PGstore'])
            ->name('step2pg.store');
        Route::post('/Step2ForeignPgStore/', [UserController::class, 'step2_foreign_pg_store'])
            ->name('step2_foreign_pg.store');


        Route::get('/Step3', [UserController::class, 'step3'])
            ->name('step3');
        Route::post('/Step3Store', [UserController::class, 'step3store'])
            ->name('step3.store');



        Route::get('/Step4', [UserController::class, 'step4'])
            ->name('step4');
        Route::post('/Step4Store/', [UserController::class, 'step4store'])
            ->name('step4.store');
        Route::post('/bank-verify', [UserController::class, 'verify'])
            ->name('bank.verify');



        Route::get('/Step5', [UserController::class, 'step5'])
            ->name('step5');
        Route::post('/Step5Store/', [UserController::class, 'step5store'])
            ->name('step5.store');

        Route::post('/check-guarantor-duplicate', [UserController::class, 'checkDuplicate'])
            ->name('check.guarantor.duplicate');



        Route::get('/Step6', [UserController::class, 'step6'])
            ->name('step6');
        Route::post('/Step6Store/', [UserController::class, 'step6store'])
            ->name('step6.store');

        Route::post('/Step6Storeug/', [UserController::class, 'step6storeug'])
            ->name('step6.storeug');

        Route::post('/Step6Storeforeign/', [UserController::class, 'step6storeforeign'])
            ->name('step6.storeforeign');


        Route::get('/Step7', [UserController::class, 'step7'])
            ->name('step7');
        Route::post('/Step7Store/', [UserController::class, 'step7store'])
            ->name('step7.store');

        // Step 8 - PDC/Cheque Details
        Route::get('/Step8', [UserController::class, 'step8'])
            ->name('step8');
        Route::post('/Step8Store/', [UserController::class, 'step8store'])
            ->name('step8.store');

        // API route for fetching chapters by pincode
        Route::get('/get-chapters/{pincode}', [UserController::class, 'getChapters'])
            ->name('get.chapters');

        // API route for Aadhaar validation
        Route::post('/validate-aadhar', [UserController::class, 'validateAadhar'])
            ->name('validate.aadhar');

        // PAN verification route
        Route::post('/pan-verify', [UserController::class, 'verifyPan'])
            ->name('verify.pan');
        Route::post('/verify-aadhaar-last4', [UserController::class, 'verifyAadhaarLast4'])
            ->name('verify.aadhaar.last4');

        // User logs route
        Route::get('/logs', [UserController::class, 'showUserLogs'])
            ->name('logs');

        // Generate Application PDF
        Route::get('/{user}/generate-pdf', [AdminController::class, 'generateApplicationPDF'])->name('generate.pdf');

        // Generate Summary PDF
        Route::get('/{user}/generate-summary-pdf', [AdminController::class, 'generateSummaryPDF'])->name('generate.summary.pdf');

        // View Sanction Letter
        Route::get('/{user}/sanction-letter', [AdminController::class, 'viewSanctionLetter'])->name('sanction.letter');

        // Route for above 1 lakh application redirection
        Route::get('/above-1-lakh-application', [UserController::class, 'above1LakhApplication'])
            ->name('above.1.lakh.application');
    });








// Website Route




Route::get('/index', [WebsiteController::class, 'index'])->name('index');
// Route::view('/index1','website.index')->name('index1');
Route::get('/', function () {
    return redirect()->route('index');
});

Route::prefix('about')->group(function () {
    Route::get('/JITO', [WebsiteController::class, 'aboutJito'])->name('jito');
    Route::get('/JEAP', [WebsiteController::class, 'aboutJeap'])->name('jeap');
    Route::get('/Board-Of-Directors', [WebsiteController::class, 'boardOfDirectors'])->name('boardOfDirectors');
    Route::get('/Zone-Chairmen', [WebsiteController::class, 'zoneChairmen'])->name('zoneChairmen');
    Route::get('/testimonials-and-Success-Stories', [WebsiteController::class, 'testimonialSuccessStories'])->name('testimonial&Success');
});
Route::prefix('application')->group(function () {
    Route::get('/document-checklist', [WebsiteController::class, 'documentchecklist'])->name('documentchecklist');
    Route::get('/document-checklist-1', [WebsiteController::class, 'documentchecklist1'])->name('documentchecklist1');
    Route::get('/document-checklist-2', [WebsiteController::class, 'documentchecklist2'])->name('documentchecklist2');
    Route::get('/document-checklist-3', [WebsiteController::class, 'documentchecklist3'])->name('documentchecklist3');
    Route::get('/DOCUMENTS', [WebsiteController::class, 'documents'])->name('documents');
    Route::get('/How-to-apply', [WebsiteController::class, 'howtoapply'])->name('howtoapply');
    Route::get('/FAQ’s', [WebsiteController::class, 'faqs'])->name('faqs');
});
Route::prefix('donors')->group(function () {
    Route::get('/be-a-donor', [WebsiteController::class, 'beDonor'])->name('beDonor');
    Route::get('/our-donors', [WebsiteController::class, 'ourDonors'])->name('ourDonors');
});

Route::prefix('University')->group(function () {
    Route::get('/domestic', [WebsiteController::class, 'domestic'])->name('domestic');
    Route::get('/foreign', [WebsiteController::class, 'foreign'])->name('foreign');
});

Route::get('/Gallery', [WebsiteController::class, 'gallery'])->name('gallery');








Route::get('/industrial', [WebsiteController::class, 'industrial'])->name('industrial_connect');


Route::get('/contact', [WebsiteController::class, 'contact'])->name('contact');









Route::get('/clean-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:cache');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('event:cache');
    $exitCode = Artisan::call('event:clear');
    $exitCode = Artisan::call('optimize');
    return '<h1>Cache facade value cleared</h1>';
});
