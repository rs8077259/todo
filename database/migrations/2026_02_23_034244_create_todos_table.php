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
        Schema::create("todos", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->string(column: "color", length: 20)->default('blue');
            $table->string(column: "name", length: 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
