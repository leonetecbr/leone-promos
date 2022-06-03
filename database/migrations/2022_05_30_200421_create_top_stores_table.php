<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TopStores;

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

        TopStores::insert([
            [
                'id' => 5632,
                'name' => 'americanas',
                'title' => 'Americanas',
                'image' => 'https://www.lomadee.com/programas/BR/5632/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 5766,
                'name' => 'submarino',
                'title' => 'Submarino',
                'image' => 'https://www.lomadee.com/programas/BR/5766/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 6,
                'name' => 'magalu',
                'title' => 'Parceiro Magalu',
                'image' => 'https://mvc.mlcdn.com.br/magazinevoce/img/common/parceiro-magalu-logo-blue.svg',
                'url' => 'https://www.magazinevoce.com.br/magazineofertasleone'
            ], [
                'id' => 5644,
                'name' => 'shoptime',
                'title' => 'Shoptime',
                'image' => 'https://www.lomadee.com/programas/BR/5644/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 7863,
                'name' => 'brandili',
                'title' => 'Brandili',
                'image' => 'https://www.lomadee.com/programas/BR/7863/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 6358,
                'name' => 'usaflex',
                'title' => 'Usaflex',
                'image' => 'https://www.lomadee.com/programas/BR/6358/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 6078,
                'name' => 'electrolux',
                'title' => 'Electrolux',
                'image' => 'https://www.lomadee.com/programas/BR/6078/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 5901,
                'name' => 'nike',
                'title' => 'Nike',
                'image' => 'https://www.lomadee.com/programas/BR/5901/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 5936,
                'name' => 'brastemp',
                'title' => 'Brastemp',
                'image' => 'https://www.lomadee.com/programas/BR/5936/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 6117,
                'name' => 'positivo',
                'title' => 'Positivo',
                'image' => 'https://www.lomadee.com/programas/BR/6117/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 6373,
                'name' => 'etna',
                'title' => 'Etna',
                'image' => 'https://www.lomadee.com/programas/BR/6373/logo_115x76.png',
                'url' => NULL
            ], [
                'id' => 6104,
                'name' => 'repassa',
                'title' => 'Repassa',
                'image' => 'https://www.lomadee.com/programas/BR/6104/logo_115x76.png',
                'url' => NULL
            ]
        ]);
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
