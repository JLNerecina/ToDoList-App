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
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        
        // Temporary change — just create the column without foreign key
        $table->unsignedBigInteger('category_id');
        
        $table->string('title');
        $table->text('description')->nullable();
        $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
        $table->enum('status', ['To Do', 'In Progress', 'Completed', 'Submitted'])->default('To Do');
        $table->date('deadline')->nullable();
        $table->timestamps();
        
        // Add foreign key after both tables exist
        $table->foreign('category_id')
              ->references('id')
              ->on('categories')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};