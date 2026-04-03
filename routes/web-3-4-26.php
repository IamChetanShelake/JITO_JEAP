<?php

use App\Http\Controllers\Auth\CustomForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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
use App\Http\Controllers\ApplicationViewController;
use App\Http\Controllers\SnapshotReportController;

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

// Custom Password Reset Routes with OTP
Route::get('/password/reset', [CustomForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [CustomForgotPasswordController::class, 'sendOtp'])->name('password.sendotp');
Route::get('/password/verify', [CustomForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verifyotp.form');
Route::post('/password/verify', [CustomForgotPasswordController::class, 'verifyOtp'])->name('password.verifyotp');
Route::post('/password/resend', [CustomForgotPasswordController::class, 'resendOtp'])->name('password.resendotp');
Route::get('/password/reset/{token}', [CustomForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [CustomForgotPasswordController::class, 'reset'])->name('password.update');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dynamic view system for applications (protected by admin middleware)
Route::middleware(['admin', 'auth.active'])->group(function () {
    Route::get('/applications/view', [ApplicationViewController::class, 'view'])->name('applications.view');
    Route::post('/applications/group', [ApplicationViewController::class, 'group'])->name('applications.group');
    Route::post('/applications/export', [ApplicationViewController::class, 'export'])->name('applications.export');
    Route::post('/views/save', [ApplicationViewController::class, 'saveView'])->name('views.save');
    Route::get('/views', [ApplicationViewController::class, 'listViews'])->name('views.list');
    Route::get('/views/{id}', [ApplicationViewController::class, 'getView'])->name('views.get');
});

// Admin Routes - Protected by admin middleware
Route::middleware(['admin', 'auth.active'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminController::class, 'index'])->name('home');

    // Admin User Registration
    Route::get('/user-registration', [AdminController::class, 'showUserRegistrationForm'])
        ->name('user-registration.create');
    Route::post('/user-registration', [AdminController::class, 'storeUserRegistration'])
        ->name('user-registration.store');

    // Apex Stage 1 Forms
    Route::get('/apex-stage1/approved', [AdminController::class, 'apexStage1Approved'])->name('apex.stage1.approved');
    Route::get('/apex-stage1/pending', [AdminController::class, 'apexStage1Pending'])->name('apex.stage1.pending');
    Route::get('/apex-stage1/draft', [AdminController::class, 'apexStage1Draft'])->name('apex.stage1.draft');
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
    Route::patch('admin/working-committee/users/{user}/update-disbursement-dates', [AdminController::class, 'updateWorkingCommitteeDisbursementDates'])
        ->name('working_committee.user.update_disbursement_dates');

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

    // About Sub-Pages
    Route::get('/website/about/jito', [AdminController::class, 'websiteAboutJito'])->name('website.about.jito');
    Route::post('/website/about/jito', [AdminController::class, 'storeAboutJito'])->name('website.about.jito.store');
    Route::put('/website/about/jito/{id}', [AdminController::class, 'updateAboutJito'])->name('website.about.jito.update');
    Route::delete('/website/about/jito/{id}', [AdminController::class, 'deleteAboutJito'])->name('website.about.jito.delete');

    Route::post('/website/about/jito/stats', [AdminController::class, 'storeJitoStats'])->name('website.about.jito.stats.store');
    Route::put('/website/about/jito/stats/{id}', [AdminController::class, 'updateJitoStats'])->name('website.about.jito.stats.update');
    Route::delete('/website/about/jito/stats/{id}', [AdminController::class, 'deleteJitoStats'])->name('website.about.jito.stats.delete');

    Route::get('/website/about/board-of-directors', [AdminController::class, 'websiteAboutBoardOfDirectors'])->name('website.about.board-of-directors');
    Route::post('/website/about/board-of-directors/store', [AdminController::class, 'storeBoardOfDirectors'])->name('website.about.board-of-directors.store');
    Route::put('/website/about/board-of-directors/update/{id}', [AdminController::class, 'updateBoardOfDirectors'])->name('website.about.board-of-directors.update');
    Route::delete('/website/about/board-of-directors/delete/{id}', [AdminController::class, 'deleteBoardOfDirectors'])->name('website.about.board-of-directors.delete');
    Route::get('/website/about/jeap', [AdminController::class, 'websiteAboutJeap'])->name('website.about.jeap');
    Route::post('/website/about/jeap/store', [AdminController::class, 'storeJeap'])->name('website.about.jeap.store');
    Route::put('/website/about/jeap/update/{id}', [AdminController::class, 'updateJeap'])->name('website.about.jeap.update');
    Route::delete('/website/about/jeap/delete/{id}', [AdminController::class, 'deleteJeap'])->name('website.about.jeap.delete');
    Route::get('/website/about/jeap/delete-image/{id}', [AdminController::class, 'deleteJeapImage'])->name('website.about.jeap.delete-image');
    Route::get('/website/about/zone-chairmen', [AdminController::class, 'websiteAboutZoneChairmen'])->name('website.about.zone-chairmen');
    Route::post('/website/about/zone-chairmen/store', [AdminController::class, 'storeZoneChairmen'])->name('website.about.zone-chairmen.store');
    Route::put('/website/about/zone-chairmen/update/{id}', [AdminController::class, 'updateZoneChairmen'])->name('website.about.zone-chairmen.update');
    Route::delete('/website/about/zone-chairmen/delete/{id}', [AdminController::class, 'deleteZoneChairmen'])->name('website.about.zone-chairmen.delete');
    Route::get('/website/about/testimonials-success', [AdminController::class, 'websiteAboutTestimonialsSuccess'])->name('website.about.testimonials-success');
    Route::post('/website/about/testimonials-success', [AdminController::class, 'storeTestimonialsSuccess'])->name('website.about.testimonials-success.store');
    Route::put('/website/about/testimonials-success/{id}', [AdminController::class, 'updateTestimonialsSuccess'])->name('website.about.testimonials-success.update');
    Route::delete('/website/about/testimonials-success/{id}', [AdminController::class, 'deleteTestimonialsSuccess'])->name('website.about.testimonials-success.delete');

    Route::get('/website/application', [AdminController::class, 'websiteApplication'])->name('website.application');

    // Application Sub-Pages - FAQs
    Route::get('/website/application/faqs', [AdminController::class, 'websiteApplicationFaqs'])->name('website.application.faqs');
    Route::post('/website/application/faqs/store', [AdminController::class, 'storeFaq'])->name('website.application.faqs.store');
    Route::put('/website/application/faqs/update/{id}', [AdminController::class, 'updateFaq'])->name('website.application.faqs.update');
    Route::delete('/website/application/faqs/delete/{id}', [AdminController::class, 'deleteFaq'])->name('website.application.faqs.delete');

    Route::get('/website/contact', [AdminController::class, 'websiteContact'])->name('website.contact');
    Route::post('/website/contact/store', [AdminController::class, 'storeContact'])->name('website.contact.store');
    Route::put('/website/contact/update/{id}', [AdminController::class, 'updateContact'])->name('website.contact.update');
    Route::delete('/website/contact/delete/{id}', [AdminController::class, 'deleteContact'])->name('website.contact.delete');

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
    Route::post('/apex-stage2/user/{user}/courier-receive', [AdminController::class, 'storeCourierReceive'])->name('apex.stage2.courier_receive.store');
    Route::post('/apex-stage2/user/{user}/courier-review', [AdminController::class, 'reviewCourierReceive'])->name('apex.stage2.courier_receive.review');

    // Edit Bank Detail Request Routes
    Route::post('/apex-stage2/approve-edit-bank-request', [AdminController::class, 'approveEditBankDetailRequest'])
        ->name('apex.stage2.approve.edit.bank.request');
    Route::post('/apex-stage2/reject-edit-bank-request', [AdminController::class, 'rejectEditBankDetailRequest'])
        ->name('apex.stage2.reject.edit.bank.request');

    // Files Report Route
    Route::get('/files-report', [App\Http\Controllers\ReportController::class, 'filesReport'])->name('files.report');

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

    // Third Stage Documents
    Route::get('/third-stage-documents/pending', [AdminController::class, 'thirdStageDocumentPending'])
        ->name('third_stage_documents.pending');
    Route::get('/third-stage-documents/send-back', [AdminController::class, 'thirdStageDocumentSendBack'])
        ->name('third_stage_documents.send_back');
    Route::get('/third-stage-documents/resubmitted', [AdminController::class, 'thirdStageDocumentResubmitted'])
        ->name('third_stage_documents.resubmitted');
    Route::get('/third-stage-documents/submitted', [AdminController::class, 'thirdStageDocumentSubmitted'])
        ->name('third_stage_documents.submitted');
    Route::get('/third-stage-documents/approved', [AdminController::class, 'thirdStageDocumentApproved'])
        ->name('third_stage_documents.approved');
    Route::get('/third-stage-documents/user/{user}', [AdminController::class, 'thirdStageDocumentUserDetail'])
        ->name('third_stage_documents.user.detail');
    Route::post('/third-stage-documents/user/{user}/approve', [AdminController::class, 'approveThirdStageDocument'])
        ->name('third_stage_documents.approve');
    Route::post('/third-stage-documents/user/{user}/send-back', [AdminController::class, 'sendBackThirdStageDocument'])
        ->name('third_stage_documents.sendback');


    Route::get('/chapters/resubmit', [AdminController::class, 'chapterResubmit'])->name('chapter.resubmit');

    // Chapter User Dashboard
    Route::get('/chapter/dashboard', [AdminController::class, 'chapterUserDashboard'])->name('chapter.user.dashboard');

    // Generate Application PDF
    Route::get('/user/{user}/generate-pdf', [AdminController::class, 'generateApplicationPDF'])->name('user.generate.pdf');

    // Generate Summary PDF
    Route::get('/user/{user}/generate-summary-pdf', [AdminController::class, 'generateSummaryPDF'])->name('user.generate.summary.pdf');

    Route::get('/user/{user}/generate-short-summary-pdf', [AdminController::class, 'generateShortSummaryPDF'])->name('user.generate.shortsummary.pdf');

    Route::get('/financial-closure/{user}', [AdminController::class, 'generateFinancialClosurePDF'])->name('user.generate.financial_closure.pdf');

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

    // Reports Routes
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/fields', [App\Http\Controllers\ReportController::class, 'getAvailableFields'])->name('reports.fields');
    Route::post('/reports/generate', [App\Http\Controllers\ReportController::class, 'generateDynamicReport'])->name('reports.generate');
    Route::post('/reports/templates', [App\Http\Controllers\ReportController::class, 'saveTemplate'])->name('reports.templates.save');
    Route::get('/reports/templates/{id}', [App\Http\Controllers\ReportController::class, 'loadTemplate'])->name('reports.templates.load');
    Route::get('/reports/templates/{id}/export', [App\Http\Controllers\ReportController::class, 'exportFromTemplate'])->name('reports.templates.export');
    Route::delete('/reports/templates/{id}', [App\Http\Controllers\ReportController::class, 'deleteTemplate'])->name('reports.templates.delete');
    Route::get('/reports/jeap-disbursement', [App\Http\Controllers\ReportController::class, 'jeapDisbursement'])->name('reports.jeap_disbursement');
    Route::get('/reports/financial-graph-report', [App\Http\Controllers\ReportController::class, 'financialGraphReport'])
        ->name('reports.financial_graph_report');
    Route::get('/reports/snapshot', [SnapshotReportController::class, 'generate'])->name('reports.snapshot');
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

        // Step 6 - Document Upload for Below 1 Lakh
        Route::post('/Step6Storeugbelow/', [UserController::class, 'step6storeugbelow'])
            ->name('step6.storeugbelow');

        Route::post('/Step6Storepgbelow/', [UserController::class, 'step6storepgbelow'])
            ->name('step6.storepgbelow');

        // Delete/Remove Document
        Route::post('/Step6RemoveDocument/', [UserController::class, 'step6RemoveDocument'])
            ->name('removeDocument');


        Route::get('/Step7', [UserController::class, 'step7'])
            ->name('step7');
        Route::post('/Step7Store/', [UserController::class, 'step7store'])
            ->name('step7.store');

        // Step 8 - PDC/Cheque Details
        Route::get('/Step8', [UserController::class, 'step8'])
            ->name('step8');
        Route::post('/Step8BankDetailsStore/', [UserController::class, 'step8BankDetailsStore'])
            ->name('step8.bank.store');
        Route::post('/Step8Store/', [UserController::class, 'step8store'])
            ->name('step8.store');

        // Step 9 - Third Stage Documents
        Route::get('/Step9', [UserController::class, 'step9'])
            ->name('step9');
        Route::post('/Step9Store/', [UserController::class, 'step9store'])
            ->name('step9.store');

        // Edit Bank Detail Request
        Route::post('/submit-edit-bank-detail-request', [UserController::class, 'submitEditBankDetailRequest'])
            ->name('submit.edit.bank.detail.request');

        // Update Bank Details (after request is approved)
        Route::post('/update-bank-details', [UserController::class, 'updateBankDetails'])
            ->name('update.bank.details');

        // Bank verification route
        Route::post('/verify-bank-details', [UserController::class, 'verifyBankDetails'])
            ->name('verify.bank.details');

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

        Route::get('/user/{user}/generate-short-summary-pdf', [AdminController::class, 'generateShortSummaryPDF'])->name('user.generate.shortsummary.pdf');

        Route::get('/financial-closure/{user}', [AdminController::class, 'generateFinancialClosurePDF'])->name('user.generate.financial_closure.pdf');
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
    Route::get('/JITO/data', [WebsiteController::class, 'aboutJitoData'])->name('jito.data');
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
Route::get('/privacy-policy', [WebsiteController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-conditions', [WebsiteController::class, 'termsConditions'])->name('terms.conditions');
Route::post('/contact', [WebsiteController::class, 'contactStore'])->name('contact.store');









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
