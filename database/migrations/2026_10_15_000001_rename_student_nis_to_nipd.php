<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('nis', 'nipd');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('registration_nis', 'registration_nipd');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('registration_nipd', 'registration_nis');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('nipd', 'nis');
        });
    }
};
