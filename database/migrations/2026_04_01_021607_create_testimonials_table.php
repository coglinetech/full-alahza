<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('city', 100);
            $table->string('photo', 255)->nullable();
            $table->text('content');
            $table->string('package_name', 100)->nullable();
            $table->year('year')->nullable();
            $table->tinyInteger('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};