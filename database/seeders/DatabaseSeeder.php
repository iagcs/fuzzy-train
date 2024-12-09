<?php

namespace Database\Seeders;

use app\Models\User;
use Illuminate\Database\Seeder;
use Modules\Article\Database\Seeders\ArticleSeeder;
use Modules\User\Database\Seeders\UserSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ArticleSeeder::class,
            UserSeeder::class
        ]);
    }
}
