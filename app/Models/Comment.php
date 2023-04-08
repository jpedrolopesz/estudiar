<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Comment extends BaseModel
{
    use SoftDeletes;
    use HasRecursiveRelationships;

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeAttribute(): string
    {
        return strtoupper(class_basename($this->commentable));
    }

    public function getShortDateAttribute(): string
    {
        $dte = $this->created_at;
        if ($dte->isToday()) {
            return $dte->format('h:ia');
        }
        if ($dte->isYesterday()) {
            return 'Yesterday';
        }

        return $dte->format('d-M-Y h:ia');
    }
}
