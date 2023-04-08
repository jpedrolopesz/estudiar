<?php

namespace App\Support;

class RelatedTask
{
    const RELATIONS = [
        'blockedBy' => 'is blocked by',
        'blocks' => 'blocks',
        'duplicatedBy' => 'is duplicated by',
        'duplicates' => 'duplicates',
        'relatesTo' => 'relates to',
    ];

    const INVERSE_RELATIONS = [
        'blockedBy' => 'blocks',
        'blocks' => 'is blocked by',
        'duplicatedBy' => 'duplicates',
        'duplicates' => 'is duplicated by',
        'relatesTo' => 'relates to',
    ];

    public static function getRelations()
    {
        $arr = [];

        foreach (self::RELATIONS as $key => $value) {
            $arr[] = [
                'id' => $key,
                'label' => $value,
            ];
        }

        return $arr;
    }
}
