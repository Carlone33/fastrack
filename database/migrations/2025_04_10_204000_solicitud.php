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
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_solicitud');
            $table->date('fecha_registro');
            $table->foreignId('registrador_funcionario_id')->constrained('funcionario')->onDelete('cascade');
            $table->foreignId('solicitante_persona_id')->constrained('persona')->onDelete('cascade');
            $table->date('fecha_solicitud');
            $table->time('hora_solicitud');
            $table->string('estado_solicitud');
            $table->foreignId('apoderado_persona_id')->nullable()->constrained('persona')->onDelete('cascade');
            $table->foreignId('abogado_funcionario_id')->constrained('persona')->onDelete('cascade');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud');
    }
};
