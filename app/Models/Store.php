<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = array('pivot');

    public function manager()
    {
        return $this->belongsToMany(User::class,'assing_stores');
    }

}
