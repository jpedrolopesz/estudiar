<?php

namespace App\Models;

use App\Enums\Roles;
use App\Traits\HasAvatar;
use App\Traits\HasStringPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use HasFactory,
        Notifiable,
        SoftDeletes,
        HasStringPrimaryKey,
        HasAvatar;


    protected string $keyPrefix = 'usr';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    protected $fillable = [
        'first_name',
        'last_name',
        'job_title',
        'about',
        'is_active',
        'role',
        'should_be_logged_out',
        'email',
        'password',
        'avatar_disk',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'should_be_logged_out' => 'boolean',
        'email_verified_at' => 'datetime',
        'courses.pivot.is_favorite' => 'boolean',
        'courses.pivot.is_admin' => 'boolean',
        'role' => Roles::class,
    ];

    public function ownedCourses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_members')
            ->withPivot(['is_admin', 'is_favorite'])
            ->withTimestamps();
    }

    public function hasFavedCourse(Course $course)
    {
        if (!$course->hasUser($this)) {
            return false;
        }

        return (bool)$this->courses()->where('id', $course->id)
            ->first()?->pivot->is_favorite;
    }

    public function isCourseOwner(Course $course)
    {
        return $course->user_id == $this->id;
    }

    public function isCourseAdmin(Course $course)
    {
        if (!$course->hasUser($this)) {
            return false;
        }

        return $this->courses()->whereId($course->id)->first()?->pivot->is_admin;
    }

    public function isCourseAdminOrOwner(Course $course)
    {
        return $this->isCourseOwner($course) || $this->isCourseAdmin($course);
    }

    public function isGuestOnCourse($course)
    {
        return $this->courses->contains($course) &&
            $this->ownedCourses->doesntContain($course);
    }



    public function isAdminOrSuperAdmin()
    {
        return $this->role == Roles::SUPER_ADMIN || $this->role == Roles::ADMIN;
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusAttribute()
    {
        return $this->is_active ? 'Active' : 'Disabled';
    }

    #[SearchUsingPrefix(['first_name', 'last_name', 'email'])]
    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email
        ];
    }
}
