<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::group(['middleware'=>'jwt.auth'],function(){
        Route::get('user', [AuthController::class, 'getUser']);
        Route::get('users', [UserController::class, 'getAuthUsers']);
        Route::post('upload-avatar', [UserController::class, 'uploadAvatar']);
        Route::post('update-profile', [UserController::class, 'updateProfile']);
//        Route::get('user-posts/{name}',[PostController::class, 'getUserPosts']);
        Route::get('all-posts',[PostController::class, 'getAllPosts']);
        Route::post('save-post',[PostController::class, 'savePost']);
        Route::patch('update-post/{id}',[PostController::class, 'updatePost']);
        Route::delete('delete-post/{id}',[PostController::class, 'deletePost']);
        Route::get('/tag/{name}',[PostController::class, 'getPostByTag']);
        Route::get('/profile/{name}',[UserController::class, 'getUserProfile']);
    });
});
