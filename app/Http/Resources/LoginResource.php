<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Sanctum\NewAccessToken;

/**
 * @property-read \App\Models\User $resource
 */
class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->resource->createToken(
            'fuzzy-token',
            ['*'],
            $expires_at = now()->addMinutes(config('sanctum.expiration'))
        );

        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'access_token' => $token->plainTextToken,
            'expires_at' => $expires_at
        ];
    }
}
