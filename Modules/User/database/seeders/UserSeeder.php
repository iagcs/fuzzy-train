<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\PreferredAuthor;
use Modules\User\Models\PreferredCategory;
use Modules\User\Models\PreferredSource;
use Modules\User\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->hasAttached(
                PreferredAuthor::factory()->count(3),
            )
            ->hasAttached(
                PreferredSource::factory()->count(2),
            )
            ->hasAttached(
                PreferredCategory::factory()->count(1),
            )
            ->create();
    }
}
