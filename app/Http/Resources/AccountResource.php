<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'id'                   => $this->id,
            'name'                 => $this->name,
            'opening_bal'          => $this->opening_bal,
            'account_type'         => $this->account_type->name,
            'account_type_id'      => $this->account_type_id,
            'crdr'                 => $this->crdr->name,
            'crdr_id'              => $this->crdr_id,
            'groupcode'            => $this->groupcode->name,
            'groupcode_id'         => $this->groupcode_id,
            'status_id'            => $this->status_id,
            'status'               => $this->status->name,
        ];
    }
}
