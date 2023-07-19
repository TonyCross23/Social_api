<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::post('/register /',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
        Route::post('/logout',[AuthController::class,'logout']);
        // profile
        Route::get('/profile',[ProfileController::class,'profile']);
        Route::post('/profile/edit/{id}',[ProfileController::class,'profileEdit']);
        Route::post('/profile/image/change',[ProfileController::class,'imageUpdate']);
        // feed
        Route::get('/feed',[FeedController::class,'allFeed']);
        Route::post('/feed/create',[FeedController::class,'createFeed']);
        Route::get('/feed/detail/{id}',[FeedController::class,'detail']);
        // comment
        Route::post('/comment/create',[CommentController::class,'createComment']);
        Route::get('/comment/all',[CommentController::class,'getAllComment']);
        Route::delete('/comment/delete/{id}',[CommentController::class,'destroy']);
        // like
       Route::post('/like/create',[LikeController::class,'createLike']);
       Route::delete('/like/unlike/{id}',[LikeController::class,'unLike']);
});