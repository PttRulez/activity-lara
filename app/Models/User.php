<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $with = ['stravaInfo'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'calories_per_100_steps' => 'float'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN->value;
    }

    //
    //    RELATIONS
    //

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function foods(): HasMany
    {
        return $this->hasMany(Food::class);
    }

    public function meals(): HasMany
    {
        return $this->hasMany(Meal::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Steps::class);
    }

    public function stravaInfo(): HasOne
    {
        return $this->hasOne(StravaInfo::class);
    }

    public function weights(): HasMany
    {
        return $this->hasMany(Weight::class);
    }
}
