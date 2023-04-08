<?php

namespace App\Http\Resources;

use App\Support\AuthorizationChecker;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'body' => html_entity_decode($this->body),
            'dates' => $this->formattedDates(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'username' => $this->user->username,
                'avatar' => $this->user->avatar,
            ],
            'commentable' => $this->commentable_id,
            'is_edited' => $this->created_at < $this->updated_at,
            'total_replies' => count($this->children),
            'replies' => static::collection($this->whenLoaded('children')),
            'can' => AuthorizationChecker::getPermissions($this->resource),
        ];
    }
}
