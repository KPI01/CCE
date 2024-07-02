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
        Schema::create('personas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('nombres', 50);
            $table->string('apellidos', 50);
            $table->string('tipo_id_nac', 3);
            $table->string('id_nac', 12)->unique();
            $table->string('email', 254)->unique();
            $table->string('tel', 20)->nullable();
            $table->string('perfil', 20)->nullable();
            $table->text('observaciones')->nullable();
        });

        Schema::create('persona_ropo', function (Blueprint $table) {
            $table->foreignUuid('persona_id')->references('id')->on('personas')->cascadeOnDelete();
            $table->string('tipo', 15);
            $table->string('nro', 25);
            $table->date('caducidad')->nullable();
            $table->string('tipo_aplicador', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('personas');
        Schema::dropIfExists('persona_ropo');
    }
};
