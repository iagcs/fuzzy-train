<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

// use Modules\User\Database\Factories\PreferredCategoryFactory;

class PreferredCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category'
    ];

    public function tags(): MorphToMany
    {
        return $this->morphToMany(User::class, 'news_preference');
    }
}
