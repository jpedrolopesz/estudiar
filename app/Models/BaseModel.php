<?php

namespace App\Models;

use App\Traits\HasStringPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory;
    use HasStringPrimaryKey;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];

    public function hasBeenUpdated(): bool
    {
        return $this->updated_at->gt($this->created_at);
    }

    public function formattedDates(): array
    {
        $base = [
            'created_at_short' => $this->created_at->isoFormat('MMM D, YYYY'),
            'created_at_long' => $this->created_at->isoFormat('MMM D, YYYY, h:mm A'),
            'created_at_human' => $this->created_at->diffForHumans(),
            'updated_at_short' => $this->updated_at->isoFormat('MMM D, YYYY'),
            'updated_at_long' => $this->updated_at->isoFormat('MMM D, YYYY, h:mm A'),
            'updated_at_human' => $this->updated_at->diffForHumans(),
            'has_been_updated' => $this->hasBeenUpdated(),
        ];

        if ($this->resolved_at) {
            return array_merge($base, [
                'resolved_at_short' => $this->resolved_at
                    ? $this->resolved_at->isoFormat('MMM D, YYYY')
                    : null,
                'resolved_at_long' => $this->resolved_at
                    ? $this->resolved_at->isoFormat('MMM D, YYYY, h:mm A')
                    : null,
                'resolved_at_human' => $this->resolved_at
                    ? $this->resolved_at->diffForHumans()
                    : null,
            ]);
        }

        return $base;
    }
}
