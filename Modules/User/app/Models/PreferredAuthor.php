<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\User\Database\Factories\PreferredAuthorFactory;
use Modules\User\Database\Factories\UserFactory;

// use Modules\User\Database\Factories\PreferredAuthorFactory;

class PreferredAuthor extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'author'
    ];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(User::class, 'news_preference');
    }

    protected static function newFactory(): PreferredAuthorFactory
    {
        return PreferredAuthorFactory::new();
    }
}
