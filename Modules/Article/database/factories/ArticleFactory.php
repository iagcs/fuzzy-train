<?php

namespace Modules\Article\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Article\Models\Article;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title'        => $this->faker->sentence(6, true),
            'content'      => $this->faker->paragraphs(3, true),
            'url'          => $this->faker->url,
            'source'       => $this->faker->company,
            'author'       => $this->faker->name,
            'category'     => $this->faker->randomElement(['Technology', 'Health', 'Food', 'Sports', 'Entertainment']),
            'published_at' => $this->faker->dateTimeBetween('-2 years', 'now')
        ];
    }
}

