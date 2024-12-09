<?php

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\PreferredSource;

class PreferredSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = PreferredSource::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'source' => $this->faker->company
        ];
    }
}

