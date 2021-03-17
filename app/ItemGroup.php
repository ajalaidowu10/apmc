<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemGroup extends Model
{
    protected $fillable = ['name', 'status_id'];

    public function items()
    {
      return $this->hasMany('App\Item');
    }
}
