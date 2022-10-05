<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;
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

// Route::get('/', function () {
//       return view('first');
//   })->name('root');


Route::get('/', [PostController::class, 'index'])
    ->name('root');

Route::get('/dashboard', function () {
    return view('dashboard');
})  
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('posts', PostController::class)
    ->only(['edit', 'create', 'update', 'destroy', 'store'])
    ->middleware('auth');

Route::resource('posts', PostController::class)
    ->only(['index', 'show']);

Route::resource('posts.comments', CommentController::class)
    ->only(['edit', 'create', 'update', 'destroy', 'store'])
    ->middleware('auth');

Route::resource('posts.purchases', PurchaseController::class)
    ->only(['index', 'destroy', 'store'])
    ->middleware('auth');

Route::resource('posts.comments', CommentController::class)
    ->only(['edit', 'create', 'update', 'destroy', 'store'])
    ->middleware('auth');
