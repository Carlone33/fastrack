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
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('unidad_administrativa_id')->nullable();
            $table->string('credencial')->unique()->nullable();
            $table->string('rango')->nullable();
            $table->string('cargo')->nullable();
            $table->timestamps();
            
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('cascade');
            $table->foreign('unidad_administrativa_id')->references('id')->on('unidad_administrativa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funcionario');
    }
};
