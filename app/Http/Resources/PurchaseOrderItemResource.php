<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderItemResource extends JsonResource
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
            'item_id'        => $this->item_id,
            'item'           => $this->item->name,
            'qty'            => $this->qty,
            'grwt'           => $this->grwt,
            'rate'           => $this->rate,
            'amount'         => $this->amount,
            'del_record'     => $this->del_record,
        ];
    }
}
