<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getMenu(User $user)
    {
      $userPermissions = [];
      $menu = $item1 = $item2 = $item3 = $item4 = $item5 =  [];

      foreach($user->roles as $role)
      {
          $userPermissions[] = $role->permissions; 
      }

      $userPermissions = array_shift($userPermissions);

      foreach ($userPermissions as $permission) 
      {
        switch ($permission->module_id) {
          case 1:
            $new_data = ['id'=>$permission->slug, 'name'=>$permission->name, 'icon'=>$permission->icon, 'link'=>$permission->link];
            array_push($item1, $new_data);
            $menu1 = ['id'=>'menu'.$permission->module_id, 'name'=>$permission->module->name, 'icon'=>$permission->module->icon, 'items'=>$item1];
            
            break;

          case 2:
            $new_data = ['id'=>$permission->slug, 'name'=>$permission->name, 'icon'=>$permission->icon, 'link'=>$permission->link];
            array_push($item2, $new_data);
            $menu2 = ['id'=>'menu'.$permission->module_id, 'name'=>$permission->module->name, 'icon'=>$permission->module->icon, 'items'=>$item2];
            break;

           case 3:
            $new_data = ['id'=>$permission->slug, 'name'=>$permission->name, 'icon'=>$permission->icon, 'link'=>$permission->link];
            array_push($item3, $new_data);
            $menu3 = ['id'=>'menu'.$permission->module_id, 'name'=>$permission->module->name, 'icon'=>$permission->module->icon, 'items'=>$item3];

            break;

            case 4:
              $new_data = ['id'=>$permission->slug, 'name'=>$permission->name, 'icon'=>$permission->icon, 'link'=>$permission->link];
              array_push($item4, $new_data);
              $menu4 = ['id'=>'menu'.$permission->module_id, 'name'=>$permission->module->name, 'icon'=>$permission->module->icon, 'items'=>$item4];
            break;

            case 5:
              $new_data = ['id'=>$permission->slug, 'name'=>$permission->name, 'icon'=>$permission->icon, 'link'=>$permission->link];
              array_push($item5, $new_data);
              $menu5 = ['id'=>'menu'.$permission->module_id, 'name'=>$permission->module->name, 'icon'=>$permission->module->icon, 'items'=>$item5];
            
            break;

          default:
            # code...
            break;
        }
      }

      array_push($menu, $menu1, $menu2, $menu3, $menu4, $menu5);

      return $menu;
    }
}
