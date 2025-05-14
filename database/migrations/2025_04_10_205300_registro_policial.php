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
        Schema::create('registro_policial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->nullable()->constrained('solicitud')->onDelete('cascade');
            $table->string('guia')->unique();
            $table->integer('numero_oficio');
            $table->date('fecha_oficio');
            $table->string('nombre_tribunal');
            // $table->string('numero_causa_tribunal');
            $table->string('numero_expediente_tribunal');
            $table->string('motivo');
            // $table->string('observaciones')->nullable();
            // $table->string('tipo_verificacion');
            $table->boolean('verificado')->default(false);
            $table->unsignedBigInteger('verificadopor_persona_id')->nullable();
            $table->date('fecha_verificacion')->nullable();
            $table->timestamps();

            $table->foreign('verificadopor_persona_id')->references('id')->on('persona')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_policial');
    }
};
