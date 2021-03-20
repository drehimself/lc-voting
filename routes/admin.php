<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
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
    });

});
