<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInventory extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function employee_inventory()
    {
        return $this->belongsTo(inventory::class,'inventory_id');
    }

    public function manager_inventory()
    {
        return $this->belongsTo(inventory::class,'inventory_id');
    }


    public function employee_sell_invontery()
    {
        
        return $this->hasMany(SellItemByUser::class,'employee_inventory_id','id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'user_id');

    }


   


    
}
