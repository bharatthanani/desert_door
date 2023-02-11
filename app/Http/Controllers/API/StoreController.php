<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;

class StoreController extends Controller
{
    public function storeLlist()
    {
        $data =  Store::with('manager')->get();
        $image_path = asset('documents/stores');
        $status = true;
        if(count($data)<0)
        {
            $data = [];
            $status = false;
        }
        return response()->json(['image_path'=>$image_path,'data'=>$data,'success' => $status]);
    }

    public function myStore()
    {
        $user = auth()->user()->id;
        $data = Store::with(['manager' => function($q) use($user) {
            $q->where('user_id', $user);
        }])->whereHas('manager', function ($q) use($user) {
            $q->where('user_id', $user);
        })->get();

        $image_path = asset('documents/stores');
        $status = true;
        if(count($data)<0)
        {
            $data = [];
            $status = false;
        }
        return response()->json(['image_path'=>$image_path,'data'=>$data,'success' => $status]); 
    }
}
