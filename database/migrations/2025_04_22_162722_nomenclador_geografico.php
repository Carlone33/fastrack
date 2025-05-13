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
        Schema::create('nomenclador_geografico', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->integer('tipo')->nullable();
            $table->integer('padre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nomenclador_geografico');
    }
};
