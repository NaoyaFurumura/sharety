<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserProfile;
use Illuminate\Support\Facades\Auth;
use Storage;
use App\User;

class UserProfilesController extends Controller
{
    public function create(){
        return view('profiles.create');
    }

    public function store(Request $request){

        $request->validate([
            'prf_img'=>'required',
        ],[
            'prf_img.required'=>'プロフィール画像を選択してください',
        ]);

        
        $path = Storage::disk('s3')->putFile('user_img', $request->prf_img, 'public');
       
        
        $userprf = new UserProfile;
        $userprf->user_profile = Storage::disk('s3')->url($path);
        $userprf->user_id = Auth::id();
        $userprf->save();
        return back();
    }

    public function update(Request $request){
        
        $user = User::find(\Auth::id());

        if($request->prf_img){

            $path = Storage::disk('s3')->putFile('user_img', $request->prf_img, 'public');

            $user->user_profile = torage::disk('s3')->url($path);
            $userprf->user_id = Auth::id();
            $userprf->save();

        }else{
            $user->profile->delete();
        }

       
        return back();

    }
}
