<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone_number',
        'avatar',
        'intro'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isStudent(): bool
    {
        return $this->role == 'student';
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function telegram(): HasOne
    {
        return $this->hasOne(Telegram::class);
    }

    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
    }

    public function socialProviders(): HasMany
    {
        return $this->hasMany(SocialProvider::class);
    }

    public function scopeSearch(Builder $query, Request $request): Builder
    {
        if ($request->has('search')) {
            $searchQuery = $request->get('search');
            return $query->where('name', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('email', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('student_id', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('program', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('faculty', "LIKE", "%" . $searchQuery . "%")
                ->orWhere('campus', "LIKE", "%" . $searchQuery . "%");
        }

        return $query;
    }
}
