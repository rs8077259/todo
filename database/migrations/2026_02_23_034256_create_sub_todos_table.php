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
        Schema::create("sub_todos", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->timestamps();
            $table->foreignId("todo_id")->references("id")->on("todos")->constrained()->cascadeOnDelete();
            $table->string(column: "work")->nullable(false);
            $table->string("discription")->nullable();
            $table->timestamp("completed")->nullable();
            $table->timestamp("reminder")->nullable();
            $table->timestamp('serverReminder')->nullable();
            $table->boolean('intimated')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_todos');
    }
};
