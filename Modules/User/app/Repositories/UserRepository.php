<?php

namespace Modules\User\Repositories;


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
}
