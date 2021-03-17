<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactype extends Model
{
    protected $fillable = ['name'];

    public function ledgers()
    {
      return $this->hasMany('App\Ledger');
    }
}
