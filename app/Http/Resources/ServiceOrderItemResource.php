<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderItemResource extends JsonResource
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
            'service_id'     => $this->service_id,
            'service'        => $this->service->name,
            'qty'            => $this->qty,
            'service_price'  => $this->service_price,
            'amount'         => $this->amount,
            'del_record'     => $this->del_record,
        ];
    }
}
