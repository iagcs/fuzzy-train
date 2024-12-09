<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\PreferredAuthor;
use Modules\User\Models\User;
use Tests\TestCase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

describe('test user api', function () {
    test('store user validation', function ($data, $error) {
        post('/user', $data)
            ->assertStatus(302)
            ->assertInvalid($error);
    })->with([
        'name:required' => [
            'data' => [],
            'error' => ['name' => 'required'],
        ],
        'name:string' => [
            'data' => ['name' => 1],
            'error' => ['name' => 'string'],
        ],
        'email:required' => [
            'data' => [],
            'error' => ['email' => 'required'],
        ],
        'email:email'           => [
            ['email' => 'teste'],
            ['email' => 'email'],
        ],
        'password:required' => [
            'data' => [],
            'error' => ['password' => 'required'],
        ],
        'password:string' => [
            'data' => ['password' => 1],
            'error' => ['password' => 'string'],
        ],
    ]);

    test('store user success', function () {
        $user = User::factory()->make();

        post('/user', $user->toArray())
            ->assertOk();
    });

    test('store user preferences validation', function($data, $error){
        actingAs(User::factory()->create())->post('/preference', $data)
            ->assertStatus(302)
            ->assertInvalid($error);
    })->with([
        'authors:array' => [
            'data' => ['authors' => 'asd'],
            'error' => ['authors' => 'array'],
        ],
        'authors.*:exists' => [
            'data' => ['authors' => [fake()->uuid]],
            'error' => ['authors.0' => 'The selected authors.0 is invalid.'],
        ],
        'sources:array' => [
            'data' => ['sources' => 'asd'],
            'error' => ['sources' => 'array'],
        ],
        'sources.*:exists' => [
            'data' => ['sources' => [fake()->uuid]],
            'error' => ['sources.0' => 'The selected sources.0 is invalid.'],
        ],
        'categories:array' => [
            'data' => ['categories' => 'asd'],
            'error' => ['categories' => 'array'],
        ],
        'categories.*:exists' => [
            'data' => ['categories' => [fake()->uuid]],
            'error' => ['categories.0' => 'The selected categories.0 is invalid.'],
        ],
    ]);

    test('store user preference validation', function () {
        $user = User::factory()->make();

        $preferences = [
            'authors' => PreferredAuthor::factory(2)->create()->pluck('id')->toArray()
        ];

        actingAs(User::factory()->create())->post('/preference', $preferences)
            ->assertOk();
    });
});
