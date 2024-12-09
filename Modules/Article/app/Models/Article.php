<?php

namespace Modules\Article\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Article\Database\Factories\ArticleFactory;

// use Modules\Article\Database\Factories\ArticleFactory;

class Article extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'url',
        'source',
        'author',
        'category',
        'published_at'
    ];

     protected static function newFactory(): ArticleFactory
     {
          return ArticleFactory::new();
     }
}
