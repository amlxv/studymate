<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'day',
        'date',
        'time_start',
        'time_end',
        'type',
        'remind',
        'course_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preference(): BelongsTo
    {
        return $this->belongsTo(Preference::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', '=', $type);
    }

    public function scopeThatBelongsTo(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeOfDay(Builder $query, Request $request): Builder
    {
        if ($request->has('day')) {
            return $query->where('day', "=", $request->get('day'));
        }

        return $query;
    }

    public function scopeOfMonth(Builder $query, Request $request): Builder
    {
        if ($request->has('month')) {
            $query->whereMonth("date", "=", $request->get('month'));
        }

        return $query;
    }

    public function scopeSearch(Builder $query, Request $request): Builder
    {
        if ($request->has('search')) {
            $searchQuery = $request->get('search');
            return $query->where('title', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('description', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('day', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('date', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('time_start', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('time_end', "LIKE", "%" . $searchQuery . "%");
        }

        return $query;
    }

    public function scopeToday(Builder $query, int $userId): Builder
    {
        return $query
            ->where(function ($query) {
                $query->where("day", "=", now()->format("l"))
                    ->orWhere("date", "=", now()->format("Y-m-d"));
            })
            ->where("user_id", "=", $userId);
    }
}
