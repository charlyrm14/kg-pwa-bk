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
        Schema::create('ranking_period_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_period_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_points');
            $table->integer('position');
            $table->timestamps();

            $table->unique(['ranking_period_id', 'user_id']);
            $table->index(['ranking_period_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_period_users');
    }
};
