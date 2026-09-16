<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('registration_nis')->nullable()->unique()->after('requested_role');
            $table->foreignId('registration_class_id')->nullable()->after('registration_nis')
                ->constrained('classes')->nullOnDelete();
            $table->string('registration_nip')->nullable()->unique()->after('registration_class_id');
            $table->string('registration_phone', 20)->nullable()->after('registration_nip');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('registration_class_id');
            $table->dropUnique(['registration_nis']);
            $table->dropUnique(['registration_nip']);
            $table->dropColumn(['registration_nis', 'registration_nip', 'registration_phone']);
        });
    }
};
