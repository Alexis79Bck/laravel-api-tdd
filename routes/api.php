<?php

use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Rutas para el Login y Register
 */
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login'])->name('login');

/**
 * Rutas protegidas por el middleware Santum
 */
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/user/profile',[UserController::class,'profile']);
    Route::get('/logout',[UserController::class,'logout']);
    /**
     * rutas para Blog
     */
     Route::prefix('blog')->group(function (){
        Route::post('/new',[BlogController::class,'create']);
        Route::get('/list',[BlogController::class,'list']);
        Route::get('/{id}',[BlogController::class,'show']);
        Route::put('/{id}',[BlogController::class,'update']);
        Route::delete('/{id}',[BlogController::class,'destroy']);
     });
});




