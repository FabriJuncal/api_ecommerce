<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('image');
            $table->string('type', 35);
            $table->string('size', 50);
            $table->foreignId('product_id')->index();
            $table->timestamps();
            $table->softDeletes(); // Agrega la columna deleted_at para soporte de eliminación suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
