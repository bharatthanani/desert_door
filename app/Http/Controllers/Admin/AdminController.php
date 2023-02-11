<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\ContactUsPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use DB;
use Hash;
use DataTables;
use Mail;
use Carbon\Carbon;
use Session;


class AdminController extends Controller
{

    function __construct()
    {
        // $this->middleware(['auth','verified']);
        $this->middleware('permission:user-status', ['only' => ['change_status']]);
    }

    public function contactUsPage(){
        $data = ContactUsPage::first();
        return view('admin.contact-us-page',compact('data'));
    }

    public function addContactUsImage(Request $request){
       $data = $request->except(['_token','id'],$request->all());
        if($request->hasFile('image1'))
        {
            $img = Str::random(20).$request->file('image1')->getClientOriginalName();
            $data['image1'] = $img;
            $request->image1->move(public_path("documents/image"), $img);
        }

        if($request->hasFile('image2'))
        {
            $img = Str::random(20).$request->file('image2')->getClientOriginalName();
            $data['image2'] = $img;
            $request->image2->move(public_path("documents/image"), $img);
        }


        if($request->hasFile('image3'))
        {
            $img = Str::random(20).$request->file('image3')->getClientOriginalName();
            $data['image3'] = $img;
            $request->image3->move(public_path("documents/image"), $img);
        }


        if($request->hasFile('image4'))
        {
            $img = Str::random(20).$request->file('image4')->getClientOriginalName();
            $data['image4'] = $img;
            $request->image4->move(public_path("documents/image"), $img);
        }


        if($request->hasFile('image5'))
        {
            $img = Str::random(20).$request->file('image5')->getClientOriginalName();
            $data['image5'] = $img;
            $request->image5->move(public_path("documents/image"), $img);
        }

        if($request->id){
            $add = ContactUsPage::where(['id'=>$request->id])->Update($data);

        }
        $add = ContactUsPage::Create($data);
        if($add){
            return redirect()->back()->with(['message'=>'Success','type'=>'success']);
        }else{
            return redirect()->back()->with(['message'=>'Error','type'=>'error']);

        }
    }
    public function user_login(Request $request)
    {
        // return view('admin/login');
        if(Auth::check()){
            return redirect('dashboard');
        }else{
           return view('admin/login');
        }
    }


    public function register(Request $request)
    {
        return view('admin/register');
    }

