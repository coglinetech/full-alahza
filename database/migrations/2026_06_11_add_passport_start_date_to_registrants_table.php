<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->date('passport_start_date')->nullable()->after('passport_issued_place');
        });
    }

    public function down()
    {
        Schema::table('registrants', function (Blueprint $table) {
            $table->dropColumn('passport_start_date');
        });
    }
};
