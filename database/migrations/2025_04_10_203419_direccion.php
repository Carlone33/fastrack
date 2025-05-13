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
       Schema::create('direccion', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->string('municipio');
            $table->string('parroquia');
            $table->string('calle');
            $table->string('casa-edificio');
            $table->string('piso');
            $table->string('apartamento');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
