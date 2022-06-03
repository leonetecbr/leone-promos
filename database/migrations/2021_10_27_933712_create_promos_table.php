<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPUnit\Framework\isNull;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('store_id');
            $table->string('name', 63);
            $table->text('link');
            $table->text('image');
            $table->float('from')->nullable();
            $table->float('for');
            $table->float('installments')->nullable();
            $table->integer('times')->nullable();
            $table->text('description')->nullable();
            $table->string('code', 40)->nullable();
            $table->integer('page')->default(1);
            $table->foreign('group_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
