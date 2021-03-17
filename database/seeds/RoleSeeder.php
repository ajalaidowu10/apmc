<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get all permissions
        $permission_ids = Permission::pluck('id');

        //create super admin roles and attach all permissions
        $super_admin_role = new Role();
        $super_admin_role->name = 'super-admin';
        $super_admin_role->save();
        $super_admin_role->permissions()->attach($permission_ids);
        

    }
}
