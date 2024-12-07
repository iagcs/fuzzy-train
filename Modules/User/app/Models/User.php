<?php

namespace Modules\User\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Dtos\UserDto;
use Spatie\LaravelData\WithData;

class User extends Authenticatable
{
    /** @use HasFactory<\Modules\User\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, CanResetPassword, HasUuids, WithData;

    protected $dataClass = UserDto::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function preferredAuthors(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(PreferredAuthor::class, 'news_preference');
    }

    public function preferredSources(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(PreferredSource::class, 'news_preference');
    }

    public function preferredCategories(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(PreferredCategory::class, 'news_preference');
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    protected static function newFactory(): UserFactory
     {
          return UserFactory::new();
     }
}
