<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;



Route::post('/register /',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
        Route::post('/logout',[AuthController::class,'logout']);
        // profile
        Route::get('/profile',[ProfileController::class,'profile']);
        // feed
        Route::get('/feed',[FeedController::class,'allFeed']);
        Route::post('/feed/create',[FeedController::class,'createFeed']);
        // comment
        Route::post('/comment/create',[CommentController::class,'createComment']);
        Route::delete('/comment/delete/{id}',[CommentController::class,'destroy']);
});