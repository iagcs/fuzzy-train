<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent;');
    }

    public function down(): void
    {
        DB::statement('DROP EXTENSION IF EXISTS "uuid-ossp";');
        DB::statement('DROP EXTENSION IF EXISTS unaccent;');
    }
};
