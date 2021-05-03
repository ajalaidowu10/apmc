<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
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
          'invoice_no'              => $this->invoice_no,
          'acct'                    => $this->acct->name,
          'acct_id'                 => $this->acct_id,
          'other_charges'           => $this->other_charges,
          'levy'                    => $this->levy,
          'apmc'                    => $this->apmc,
          'map_levy'                => $this->map_levy,
          'comm'                    => $this->comm,
          'tds'                     => $this->tds,
          'total_amount'            => $this->total_amount,
          'total_qty'               => $this->total_qty,
          'created_at'              => date('Y-m-d',strtotime($this->created_at)),
          'sales_order_items'       => SalesOrderItemResource::collection($this->sales_order_items),
        ];
    }
}
