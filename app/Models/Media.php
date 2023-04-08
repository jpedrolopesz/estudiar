<?php

namespace App\Models;

use App\Traits\HasStringPrimaryKey;

class Media extends \Spatie\MediaLibrary\MediaCollections\Models\Media
{
    use HasStringPrimaryKey;

    public string $keyPrefix = 'med';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $guarded = [];
}
