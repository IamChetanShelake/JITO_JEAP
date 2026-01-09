<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ApexLeadershipController;
use App\Http\Controllers\WorkingCommitteeController;
use App\Http\Controllers\InitiativeController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes - Protected by auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/home', [AdminController::class, 'index'])->name('home');

    // Apex Leadership Routes
    Route::resource('apex', ApexLeadershipController::class);

    // Working Committee Routes
    Route::resource('committee', WorkingCommitteeController::class);

    // Zone Routes
    Route::resource('zones', ZoneController::class);

    // Chapter Routes
    Route::resource('chapters', ChapterController::class);

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
    });
