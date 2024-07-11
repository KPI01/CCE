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
        //
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists("empresa_ropo");
        Schema::dropIfExists("persona_ropo");

        Schema::create("empresa_ropo", function (Blueprint $table) {
            $table
                ->foreignUuid("empresa_id")
                ->unique()
                ->references("id")
                ->on("empresas")
                ->cascadeOnDelete();
            $table->string("capacitacion", 30);
            $table->string("nro", 25)->unique();
            $table->date("caducidad")->nullable();
        });
        Schema::create("persona_ropo", function (Blueprint $table) {
            $table
                ->foreignUuid("persona_id")
                ->unique()
                ->references("id")
                ->on("personas")
                ->cascadeOnDelete();
            $table->string("capacitacion", 30);
            $table->string("nro", 25)->unique();
            $table->date("caducidad")->nullable();
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
