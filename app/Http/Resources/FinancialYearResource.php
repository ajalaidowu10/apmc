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
            'from_date'      => $this->from_date,
            'to_date'        => $this->to_date,
            'company'        => $this->company->name,
            'company_id'     => $this->company_id,
            'status_id'      => $this->status_id,
            'status'         => $this->status->name,

        ];
    }
}
