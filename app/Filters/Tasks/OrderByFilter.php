<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class OrderByFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['sortBy'] ?? null, function ($builder, $field) use ($filters) {
            $dir = $filters['dir'];
            if (in_array($field, ['created_at', 'due_date', 'updated_at', 'title', 'key'])) {
                if ($field == 'key') {
                    $field = 'display_key';
                }
                $builder->orderBy($field, $filters['dir']);
            }
            if (in_array($field, ['priority', 'type'])) {
                $builder->orderByCode("{$field}_id", $dir);
            }
            if (in_array($field, ['assignee', 'reporter'])) {
                $builder->orderByUser($field, $dir);
            }
        });

        return $next($data);
    }
}
