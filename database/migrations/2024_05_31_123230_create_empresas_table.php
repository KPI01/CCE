<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('nombre', 100);
            $table->string('nif', 9)->unique();
            $table->string('email', 254)->unique()->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('codigo', 10)->nullable();
            $table->string('perfil', 20);
            $table->text('direccion')->nullable();
            $table->text('observaciones')->nullable();
        });

        Schema::create('empresa_ropo', function (Blueprint $table) {
            $table->foreignUuid('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->string('tipo', 15);
            $table->string('nro', 25);
            $table->date('caducidad')->nullable();
            $table->string('tipo_aplicador', 30)->nullable();
        });

        Schema::create('empresa_persona', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->foreignUuid('empresa_id')->references('id')->on('empresas')->cascadeOnDelete();
            $table->foreignUuid('persona_id')->references('id')->on('personas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('empresas');
        Schema::dropIfExists('empresa_ropo');
        Schema::dropIfExists('empresa_persona');
    }
};
