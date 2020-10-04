<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\JwtAuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login',[JwtAuthController::class,'login']);
Route::post('/register',[JwtAuthController::class, 'register']);
Route::get('logout',[JwtAuthController::class,'logout']);
Route::get('/user-info',[JwtAuthController::class,'getUser'])->middleware('jwt.verify');
Route::group(['prefix' => 'task'], function () {
    Route::post('/store',[TaskController::class,'store']);
    Route::get('/',[TaskController::class,'index']);
    Route::get('/show/{id}',[TaskController::class,'show']);
    Route::patch('/edit/{id}',[TaskController::class,'update']);
    Route::delete('/delete/{id}',[TaskController::class,'destroy']);
});
Route::group(['prefix' => 'group'], function () {
    Route::post('/store',[GroupController::class,'store']);
    Route::get('/',[GroupController::class,'index']);
    Route::get('/{id}',[GroupController::class,'show']);

});
