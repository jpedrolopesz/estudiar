<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class ReporterFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['reporter'] ?? null, function ($builder, $reporter) {
            $builder->where('reporter_id', $reporter);
        });

        return $next($data);
    }
}
