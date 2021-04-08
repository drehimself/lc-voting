<?php

use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IdeaController::class, 'index'])->name('idea.index');
Route::get('/ideas/{idea:slug}', [IdeaController::class, 'show'])->name('idea.show');
Route::get('/user/favourites',[IdeaController::class,'showFavourites'])->name('favourites.list')->middleware('auth');
Route::get('/user/remove/favourites/{idea}',[IdeaController::class,'removeFav'])->name('favourites.remove')->middleware('auth');

Route::get('/challenges', [ChallengesController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge:slug}', [ChallengesController::class, 'show'])->name('challenge.show');
// Route::get('/user/remove/favourites/{idea}',[IdeaController::class,'removeFav'])->name('favourites.remove')->middleware('auth');

Route::get('/task', function () {
    return view('interview');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/biz_tools.php';