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
        Schema::create('ranking_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('trigger_type', 120);
            $table->unsignedBigInteger('trigger_id')->nullable();
            $table->integer('points_awarded');
            $table->integer('max_points_per_period')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['trigger_type', 'trigger_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_rules');
    }
};
