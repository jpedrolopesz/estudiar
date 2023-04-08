<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class PriorityFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['priorities'] ?? null, function ($builder, $priorities) {
            $builder->whereIn('priority_id', $priorities);
        });

        return $next($data);
    }
}
