<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomGroup extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'descp', 'room_price', 'extra_bed_price', 'status_id','deleted_at'];

    public function rooms()
    {
      return $this->hasMany('App\Room');
    }

    public function booking_orders()
    {
      return $this->hasMany('App\BookingOrder');
    }
    
    public function status()
    {
      return $this->belongsTo('App\Status');
    }
}
