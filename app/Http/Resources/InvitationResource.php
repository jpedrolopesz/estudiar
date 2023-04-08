<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationResource extends JsonResource
{
    /**
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'recipient' => $this->resource->recipient_email,
            'sender' => $this->resource->sender->name,
            'days_old' => $this->resource->created_at->diffForHumans(),
        ];
    }
}
