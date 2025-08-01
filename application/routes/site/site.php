<?php
use App\Http\Controllers\Site\Home\HomeGetController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeGetController::class,'viewHomepage']);