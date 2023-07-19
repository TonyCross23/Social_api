<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Feed;
use App\Models\Media;
use App\Models\Comment;
use App\Helper\BlogHelper;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\FeedResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FeedCreateResource;
use App\Http\Resources\FeedDetailResource;

class FeedController extends Controller
{
    //all feed
    public function allFeed () {
        $feeds = Feed::with('comment')->get();
        
        return FeedResource::collection($feeds)->additional(['message' => 'success']);
    }

    // feed detail
    public function detail ($id) {
        $feed_detail = Feed::where('id',$id)->where('user_id',Auth::user()->id)->with('comment')->get();

        $comments = Comment::where('feed_id',$id)->get();

       return FeedDetailResource::collection($feed_detail,$comments)->additional(['message' => 'success']);
    }

    // create feed
    public function createFeed (Request $request){
        
        $request->validate([
            'description' => 'required',
        ]);

        DB::beginTransaction();
        try {
                 $file_name = null;

                if($request->hasFile('image')){
                    $file = $request->file('image');
                    $file_name = uniqid() . '.' . date('Y-m-d-H-i-s'). '.' . $file->getClientOriginalExtension();
                    Storage::put('media/' . $file_name, file_get_contents($file));
                }

                $feed = new Feed();
                $feed->user_id = auth()->user()->id;
                $feed->description = $request->description;
                $feed->save();

                $media = new Media();
                $media->file_name = $file_name;
                $media->file_type = 'image';
                $media->model_id = $feed->id;
                $media->model_type = Feed::class;
                $media->save();

                DB::commit();
                return BlogHelper::success(new FeedCreateResource($feed,$media),'Successfully Uploaded');
        } catch (\Exception $e) {
                DB::rollBack();
                return BlogHelper::fail($e->getMessage());
        }
   
    }
}