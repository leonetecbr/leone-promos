<?php

use App\Models\TopStores;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('top_stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 25);
            $table->string('title', 25);
            $table->text('image');
            $table->text('url')->nullable();
        });

        TopStores::initialize();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('top_stores');
    }
}
