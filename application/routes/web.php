<?php

use App\Http\Controllers\Glob\GlobPostController;
use Illuminate\Support\Facades\Route;

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

Route::post('glob/uploadsummernote',[GlobPostController::class,'postUploadSumernote']);
Route::post('glob/deletesummernote',[GlobPostController::class,'postDeletesummernote']);