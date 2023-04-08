<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends BaseModel
{
    use SoftDeletes;

    protected $casts = [
        'courses' => 'array',
    ];

    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public static function hasPendingInvite($email)
    {
        return self::where('recipient_email', $email)->exists();
    }
}
