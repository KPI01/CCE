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
        Schema::create("campanias", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char("nombre", 25);
            $table->boolean("is_activa");
            $table->date("inicio");
            $table->date("fin");
            $table->text("descripcion");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("campanias");
    }
};
