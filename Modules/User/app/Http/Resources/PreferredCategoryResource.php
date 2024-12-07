<?php

namespace Modules\User\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \Modules\User\Models\PreferredAuthor $resource
 */
class PreferredCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->resource->id,
            'category' => $this->resource->category,
        ];
    }
}
