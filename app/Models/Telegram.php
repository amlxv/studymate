<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Telegram extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'first_name',
        'chat_id',
        'photo_url',
        'auth_date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
