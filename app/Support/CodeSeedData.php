<?php

namespace App\Support;

use App\Enums\CodeTypes;

class CodeSeedData
{
    const PRIORITY_SEED = [
        ['type' => CodeTypes::TASK_PRIORITY, 'display' => 'Highest', 'color' => 'red', 'available_in_subtask' => true],
        ['type' => CodeTypes::TASK_PRIORITY, 'display' => 'High', 'color' => 'pink', 'available_in_subtask' => true],
        ['type' => CodeTypes::TASK_PRIORITY, 'display' => 'Medium', 'color' => 'orange', 'available_in_subtask' => true],
        ['type' => CodeTypes::TASK_PRIORITY, 'display' => 'Low', 'color' => 'blue', 'available_in_subtask' => true],
        ['type' => CodeTypes::TASK_PRIORITY, 'display' => 'Lowest', 'color' => 'gray', 'available_in_subtask' => true],
    ];

    const SECTION_SEED = [
        ['type' => CodeTypes::TASK_SECTION, 'display' => CodeTypes::TASK_SECTION_BACKLOG, 'color' => 'gray', 'available_in_subtask' => false],
        ['type' => CodeTypes::TASK_SECTION, 'display' => CodeTypes::TASK_SECTION_SELECTED, 'color' => 'orange', 'available_in_subtask' => false],
        ['type' => CodeTypes::TASK_SECTION, 'display' => CodeTypes::TASK_SECTION_PROGRESS, 'color' => 'blue', 'available_in_subtask' => false],
        ['type' => CodeTypes::TASK_SECTION, 'display' => CodeTypes::TASK_SECTION_DONE, 'color' => 'green', 'available_in_subtask' => false],
    ];

    const TYPE_SEED = [
        ['type' => CodeTypes::TASK_TYPE, 'display' => CodeTypes::TASK_TYPE_STORY, 'color' => 'green', 'available_in_subtask' => false],
        ['type' => CodeTypes::TASK_TYPE, 'display' => CodeTypes::TASK_TYPE_TASK, 'color' => 'blue', 'available_in_subtask' => true],
        ['type' => CodeTypes::TASK_TYPE, 'display' => CodeTypes::TASK_TYPE_BUG, 'color' => 'red', 'available_in_subtask' => true],
    ];
}
