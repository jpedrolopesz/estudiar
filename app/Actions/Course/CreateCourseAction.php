<?php

namespace App\Actions\Course;

use App\Data\Course\CreateCourseData;
use Illuminate\Support\Facades\Auth;

class CreateCourseAction
{
    public static function run(CreateCourseData $data)
    {
        $course = Auth::user()
            ->ownedCourses()
            ->create([
                'name' => $data->name,
                'description' => $data->description,
                'code' => $data->code,
                'color' => $data->color,
                'icon' => 'briefcase',
            ]);

        $course->members()->sync($data->members);

        return $course;
    }
}
