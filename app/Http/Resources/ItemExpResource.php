<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemExpResource extends JsonResource
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
            'enter_date'     => $this->enter_date,
            'comm'           => $this->comm,
            'p_hamali'       => $this->p_hamali,
            'b_hamali'       => $this->b_hamali,
            'p_levy'         => $this->p_levy,
            'b_levy'         => $this->b_levy,
            'apmc'           => $this->apmc,
            'map_levy'       => $this->map_levy,
            'discount'       => $this->discount,
            'tolai'          => $this->tolai,
            'tds'            => $this->tds,
            'item'           => $this->item->name,
            'item_id'        => $this->item_id,
            'unit'           => $this->item->unit,
            'weight_pb'      => $this->item->weight_pb,
            'status_id'      => $this->status_id,
            'status'         => $this->status->name,

        ];
    }
}
