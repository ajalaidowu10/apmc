<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;

class BookingOrderItem extends Model
{
    use SoftDeletes;
    protected $fillable = [
                          'booking_order_id', 'dummy_room_id', 'adults', 'extra_bed', 
                          'children', 'child_age', 'status_id', 'deleted_at'
                        ];

    public function booking_order()
    {
      return $this->belongsTo('App\BookingOrder');
    }
    public function room()
    {
      return $this->belongsTo('App\Room');
    }
    public function status()
    {
      return $this->belongsTo('App\Status');
    }
    public function getRoomNameAttribute()
    {
      if ($this->room_id) {
        return $this->room->name;
      } else {
        return "None";
      }
      
    }

    public function getDayStayedAttribute()
    {
      if ($this->time_in && $this->time_out) {

        $time_in = new DateTime($this->time_in);
        $time_in = $time_in->format('Y-m-d');
        $time_out = new DateTime($this->time_out);
        $time_out = $time_out->format('Y-m-d');
        $datetime1 = new DateTime($time_in);
        $datetime2 = new DateTime($time_out);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');

        if ($days == 0) {
          return 1;
        }
        
        return $days;
        
      }
      
      if ($this->time_in && !$this->time_out) {
        $time_in = new DateTime($this->time_in);
        $time_in = $time_in->format('Y-m-d');
        $time_out = now();
        
        $datetime1 = new DateTime($time_in);
        $datetime2 = new DateTime($time_out);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');

        if ($days == 0) {
          return 1;
        }
        
        return $days;
      }

      return  null;
      
    }

    public function getCostAttribute()
    {
      if ($this->day_stayed) {
        $room_cost = $this->booking_order->room_price * $this->day_stayed;
        $bed_cost = ($this->booking_order->extra_bed_price * $this->extra_bed) * $this->day_stayed;
        $cost = $room_cost + $bed_cost;

        return $cost;
      }

      return null;
    }
    public function getGstAttribute()
    {
      if ($this->day_stayed) {
        $gst = $this->cost * 0.16;

        return $gst;
      }

      return null;
    }
    public function getAmountAttribute()
    {
      if ($this->day_stayed) {
        $amount = $this->cost + $this->gst;

        return $amount;
      }

      return null;
    }
}
