<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
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
          'motor_no'                => $this->motor_no,
          'invoice_no'                => $this->invoice_no,
          'acct'                    => $this->acct->name,
          'acct_id'                 => $this->acct_id,
          'comm'                    => $this->comm,
          'other_charges'           => $this->other_charges,
          'apmc'                    => $this->apmc,
          'total_amount'            => $this->total_amount,
          'total_qty'               => $this->total_qty,
          'created_at'              => date('Y-m-d',strtotime($this->created_at)),
          'purchase_order_items'    => PurchaseOrderItemResource::collection($this->purchase_order_items),
        ];
    }
}
