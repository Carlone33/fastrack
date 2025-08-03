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
        Schema::create('movimientos_solicitud', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solicitud_id');
            $table->unsignedBigInteger('usuario_id');
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps(); // created_at y updated_at automáticos

            $table->foreign('solicitud_id')->references('id')->on('solicitud')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_solicitud');
    }
};
