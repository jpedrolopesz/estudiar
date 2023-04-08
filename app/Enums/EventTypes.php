<?php

namespace App\Enums;

enum EventTypes: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case UPLOADED = 'uploaded';
    case DELETED = 'deleted';
}
