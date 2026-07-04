<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('registrants', function (Blueprint $table) {
            $table->id();
            $table->string('package_option')->nullable();
            $table->string('name');
            $table->string('passport_no')->nullable();
            $table->date('passport_issued_date')->nullable();
            $table->string('passport_issued_place')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->json('emergency_contacts')->nullable();
            $table->string('mahram_name')->nullable();
            $table->string('mahram_relation')->nullable();
            $table->string('umrah_experience')->nullable();
            $table->string('photo_path')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrants');
    }
};
