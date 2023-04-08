<?php

namespace App\Rules;

use App\Models\Course;
use Illuminate\Contracts\Validation\Rule;

class TaskDateWithinCourseTimeline implements Rule
{
    public string $feedback = '';

    public function __construct(public Course $course)
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }

        $course_start = $this->course->start_date;
        $course_end = $this->course->due_date;

        if ($course_start && $course_start > $value) {
            $this->feedback = "Due date is before course start date ({$course_start})";

            return false;
        }

        if ($course_end && $course_end < $value) {
            $this->feedback = "Due date is after course end date ({$course_end})";

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->feedback;
    }
}
