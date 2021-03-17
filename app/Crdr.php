<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crdr extends Model
{
    protected $fillable = ['name']; 

    public function accounts()
    {
      return $this->hasMany('App\Account');
    }

    public function ledgers()
    {
      return $this->hasMany('App\Ledger');
    }
}
