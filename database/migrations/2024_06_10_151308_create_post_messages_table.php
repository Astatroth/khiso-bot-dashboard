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
        Schema::create('post_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts', 'id')->cascadeOnDelete();
            $table->integer('chat_id');
            $table->tinyInteger('message_type');
            $table->longText('message_content');
            $table->longText('message_media')->nullable();
            $table->string('message_parse_mode')->nullable();
            $table->longText('message_reply_markup')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_messages');
    }
};
