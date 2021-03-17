<?php

namespace App\Http\Controllers;
use App\Permission;
use Symfony\Component\HttpFoundation\Response;
use App\Admin;
use Auth;
use App\Http\Resources\PermissionResource;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    function __construct()
    {
      $this->middleware('JWT');
    } 

    public function check(string $permissionName)
    {
        $get_permission = Permission::where('slug', $permissionName)->first();
        if ($get_permission) 
        {
          if (Auth::guard('admin')->user()->hasPermissionTo($get_permission)) 
          {
            return response('', 204);
          }
        } 
        
      return response()->json(['error' => 'Unauthorized'], 401);;
    }

    public function getPermission(Admin $admin)
    {
        if ($admin->id == 1) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $all_permissions =  PermissionResource::collection(Permission::all());

        $user_permissions = [];

        foreach ($admin->permissions as $value) {
          $user_permissions[] = $value->slug;
        }

        return response(['all_permissions' => $all_permissions, 'user_permissions' => $user_permissions]);

    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function refreshPermission(Request $request, Admin $admin)
    {
        if ($admin->id == 1) 
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user_permissions = $request->input('user_permissions');

        $admin = $admin->refreshPermissions($user_permissions);
        $admin->save();

        return response(['name' => $user_permissions], Response::HTTP_CREATED);
        
    }
}
