<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tables created in 2026_07_29_000001_create_portfolio_tables.php
        // This migration is intentionally a no-op to avoid duplicate table errors.
        if (!Schema::hasTable('achievements')) {
            Schema::create('achievements', function ($table) {
                $table->id();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};

