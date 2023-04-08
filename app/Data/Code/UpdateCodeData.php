<?php

namespace App\Data\Code;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateCodeData extends Data
{
    public string $name;

    public string $color;

    public string $type;

    public bool $is_active;

    public bool $available_in_subtask;

    public ?string $description;

    public static function rules(): array
    {
        $course = request()->course?->id;
        $type = request()->type;
        $id = request()->code?->id;

        return [
            'name' => [
                'required', 'string', 'max:200',
                Rule::unique('codes', 'display')
                    ->where(fn ($q) => $q->where('course_id', $course)->where('type', $type))->ignore($id),
            ],
            'color' => ['required', 'string'],
            'type' => ['required', 'string'],
            'is_active' => ['required', 'boolean'],
            'available_in_subtask' => ['required', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }
}
