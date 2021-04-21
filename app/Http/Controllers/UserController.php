<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function edit(){
        if(Auth::user()){
            $user = User::find(Auth::user()->id);
            if($user){
                return view('user.edit')->withUser($user);
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }
    }
    public function update(Request $request){
        $user = User::find(Auth::user()->id);
        if($user){
            $validate= $request->validate([
                'avatar'  => ['sometimes', 'image', 'mimes:jpg,jpeg,bmp,svg,png', 'max:5000'],
            ]);
            $user->description= $request['description'];

            $get_image=$request->file('avatar');
        if($get_image){
            $get_name_image=$get_image->getClientOriginalName();
            $name_image=current(explode('.', $get_name_image));
            $new_image = 'public/images/' . time() . '.' .$get_image->getClientOriginalExtension();
        
            $get_image->move('public/images/',$new_image);
            $user->avatar=$new_image;
        }
            $user->save();

            $request->session()->flash('mess', 'update success');
            return redirect()->back();
        }
        else{
            return redirect()->back();
        }
    }

    public function change_password(){
        return view('user.change_password');
    }
    public function update_password(Request $request){
        // $request->validate([
        //     'old_password' => 'required|min=8|max=20',
        //     'new_password' => 'required|min=8|max=20',
        //     'confirm_password' => 'required|same:new_password',
        // ]);
        $user =   User::find(Auth::user()->id);
        
        if(Hash::check($request->old_password,$user->password)){
            $user->update([
                'password' =>Hash::make($request->new_password)
            ]);
            echo 'day nha';
            // console.log('day nah');
            echo $request->old_password;
             echo $user->password;
            return redirect()->back()->with('success', 'Change password success');

        }else{
            echo 'day nha';
            // console.log('day nah');
            echo $request->old_password;
             echo $user->password;
            return redirect()->back()->with('error', 'Old password not matched');
        }
    }
}

