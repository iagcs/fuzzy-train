<?php

namespace Modules\Article\Services;

use App\Services\ElasticService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Article\DTOs\ArticleDto;
use Modules\Article\Repositories\ArticleRepository;
use Modules\User\Enums\ValidSearchFields;
use Modules\User\Models\User;
use Modules\User\Repositories\UserRepository;

readonly class ArticleService
{
    public function __construct(
        private UserRepository $userRepository,
        private ArticleRepository $articleRepository
    ) {
    }

    /**
     * @throws \Exception
     */
    public function insertAndIndex(array $data): void
    {
        $this->articleRepository->insert($data);
        $this->articleRepository->index($data);
    }

    /**
     * @throws \JsonException
     */
    public function fetchUserPreferredArticles(User $user): array
    {
        $preferredData = $this->userRepository->getPreferredArticleData($user);

        abort_if(empty($preferredData), 400, 'User dont have preferences set.');

        $cacheKey = 'search-' . $user->id . '-' . md5(json_encode($preferredData, JSON_THROW_ON_ERROR));

        return Cache::remember($cacheKey, 3600, function() use($preferredData) {

            $query = $this->buildPreferencesQuery($preferredData);

            return $this->articleRepository->optimizedSearch($query);
        });
    }

    private function buildPreferencesQuery(array $preferredData): array
    {
        $should = [];

        foreach ($preferredData as $key => $data){
            foreach ($data as $datum){
                $should[] = [
                    'match_phrase' => [
                        $key => $datum
                    ]
                ];
            }
        }

        return [
            'bool' => [
                'should'               => $should,
                'minimum_should_match' => 1,
            ],
        ];
    }

    /**
     * @throws \JsonException
     */
    public function search(string $user_id, array $filters): array
    {
        $cacheKey = 'search-' . $user_id . '-' . md5(json_encode($filters, JSON_THROW_ON_ERROR));

        return Cache::remember($cacheKey, 3600, function() use($filters){
            $query = empty($filters) ? ['match_all' => []] : $this->buildFilterQuery($filters);

            return $this->articleRepository->optimizedSearch($query);
        });
    }

    private function buildFilterQuery(array $filters): array
    {
        $mustQuery = [
            'must' => [],
        ];

        if (!empty($filters[ValidSearchFields::KEYWORD->value])) {
            $mustQuery['must'][] = [
                'multi_search' => [
                    "query"  => $filters['keyword'],
                    "fields" => ["title", "content"],
                    "type"   => "phrase",
                ],
            ];
        }

        if (!empty($filters[ValidSearchFields::CATEGORY->value])) {
            $mustQuery['must'][] = [
                'match' => [
                    'category' => $filters['category'],
                    'fuzziness' => "AUTO"
                ],
            ];
        }

        if (!empty($filters[ValidSearchFields::SOURCE->value])) {
            $mustQuery['must'][] = [
                'match' => [
                    'source' => $filters['source'],
                    'fuzziness' => "AUTO"
                ],
            ];
        }

        if (!empty($filters[ValidSearchFields::FROM->value])) {
            $mustQuery['must'][] = [
                'term' => [
                    'published_at' => $filters['from'],
                ],
            ];
        }

        return ['bool' => $mustQuery];
    }
}
