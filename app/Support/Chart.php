<?php

namespace App\Support;

use Carbon\Carbon;

class Chart
{
    const colorMap = [
        'blue' => '#2196f3',
        'cyan' => '#00bcd4',
        'gray' => '#b5b5b5',
        'green' => '#4caf50',
        'indigo' => '#6366f1',
        'orange' => '#ff9800',
        'pink' => '#e91e63',
        'purple' => '#9c27b0',
        'red' => '#f44336',
        'rose' => '#fda4af',
        'sky' => '#7dd3fc',
        'teal' => '#009688',
        'yellow' => '#ffeb3b',

    ];

    public static function resolvePeriod(string $period)
    {
        $now = (new Carbon)->toDateString();

        return match ($period) {
            '7d' => [static::getDateString(7), $now],
            '30d' => [static::getDateString(30), $now],
            '90d' => [static::getDateString(90), $now],
            default => null
        };
    }

    public static function getDateString($days)
    {
        return (new Carbon)->subDays($days)->toDateString();
    }
}
