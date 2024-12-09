<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\User\Database\Factories\PreferredSourceFactory;

class PreferredSource extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'source'
    ];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(User::class, 'news_preference');
    }

    protected static function newFactory(): PreferredSourceFactory
    {
        return PreferredSourceFactory::new();
    }
}
