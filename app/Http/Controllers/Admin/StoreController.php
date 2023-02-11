<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use App\Models\AssingStore;
use App\Models\inventory;
use Illuminate\Support\Str;
use DB;

class StoreController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:store-list|store-create|store-edit|store-delete', ['only' => ['viewStore','addStore']]);
         $this->middleware('permission:store-list', ['only' => ['viewStore']]);
         $this->middleware('permission:store-create', ['only' => ['addStore']]);
         $this->middleware('permission:store-edit', ['only' => ['addStore']]);
         $this->middleware('permission:store-delete', ['only' => ['deleteStore']]);
         $this->middleware('permission:store-status', ['only' => ['changeStoreStatus']]);
         $this->middleware('permission:assign-store', ['only' => ['assignStore']]);
         $this->middleware('permission:store-detail', ['only' => ['storeDetail']]);
         $this->middleware('permission:view-event', ['only' => ['viewEvent']]);
         
         
    }
    
    public function viewStore()
    {
       $stores = Store::get();
       $user = auth()->user()->id;
      if(auth()->user()->type == 'manager')
       {
          $stores = Store::with(['manager' => function($q) use($user) {
                $q->where('user_id', $user);
            }])->whereHas('manager', function ($q) use($user) {
                $q->where('user_id', $user);
            })->get();
       }
        return view('admin.view-store',compact('stores'));
    } 

    public function addStore(Request $request)
    {
        
         $data = $request->except(['image'],$request->all());
        if($request->hasFile('image'))
        {
            $img = Str::random(20).$request->file('image')->getClientOriginalName();
            $data['image'] = $img;
            
            $request->image->move(public_path("documents/stores"), $img);
        }

        // return $data;
        $add = Store::updateOrCreate(['id'=>$request->id],$data,$request->except(['_token']));

        if($request->id)
        {
            // $add = Store::where('id',$request->id)->update($request->except(['_token','id']),$data);
            $message = 'Store Update successfully';
        }else{
            // $add = Store::create($request->except(['_token']),$data);
            $message = 'Store Create successfully';
        }

        return redirect()->back()->with(['message'=>$message,'type'=>'success']);
    }

    public function deleteStore(Request $request)
    {
        Store::where('id',$request->id)->delete();
       return array('message'=>'deleted successfully','type'=>'success');
    }

    public function updateStore(Request $request)
    {
        return Store::where('id',$request->id)->first(); 
    }

    public function changeStoreStatus($id,$status)
    {
       $update =  Store::where('id',$id)->update(['status'=>$status]);
       if($update){
          return redirect()->back()->with(['message'=>'Status updated successfully','type'=>'success']);
       }else{
        return redirect()->back()->with(['message'=>'Something went wrong please try again','type'=>'error']);
       }
    }

    public function assignStore(Request $request)
    {
       
        // return $user = Store::with('manager')->get();
        $stores = Store::where('status',1)->get();
        $manager = User::where('status',1)->where('role_id','Manager')->get();
        return view('admin.assign-store',compact('stores','manager'));
    }

    public function AssignToManager(Request $request)
    {
        foreach($request->user_id as $item)
        {
            $check_user = AssingStore::where(['store_id'=>$request->store_id])->first();
            if($check_user)
            {
                $add =  AssingStore::where(['store_id'=>$request->store_id])->update(['store_id'=>$request->store_id,'user_id'=>$item]);
            }else{
                $add =  AssingStore::create(['store_id'=>$request->store_id,'user_id'=>$item]);
            }
        }

        if($add)
        {
            return redirect()->back()->with(['message'=>'Assign successfully','type'=>'success']);
        }else{
            return redirect()->back()->with(['message'=>'Something went wrong please try again','type'=>'error']);
        }
    }

    public function getUserForAssingStore(Request $request)
    {
        $store =  Store::where('id',$request->id)->first();
        $user_id = AssingStore::where('store_id',$request->id)->pluck('user_id');
        $user =  User::whereNotIn('id',$user_id)->where('role_id','Manager')->where('status',1)->get();
        return [$store,$user];
    }

    public function storeDetail($id)
    {
       $store =  Store::with('manager')->where('id',$id)->first();
        return view('admin/store-detail',compact('store'));
    }

    public function createEvent(Request $request)
    {
        // return $request->all();

        $data = $request->except(['_token'],$request->all());
        $data['user_id'] = auth()->user()->id;
        $data['quantity'] = $request->number_of_botels;
        $add = inventory::updateOrCreate(['id'=>$request->id],$data);
        if($add->number_of_botels >= 15){  
            $firing_email = 'above';
        }else{
            $firing_email = 'less';
        }
        inventory::where('id',$add->id)->update(['firing_email'=>$firing_email]);
        if($request->id){
            $message = 'Inventory Update successfully';
        }else{
            $message = 'Inventory Create successfully';
        }
        return redirect()->back()->with(['message'=>$message,'type' => 'success']);

        // $user = auth()->user()->id;
        
        // $store = Store::with(['manager' => function($q) use($user) {
        //     $q->where('user_id', $user);
        // }])->whereHas('manager', function ($q) use($user) {
        //     $q->where('user_id', $user);
        // })->first();
        // return view('admin/create-event',compact('store')); 
    }


    public function viewEvent()
    {
        $stores = Store::get();
        if(auth()->user()->type == 'manager')
        {
            $inventory =  inventory::with(['store','user'])->where('user_id',auth()->user()->id)->get();
        }else{
            $inventory =  inventory::with(['store','user'])->get();
        }
        return view('admin/view-event',compact('inventory','stores')); 
    }
    public function updateEvent(Request $request)
    {
       $store =  Store::where('id',$request->store_id)->first();
       $inventory = inventory::where('id',$request->id)->first();
      
       return [$inventory,$store];
    }

    public function deleteEvent(Request $request)
    {
        $inventory = inventory::where('id',$request->id)->delete();
        return array('message'=>'event deleted successfully','type'=>'success');
    }



}
