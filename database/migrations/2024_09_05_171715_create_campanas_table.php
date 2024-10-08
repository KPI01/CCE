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
        Schema::create("campanas", function (Blueprint $table) {
            $table->ulid("id")->unique();
            $table->timestamps();
            $table->string("nombre");
            $table->boolean("is_activa");
            $table->date("inicio");
            $table->date("fin");
            $table->text("descripcion")->nullable();
        });

        Schema::create("campana_empresa", function (Blueprint $table) {
            $table->timestamp("created_at");
            $table->foreignUuid("campana_id")->references("id")->on("campanas");
            $table->foreignUuid("empresa_id")->references("id")->on("empresas");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("campanas");
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists("campana_empresa");
    }
};
