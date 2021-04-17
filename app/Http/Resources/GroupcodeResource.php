<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupcodeResource extends JsonResource
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
                  'id'                   => $this->id,
                  'name'                 => $this->name,
                  'descp'                => $this->descp,
                  'is_visible'           => $this->is_visible,
                  'parent_groupcode'     => $this->parent_groupcode->name,
                  'parent_groupcode_id'  => $this->parent_groupcode_id,
                  'status_id'            => $this->status_id,
                  'status'               => $this->status->name,
        ];
    }
}
