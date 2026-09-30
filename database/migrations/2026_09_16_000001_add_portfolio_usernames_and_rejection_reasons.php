<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique()->after('name');
            });

            foreach (DB::table('users')->orderBy('id')->get(['id', 'name']) as $user) {
                $base = Str::slug($user->name) ?: 'user';
                $username = $base;
                $suffix = 2;
                while (DB::table('users')->where('username', $username)->exists()) {
                    $username = $base . '-' . $suffix++;
                }
                DB::table('users')->where('id', $user->id)->update(['username' => $username]);
            }
        }

        foreach (['achievements', 'certificates'] as $tableName) {
            if (!Schema::hasColumn($tableName, 'rejection_reason')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->text('rejection_reason')->nullable()->after('status');
                });
            }
        }
    }

    public function down(): void
    {
        // Retained to avoid destroying portfolio URLs and verification history.
    }
};
