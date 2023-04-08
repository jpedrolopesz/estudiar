<?php

namespace App\Http\Resources;

use App\Actions\Code\GetCourseCodesAction;
use App\Support\AuthorizationChecker;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'code' => $this->code,
            'icon' => $this->icon,
            'start_date' => $this->start_date?->isoFormat('YYYY-MM-D'),
            'due_date' => $this->due_date?->isoFormat('YYYY-MM-D'),
            'is_archived' => $this->resource->isArchived(),
            'is_faved' => Auth::user()?->hasFavedCourse($this->resource),
            $this->mergeWhen($this->resource->relationLoaded('owner'), [
                'owner' => [
                    'id' => $this->owner->id,
                    'name' => $this->owner->name,
                    'avatar' => $this->owner->profile_photo_url,
                ],
            ]),
            'codes' => $this->when($this->resource->relationLoaded('codes'),
                GetCourseCodesAction::run($this->resource)
            ),
            'members' => $this->when($this->resource->relationLoaded('members'),
                $this->members->map(fn($member) => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'email' => $member->email,
                    'avatar' => $member->profile_photo_url,
                    'is_admin' => $member->isCourseAdmin($this->resource),
                    'is_owner' => $member->isCourseOwner($this->resource),
                ])
            ),
            'can' => AuthorizationChecker::getPermissions($this->resource),
            '_links' => [
                'overview' => route('courses.overview', [$this->id]),
                'list' => route('courses.list', [$this->id]),
                'board' => route('courses.board', [$this->id]),
                'settings' => route('courses.settings', [$this->id]),
            ],
        ];
    }
}
