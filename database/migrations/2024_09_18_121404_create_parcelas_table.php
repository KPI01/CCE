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
        Schema::create(
            table: "parcelas",
            callback: function (Blueprint $table): void {
                $table->uuid(column: "id")->primary()->index();
                $table->timestamps();
                $table->char(column: "codigo")->unique();
                $table->float(column: "superficie_km");
                $table->integer(column: "nro_plantas");
                $table
                    ->foreignUuid(column: "persona_id")
                    ->nullable()
                    ->references(column: "id")
                    ->on(table: "personas")
                    ->nullOnDelete();
                $table
                    ->foreignUuid(column: "empresa_id")
                    ->nullable()
                    ->references(column: "id")
                    ->on(table: "empresas")
                    ->nullOnDelete();
                $table
                    ->foreignUuid(column: "campana_id")
                    ->nullable()
                    ->references(column: "id")
                    ->on(table: "campanas")
                    ->nullOnDelete();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: "parcelas");
    }
};
