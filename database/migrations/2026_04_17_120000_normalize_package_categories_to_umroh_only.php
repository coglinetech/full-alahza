<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Make sure legacy values are normalized before enum is tightened.
        DB::statement("ALTER TABLE packages MODIFY category VARCHAR(50) NOT NULL");
        DB::statement("UPDATE packages SET category = 'umroh_plus' WHERE category NOT IN ('umroh_reguler', 'umroh_plus')");
        DB::statement("ALTER TABLE packages MODIFY category ENUM('umroh_reguler', 'umroh_plus') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE packages MODIFY category VARCHAR(50) NOT NULL");
    }
};
