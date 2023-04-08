<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge($this->only('id', 'display', 'color', 'available_in_subtask', 'is_active', 'type'), [
            'type_text' => ucwords(strtolower(str($this->type)->replace('_', ' '))),
        ]);
    }
}
