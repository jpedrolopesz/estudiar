<?php

namespace App\Http\Resources;

use App\Actions\Code\GetCourseCodesAction;
use App\Support\AuthorizationChecker;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->display_key,
            'title' => $this->title,
            'display' => $this->display,
            'description' => $this->description,
            'resolved' => $this->resource->isResolved(),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'children' => TaskResource::collection($this->whenLoaded('children')),
            'children_count' => $this->whenLoaded('children', function () {
                return $this->resource->descendants()->count();
            }),
            $this->mergeWhen($this->parent_id && $this->resource->relationLoaded('parent'), [
                'parent' => [
                    'id' => $this->parent?->id,
                    'key' => $this->resource->parent?->display_key,
                    'title' => $this->resource->parent?->title,
                    'course' => $this->resource->parent?->course_id,
                ],
            ]),
            'due_date' => [
                'yyyymmd' => $this->due_date?->isoFormat('YYYY-MM-D'),
                'mmddyyyy' => $this->due_date?->isoFormat('MMM DD, YYYY'),
            ],
            'is_late' => $this->isLate(),
            'dates' => $this->resource->formattedDates(),
            'attachments' => MediaResource::collection($this->media),
            'type' => new CodeResource($this->whenLoaded('type')),
            'section' => new CodeResource($this->whenLoaded('section')),
            'priority' => new CodeResource($this->whenLoaded('priority')),
            'total_comments' => $this->comments->count(),
            'assignee' => $this->when(($this->resource->relationLoaded('assignee')), [
                'id' => $this->assigned_to?->id,
                'name' => $this->assigned_to?->name,
                'avatar' => $this->assigned_to?->avatar,
            ]),
            'course' => [
                'id' => $this->course->id,
                'title' => $this->course->name,
                'color' => $this->course->color,
                'is_archived' => $this->course->isArchived(),
                'is_faved' => Auth::user()?->hasFavedCourse($this->course),
                'members' => $this->course->members->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'avatar' => $member->avatar,
                    ];
                }),
                'codes' => GetCourseCodesAction::run($this->course),
                'can' => AuthorizationChecker::getPermissions($this->course),
            ],
            'reporter' => $this->when(($this->resource->relationLoaded('reporter') && $this->reporter), [
                'id' => $this->reporter->id,
                'name' => $this->reporter->name,
                'avatar' => $this->reporter->avatar,
            ]),
            '_links' => [
                'self' => route('tasks.show', [$this->course_id, $this->display_key]),
            ],
        ];
    }
}
