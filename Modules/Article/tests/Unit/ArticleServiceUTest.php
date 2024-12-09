<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Modules\Article\Repositories\ArticleRepository;
use Modules\Article\Services\ArticleService;
use Modules\User\Models\User;
use Modules\User\Repositories\UserRepository;
use Tests\TestCase;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

describe('test Article Srrvice class', function(){
    beforeEach(function () {
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->articleRepository = Mockery::mock(ArticleRepository::class);

        $this->service = new ArticleService(
            $this->userRepository,
            $this->articleRepository
        );
    });

    it('fetchUserPreferredArticles fetches articles based on user preferences and using cache', function () {
        $user = new User(['id' => 1]);

        $preferredData = [
            'author' => ['John Doe'],
            'category' => ['Tech'],
            'source' => ['TechCrunch'],
        ];

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(['article1', 'article2']);

        $this->userRepository
            ->shouldReceive('getPreferredArticleData')
            ->once()
            ->with($user)
            ->andReturn($preferredData);

        $result = $this->service->fetchUserPreferredArticles($user);

        expect($result)->toBe(['article1', 'article2']);
    });

    it('fetchUserPreferredArticles fetches articles based on user preferences', function () {
        $user = new User(['id' => 1]);

        $preferredData = [
            'author' => ['John Doe'],
            'category' => ['Tech'],
            'source' => ['TechCrunch'],
        ];

        $this->userRepository
            ->shouldReceive('getPreferredArticleData')
            ->once()
            ->with($user)
            ->andReturn($preferredData);

        $this->articleRepository
            ->shouldReceive('optimizedSearch')
            ->once()
            ->andReturn(['article1', 'article2']);

        $result = $this->service->fetchUserPreferredArticles($user);

        expect($result)->toBe(['article1', 'article2']);
    });

    it('fetchUserPreferredArticles aborts if user has no preferences', function () {
        $user = new User(['id' => 1]);

        $this->userRepository
            ->shouldReceive('getPreferredArticleData')
            ->once()
            ->with($user)
            ->andReturn([]);

        $this->expectException(Symfony\Component\HttpKernel\Exception\HttpException::class);

        $this->service->fetchUserPreferredArticles($user);
    });

    it('search performs a cached search with filters', function () {
        $filters = ['keyword' => 'Laravel', 'category' => 'Tech'];
        $userId = '123';

        $this->articleRepository
            ->shouldReceive('optimizedSearch')
            ->once()
            ->andReturn(['article1', 'article2']);

        $result = $this->service->search($userId, $filters);

        expect($result)->toBe(['article1', 'article2']);
    });

    it('search performs a cached search with filters and using cache', function () {
        $filters = ['keyword' => 'Laravel', 'category' => 'Tech'];
        $userId = '123';

        Cache::shouldReceive('remember')
            ->once()
            ->andReturn(['article1', 'article2']);

        $result = $this->service->search($userId, $filters);

        expect($result)->toBe(['article1', 'article2']);
    });

    it('buildPreferencesQuery constructs a proper query', function () {
        $preferredData = [
            'author' => ['John Doe'],
            'category' => ['Tech'],
            'source' => ['TechCrunch'],
        ];

        $reflection = new ReflectionClass(ArticleService::class);
        $method = $reflection->getMethod('buildPreferencesQuery');
        $method->setAccessible(true);

        $result = $method->invoke($this->service, $preferredData);

        expect($result)->toBe([
            'bool' => [
                'should' => [
                    ['match_phrase' => ['author' => 'John Doe']],
                    ['match_phrase' => ['category' => 'Tech']],
                    ['match_phrase' => ['source' => 'TechCrunch']],
                ],
                'minimum_should_match' => 1,
            ],
        ]);
    });
});
