<?php

namespace App\Http\Controllers\Api;

use App\Helper\BlogHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //profile 
    public function profile () {
        $user = auth()->guard()->user();

        return BlogHelper::success(new ProfileResource($user));
    }
}