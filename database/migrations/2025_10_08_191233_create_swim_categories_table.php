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
        Schema::create('swim_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug')->nullable()->unique();
            $table->string('description');
            $table->unsignedInteger('level_order')->default(1);
            $table->foreignId('swim_program_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['swim_program_id', 'level_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swim_categories');
    }
};
