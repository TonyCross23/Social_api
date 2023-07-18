<?php

namespace App\Http\Controllers;

use App\Helper\BlogHelper;
use App\Http\Resources\LikeResource;
use App\Models\Like;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    //create like
    public function createLike (Request $request) {
        $request->validate([
            'user_id' => 'required',
            'feed_id' => 'required',
        ]);

        $like = new Like();
        $like->user_id = auth()->user()->id;
        $like->feed_id = $request->feed_id;
        $like->save();

        return BlogHelper::success(new LikeResource($like));
    }
}