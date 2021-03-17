<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingOrderResource extends JsonResource
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
          'room_group'                => $this->room_group->name, 
          'date_from'                 => $this->date_from,
          'date_to'                   => $this->date_to, 
          'status'                    => $this->status->name,
          'message'                   => $this->message,  
          'num_of_night'              => $this->num_of_night,
          'total_extra_bed'           => $this->total_extra_bed, 
          'total_room'                => $this->total_room,
          'total_adults'              => $this->total_adults,
          'total_children'            => $this->total_children, 
          'room_price'                => $this->room_price,
          'extra_bed_price'           => $this->extra_bed_price,  
          'total_room_amount'         => $this->total_room_amount, 
          'total_extra_bed_amount'    => $this->total_extra_bed_amount,  
          'total_room_cost'           => $this->total_room_cost,
          'cgst_amount'               => $this->cgst_amount,
          'sgst_amount'               => $this->sgst_amount,
          'other_charge'              => $this->other_charge,
          'user_id'                   => $this->user_id,
          'account_id'                => $this->user->account->id,
          'account_name'              => $this->user->account->name,
          'total_amount'              => $this->total_amount,
          'created_at'                => $this->created_at->diffForHumans(),
          'user'                      => new UserResource($this->user),
          

        ];
    }
}
