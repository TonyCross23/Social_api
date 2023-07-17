<?php

namespace App\Http\Controllers;

use App\Helper\BlogHelper;
use App\Http\Resources\FeedCreateResource;
use App\Models\Feed;
use Illuminate\Http\Request;
use App\Http\Resources\FeedResource;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class FeedController extends Controller
{
    //all feed
    public function allFeed () {
        $feeds = Feed::get();
        
        return FeedResource::collection($feeds)->additional(['message' => 'success']);
    }

    // create feed
    public function createFeed (Request $request){
        
        $request->validate([
            'description' => 'required',
        ]);

        $file_name = null;

        if($request->hasFile('image')){
            $file = $request->file('image');
            $file_name = uniqid() . '.' . date('Y-m-d-H-i-s'). '.' . $file->getClientOriginalExtension();
            Storage::put('Feed/' . $file_name, file_get_contents($file));
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

        return BlogHelper::success(new FeedCreateResource($feed,$media),'Successfully Uploaded');
    }
}