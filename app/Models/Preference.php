<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telegram_id',
        'time_before',
        'custom_message'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function telegram(): BelongsTo
    {
        return $this->belongsTo(Telegram::class);
    }
}
