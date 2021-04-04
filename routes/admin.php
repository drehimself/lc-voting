<?php

use App\Http\Controllers\Backend\ChallengesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\IdeaController;
use App\Http\Controllers\Backend\IdeaSpamController;
use App\Http\Controllers\Backend\UserController;

/**
 *
 * ADMIN Routes
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');



    // specific & restricted to admin only...
    Route::group(['middleware' => ['adminRestrict']], function () {
        Route::resource('users', UserController::class);
        Route::get('/spammed-ideas', [IdeaSpamController::class,'index'])->name('spam.ideas');
        Route::delete('/spammed-ideas/delete/{idea}', [IdeaSpamController::class,'destroy'])->name('spam.ideas.destroy');
        Route::delete('/spammed-challenges/delete/{challenge}', [IdeaSpamController::class,'destroyChallenge'])->name('spam.challengs.destroy');
    });

    // User Route
    Route::group(['as'=>'backend.'], function () {
        Route::resource('idea', IdeaController::class);
        Route::resource('challenges', ChallengesController::class);
    });
});
