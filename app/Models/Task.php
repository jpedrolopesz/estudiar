<?php

namespace App\Models;

use App\Enums\CodeTypes;
use App\Models\Builders\TaskBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Task extends BaseModel implements HasMedia
{
    use TaskBuilder;
    use SoftDeletes;
    use Searchable;
    use InteractsWithMedia;
    use HasRecursiveRelationships;
    use LogsActivity;

    public string $keyPrefix = 'tsk';

    protected $casts = [
        'resolved_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function relatedFrom(): BelongsToMany
    {
        return $this->belongsToMany(Task::class,
            'task_relations',
            'related_to_id',
            'related_from_id'
        )->withPivot('relationship')
            ->withTimestamps();
    }

    public function relatedTo(): BelongsToMany
    {
        return $this->belongsToMany(Task::class,
            'task_relations',
            'related_from_id',
            'related_to_id'
        )
            ->withPivot('relationship')
            ->withTimestamps();
    }

    public function isRelatedTo($task): bool
    {
        return $this->relatedFrom->contains($task) || $this->relatedTo->contains($task);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'section_id')
            ->where('type', CodeTypes::TASK_SECTION);
    }

    public function priority(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'priority_id')
            ->where('type', CodeTypes::TASK_PRIORITY);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Code::class, 'type_id')
            ->where('type', CodeTypes::TASK_TYPE);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')->oldest();
    }

    public function getCanResolveAttribute()
    {
        return (bool)$this->descendants()->open()->doesntExist();
    }

    public function getDisplayAttribute()
    {
        return $this->display_key . ': ' . $this->title;
    }

    public function isResolved()
    {
        return !is_null($this->resolved_at);
    }

    public function isLate()
    {
        if (!$this->due_date) {
            return false;
        }

        return $this->due_date < Carbon::now();
    }

    public function getAssignedToAttribute()
    {
        if (!$this->assignee) {
            return (object)[
                'id' => 'unassigned',
                'avatar' => 'https://ui-avatars.com/api/?name=!&color=ffffff&background=f1f1f1',
                'name' => 'Unassigned',
            ];
        }

        return $this->assignee;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'assignee.name',
                'priority.display',
                'section.display',
                'type.display',
                'title',
                'due_date',
                'resolved_at',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

//    #[SearchUsingFullText(['description'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'display_key' => $this->display_key,
        ];
    }
}
