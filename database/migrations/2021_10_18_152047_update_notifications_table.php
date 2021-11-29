<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNotificationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('notifications', function ($table) {
      $table->boolean('p1')->default(true);
      $table->boolean('p2')->default(true);
      $table->boolean('p3')->default(true);
      $table->boolean('p4')->default(true);
      $table->boolean('p5')->default(true);
      $table->boolean('p6')->default(true);
      $table->boolean('p7')->default(true);
      $table->boolean('p8')->default(true);
      $table->boolean('p9')->default(true);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    if (Schema::hasColumn('p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8', 'p9')) {
      Schema::table('users', function ($table) {
        $table->dropColumn(['p1', 'p2', 'p3', 'p4', 'p5', 'p6', 'p7', 'p8', 'p9']);
      });
    }
  }
}
