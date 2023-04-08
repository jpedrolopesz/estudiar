<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class Course extends BaseModel
{
    use Searchable;

    public string $keyPrefix = 'prj';

    protected $casts = [
        'start_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function codes(): HasMany
    {
        return $this->hasMany(Code::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_members')
            ->withPivot('is_admin', 'is_favorite')
            ->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function hasUser(User $user)
    {
        return (bool)$this->members()->where('user_id', $user->id)->first();
    }

    public function isArchived()
    {
        return !is_null($this->archived_at);
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}
