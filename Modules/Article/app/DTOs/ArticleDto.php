<?php

namespace Modules\Article\DTOs;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class ArticleDto extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public string $content,
        public string $url,
        public string $source,
        public string $author,
        public string $category,
        public string $published_at,
        public Carbon $created_at,
        public Carbon $updated_at,
    )
    {
    }

    public static function rules(): array
    {
        return [
            'id'           => ['required', 'string', 'uuid'],
            'title'        => ['required', 'string'],
            'content'      => ['required', 'string'],
            'url'          => ['required', 'string'],
            'source'       => ['required', 'string'],
            'author'       => ['required', 'string'],
            'category'     => ['required', 'string'],
            'published_at' => ['required', 'date', 'before_or_equal:now'],
            'created_at'   => ['required', 'date', 'before_or_equal:now'],
            'updated_at'   => ['required', 'date', 'before_or_equal:now'],
        ];
    }
}
