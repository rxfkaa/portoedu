<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Reconciles databases created before the migration history was tracked.
     * Every operation is conditional so existing portfolio data is preserved.
     */
    public function up(): void
    {
        if (!Schema::hasTable('organizations')) {
            Schema::create('organizations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->cascadeOnDelete();
                $table->string('organization_name')->nullable();
                $table->string('name')->nullable();
                $table->string('position');
                $table->date('start_date')->nullable();
                $table->date('started_at')->nullable();
                $table->date('end_date')->nullable();
                $table->date('ended_at')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('galleries')) {
            Schema::create('galleries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->cascadeOnDelete();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('image');
                $table->string('photo')->nullable();
                $table->string('caption')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('internships')) {
            Schema::create('internships', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->cascadeOnDelete();
                $table->string('company');
                $table->string('position');
                $table->string('address')->nullable();
                $table->string('logo')->nullable();
                $table->text('description')->nullable();
                $table->date('started_at');
                $table->date('ended_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('portfolio_settings')) {
            Schema::create('portfolio_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->unique()->constrained()->cascadeOnDelete();
                $table->string('theme')->default('indigo');
                $table->boolean('is_public')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('social_links')) {
            Schema::create('social_links', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->cascadeOnDelete();
                $table->string('platform');
                $table->string('url');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('comments')) {
            Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
                $table->text('comment');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('activity');
                $table->string('ip_address', 45)->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('message');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('category');
                $table->date('date');
                $table->string('result')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('badges')) {
            Schema::create('badges', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('icon')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('role');
            }
            if (!Schema::hasColumn('users', 'requested_role')) {
                $table->string('requested_role')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('requested_role');
            }
        });

        if (!Schema::hasColumn('certificates', 'description')) {
            Schema::table('certificates', fn (Blueprint $table) => $table->text('description')->nullable()->after('certificate_number'));
        }
    }

    public function down(): void
    {
        // Intentionally no-op: this migration repairs legacy installations and must not remove user data.
    }
};
