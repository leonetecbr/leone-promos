<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sent_notifications', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('by');
            $table->string('title', 60);
            $table->text('image')->nullable();
            $table->string('content', 200);
            $table->string('link', 60);
            $table->integer('to')->default(1);
            $table->integer('clicks')->default(0);
            $table->dateTime('sent_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_notifications');
    }
}
