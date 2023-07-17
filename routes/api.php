<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
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
});