<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendedNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sended_notifications', function (Blueprint $table) {
            $table->string('id')->unique()->primary();
            $table->string('by');
            $table->string('title', 60);
            $table->text('image')->nullable();
            $table->string('content', 200);
            $table->string('link', 60);
            $table->integer('to')->default(1);
            $table->integer('clicks')->default(0);
            $table->dateTime('sended_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sended_notifications');
    }
}
