<?php

namespace App\Models;

use App\Enums\EventTypes;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Activity
{
    public function cleanedDescriptions()
    {
        $new = $this->getExtraProperty('attributes');
        $old = $this->getExtraProperty('old');
        $descriptions = [];

        if ($this->event === EventTypes::CREATED->value) {
            $reflect = new \ReflectionClass($this->subject);
            $target = strtolower($reflect->getShortName());
            $descriptions[] = "{$target} {$this->event}";
        } elseif (in_array($this->event, [EventTypes::UPLOADED->value, EventTypes::DELETED->value])) {
            $descriptions[] = "{$this->event} {$this->getExtraProperty('file')}";
        } elseif ($this->event === EventTypes::UPDATED->value) {
            foreach ($old as $key => $value) {
                if ($key == 'resolved_at') {
                    $newValue = Arr::get($new, $key);
                    $term = $newValue ? 'Resolved' : 'Unresolved';
                    $descriptions[] = "marked as {$term}";
                } else {
                    $candidate = Str::before($key, '.');
                    if (!$newValue = Arr::get($new, $key)) {
                        continue;
                    }
                    if ($key == 'due_date') {
                        $newValue = Carbon::parse($newValue)->isoFormat('D MMM, YYYY');
                        $candidate = 'due date';
                    }
                    $descriptions[] = "{$this->event} {$candidate} to {$newValue}";
                }

            }
        }

        return $descriptions;
    }
}
