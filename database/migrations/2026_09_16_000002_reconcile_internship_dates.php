<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Keep older PortoEdu databases compatible with the PKL form fields. */
    public function up(): void
    {
        if (!Schema::hasTable('internships')) {
            return;
        }

        if (!Schema::hasColumn('internships', 'started_at')) {
            Schema::table('internships', function (Blueprint $table) {
                $table->date('started_at')->nullable()->after('description');
            });

            if (Schema::hasColumn('internships', 'start_date')) {
                DB::table('internships')->whereNull('started_at')->update([
                    'started_at' => DB::raw('start_date'),
                ]);
            }
        }

        if (!Schema::hasColumn('internships', 'ended_at')) {
            Schema::table('internships', function (Blueprint $table) {
                $table->date('ended_at')->nullable()->after('started_at');
            });

            if (Schema::hasColumn('internships', 'end_date')) {
                DB::table('internships')->whereNull('ended_at')->update([
                    'ended_at' => DB::raw('end_date'),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Do not remove compatibility columns: they may contain user data.
    }
};
