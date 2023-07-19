<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Media;
use App\Helper\BlogHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //profile 
    public function profile () {
        $user = auth()->guard()->user();

        return BlogHelper::success(new ProfileResource($user));
    }

    // profileEdit
    public function profileEdit ($id,Request $request){
       
        $user = User::findOrFail($id);

        $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'gender' => 'required',
                'dob' => 'required',
        ]);
   
        $user->name = $request->name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->dob = $request->dob;
        $user->update();

        return BlogHelper::success(new ProfileResource($user),'success');
    }

    // profile image update
    public function imageUpdate (Request $request) {

        $user = Auth::user()->id;
        $media = Media::get();
        
      $file_name = null;

            if($request->hasFile('image')){
                $file = $request->file('image');
                $file_name = uniqid().'-'.date('Y-m-d,H-i-s'). '.' . $file->getClientOriginalExtension();
                Storage::put('media/'.$file_name,file_get_contents($file));
            }

     $media = new Media();
            $media->file_name = $file_name;
            $media->file_type = 'image';
            $media->model_id = $user->id;
            $media->model_type = User::class;
            $media->save();
        
        return $media;
    }
}