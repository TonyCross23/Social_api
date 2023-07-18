<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Comment;
use App\Helper\BlogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommetResource;


class CommentController extends Controller
{
    //create comment
    public function createComment (Request $request) {

        $request->validate([
            'user_id' => 'required',
            'feed_id' => 'required',
            'comment' => 'required'
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->feed_id = $request->feed_id;
        $comment->comment = $request->comment;
        $comment->save();

         return BlogHelper::success(new CommetResource($comment),'Success');
    }

    // comment delete
    public function destroy ($id,Request $request) {
        $comment = Comment::where('id',$id)->where('user_id',Auth::user()->id)->Find($id);
        

        if(!$comment){
            return BlogHelper::fail(['message' => 'Comment Not Found']);
        }

        if($comment->user_id !=Auth::user()->id) {
            return BlogHelper::fail([]);
        }

     $comment->delete($id);

        return BlogHelper::success([],'Succefull Deleted');
      
    }

    // get all comment
    public function getAllComment () {
    $feed_id = request()->feed_id;
    $comment = Feed::find($feed_id)->comment;

        return CommetResource::collection($comment)->additional(['message' => 'success']);
    }
}