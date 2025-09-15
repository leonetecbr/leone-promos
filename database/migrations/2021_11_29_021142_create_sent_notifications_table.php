<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sent_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60);
            $table->text('image')->nullable();
            $table->string('content');
            $table->text('link');
            $table->unsignedBigInteger('clicks')->default(0);
            $table->foreignId('sent_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_notifications');
    }
};
