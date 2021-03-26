<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\IdeaSpamController;
use App\Http\Controllers\Backend\UserController;

/**
 *
 * ADMIN Routes
 */
Route::group(['middleware' => ['auth']], function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // specific & restricted to admin only...
    Route::group(['middleware' => ['adminRestrict']],function(){
        Route::resource('users', UserController::class);
        Route::get('/spammed-ideas',[IdeaSpamController::class,'index'])->name('spam.ideas');
        Route::delete('/spammed-ideas/delete/{idea}',[IdeaSpamController::class,'destroy'])->name('spam.ideas.destroy');
    });

});
