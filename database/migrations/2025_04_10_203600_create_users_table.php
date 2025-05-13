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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('funcionario_id')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->integer('intentos_fallidos')->default(0);
            $table->boolean('habilitado')->default(false);
            $table->boolean('eliminado')->default(false);
            $table->boolean('bloqueado')->default(false);
            $table->timestamp('fecha_ultimo_cambio_contrasena')->useCurrent();
            $table->string('observaciones')->nullable();
            $table->timestamps();
            
            $table->foreign('funcionario_id')->references('id')->on('funcionario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
