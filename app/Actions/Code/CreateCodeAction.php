<?php

namespace App\Actions\Code;

use App\Data\Code\StoreCodeData;
use App\Models\Course;

class CreateCodeAction
{
    public static function run(StoreCodeData $data, Course $course)
    {
        $course->codes()->create([
            'type' => $data->type,
            'display' => $data->name,
            'color' => $data->color,
            'description' => $data->description,
            'is_active' => $data->is_active,
            'available_in_subtask' => $data->available_in_subtask,
        ]);
    }
}
