<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BizTools\HomeController;
use App\Http\Controllers\BizTools\BoardController;
use App\Http\Controllers\BizTools\LeadsController;
use App\Http\Controllers\BizTools\LedgerController;
use App\Http\Controllers\BizTools\CustomerController;
use App\Http\Controllers\BizTools\TaskBoardController;
use App\Http\Controllers\BizTools\SubscriptionController;
use App\Http\Controllers\BizTools\TaskController;

Route::group(['middleware' => ['auth','adminRestrict']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::post('/update/lead/status', [LeadsController::class, 'updateBoard'])->name('update.lead.board');
    Route::post('/fetch/lead/{lead}', [LeadsController::class, 'fetchLeadDetails'])->name('fetch.lead.details');
    Route::get('/lead/{lead}/delete', [LeadsController::class, 'destroy'])->name('delete.lead');
    Route::get('convert/lead/customer/{lead}', [LeadsController::class, 'convertToCustomer'])->name('convert.lead.customer');
    Route::get('convert/customer/lead/{customer}', [CustomerControler::class, 'convertToLead'])->name('convert.customer.lead');

    // // subscription datatable
    Route::get('/data/fetch/', [SubscriptionController::class, 'fetchData'])->name('subscription.data.fetch');
    Route::resource('customers', CustomerController::class);
    Route::resource('leads', LeadsController::class);
    Route::resource('boards', BoardController::class);
    Route::resource('task-board', TaskBoardController::class);
    Route::resource('subscriptions', SubscriptionController::class);

    Route::post('/update/task/status', [TaskController::class, 'updateBoard'])->name('update.tasks.board');
    Route::get('/data/fetch/tasks', [TaskController::class, 'fetchData'])->name('tasks.data.fetch');
    Route::resource('tasks', TaskController::class);

    Route::post('/ledger/category', [LedgerController::class, 'createCategory'])->name('ledger.category');
    Route::resource('ledger', LedgerController::class);
});
