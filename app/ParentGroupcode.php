<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentGroupcode extends Model
{
    protected $fillable = ['name'];

    public function groupcode()
    {
      return $this->hasMany('App\Groupcode');
    }
}
