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
        Schema::create("tipos_maquina", function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("tipo", 50)->index();
        });

        Schema::create("maquinas", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->string("nombre", 100);
            $table
                ->foreignId("tipo_id")
                ->nullable()
                ->references("id")
                ->on("tipos_maquina")
                ->onDelete("set null");
            $table->string("matricula", 25)->unique();
            $table->string("modelo", 50)->nullable();
            $table->string("marca", 50)->nullable();
            $table->string("roma")->unique()->nullable();
            $table->string("nro_serie", 50)->unique()->nullable();
            $table->string("fabricante", 100)->nullable();
            $table->date("cad_iteaf")->nullable();
            $table->text("observaciones")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists("tipos_maquina");
        Schema::dropIfExists("maquinas");
    }
};
