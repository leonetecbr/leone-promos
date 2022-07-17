<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['id', 'name', 'link', 'image'];

    /**
     * Cria os registros padrões no banco de dados
     * @return void
     */
    public static function initialize(): void
    {
        self::insert([
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
                'image' => '/img/lojas/parceiro_magalu.png',
                'link' => '/redirect?url=https://www.magazinevoce.com.br/magazineofertasleone/'
            ], [
                'id' => 7,
                'name' => 'Shopee',
                'image' => '/img/lojas/shopee.png',
                'link' => 'https://shopee.com.br/ofertas.leone.tec.br' // Loja proprietária
            ]
        ]);
    }
}
