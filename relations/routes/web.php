<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\indexController;

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

Route::get('relationsIndex',[indexController::class,'index']);
Route::post('relationIndex/store',[indexController::class,'store'])->name('book.store');
Route::delete('relationIndex/delete/{id}',[indexController::class,'delete'])->name('book.delete');

