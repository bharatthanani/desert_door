<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventory;
use App\Models\User;
use App\Models\EmployeeInventory;
use App\Models\SellItemByUser;
use Auth;

class InventoryController extends Controller
{
    public function createUpdateInventory(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['quantity'] = $request->number_of_botels;
        $data['bottle_price'] = 10*$request->number_of_botels;
        $add = inventory::updateOrCreate(['id'=>$request->id],$data);
        if($request->id){
            $message = 'Inventory Update successfully';
        }else{
            $message = 'Inventory Create successfully';
        }
        return response()->json(['message'=>$message,'success' => true]);
    }


    public function inventoryLlist()
    {
    //    $data =  User::with('inventory')->where('id',auth()->user()->id)->get();
       $data =  inventory::with('user')->get();
       $status = true;
        if(count($data)<0)
        {
            $data = [];
            $status = false;
        }
      return response()->json(['data'=>$data,'success' => $status]);
       
    }

    public function myInventory()
    {
        
    //    return $data =  User::with('inventory')->where('id',auth()->user()->id)->first(); 
       $data =  inventory::select('inventories.id','inventories.number_of_botels','inventories.created_at','inventories.updated_at')->where('user_id',auth()->user()->id)->get(); 
        $status = true;
        if(count($data)<0)
        {
            $data = [];
            $status = false;
        }
      return response()->json(['data'=>$data,'success' => $status]);
    }

    public function registerEmployeeInEvent(Request $request)
    {
        // return $request->all();
         $inventory = inventory::where('id',$request->inventory_id)->first();
         $data = $request->all();
         $data['user_id'] = auth()->user()->id;
         
        if($request->buy_item<=$inventory->number_of_botels)
        {
           $checkInventory =  EmployeeInventory::where(['user_id'=>auth()->user()->id,'inventory_id'=>$request->inventory_id])->first();
           if($checkInventory)
           {
                EmployeeInventory::where(['user_id'=>auth()->user()->id,'inventory_id'=>$request->inventory_id])->increment('buy_item',$request->buy_item);
           }else{
                EmployeeInventory::create($data);
           }
            inventory::where('id',$request->inventory_id)->decrement('number_of_botels', $request->buy_item);
            $check_number_of_botels = inventory::where('id',$request->inventory_id)->first()->number_of_botels;
            if($check_number_of_botels < 15)
            { 
                inventory::where('id',$request->inventory_id)->update(['firing_email'=>'less']);
            }
            $message = 'You have successfully buy item';
            $success = true;

        }else{
            $message = 'out of stock';
            $success = false;
        }
        return response()->json(['message'=>$message,'success' => $success]);
    }

    public function sellItemByUser(Request $request)
    {
        // return auth()->user()->id;
        date_default_timezone_set("Asia/Karachi"); 
        $input =  $request->all();
        $input['employee_id'] = auth()->user()->id;
        $emp = EmployeeInventory::find($request->employee_inventory_id);
        $inventory_id =  $emp->inventory_id;
        $manager_id = inventory::where('id',$inventory_id)->pluck('user_id');
        $manager =  User::whereIn('id',$manager_id)->first();
        $manager_name = $manager->first_name ." ". $manager->last_name;
        $employee_name = auth()->user()->first_name." ".auth()->user()->last_name;

        if($emp->user_id != auth()->user()->id){
            return response()->json(['message'=>'Unknwon user','false' => false]);
        }
        if($emp)
        {
            if($request->sell_item >= $emp->buy_item)
            {
                return response()->json(['message'=>'Out of stock','success' => false]);
            }
            if($emp->buy_item <= $emp->sell_bottels)
            {
                $this->checknotification_for_user("Hi $manager_name. I am  $employee_name i have sold your all items which i had bought from you",'this employee has sold your all items',$manager->device_token);  
                $message = "No item found in your inventory you have sold your all item successfully";
                $success = false;
            }else{

                SellItemByUser::create($input);
                EmployeeInventory::where('id',$request->employee_inventory_id)->increment('sell_bottels',$request->sell_item);
                $message = "You have successfully sell your item";
                $success = true;
           }

        }else{
            $message = "No data found";
            $success = false;
            
        }
        return response()->json(['message'=>$message,'success' => $success]);
    }

    public function checknotification_for_user($title,$message,$device_token)
       {
          
          
        //   $user = User::where('id',auth()->user()->id)->first();
        
        // dd($userData);
        
            $serverKey = "AAAAskTMn9U:APA91bHiYBqaEyFDIrDp0qzbfYXe6wXwuxbv7XBld2yaF5yA5a6YOPKSh33PJrvel2T0KT2_xJK8iserS5t1mua9rxR5NAzJ7d91X8y_kJ52fBEY2LPh_FeoFKjAltkKfJDRo-ApgIZY";
            // $serverKey = "AAAHULcDwA:APA91bFcSuDsXwm1tBFbcyGqgx3m74mU9zKF6dGmieJHa95upt9Ab1HrR2jrBJYh4wvb4GnaLAcVW8zEbb7wT0PJcOeyydM3rdJ0puDQWw_9G6PxhWMux9LaQ531-n7HUJlWtPUxI-WD";
    	    
    	    //URL that we will send our message to for it to be processed by Firebase.
        	$url = "https://fcm.googleapis.com/fcm/send";
        	
        	$recipient = $device_token;
        
           $notification =
        	[
        		'title'     => $title,
        		'body'      => $message,
        		
        	];
        
        
        	$dataPayload = 
        	[
        		"powerLevel" => "9001",
        		"dataString" => "This is some string data"
        	];
        	
        
        	$fields = 
        	[
        		'to'  => $recipient,
        		'notification' => $notification,
        		'data' => $dataPayload
        	];
        
        	//Set the appropriate headers
        	$headers = 
        	[
        	'Authorization: key=' . $serverKey,
        	'Content-Type: application/json'
        	];
        
        	//Send the message using cURL.
        	$ch = curl_init();
        	curl_setopt( $ch,CURLOPT_URL, $url);
        	curl_setopt( $ch,CURLOPT_POST, true );
        	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        	$result = curl_exec($ch );
        	curl_close( $ch );
        // 	return $result;
       }
}
