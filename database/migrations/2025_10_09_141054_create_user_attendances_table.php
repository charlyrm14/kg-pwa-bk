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
        Schema::create('user_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('attendance_status_id')->constrained()->onDelete('cascade');
            $table->timestamp('attendance_date');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'attendance_date', 'user_schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_attendances');
    }
};
