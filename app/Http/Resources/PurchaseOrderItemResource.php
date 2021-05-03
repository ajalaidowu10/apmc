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
            'id'                => $this->id,
            'item_id'           => $this->item_id,
            'item'              => $this->item->name,
            'qty'               => $this->qty,
            'grwt'              => $this->grwt,
            'rate'              => $this->rate,
            'amount'            => $this->amount,
            'map_levy'          => $this->map_levy,
            'levy'              => $this->levy,
            'apmc'              => $this->apmc,
            'comm'              => $this->comm,
            'tds'               => $this->tds,
            'is_charged'        => $this->is_charged,
            'final_amount'      => $this->final_amount,
            'item_exp_object'   => json_decode($this->item_exp_object),
            'del_record'        => $this->del_record,
        ];
    }
}
