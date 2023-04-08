<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class UserTasksFilter
{
    public function handle(TaskFilterData $data, Closure $next, string $field = 'both')
    {
        if ($field == 'both') {
            $data->builder->where(function ($query) use ($data) {
                $query->where('reporter_id', $data->user_id)
                    ->orWhere('assignee_id', $data->user_id);
            });
        } else {
            $data->builder->where("{$field}_id", $data->user_id);
        }

        return $next($data);
    }
}
