<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomGroupResource extends JsonResource
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
                  'id'               => $this->id,
                  'name'             => $this->name,
                  'descp'             => $this->descp,
                  'room_price'       => $this->room_price,
                  'extra_bed_price'  => $this->extra_bed_price,
                  'status_id'        => $this->status_id,
                  'status'           => $this->status->name,
        ];
    }
}
