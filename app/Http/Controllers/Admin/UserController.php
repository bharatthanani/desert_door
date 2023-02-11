<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\inventory;
use App\Models\EmployeeInventory;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function __construct()
    {
        //  $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-list', ['only' => ['index']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
         $this->middleware('permission:view-manager', ['only' => ['viewManager']]);
         $this->middleware('permission:view-employee', ['only' => ['viewEmployee']]);
         $this->middleware('permission:employee-detail', ['only' => ['EmployeeDetail']]);
   
    }


    public function ip_details()
    {
        $ip = '103.239.147.187'; //For static IP address get
        //$ip = request()->ip(); //Dynamic IP address get
        return $data = \Location::get($ip);                
        // return view('details',compact('data'));
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id','DESC')->where('id','!=',auth()->user()->id)->get();
        return view('admin.view_user',compact('data'));
    }
    

    public function create()
    {
        $roles = Role::pluck('name')->all();
        return view('admin.user-create',compact('roles'));
    }
    

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            
        ]);
    
        $input = $request->all();
        if($request->role_id == 'Admin'){
            $input['type'] ='admin';
        }else if($request->role_id == 'SuperAdmin'){
            $input['type'] ='super_admin';
        }else if($request->role_id == 'Employee'){
            $input['type'] ='employee';
        }else if($request->role_id == 'Manager'){
            $input['type'] ='manager';
        }
        $input['password'] = Hash::make($input['password']);
        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $input['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }
        $user = User::create($input);
        $user->assignRole($request->input('role_id'));
    
        return redirect()->back()->with(['message'=>'User created successfully','type'=>'success']);
    }
    
    public function show($id)
    {
        // return auth()->user()->id;
        if(auth()->user()->type == 'manager'){
            if(auth()->user()->id == $id)
            {
                $user = User::find($id);
            }else{
                return redirect()->back();
            }
        }else if(auth()->user()->type == 'employee'){
            if(auth()->user()->id == $id)
            {
                $user = User::find($id);
            }else{
                return redirect()->back();
            }
        }
        else{
            $user = User::find($id);
        }
        return view('admin.user-show',compact('user'));
    }
    
    public function edit($id)
    {
        if(auth()->user()->type == 'manager'){
            if(auth()->user()->id == $id)
            {
                $user = User::find($id);
            }else{
                return redirect()->back();
            }
        }
        else if(auth()->user()->type == 'employee'){
            if(auth()->user()->id == $id)
            {
                $user = User::find($id);
            }else{
                return redirect()->back();
            }
        }
        else{
            $user = User::find($id);
        }
        // $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('admin.user-edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
       
        $this->validate($request, [
            // 'first_name' => 'required',
            // 'email' => 'required|email|unique:users,email,'.$id,
            // 'password' => 'same:confirm-password',
            // 'role_id' => 'required'
        ]);
    
        $input = $request->all();
       
        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $input['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        if(auth()->user()->type == 'manager'){
            $user->assignRole('Manager');  
        }else if(auth()->user()->type == 'employee'){
            $user->assignRole('Employee');
        }else if(auth()->user()->type == 'admin'){
            $user->assignRole('Admin');
        }else{
            $user->assignRole($request->input('role_id'));
        }
    
        return redirect()->back()
                ->with(['message'=>'User update successfully','type'=>'success']);
    }
    
    public function destroy($id)
    {
       
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with(['message'=>'User delete successfully','type'=>'success']);
    }

    public function viewManager()
    {
        $data = User::orderBy('id','ASC')->where('type','manager')->where('id','!=',auth()->user()->id)->get();

        if(auth()->user()->type == 'super_admin')
        {
            $data = User::orderBy('id','ASC')->where('type','manager')->where('id','!=',auth()->user()->id)->get();
        }else if(auth()->user()->type == 'manager'){
            $data = User::orderBy('id','ASC')->where('type','manager')->where('id',auth()->user()->id)->get();
        }else{
            $data = User::orderBy('id','ASC')->where('type','manager')->where('id','!=',auth()->user()->id)->get();
        }
        return view('admin.view-manager',compact('data'));
    }


    public function viewEmployee()
    { 
       $data = User::orderBy('id','ASC')->where('type','employee')->where('id','!=',auth()->user()->id)->get();

        if(auth()->user()->type == 'super_admin'){
            $data = User::orderBy('id','ASC')->where('type','employee')->where('id','!=',auth()->user()->id)->get();
        }else if(auth()->user()->type == 'employee'){
            $data = User::orderBy('id','ASC')->where('type','employee')->where('id',auth()->user()->id)->get();
        }
        return view('admin.view-employee',compact('data'));  
    }

    public function EmployeeDetail($id)
    {
        // return $id;
        //  $buy = User::with('employee')->get();
        //  $employee_detail =  User::with('inventory.store')->where('id',$id)->first();
         $employee_detail =  User::with('inventory.store')->where('id',$id)->first();
    //    $employee_detail[0]->inventory;
        return view('admin.user-detail',compact('employee_detail'));
    }

     public function managerDetail($id)
     {
        // return $id;
        $employee_detail =  User::with('inventory.store.manager')->where('id',$id)->first();
        return view('admin.manager-detail',compact('manager_detail'));
     }
}
