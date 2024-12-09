<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\PreferredCategory;

class PreferredCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = PreferredCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category'     => $this->faker->randomElement(['Technology', 'Health', 'Food', 'Sports', 'Entertainment']),
        ];
    }
}

