<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', static function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('url')->nullable();
            $table->text('source')->nullable();
            $table->text('author')->nullable();
            $table->text('category')->nullable();
            $table->text('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
