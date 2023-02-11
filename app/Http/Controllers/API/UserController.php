<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Laravel\Passport\Passport;
use Auth;
use Hash;
use Mail;

use DB;


/*use Carbon\Carbon;
use File;
use Image;*/

class UserController extends Controller
{
   
    public function register(Request $request)
   	{
        
    //    return $request->all();
       $checkEmail = User::where('email',$request->email)->first();
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                
            ]);

           if(!$request->password)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Password is required'
                ]);
                    
            }else if($request->password != $request->confirm_password)
            {
                
                return response()->json([
                    'success' => false,
                    'message' => 'Confirm password does not match'
                ]);
            }
        
            if($checkEmail){
                return response()->json([
                    'success' => false,
                    'message' => 'Email already exits'
                ]);
            }
			
        //   $data = [
        //         'role_id'        =>'Manager',
        //         'first_name'     =>$request->first_name,
        //         'last_name'      => $request->last_name,
        //         'phone_number'   =>$request->phone_number,
        //         'address'        =>$request->address,
        //         'email'          =>$request->email,
        //         'password'       =>Hash::make($request->password),
        //         'status'         =>0,
        //     ];
            $data = $request->except(['confirm_password'],$request->all());
            if($request->hasFile('profile'))
            {
                $img = Str::random(20).$request->file('profile')->getClientOriginalName();
                $data['profile'] = $img;
                $request->profile->move(public_path("documents/profile"), $img);
            }
            $data['role_id'] = 'Employee';
            $data['password'] = Hash::make($request->password);
            $data['status']   = 0;
            $user = User::create($data);
            $user->assignRole('Employee');
          if($user)
          {
            if (auth()->attempt($credentials))
                {
                    //generate the token for the user
                    $user_login_token= auth()->user()->createToken('desert-door')->accessToken;
                    $profile_path = asset('documents/profile/'.auth()->user()->profile);
                    return response()->json([
                        'profile_path' =>$profile_path,
                        'success' => true,
                        'data' 	  => auth()->user(),
                        'token'	  => $user_login_token
                    ]);
                }
          }else{
            return response()->json([
                'success' => false,
                'message' => 'User has not added please try again'
            ]);
          } 
		
       
	
	}

	public function authenticate(Request $request)
	{

        if(!$request->email)
        {
            return response()->json([
                'success' => false,
                'message' => 'Email is required'
            ]);
                
        }else if(!$request->password)
        {
            
            return response()->json([
                'success' => false,
                'message' => 'Password is required'
            ]);
        }
        
		$credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            
        ]);
        
		
		if (Auth()->attempt($credentials))
        {
            //generate the token for the user
             $user_login_token= Auth()->user()->createToken('desert-door')->accessToken;
             $profile_path = asset('documents/profile/'.auth()->user()->profile);
            return response()->json([
                'profile_path' =>$profile_path,
	            'success' => true,
	            'data' 	  => Auth()->user(),
	            'token'	  => $user_login_token
	        ]);
		}
        else
        {
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json([
                'success' => false,
                'message' => 'UnAuthorized Access'
            ]);
		}

	}
	

    public function invalid()
    {
        return response()->json([
            'success' => false,
            'message' => 'UnAuthorized Access'
        ]);
    }
   
	public function ForgetPasswordEmail(Request $request)
    {
        if($request->has("email")){
           $user = User::where('email',$request->email)->get()->first();
            if($user){
               
                $email = $user->email;
                $fourRandomDigit = mt_rand(1000, 9999);
                User::where('email',$request->email)->update(['forget_password_code'=>$fourRandomDigit]);
                $data = array('otp'=>$fourRandomDigit);
                $send = Mail::send("mail", $data, function($message) use($email) {
                $message->to($email)->subject('You have requested to reset your password');
                $message->from('areebraza@qtechnologies.org','foot fetchapp');
                });
                 return response([
                    'success' => true,
                    'message' => 'Otp has been send to your email',
                    'code'    => $fourRandomDigit,
                    'id'      =>$user->id
                 ]);
                 
            }else{
               
                 return response([
                    'success' => false,
                    'message' => 'Invalid Email'
                 ]);
            }
        }else
        {
             return response([
                'success' => false,
                'message' => 'Please provide email'
            ]);
            
        }
    }
    

	public function ForgetPasswordEmail1(Request $request)
	{
		$emailAddress   = $request->email;
		$checkEmailExist = User::where('email', $emailAddress)->first();
        if($checkEmailExist)
        {
            //generate six digits code
            // return str_random(1,20);
             $six_digit_random_number = mt_rand(1000, 9999);

            $setCode = User::where('email', $emailAddress)->update([
                'forget_password_code'  => $six_digit_random_number
            ]);

            if($setCode)
            {
               return response([
                    'success' => true,
                    'message' => 'Successfully Code generated',
                    'data'      => [
                        'id'    => $checkEmailExist->id,
                        'email' => $checkEmailExist->email
                    ]
                ]);
            }
            else
            {
                return response([
                    'success' => false,
                    'message' => 'Failed to generate code'
                ]);
            }
        }
        else
        {
            return response([
                'success' => false,
                'message' => 'Email not exists'
            ]);
        }
	}

	public function checkForgetPasswordCodeVerification(Request $request)
	{
		$code = $request->code;
        // $id   = $request->id;

        $checkEmailCode = User::where('forget_password_code', $code)->first();
        if($checkEmailCode == null)
            return response([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        else
            return response([
                'success'   => true,
                'message'   => 'Code matched successfully'
            ]);
    }

    public function updateForgetPassword(Request $request)
    {
        $id = $request->id;
        $password = $request->password;

        $passwordHash   = Hash::make($password);
        $updatePassword = User::find($id)->update(['password' => $passwordHash]);
        if($updatePassword)
        {
            return response([
                'success'   => true,
                'message'   => 'Password updated successfully'
            ]);
        }
        else
        {
            return response([
                'success' => false,
                'message' => 'Failed'
            ]);
        }
    }

    public function changePassword(Request $request)
    {
       
        // $token= request()->bearerToken();
		#Match The Old Password
        if(!Hash::check($request->oldPassword, auth()->user()->password))
            return response([
                'success' => false,
                'message' => "Old Password Doesn't match!"
            ]);
    
        #Update the new Password
        User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->newPassword)
        ]);

        return response([
            'success'   => true,
            'message'   => 'Password updated successfully'
        ]);
	}


   

    public function UpdateProfile(Request $request)
    {
        
        $data = $request->all();
        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $data['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }
        $user = User::where('id',auth()->user()->id)->update($data);
        $profile_path = asset('documents/profile');
        $data = User::where('id',auth()->user()->id)->first();
        
        return response()->json(['user_data'=>$data,'success' => true]);

    }

}
