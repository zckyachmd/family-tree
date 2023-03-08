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
        // Check if family_trees tables is already created
        if (Schema::hasTable('family_trees')) {
            return;
        }

        // Create family_trees table
        Schema::create('family_trees', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('gender', ['male', 'female']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('family_trees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop family_trees table
        Schema::dropIfExists('family_trees');
    }
};
