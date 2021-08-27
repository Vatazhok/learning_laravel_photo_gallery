<?php

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

Route::get('/', [App\Http\Controllers\ImageController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/image', [App\Http\Controllers\ImageController::class, 'post']);
Route::delete('/image/{id}', [App\Http\Controllers\ImageController::class, 'destroy'])->name('destroy');
Route::post('/sharingImage', [App\Http\Controllers\ImageController::class, 'sharingImage'])->name('sharingImage');;
Route::post('/watermark', [App\Http\Controllers\ImageController::class, 'watermark'])->name('watermark');
Route::get('/image/{id}', [App\Http\Controllers\ImageController::class, 'showImage'])->name('showImage');
Route::get('/watermark/{id}', [App\Http\Controllers\ImageController::class, 'addWatermark'])->name('addWatermark');
Route::delete('/delete-watermark/{id}', [App\Http\Controllers\ImageController::class, 'destroyWatermark'])->name('destroyWatermark');

