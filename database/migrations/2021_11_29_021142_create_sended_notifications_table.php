<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\isNull;

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
      $table->string('por');
      $table->string('titulo', 60);
      $table->text('imagem')->nullable();
      $table->string('conteudo', 200);
      $table->string('link', 60);
      $table->integer('para')->default(1);
      $table->integer('cliques')->default(0);
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
