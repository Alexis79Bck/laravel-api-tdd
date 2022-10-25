<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Rutas para el Login y Register
 */
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('user/profile',[UserController::class,'profile']);
    Route::get('logout',[UserController::class,'logout']);
});




