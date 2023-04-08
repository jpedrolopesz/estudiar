<?php

namespace App\Rules;

use App\Models\Course;
use Illuminate\Contracts\Validation\Rule;

class CourseDateMatchesTaskDates implements Rule
{
    public string $feedback = '';

    public function __construct(public Course $course)
    {
        //
    }

    public function passes($attribute, $value)
    {
        if (!$value) {
            return true;
        }

        if ($attribute == 'start_date') {
            $min_date = $this->course->tasks()->min('due_date');
            if ($min_date && $value > $min_date) {
                $this->feedback = 'There are tickets earlier than this start date';

                return false;
            }
        }

        if ($attribute == 'due_date') {
            $max_date = $this->course->tasks()->max('due_date');
            if ($max_date && $value < $max_date) {
                $this->feedback = 'There are tickets later than this due date';

                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return $this->feedback;
    }
}
