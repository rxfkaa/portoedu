<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Achievements
        if (!Schema::hasColumn('achievements', 'description')) {
            Schema::table('achievements', function (Blueprint $table) {
                $table->text('description')->nullable()->after('organizer');
            });
        }
        if (!Schema::hasColumn('achievements', 'image')) {
            Schema::table('achievements', function (Blueprint $table) {
                $table->string('image')->nullable()->after('proof');
            });
        }

        // Certificates
        if (!Schema::hasColumn('certificates', 'certificate_number')) {
            Schema::table('certificates', function (Blueprint $table) {
                $table->string('certificate_number')->nullable()->after('issuer');
            });
        }
        if (!Schema::hasColumn('certificates', 'description')) {
            Schema::table('certificates', function (Blueprint $table) {
                $table->text('description')->nullable()->after('certificate_number');
            });
        }
        if (!Schema::hasColumn('certificates', 'image')) {
            Schema::table('certificates', function (Blueprint $table) {
                $table->string('image')->nullable()->after('file');
            });
        }

        // Projects
        if (!Schema::hasColumn('projects', 'category')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('category')->nullable()->after('title');
            });
        }
        if (!Schema::hasColumn('projects', 'technology')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('technology')->nullable()->after('description');
            });
        }
        if (!Schema::hasColumn('projects', 'image')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('image')->nullable()->after('thumbnail');
            });
        }
        // Make slug nullable so controller can create without slug
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
        });

        // Organizations
        if (!Schema::hasColumn('organizations', 'organization_name')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->string('organization_name')->nullable()->after('name');
            });
        }
        if (!Schema::hasColumn('organizations', 'start_date')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->date('start_date')->nullable()->after('started_at');
            });
        }
        if (!Schema::hasColumn('organizations', 'end_date')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->date('end_date')->nullable()->after('start_date');
            });
        }
        if (!Schema::hasColumn('organizations', 'description')) {
            Schema::table('organizations', function (Blueprint $table) {
                $table->text('description')->nullable()->after('end_date');
            });
        }

        // Galleries
        if (!Schema::hasColumn('galleries', 'title')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->string('title')->nullable()->after('student_id');
            });
        }
        if (!Schema::hasColumn('galleries', 'description')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->text('description')->nullable()->after('title');
            });
        }
        if (!Schema::hasColumn('galleries', 'image')) {
            Schema::table('galleries', function (Blueprint $table) {
                $table->string('image')->nullable()->after('photo');
            });
        }

        // Internships
        if (!Schema::hasColumn('internships', 'description')) {
            Schema::table('internships', function (Blueprint $table) {
                $table->text('description')->nullable()->after('ended_at');
            });
        }
    }

    public function down(): void
    {
        // Optional rollback (drop added columns)
        $columns = ['description', 'image'];
        foreach ($columns as $col) {
            if (Schema::hasColumn('achievements', $col)) {
                Schema::table('achievements', fn (Blueprint $t) => $t->dropColumn($col));
            }
        }
        $columns = ['certificate_number', 'description', 'image'];
        foreach ($columns as $col) {
            if (Schema::hasColumn('certificates', $col)) {
                Schema::table('certificates', fn (Blueprint $t) => $t->dropColumn($col));
            }
        }
        $columns = ['category', 'technology', 'image'];
        foreach ($columns as $col) {
            if (Schema::hasColumn('projects', $col)) {
                Schema::table('projects', fn (Blueprint $t) => $t->dropColumn($col));
            }
        }
        $columns = ['organization_name', 'start_date', 'end_date', 'description'];
        foreach ($columns as $col) {
            if (Schema::hasColumn('organizations', $col)) {
                Schema::table('organizations', fn (Blueprint $t) => $t->dropColumn($col));
            }
        }
        $columns = ['title', 'description', 'image'];
        foreach ($columns as $col) {
            if (Schema::hasColumn('galleries', $col)) {
                Schema::table('galleries', fn (Blueprint $t) => $t->dropColumn($col));
            }
        }
        if (Schema::hasColumn('internships', 'description')) {
            Schema::table('internships', fn (Blueprint $t) => $t->dropColumn('description'));
        }
    }
};

