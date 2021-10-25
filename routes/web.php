<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register')
    ]);
});

Route::get('/gallery', [App\Http\Controllers\ImageController::class, 'index'])->name('gallery')->middleware('auth');
Route::get('/upload', [App\Http\Controllers\ImageController::class, 'upload'])->name('upload')->middleware('auth');
Route::post('/uploadImage', [App\Http\Controllers\ImageController::class, 'uploadImage'])->name('uploadImage')->middleware('auth');
Route::delete('/image/{id}', [App\Http\Controllers\ImageController::class, 'destroy'])->name('destroy')->middleware('auth');
Route::delete('/destroyAll', [App\Http\Controllers\ImageController::class, 'destroyAll'])->name('destroyAll')->middleware('auth');
Route::post('/sharingImage', [App\Http\Controllers\ImageController::class, 'sharingImage'])->name('sharingImage')->middleware('auth');
Route::get('/sharingImageImgur', [App\Http\Controllers\ImageController::class, 'sharingImageImgur'])->name('sharingImageImgur')->middleware('auth');
Route::get('/image/{id}', [App\Http\Controllers\ImageController::class, 'showImageWithWatermark'])->name('showImageWithWatermark')->middleware('auth');
Route::get('/watermark/{id}', [App\Http\Controllers\ImageController::class, 'addWatermark'])->name('addWatermark');
Route::delete('/delete-watermark/{id}', [App\Http\Controllers\ImageController::class, 'destroyWatermark'])->name('destroyWatermark')->middleware('auth');

require __DIR__.'/auth.php';