    public function loginAdminProcess(Request $request)
    {

        
        if (Auth::attempt(array('email' => $request->email, 'password' => $request->password)))
        {
           if(Auth::check()){
            
              if(auth()->user()->email_verified_at){
                  if(auth()->user()->status == 1)
                  {
                      return redirect('dashboard')->with(array('message'=>'Login success','type'=>'success'));
                  }else{
                        Auth::logout(); 
                        return redirect()->back()->with(array('message'=>'Please wait for admin approval','type'=>'error'));;
                  }
                return redirect('dashboard')->with(array('message'=>'Login success','type'=>'success'));
                }else{
                    Session::flush();
                    Auth::logout();
                    // return auth()->user()->email_verified_at;
                    return redirect('/')->with(array('message'=>'Your email is not verified','type'=>'error'));;
                   
                   
                }   
            }
        }else{
            
            return redirect()->back()->with(array('message'=>'Invalid email or Password','type'=>'error'));
        }
    }
    
    
    public function AdminRegisterPrcess(Request $request)
    {
       
        $token = Str::random(40); 
        $validator = Validator::make($request->all(), [
           'email'         => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with(array('message'=>'This email is already exists','type'=>'error'));
        }
        
        $users = $request->except(['password','password_confirmation'],$request->all());
        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $users['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }
        $users['role_id'] = 'Manager';
        $users['password'] = hash::make($request->password);
        $users['remember_token'] = $token;
        $user = User::create($users);
        $user->assignRole('Manager');
        $myUser = User::where('id',$user->id)->first();
        if($myUser)
        {
            if($myUser->email_verified_at == null)
            {
                $data = ['token'=>$token];
                $this->CheckEmailVerify($token,$request->email);
            
            }
        }
        if($user)
        {
            return redirect()->back()->with(array('message'=>'account created succssfully Please check your email','type'=>'success'));
            
        }else{
            return redirect()->with(array('message'=>'Somethig wrong please try again','type'=>'error'));
        }


    }

    public function dashboard(Request $request)
    {
        // return \Request::getClientIp(true);
        
        return view('admin/dashboard');
    }

    public function view_user()
    {
      return view('admin/view-user');
    }

    public function get_users(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    if($row->status == '0'){
                        $status = '<a href="javascript:void(0)" data-id='.$row->id.' data-status="1" class="active-record btn btn-danger btn-sm">Inactive</a>';
                    }else{
                        $status = '<a href="javascript:void(0)" data-id='.$row->id.' data-status="0" class="active-record btn btn-success btn-sm">Active</a>'; 
                    }
                    $actionBtn = ''.$status.' <a href="javascript:void(0)" data-toggle="modal"  data-target="#modal-default" class="update_user btn btn-success btn-sm"  data-id='.$row->id.'>Update</a>  <a href="javascript:void(0)" data-id='.$row->id.' class="delete-record btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function change_status(Request $request)
    {
        $statusChange = User::where('id',$request->id)->update(['status'=>$request->status]);
        if($statusChange)
        {
            return array('message'=>'User status  has been changed successfully','type'=>'success');
        }else{
            return array('message'=>'User status has not changed please try again','type'=>'error');
        }

    }

    public function delete_user(Request $request)
    {
       
       $deleteUser = User::where('id',$request->id)->delete();
        if($deleteUser)
        {
            return array('message'=>'User has been deleted successfully','type'=>'success');
        }else{
            return array('message'=>'User has not deleted please try again','type'=>'error');
        }
    }

   
   public function logouts()
    {
        Auth::logout();
        return redirect('/');
    }

    public function profile()
    {
        return view('admin/profile'); 
    }

    

    public function addUpdateUser(Request $request)
    {
        if(!$request->id)
        {
            $validator = Validator::make($request->all(), [
                'email'         => 'required|email|unique:users',
            ]);
            if ($validator->fails()) {
                 return array('message'=>'This email is already exists','type'=>'error');
            }
        }
        
        $users = [
            'first_name'    =>$request->first_name,
            'last_name'     =>$request->last_name,
            'email'         =>$request->email,
            'phone_number'  =>$request->phone_number,
            'address'       =>$request->address,
            // 'country_id'   =>$request->country_id,
        ];
        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $users['profile'] = $img;
            $request->profile->move(public_path("/documents/profile"), $img);
        }
        if($request->id)
        {
            $user = User::where('id',$request->id)->update($users);
            $message = 'User update successfully';
        }else{
            $user = User::create($users);
            $message = 'account created succssfully';
        }
        
        if($user)
        {
            return array('message'=>$message,'type'=>'success');
        }else{
            return array('message'=>'Somethig wrong please try again','type'=>'error');
        }
    }

    public function getUsers(Request $request)
    {
        return User::where('id',$request->id)->first();
    }


    public function CheckEmailVerify($token,$email)
    {
           $data = ['token'=> $token];

           $mail = Mail::send('admin.check-email', array(
                'token' => $data,
               
            ), function($message) use ($email){
                $message->to($email)->subject('Verify  Mail');
            });
    }
    
    public function verrifyEmail($token)
    {
        $user = User::where('remember_token',$token)->first();
        $myToken = Str::random(40);
        if($user)
        {
            User::where('remember_token',$token)->update(['email_verified_at' => Carbon::now(),'remember_token'=>$myToken]);
            return redirect('/')->with(['message'=>'Email verified please login your account','type'=>'success']);
        }else{
           return redirect()->back()->with(array('message'=>'Something went wrong please try again','type'=>'error')); 
        }
    }


    

 }
