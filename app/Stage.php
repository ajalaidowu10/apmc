<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name',];

    public function book_orders()
    {
      return $this->hasMany('App\BookOrder');
    }
}
