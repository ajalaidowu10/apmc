<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashbankOrderResource extends JsonResource
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
          'id'                      => $this->id,
          'enter_date'              => $this->enter_date,
          'cashbank_type'           => $this->cashbank_type->name,
          'cashbank_type_id'        => $this->cashbank_type_id,
          'payment_type'            => $this->payment_type->name,
          'payment_type_id'         => $this->payment_type_id,
          'acct_one'                => $this->acct_one->name,
          'acct_one_id'             => $this->acct_one_id,
          'total_amount'            => $this->total_amount,
          'cashbank_order_items'    => CashbankOrderItemResource::collection($this->cashbank_order_items),
        ];
    }
}
