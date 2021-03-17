<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Account;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use App\Ledger;
use DB;
use Auth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function getAllUser()
    {
      return User::all()->get(['email']);
    }

    public function signup(SignupRequest $request)
    {
        DB::beginTransaction();
          try 
          {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                
                $account = new Account;
                $account->account_type_id = 2;
                $account->name = $request->input('first_name')." ".$request->input('last_name');
                $account->crdr_id = 2;
                $account->groupcode_id = 10;
                if (Auth::guard('admin')->check()) 
                {
                  $account->created_by = Auth::guard('admin')->user()->id;
                }
                else
                {
                    $account->created_by = null;
                }
                $account->save();
                $opening_bal = new Ledger([
                                              'tran_id' => $account->id, 
                                              'transactype_id' => 1, 
                                              'acct_one_id' => $account->id,
                                              'acct_two_id' => $account->id,
                                              'amount' => 0,
                                              'enter_date' => $account->created_at,
                                              'crdr_id' => $account->crdr_id,
                                              'descp' => $account->name.' '.' Opening Balance of '.$account->opening_bal.' '.$account->crdr->name,
                                              'created_by' => $account->created_by,
                                          ]);
                $opening_bal->save();

                $user = new User($request->all());
                $account->user()->save($user);
            } else {
              $user->update($request->all());
            }
            
            
            
          } catch (Exception $e) {
            DB::rollback();
            throw $e;
            
          }

          DB::commit();
          

        // Mail::to($user->email)->send(new VerificationMail($user));
        
        return response()->json(['user_id' => $user->id]);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->fullname(),
        ]);
    }
}
