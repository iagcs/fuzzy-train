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
    public function getPreferenceArticles(User $user): array
    {
        $preferredData = $this->userRepository->getPreferredArticleData($user);

        $cacheKey = 'search-' . $user->id . '-' . md5(json_encode($preferredData, JSON_THROW_ON_ERROR));

        return Cache::remember($cacheKey, 3600, function() use($preferredData) {
            $query = [
                'bool' => [
                    'should'               => [
                        [
                            'match' => [
                                'author' => [
                                    'query'     => $preferredData['authors'],
                                    'operator'  => 'or',
                                    'fuzziness' => 'AUTO',
                                ],
                            ],
                        ],
                        [
                            'match' => [
                                'category' => [
                                    'query'     => $preferredData['categories'],
                                    'operator'  => 'or',
                                    'fuzziness' => 'AUTO',
                                ],
                            ],
                        ],
                        [
                            'match' => [
                                'source' => [
                                    'query'     => $preferredData['sources'],
                                    'operator'  => 'or',
                                    'fuzziness' => 'AUTO',
                                ],
                            ],
                        ],
                    ],
                    'minimum_should_match' => 1,
                ],
            ];

            return $this->articleRepository->optimizedSearch($query);
        });
    }

    /**
     * @throws \JsonException
     */
    public function search(string $user_id, array $filters): array
    {
        $cacheKey = 'search-' . $user_id . '-' . md5(json_encode($filters, JSON_THROW_ON_ERROR));

        return Cache::remember($cacheKey, 3600, function() use($filters){
            $query = empty($filters) ? ['match_all' => []] : $this->buildQueryForFilters($filters);

            return $this->articleRepository->optimizedSearch($query);
        });
    }

    private function buildQueryForFilters(array $filters): array
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
                ],
            ];
        }

        if (!empty($filters[ValidSearchFields::SOURCE->value])) {
            $mustQuery['must'][] = [
                'match' => [
                    'source' => $filters['source'],
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
