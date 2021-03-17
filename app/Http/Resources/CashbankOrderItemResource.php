<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CashbankOrderItemResource extends JsonResource
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
            'acct_two_id'    => $this->acct_two_id,
            'acct_two'       => $this->acct_two->name,
            'amount'         => $this->amount,
            'descp'          => $this->descp,
            'del_record'     => $this->del_record,
        ];
    }
}
