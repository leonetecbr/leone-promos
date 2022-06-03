<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Store;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->text('image');
            $table->text('link');
        });

        Store::insert([
            [
                'id' => 1,
                'name' => 'Aliexpress',
                'image' => 'https://ae01.alicdn.com/kf/H2111329c7f0e475aac3930a727edf058z.png',
                'link' => '/redirect?url=https%3A%2F%2Fpt.aliexpress.com%2F'
            ], [
                'id' => 2,
                'name' => 'Casas Bahia',
                'image' => 'https://m.casasbahia.com.br/assets/images/casasbahia-logo-new.svg',
                'link' => '/redirect?url=https%3A%2F%2Fwww.casasbahia.com.br%2F'
            ], [
                'id' => 3,
                'name' => 'Extra',
                'image' => 'https://m.extra.com.br/assets/images/ic-extra-navbar.svg',
                'link' => '/redirect?url=https%3A%2F%2Fwww.casasbahia.com.br%2F'
            ], [
                'id' => 4,
                'name' => 'Ponto',
                'image' => 'https://m.pontofrio.com.br/assets/images/ic-navbar-logo.svg',
                'link' => '/redirect?url=https%3A%2F%2Fwww.pontofrio.com.br%2F'
            ], [
                'id' => 5,
                'name' => 'Amazon',
                'image' => '/img/lojas/amazon-large-store.png',
                'link' => '/redirect?url=https://www.amazon.com.br/'
            ], [
                'id' => 6,
                'name' => 'Parceiro Magalu',
                'image' => 'https://mvc.mlcdn.com.br/magazinevoce/img/common/parceiro-magalu-logo-blue.svg',
                'link' => '/redirect?url=https://www.magazinevoce.com.br/magazineofertasleone/'
            ], [
                'id' => 7,
                'name' => 'Shopee',
                'image' => '/img/lojas/shopee.png',
                'link' => 'https://shopee.com.br/ofertas.leone.tec.br' // Loja proprietária
            ], [
                'id' => 8,
                'name' => 'Soub!',
                'image' => '/img/lojas/soub.png',
                'link' => '/redirect?url=https://www.soubarato.com.br/'
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
        Schema::dropIfExists('stores');
    }
}