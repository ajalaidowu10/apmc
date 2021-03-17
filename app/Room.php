<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    protected $fillable = ['room_group_id', 'name', 'intercom', 'status_id','deleted_at'];

    public function room_group()
    {
      return $this->belongsTo('App\RoomGroup');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}
