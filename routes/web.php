<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/admin/home', function () {
//     return view('admin.home');
// })->name('admin.home')->middleware(['auth', 'admin']);
Route::get('/admin/home', [AdminController::class, 'index'])
    ->name('admin.home')
    ->middleware(['auth', 'admin']);

// Route::get('/user/home', [UserController::class, 'index'])
//     ->name('user.home')
//     ->middleware(['auth', 'user']);
// Route::get('/loan/apply/{type}', [UserController::class, 'applyLoan'])
//     ->name('loan.apply')
//     ->middleware(['auth', 'user']);

Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/home', [UserController::class, 'index'])
            ->name('home');

        Route::get('/loan/apply/{type}', [UserController::class, 'applyLoan'])
            ->name('loanapply');
        Route::get('/step1', [UserController::class, 'step1'])
            ->name('step1');
    });
