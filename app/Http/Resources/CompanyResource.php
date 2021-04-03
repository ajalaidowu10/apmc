<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
            'id'               => $this->id,
            'name'             => $this->name,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'address'          => $this->address,
            'status_id'        => $this->status_id,
            'status'           => $this->status->name,
            'invheader_path'   => $this->invheader_path,
            'invfooter_path'   => $this->invfooter_path,
            'recheader_path'   => $this->recheader_path,
            'recfooter_path'   => $this->recfooter_path,
            'finyear'          => FinyearResource::collection($this->finyears),

        ];
    }
}
