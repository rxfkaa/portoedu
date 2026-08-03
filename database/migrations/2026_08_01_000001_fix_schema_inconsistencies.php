<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Schema sudah konsisten dengan student_id di migration utama.
        // Migration ini dibuat no-op agar tidak menambahkan kolom user_id
        // yang tidak dipakai oleh controllers/model saat ini.
    }

    public function down(): void
    {
        // nothing to rollback
    }
};

