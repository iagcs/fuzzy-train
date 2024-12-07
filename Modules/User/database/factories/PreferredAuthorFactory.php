<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\PreferredAuthor;

class PreferredAuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = PreferredAuthor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'author' => $this->faker->name
        ];
    }
}

