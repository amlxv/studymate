<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'student_id',
        'user_id',
        'gender',
        'address',
        'faculty',
        'program',
        'campus',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function telegram(): HasOne
    {
        return $this->hasOne(Telegram::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

}
