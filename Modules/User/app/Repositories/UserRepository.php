<?php

namespace Modules\User\Repositories;


use Illuminate\Support\Facades\Cache;
use Modules\User\Dtos\UserDto;
use Modules\User\Models\User;

class UserRepository
{
    /**
     * @throws \Spatie\LaravelData\Exceptions\InvalidDataClass
     */
    public function create(UserDto $userDto): UserDto
    {
        return User::query()
            ->create($userDto->toArray())
            ->getData();
    }

    public function getPreferredArticleData(User $user): array
    {
        $preferredData = [
            'author'   => $user->preferredAuthors()->exists() ? $user->preferredAuthors()->pluck('author')->toArray() : [],
            'category' => $user->preferredCategories()->exists() ? $user->preferredCategories()->pluck('category')->toArray() : [],
            'source'   => $user->preferredSources()->exists() ? $user->preferredSources()->pluck('source')->toArray() : [],
        ];

        return array_filter($preferredData);
    }

    /**
     * @throws \JsonException
     */
    public function setNewsPreference(User $user, array $preferences): void
	{
        $this->clearCacheWhenChangePreferences($user->id, $this->getPreferredArticleData($user));

        \DB::transaction(static function () use ($user, $preferences){
            $user->preferredAuthors()->detach();
            $user->preferredAuthors()->sync($preferences['authors'] ?? []);

            $user->preferredSources()->detach();
            $user->preferredSources()->sync($preferences['sources'] ?? []);

            $user->preferredCategories()->detach();
            $user->preferredCategories()->sync($preferences['categories'] ?? []);
        });
	}

    /**
     * @throws \JsonException
     */
    private function clearCacheWhenChangePreferences(string $user_id, array $preferredData): void
    {
        $cacheKey = 'search-' . $user_id . '-' . md5(json_encode($preferredData, JSON_THROW_ON_ERROR));

        Cache::delete($cacheKey);
    }
}
