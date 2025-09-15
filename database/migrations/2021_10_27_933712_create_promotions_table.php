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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60);
            $table->text('link');
            $table->text('image');
            $table->float('was', 2)->nullable();
            $table->float('for', 2);
            $table->float('installments')->nullable();
            $table->unsignedTinyInteger('times')->nullable();
            $table->text('description')->nullable();
            $table->string('code', 40)->nullable();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_top')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
