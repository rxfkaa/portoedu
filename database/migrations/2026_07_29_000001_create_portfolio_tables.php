<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) $table->string('role')->default('student')->after('password');
        });

        Schema::create('departments', function (Blueprint $table) { $table->id(); $table->string('name'); $table->string('code')->unique(); $table->timestamps(); });
        Schema::create('classes', function (Blueprint $table) { $table->id(); $table->foreignId('department_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->string('level'); $table->timestamps(); });
        Schema::create('students', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete(); $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->string('nis')->unique(); $table->string('nisn')->nullable()->unique(); $table->string('name'); $table->string('birth_place')->nullable(); $table->date('birth_date')->nullable();
            $table->enum('gender', ['L','P'])->nullable(); $table->text('address')->nullable(); $table->string('phone')->nullable(); $table->string('photo')->nullable(); $table->text('bio')->nullable();
            $table->string('github')->nullable(); $table->string('linkedin')->nullable(); $table->string('website')->nullable(); $table->timestamps();
        });
        Schema::create('teachers', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete(); $table->string('nip')->nullable()->unique(); $table->string('name'); $table->string('subject')->nullable(); $table->string('phone')->nullable(); $table->string('photo')->nullable(); $table->timestamps(); });
        Schema::create('achievements', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('title'); $table->string('category'); $table->string('level'); $table->string('organizer'); $table->date('date'); $table->string('proof')->nullable(); $table->string('status')->default('pending'); $table->foreignId('verified_by')->nullable()->constrained('teachers')->nullOnDelete(); $table->timestamp('verified_at')->nullable(); $table->timestamps(); });
        Schema::create('certificates', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('title'); $table->string('category'); $table->string('issuer'); $table->date('issued_at'); $table->string('file')->nullable(); $table->string('status')->default('pending'); $table->foreignId('verified_by')->nullable()->constrained('teachers')->nullOnDelete(); $table->timestamp('verified_at')->nullable(); $table->timestamps(); });
        Schema::create('projects', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('title'); $table->string('slug')->unique(); $table->text('description'); $table->string('thumbnail')->nullable(); $table->string('github')->nullable(); $table->string('demo')->nullable(); $table->string('status')->default('draft'); $table->timestamps(); });
        Schema::create('skills', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->string('level'); $table->timestamps(); });
        Schema::create('project_skill', function (Blueprint $table) { $table->id(); $table->foreignId('project_id')->constrained()->cascadeOnDelete(); $table->foreignId('skill_id')->constrained()->cascadeOnDelete(); $table->unique(['project_id','skill_id']); });
        Schema::create('organizations', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->string('position'); $table->date('started_at'); $table->date('ended_at')->nullable(); $table->timestamps(); });
        Schema::create('galleries', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('photo'); $table->string('caption')->nullable(); $table->timestamps(); });
        Schema::create('internships', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('company'); $table->string('position'); $table->string('address')->nullable(); $table->date('started_at'); $table->date('ended_at')->nullable(); $table->timestamps(); });
        Schema::create('events', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->string('category'); $table->date('date'); $table->string('result')->nullable(); $table->timestamps(); });
        Schema::create('badges', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('name'); $table->string('icon')->nullable(); $table->timestamps(); });
        Schema::create('portfolio_settings', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->unique()->constrained()->cascadeOnDelete(); $table->string('theme')->default('indigo'); $table->boolean('is_public')->default(true); $table->timestamps(); });
        Schema::create('social_links', function (Blueprint $table) { $table->id(); $table->foreignId('student_id')->constrained()->cascadeOnDelete(); $table->string('platform'); $table->string('url'); $table->timestamps(); });
        Schema::create('comments', function (Blueprint $table) { $table->id(); $table->foreignId('teacher_id')->constrained()->cascadeOnDelete(); $table->foreignId('project_id')->constrained()->cascadeOnDelete(); $table->text('comment'); $table->timestamps(); });
        Schema::create('activity_logs', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('activity'); $table->string('ip_address', 45)->nullable(); $table->timestamps(); });
        Schema::create('notifications', function (Blueprint $table) { $table->id(); $table->foreignId('user_id')->constrained()->cascadeOnDelete(); $table->string('title'); $table->text('message'); $table->boolean('is_read')->default(false); $table->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('notifications'); Schema::dropIfExists('activity_logs'); Schema::dropIfExists('comments'); Schema::dropIfExists('social_links'); Schema::dropIfExists('portfolio_settings'); Schema::dropIfExists('badges'); Schema::dropIfExists('events'); Schema::dropIfExists('internships'); Schema::dropIfExists('galleries'); Schema::dropIfExists('organizations'); Schema::dropIfExists('project_skill'); Schema::dropIfExists('skills'); Schema::dropIfExists('projects'); Schema::dropIfExists('certificates'); Schema::dropIfExists('achievements'); Schema::dropIfExists('teachers'); Schema::dropIfExists('students'); Schema::dropIfExists('classes'); Schema::dropIfExists('departments'); }
};
