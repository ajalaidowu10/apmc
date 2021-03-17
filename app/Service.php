<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'price', 'status_id','deleted_at'];

    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}
