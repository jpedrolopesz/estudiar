<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class TypeFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['types'] ?? null, function ($builder, $types) {
            $builder->whereIn('type_id', $types);
        });

        return $next($data);
    }
}
