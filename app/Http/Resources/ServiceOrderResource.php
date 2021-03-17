<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderResource extends JsonResource
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
          'descp'                   => $this->descp,
          'cus_acct'                => $this->cus_acct->name,
          'cus_acct_id'             => $this->cus_acct_id,
          'total_amount'            => $this->total_amount,
          'total_qty'               => $this->total_qty,
          'created_at'              => date('Y-m-d',strtotime($this->created_at)),
          'service_order_items'     => ServiceOrderItemResource::collection($this->service_order_items),
        ];
    }
}
