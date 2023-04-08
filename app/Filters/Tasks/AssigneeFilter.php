<?php

namespace App\Filters\Tasks;

use App\Data\Task\TaskFilterData;
use Closure;

class AssigneeFilter
{
    public function handle(TaskFilterData $data, Closure $next)
    {
        $builder = $data->builder;
        $filters = $data->filters;

        $builder->when($filters['assignee'] ?? null, function ($builder, $assignee) {
            if ($assignee == 'unassigned') {
                $builder->whereNull('assignee_id');
            } else {
                $builder->where('assignee_id', $assignee);
            }
        });

        return $next($data);
    }
}
