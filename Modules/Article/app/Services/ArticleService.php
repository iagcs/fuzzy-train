<?php

namespace Modules\Article\Services;

use App\Services\ElasticService;
use Illuminate\Support\Collection;
use Modules\Article\Repositories\ArticleRepository;
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
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function getPreferenceArticles(User $user): array
    {
        $preferredData = $this->userRepository->getPreferredArticleData($user);

        $body = [
            'query' => [
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
            ],
        ];

        return $this->articleRepository->optimizedSearch(compact('body'));
    }
}
