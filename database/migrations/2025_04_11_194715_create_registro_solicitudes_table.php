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
        Schema::create('registro_solicitud', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitud')->cascadeOnDelete();
            // $table->foreignId('dependencia_id')->nulleable()->constrained('unidad_administrativa')->cascadeOnDelete();
            $table->string('delito');
            // $table->string('razon_persona');
            // $table->string('estado_persona');
            // $table->date('fecha_apertura_siipol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_solicitud');
    }
};
