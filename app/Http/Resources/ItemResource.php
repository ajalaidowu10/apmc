<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'unit'           => $this->unit,
            'weight_pb'      => $this->weight_pb,
            'status_id'      => $this->status_id,
            'status'         => $this->status->name,

        ];
    }
}
