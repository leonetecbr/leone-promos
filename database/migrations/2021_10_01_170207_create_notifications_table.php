<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('endpoint', 700)->unique();
            $table->string('p256dh', 88);
            $table->string('auth', 24);
            $table->boolean('p1')->default(true);
            $table->boolean('p2')->default(true);
            $table->boolean('p3')->default(true);
            $table->boolean('p4')->default(true);
            $table->boolean('p5')->default(true);
            $table->boolean('p6')->default(true);
            $table->boolean('p7')->default(true);
            $table->boolean('p8')->default(true);
            $table->boolean('p9')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
