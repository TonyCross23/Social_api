<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Helper\BlogHelper;
use Illuminate\Http\Request;
use App\Http\Resources\LikeResource;
use Illuminate\Support\Facades\Auth;


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

    // unlike
    public function unLike ($id,Request $request) {

        $like = Like::where('id',$id)->where('user_id',auth()->user()->id)->find($id);

        if(!$like){
            return BlogHelper::fail(['message' => 'Not Found']);
        }

        if($like->user_id !=Auth::user()->id) {
            return BlogHelper::fail([]);
        }

     $like->delete($id);

     return BlogHelper::success(new LikeResource($like),'success');
        
    }
}