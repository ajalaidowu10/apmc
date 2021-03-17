<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name',];

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function users()
    {
      return $this->hasMany('App\User');
    }

    public function book_orders()
    {
      return $this->hasMany('App\BookOrder');
    }

    public function admins()
    {
      return $this->hasMany('App\Admin');
    }

    public function accounts()
    {
      return $this->hasMany('App\Account');
    }
}
