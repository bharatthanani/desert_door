<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\User;
use App\Models\Store;
use App\Models\EmployeeInventory;
use App\Models\SellItemByUser;
use Mail;

class InverntoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:inventory-list', ['only' => ['viewInventory']]);
         $this->middleware('permission:sell-bottel-details', ['only' => ['totalSellBottels']]);
    }
    
    public function viewInventory()
    {
     
      // return auth()->user()->id;
      $employee = User::where('id',auth()->user()->id)->where('role_id','Employee')->get();
      if(count($employee)>0)
      {
      //  return $inventory =  EmployeeInventory::with('employee_inventory.store','employee_inventory.user')->where('user_id',auth()->user()->id)->get();
      $inventory =  EmployeeInventory::with('employee_inventory')->where('user_id',auth()->user()->id)->get();
      
      }else{
         // $inventory =  EmployeeInventory::with('employee_inventory')->get();

        $inventory =  inventory::with('employee_inventories')->get();
      }
       return view('admin/view-inventory',compact('inventory'));
    }
    
    public function getStoreAndEmployee(Request $request)
    {
    
        if($request->status == 'employee'){
           return  User::where('id',$request->id)->first();
        }else if($request->status == 'store'){
           return  Store::where('id',$request->id)->first(); 
        }else{
         return  inventory::where('id',$request->id)->first();
        }
    }

    public function changeInventoryStatus(Request $request)
    {
        $update =  inventory::where('id',$request->id)->update(['status'=>$request->status]);
        if($update){
           return ['message'=>'Status updated successfully','type'=>'success'];
        }else{
         return ['message'=>'Something went wrong please try again','type'=>'error'];
        }
    }

    public function deleteInventory(Request $request)
    {
      $buy_item = EmployeeInventory::where('id',$request->id)->first();
      inventory::where('id',$buy_item->inventory_id)->increment('number_of_botels',$buy_item->buy_item);
      $check_number_of_botels = inventory::where('id',$buy_item->inventory_id)->first();
      if($check_number_of_botels->number_of_botels >= 15)
      { 
         inventory::where('id',$buy_item->id)->update(['firing_email'=>'above']);
      }
      $delete =  EmployeeInventory::where('id',$request->id)->delete();

      if($delete){
         return ['message'=>'Deleted successfully','type'=>'success'];
      }else{
       return ['message'=>'Something went wrong please try again','type'=>'error'];
      }
    }

    public function updateInventory(Request $request)
    {
       $data = $request->except(['_token','id'],$request->all());
      $update = inventory::where('id',$request->id)->update($data);
      $check_number_of_botels = inventory::where('id',$request->id)->first()->number_of_botels;
      if($check_number_of_botels >= 15)
      { 
            inventory::where('id',$request->id)->update(['firing_email'=>'above']);
      }

      if($update){
         return redirect()->back()->with(['message'=>'inventory updated successfully','type'=>'success']);
      }else{
         return redirect()->back()->with(['message'=>'Something went wrong please try again','type'=>'error']);
      }
    }

    public function sendEmailToManager(Request $request)
    {
        $user_id =  inventory::where('firing_email','less')->pluck('user_id');
        $store_id =  inventory::where('firing_email','less')->pluck('store_id');
      //  $query = User::WhereIn('id', $user_id)->get();
        $query = inventory::with('user','store')->where('firing_email','less')->WhereIn('user_id',$user_id)
       ->get();
        if(count($query)>0){
          foreach($query as $item)
          {
               $store_name = $item->store['name'];
               $email = $item->user['email'];
               $data = array('inventery'=>'your store:'.$store_name.' inventory  has 15 items left kindly increase your items ');
               $send = Mail::send("admin/inventery_email", $data, function($message) use($email) {
               $message->to($email)->subject('Your inventery is less then 15 item');
               $message->from('desert@desert-door.com','Desert door');
               });

          }
        } 
         
   //   return $models->map->only(['user_id', 'store_id'])->values();
    }

    public function totalSellBottels($id)
    {
      
     $details = inventory::with('employee_inventories.employee_sell_invontery','employee_inventories.employee','user','store')->where('id',$id)->first();
      if(auth()->user()->type == 'employee')
      {
        $user_id =  EmployeeInventory::where('id',$id)->first()->user_id;
        if(auth()->user()->id == $user_id)
         {
           $details =EmployeeInventory::with('employee','employee_sell_invontery','manager_inventory.manager','manager_inventory.store')->where('id',$id)->first();
         }else{
            return redirect('view-inventory');
         }
      }
      
   //   return $collection = $details->map(function ($array) {
   //       return collect($array)->unique('employee_inventories.employee')->all();
   //   });

      // $details = inventory::with('employee_inventories.employee_sell_invontery','employee_inventories.employee','user','store')->where('id',$id)->first();
      return view('admin.total-sell-bottels',compact('details'));
    }

    
}
