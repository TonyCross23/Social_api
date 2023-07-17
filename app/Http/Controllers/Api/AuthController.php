<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Models\Media;
use App\Helper\BlogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    //register 
    public function register (Request $request){
       $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'gender' => 'required',
        'dob' => 'required',
        'password' => 'required|min:8',
       ]);

       DB::beginTransaction();
      try {
                $file_name = null;

            if($request->hasFile('image')){
                $file = $request->file('image');
                $file_name = uniqid().'-'.date('Y-m-d,H-i-s'). '.' . $file->getClientOriginalExtension();
                Storage::put('media/'.$file_name,file_get_contents($file));
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->password = Hash::make($request->password);
            $user->save();

            $media = new Media();
            $media->file_name = $file_name;
            $media->file_type = 'image';
            $media->model_id = $user->id;
            $media->model_type = User::class;
            $media->save();

                $token = $user->createToken('blog')->accessToken;
            return BlogHelper::success([
                'access_token' => $token,
            ]);
      } catch (Exception $e) {
        DB::rollBack();
        return BlogHelper::fail($e->getMessage());
      }
    }

    // login 
    public function login (Request $request) {
        if(Auth::attempt(['email' => $request->email , 'password' => $request->password])){
            $user = Auth::user();

            $token = $user->createToken('Token')->accessToken;

            return BlogHelper::success([
                'access_token' => $token,
            ]);
        }
    }

    // logout
    public function logout (Request $request){
        Auth::user()->token()->revoke();

        return BlogHelper::success([],'Successfull Logout');
    }
}