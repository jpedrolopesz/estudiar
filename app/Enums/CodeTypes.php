<?php

namespace App\Enums;

enum CodeTypes: string
{
    case TASK_PRIORITY = 'TASK_PRIORITY';
    case TASK_TYPE = 'TASK_TYPE';
    case TASK_SECTION = 'TASK_SECTION';

    case TASK_TYPE_STORY = 'Story';
    case TASK_TYPE_TASK = 'Task';
    case TASK_TYPE_BUG = 'Bug';

    case TASK_SECTION_DONE = 'Done';
    case TASK_SECTION_BACKLOG = 'Backlog';
    case TASK_SECTION_SELECTED = 'Selected for development';
    case TASK_SECTION_PROGRESS = 'In Progress';
}
