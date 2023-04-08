<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class KeywordFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['q'] ?? null, function ($builder, $keyword) {
            $builder->where('title', 'REGEXP', $keyword)
                ->orWhere('display_key', 'REGEXP', $keyword);
        });

        return $next($data);
    }
}
