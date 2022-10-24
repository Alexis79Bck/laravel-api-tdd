<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * Routes for UserController
 */
Route::post('register', [UserController::class,'store']);
Route::post('login', [UserController::class,'userLogin']);
// Route::middleware('auth:sanctum')->group(function () {
    Route::get('users', [UserController::class,'index']);
    Route::get('user/{id}', [UserController::class,'show']);
    Route::post('user/{id}', [UserController::class,'update']);
    Route::delete('user/{id}', [UserController::class,'destroy']);
    Route::post('/profile',[UserController::class,'userProfile'])->middleware('auth:sanctum');
// });




