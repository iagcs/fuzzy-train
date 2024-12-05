<?php

namespace Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsPreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'authors'    => PreferredAuthorResource::collection($request->user()->preferredAuthors),
            'sources'    => PreferredSourceResource::collection($request->user()->preferredSources),
            'categories' => PreferredCategoryResource::collection($request->user()->preferredCategories),
        ];
    }
}
