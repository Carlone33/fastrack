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
        Schema::create('guide_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('Tipo de guía');
            $table->integer('year');
            $table->integer('last_number')->default(0);
            $table->string('preview')->nullable()->comment('Número de guía generado previamente');
            $table->timestamps();

            $table->unique(['type', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guide_sequences');
    }
};
