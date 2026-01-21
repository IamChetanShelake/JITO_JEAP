<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\PincodeController;
use App\Http\Controllers\ApexLeadershipController;
use App\Http\Controllers\WorkingCommitteeController;
use App\Http\Controllers\InitiativeController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes - Protected by admin middleware
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminController::class, 'index'])->name('home');

    // Apex Stage 1 Forms
    Route::get('/apex-stage1/approved', [AdminController::class, 'apexStage1Approved'])->name('apex.stage1.approved');
    Route::get('/apex-stage1/pending', [AdminController::class, 'apexStage1Pending'])->name('apex.stage1.pending');
    Route::get('/apex-stage1/hold', [AdminController::class, 'apexStage1Hold'])->name('apex.stage1.hold');
    Route::get('/apex-stage1/user/{user}', [AdminController::class, 'apexStage1UserDetail'])->name('apex.stage1.user.detail');

    // Chapter Forms
    Route::get('/chapter/approved', [AdminController::class, 'chapterApproved'])->name('chapter.approved');
    Route::get('/chapter/pending', [AdminController::class, 'chapterPending'])->name('chapter.pending');
    Route::get('/chapter/hold', [AdminController::class, 'chapterHold'])->name('chapter.hold');
    Route::get('/chapter/user/{user}', [AdminController::class, 'chapterUserDetail'])->name('chapter.user.detail');

    // Approval workflow endpoints
    Route::post('/user/{user}/approve/{stage}', [AdminController::class, 'approveStage'])->name('user.approve');
    Route::post('/user/{user}/reject/{stage}', [AdminController::class, 'rejectStage'])->name('user.reject');

    // Chapter Interview endpoints
    Route::post('/chapter/interview/save', [AdminController::class, 'saveChapterInterview'])->name('chapter.interview.save');
    Route::get('/chapter/interview/answers/{user}/{workflow}', [AdminController::class, 'getChapterInterviewAnswers'])->name('chapter.interview.answers');

    // Total Applications
    Route::get('/total-applications', [AdminController::class, 'totalApplications'])->name('total.applications');
    Route::get('/total-hold', [AdminController::class, 'totalHold'])->name('total.hold');

    // Apex Leadership Routes
    Route::resource('apex', ApexLeadershipController::class);

    // Working Committee Routes
    Route::resource('committee', WorkingCommitteeController::class);

    // Zone Routes
    Route::resource('zones', ZoneController::class);

    // Chapter Routes
    Route::resource('chapters', ChapterController::class);

    // Pincode Routes
    Route::resource('pincodes', PincodeController::class);

    // Initiative Routes
    Route::resource('initiatives', InitiativeController::class);
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

        Route::get('/Step5', [UserController::class, 'step5'])
            ->name('step5');
        Route::post('/Step5Store/', [UserController::class, 'step5store'])
            ->name('step5.store');


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

        // API route for fetching chapters by pincode
        Route::get('/get-chapters/{pincode}', [UserController::class, 'getChapters'])
            ->name('get.chapters');
    });
