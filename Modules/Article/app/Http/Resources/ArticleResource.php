<?php

namespace Modules\Article\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->resource['id'],
            'title'    => $this->resource['title'],
            'content'  => $this->resource['content'],
            'url'      => $this->resource['url'],
            'source'   => $this->resource['source'],
            'author'   => $this->resource['author'],
            'category' => $this->resource['category'],
        ];
    }
}
