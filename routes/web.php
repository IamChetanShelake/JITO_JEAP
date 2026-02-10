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

Route::get('/', function () {
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
    Route::get('/repayments/user/{user}', [RepaymentController::class, 'show'])->name('repayments.show');
    Route::post('/repayments/user/{user}', [RepaymentController::class, 'store'])->name('repayments.store');

    // Donor Routes
    Route::resource('donors', DonorController::class);

    // Disbursement Filtered Routes
    Route::get('/disbursement/completed', [DisbursementController::class, 'completed'])->name('disbursement.completed');
    Route::get('/disbursement/in-progress', [DisbursementController::class, 'inProgress'])->name('disbursement.in_progress');
    Route::get('/disbursement/pending', [DisbursementController::class, 'pending'])->name('disbursement.pending');

    // Subcast Routes
    Route::resource('subcasts', SubcastController::class);
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



    });




