<?php

namespace Modules\User\Repositories;


use Illuminate\Support\Facades\Cache;
use Modules\User\Models\User;

class UserRepository
{
	public function getPreferredArticleData(User $user): array
	{
		return [
			'authors'    => $user->preferredAuthors()->pluck('author')->implode(' '),
			'categories' => $user->preferredCategories()->pluck('category')->implode(' '),
			'sources'    => $user->preferredSources()->pluck('source')->implode(' '),
		];
	}

    /**
     * @throws \JsonException
     */
    public function setNewsPreference(User $user, array $preferences): void
	{
        $this->clearCacheWhenChangePreferences($user->id, $this->getPreferredArticleData($user));

		$user->preferredAuthors()->sync($preferences['authors']);
		$user->preferredSources()->sync($preferences['sources']);
		$user->preferredCategories()->sync($preferences['categories']);
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
