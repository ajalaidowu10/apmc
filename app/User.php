<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasPermissionsTrait;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'company_id', 'first_name', 'last_name', 'phone', 'email', 'password', 'status_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function fullname()
    {
      return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }

    public function account()
    {
      return $this->belongsTo('App\Account');
    }

    public function company()
    {
      return $this->belongsTo('App\Company');
    }

    public function booking_orders()
    {
      return $this->hasMany('App\BookingOrder');
    }




    

}
