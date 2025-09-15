<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Store::factory()->count(14)->sequence(
            [
                'slug' => 'aliexpress',
                'name' => 'Aliexpress',
                'image' => 'https://ae01.alicdn.com/kf/H2111329c7f0e475aac3930a727edf058z.png',
                'is_top' => false,
                'link' => '/redirect?url=https%3A%2F%2Fpt.aliexpress.com%2F'
            ], [
                'slug' => 'casas-bahia',
                'name' => 'Casas Bahia',
                'image' => 'https://m.casasbahia.com.br/assets/images/casasbahia-logo-new.svg',
                'is_top' => false,
                'link' => '/redirect?url=https%3A%2F%2Fwww.casasbahia.com.br%2F'
            ], [
                'slug' => 'extra',
                'name' => 'Extra',
                'image' => 'https://m.extra.com.br/assets/images/ic-extra-navbar.svg',
                'is_top' => false,
                'link' => '/redirect?url=https%3A%2F%2Fwww.casasbahia.com.br%2F'
            ], [
                'slug' => 'ponto-frio',
                'name' => 'Ponto',
                'image' => 'https://m.pontofrio.com.br/assets/images/ic-navbar-logo.svg',
                'is_top' => false,
                'link' => '/redirect?url=https%3A%2F%2Fwww.pontofrio.com.br%2F'
            ], [
                'slug' => 'amazon',
                'name' => 'Amazon',
                'image' => '/img/lojas/amazon-large-store.png',
                'is_top' => false,
                'link' => '/redirect?url=https://www.amazon.com.br/'
            ], [
                'slug' => 'parceiro-magalu',
                'name' => 'Parceiro Magalu',
                'image' => '/img/lojas/parceiro_magalu.png',
                'is_top' => true,
                'link' => '/redirect?url=https://www.magazinevoce.com.br/magazineofertasleone/'
            ], [
                'slug' => 'shopee',
                'name' => 'Shopee',
                'image' => '/img/lojas/shopee.png',
                'is_top' => false,
                'link' => '/redirect?url=https://shopee.com.br/'
            ], [
                'slug' => 'brandili',
                'name' => 'Brandili',
                'image' => 'https://www.lomadee.com/programas/BR/7863/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://www.brandili.com.br/'
            ], [
                'slug' => 'usaflex',
                'name' => 'Usaflex',
                'image' => 'https://www.lomadee.com/programas/BR/6358/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://www.usaflex.com.br/'
            ], [
                'slug' => 'electrolux',
                'name' => 'Electrolux',
                'image' => 'https://www.lomadee.com/programas/BR/6078/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://loja.electrolux.com.br/'
            ], [
                'slug' => 'nike',
                'name' => 'Nike',
                'image' => 'https://www.lomadee.com/programas/BR/5901/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://www.nike.com.br/'
            ], [
                'slug' => 'brastemp',
                'name' => 'Brastemp',
                'image' => 'https://www.lomadee.com/programas/BR/5936/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://www.brastemp.com.br/'
            ], [
                'slug' => 'positivo',
                'name' => 'Positivo',
                'image' => 'https://www.lomadee.com/programas/BR/6117/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://loja.meupositivo.com.br/'
            ], [
                'slug' => 'repassa',
                'name' => 'Repassa',
                'image' => 'https://www.lomadee.com/programas/BR/6104/logo_115x76.png',
                'is_top' => true,
                'link' => '/redirect?url=https://www.repassa.com.br/'
            ]
        )->create();
    }
}
