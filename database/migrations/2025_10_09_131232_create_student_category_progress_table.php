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
        Schema::create('student_category_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_program_id')->constrained()->onDelete('cascade');
            $table->foreignId('swim_category_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('progress_percentage')->default(0);
            $table->date('started_at');
            $table->date('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['student_program_id', 'swim_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_category_progress');
    }
};
