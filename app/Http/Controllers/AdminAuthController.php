<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Admin;
use App\Account;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use App\Ledger;
use DB;
use Auth;
use App\Http\Resources\AdminResource;


class AdminAuthController extends Controller
{
    /**
     * Create a new AdminAuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','signup']]);
    }

   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AdminResource::collection(Admin::latest()->get());
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(AdminRequest $request)
    {
        $admin = new Admin($request->all());
        $admin->save();

        return response(['name' => $admin->name], Response::HTTP_CREATED);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $Admin)
    {
       return new AdminResource($Admin);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        $admin->update($request->all());
        return response(['name' => $admin->name], Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
       $admin->delete();
       return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Auth::guard('admin')->user()->company_id = request('company_id');
        Auth::guard('admin')->user()->finyear_id = request('finyear_id');
        Auth::guard('admin')->user()->save();


        return $this->respondWithToken($token);
    }


    /**
     * Get the authenticated Admin.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(Auth::guard('admin')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();


        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('admin')->refresh());
    }

    public function menu()
    {
      $admin = Auth::guard('admin')->user();
      $adminPermissions = $admin->permissions;
      $menu = $item1 = $item2 = $item3 = $item4 = $item5 =  $menu1 = $menu2 = $menu3 = $menu4 = $menu5 =[];


      foreach ($adminPermissions as $permission) 
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

      if ($menu1) 
      {
          array_push($menu, $menu1);
      }
      if ($menu2) 
      {
          array_push($menu, $menu2);
      }
      if ($menu3) 
      {
          array_push($menu, $menu3);
      }
      if ($menu4) 
      {
          array_push($menu, $menu4);
      }
      if ($menu5) 
      {
          array_push($menu, $menu5);
      }
      

      return $menu;
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $company = Auth::guard('admin')->user()->company->name;
        $finyear_from = substr(Auth::guard('admin')->user()->finyear->from_date, 0, 4);
        $finyear_to = substr(Auth::guard('admin')->user()->finyear->to_date, 2, 2);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('admin')->factory()->getTTL() * 60,
            'user' => Auth::guard('admin')->user()->name,
            'company' => $company.' | '.$finyear_from.' - '.$finyear_to,
        ]);
    }
}
