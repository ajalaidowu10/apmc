<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingOrder extends Model
{
    use SoftDeletes;
    protected $fillable = [
                            'user_id', 'room_group_id', 'date_from', 'date_to', 
                            'num_of_night', 'total_room', 'total_adults', 'total_children', 'total_extra_bed', 'room_price', 
                            'extra_bed_price', 'total_room_amount', 
                            'total_room_cost','total_amount', 'status_id', 'is_booked', 'site_booking', 'created_by',
                            'total_extra_bed_amount', 'stage_id', 'deleted_at' 
                            
                          ];

    protected static function boot()
    {
      parent::boot();
      static::creating(function ($booking) {
          $booking->total_room_amount = $booking->num_of_night * $booking->total_room *  $booking->room_price;
          $booking->total_extra_bed_amount = $booking->num_of_night * $booking->total_extra_bed *  $booking->extra_bed_price;
          $booking->total_room_cost = $booking->total_room_amount + $booking->total_extra_bed_amount;
          $booking->total_amount = $booking->total_room_cost;
      });
      static::updating(function ($booking) {
          $booking->total_room_amount = $booking->num_of_night * $booking->total_room *  $booking->room_price;
          $booking->total_extra_bed_amount = $booking->num_of_night * $booking->total_extra_bed *  $booking->extra_bed_price;
          $booking->total_room_cost = $booking->total_room_amount + $booking->total_extra_bed_amount;
          $booking->total_amount = $booking->total_room_cost;
      });
      static::deleting(function ($booking) {
          $booking->booking_order_items()->each(function ($booking_order_item)
          {
            $booking_order_item->delete();
          });
      });
    }

    public function booking_order_items()
    {
      return $this->hasMany('App\BookingOrderItem');
    }

    public function room_group()
    {
      return $this->belongsTo('App\RoomGroup');
    }
    
    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function created_by()
    {
      return $this->belongsTo('App\Admin');
    }

    public function status()
    {
      return $this->belongsTo('App\Status');
    }
    public function stage()
    {
      return $this->belongsTo('App\Stage');
    }
    
}
