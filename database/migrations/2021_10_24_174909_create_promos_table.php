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
            $table->string('nome', 53);
            $table->text('link');
            $table->text('imagem');
            $table->float('de')->nullable();
            $table->float('por');
            $table->float('parcelas')->nullable();
            $table->integer('vezes')->nullable();
            $table->text('desc')->nullable();
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
