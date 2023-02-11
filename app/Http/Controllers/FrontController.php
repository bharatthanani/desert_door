<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


use DB;
use Hash;
use DataTables;
use Session;

class FrontController extends Controller
{

   public function forgotPasswords()
    {
        return view('admin.forgot-password');
    }
    public function resetpassword($id)
    {
        
        return view('admin.resetpasswords-password',compact('id'));
    }
      
    public function forgotPassword(Request $request)
    {
        if($request->has("email")){
            $user = User::where('email',$request->email)->get()->first();
            if($user){
                $first_name = $user->first_name??'';
                $last_name = $user->last_name??'';
                $email = $user->email;
                $fourRandomDigit = time().rand(1000,9999);
                User::where('email',$request->email)->update(['remember_token'=>$fourRandomDigit]);
                $data = array('otp'=>$fourRandomDigit);
               $send = Mail::send("admin/mail2", $data, function($message) use($email,$first_name,$last_name) {
                    $message->to($email, $first_name." ".$last_name)->subject('You have requested to reset your password');
                    $message->from('robertsonalexander40@gmail.com','Test');
                });
                return redirect()->back()->with(['message'=>"A password reset link has been sent to your email",'type'=>'success']);
            }else{
                return redirect()->back()->with(['message'=>"Invalid Email",'type'=>'error']);
            }
        }else
        {
            return redirect()->back()->with(['message'=>"Please provide emai",'type'=>'error']);
        }
    }
    public function updatePassword(Request $request)
    {
        if($request->has("remember_token")){
            if($request->has("password")){
                $user = User::where('remember_token',$request->remember_token)->get()->first();
                if($user)
                {
                    User::where('remember_token',$request->remember_token)->update(['remember_token'=>time().rand(1000,9999),'password'=>Hash::make($request->password)]);
                    return redirect('/')->with(['message'=>"Password reset Successfully",'type'=>'success']);
                }else
                {
                    return redirect()->back()->with(['message'=>"Invalid token please try again",'type'=>'error']);
                }
            }else{
                return redirect()->back()->with(['message'=>"Please enter password",'type'=>'error']);
            }
        }else
        {
            
            return redirect()->back()->with(['message'=>"Please provide reset password token",'type'=>'error']);
        }
    }
    
    
    
}
