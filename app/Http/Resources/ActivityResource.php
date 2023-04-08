<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'causer' => [
                'id' => $this->causer->id,
                'name' => $this->causer->name,
                'username' => $this->causer->username,
                'avatar' => $this->causer->avatar,
            ],
            'changes' => $this->resource->cleanedDescriptions(),
            'created_at' => $this->created_at->isoFormat('MMM D, YYYY, h:mm A'),
        ];
    }
}
