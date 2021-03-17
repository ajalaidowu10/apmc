<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalOrderItemResource extends JsonResource
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
            'acct_one_id'    => $this->acct_one_id,
            'acct_one'       => $this->acct_one->name,
            'crdr_id'        => $this->crdr_id,
            'crdr'           => $this->crdr->name,
            'amount'         => $this->amount,
            'descp'          => $this->descp,
            'del_record'     => $this->del_record,
        ];
    }
}
