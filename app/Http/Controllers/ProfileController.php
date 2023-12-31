<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(){
        return view('backend.profile');
    }
    public function update(Request $request){
        $request->validate([
            'name'=>'required|string|max:30',
            'email'=>'required|email|unique:users,email,'.auth()->id(),
            'profile'=> 'nullable|image|mimes:png,jpg,jpeg,webp'
        ]);
        if($request->hasFile('profile')){
            $profile_image_name = str(auth()->user()->name)->slug().time().'.'.$request->profile->extension();
            $request->profile->storeAs('user',$profile_image_name, 'public');
        }

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile = isset($profile_image_name) ? $profile_image_name : auth()->user()->profile;
        $user->save();
        return back();
    }
    //change password
    public function changePassword(Request $request){
        $request->validate([
            'oldpass'=>'required|current_password',
            'password'=>'required|min:8|confirmed|different:oldpass',

        ]);
        $user = User::find(auth()->id());
        $user->password = Hash::make($request->password);
        $user->save();
        notify()->success('Laravel Notify is awesome!');
        return back();
    }
}
