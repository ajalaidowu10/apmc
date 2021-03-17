<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      //get roles 
      $role_super_admin = Role::where('name','super-admin')->first();
      $permission_ids = Permission::pluck('id');


      //create user super admin attach roles and permissions
      $create_super_admin = new Admin([
                                          'name' => 'Super Admin', 
                                          'status_id' => 1, 
                                          'email' => 'superadmin@hotelmanager.com', 
                                          'password' => 'superadmin321',
                                          'created_by' => 1
                                        ]);
      $create_super_admin->role()->associate($role_super_admin);
      $create_super_admin->save();
      $create_super_admin->permissions()->attach($permission_ids);
      $create_super_admin->roles()->attach($role_super_admin);

    }
}
