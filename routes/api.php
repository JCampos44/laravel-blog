<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('posts', [PostController::class, 'index']);
Route::get('/post/{slug}', [PostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('whoami', [AuthController::class, 'whoami']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('posts/create', [PostController::class, 'store']);
    Route::post('posts/update', [PostController::class, 'update']);
    Route::delete('posts/delete/{id}', [PostController::class, 'destroy'])->whereNumber('id');

});
