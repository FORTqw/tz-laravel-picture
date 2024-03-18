<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pictures/create', [PictureController::class, 'create'])->name('pictures.create');
Route::post('/pictures', [PictureController::class, 'store'])->name('pictures.store');
Route::get('/pictures', [PictureController::class, 'index'])->name('pictures.index');
Route::get('/pictures/{filename}/downloadZip', [PictureController::class, 'downloadZip'])->name('pictures.downloadZip');

