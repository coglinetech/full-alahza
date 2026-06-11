<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->enum('category', ['umroh_reguler', 'umroh_plus']);
            $table->string('duration', 50);
            $table->decimal('price_start', 15, 2);
            $table->string('currency', 5)->default('IDR');
            $table->json('highlights')->nullable();
            $table->text('description')->nullable();
            $table->string('destination', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};