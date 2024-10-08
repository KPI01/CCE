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
        Schema::create("cultivos", function (Blueprint $table) {
            $table->ulid("id")->unique()->primary();
            $table->timestamps();
            $table->char("nombre", 65);
            $table->char("variedad", 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("cultivos");
    }
};
