<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingOrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'room_id'                   => $this->room_id,
            'booking_order_id'          => $this->booking_order_id,
            'dummy_room_id'             => $this->dummy_room_id,
            'room_name'                 => $this->room_name,
            'room_group_name'           => $this->booking_order->room_group->name,
            'adults'                    => $this->adults,
            'extra_bed'                 => $this->extra_bed,
            'children'                  => $this->children,
            'child_age'                 => $this->child_age,
            'status_id'                 => $this->status_id,
            'time_in'                   => $this->time_in,
            'time_out'                  => $this->time_out,
            'day_stayed'                => $this->day_stayed,
            'cost'                      => $this->cost,
            'status_name'               => $this->status->name,
            'booking_order'             => new BookingOrderResource($this->booking_order),        
        ];
    }
}
