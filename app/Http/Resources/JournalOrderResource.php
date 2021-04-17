<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalOrderResource extends JsonResource
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
          'total_cr_amount'         => $this->total_cr_amount,
          'total_dr_amount'         => $this->total_dr_amount,
          'journal_order_items'     => JournalOrderItemResource::collection($this->journal_order_items)
        ];
    }
}
