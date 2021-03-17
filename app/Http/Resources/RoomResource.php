<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'id'             => $this->id,
            'name'           => $this->name,
            'intercom'       => $this->intercom,
            'status_id'      => $this->status_id,
            'room_group'     => $this->room_group->name,
            'room_group_id'  => $this->room_group_id,
            'status'         => $this->status->name,
        ];
    }
}
