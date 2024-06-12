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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('olympiad_id')->constrained('olympiads', 'id')->cascadeOnDelete();
            $table->tinyInteger('type');
            $table->longText('content');
            $table->unsignedInteger('correct_answer_cost')->default(1);
            $table->integer('wrong_answer_cost')->default(-1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
