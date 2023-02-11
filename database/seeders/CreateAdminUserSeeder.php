<?php

namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
  
class CreateAdminUserSeeder extends Seeder
{
   
    public function run()
    {
        $user = User::create([
            'first_name' => 'David', 
            'last_name' => 'Brown', 
            'email'       => 'admin@gmail.com',
            'password' => hash::make(123),
        ]);
    
        $role = Role::create(['name' => 'SuperAdmin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
        
        $user->role_id = $role->name;
        $user->save();
    }
}
