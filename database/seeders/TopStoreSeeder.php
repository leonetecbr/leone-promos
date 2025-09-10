<?php

namespace Database\Seeders;

use App\Models\TopStore;
use Illuminate\Database\Seeder;

class TopStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TopStore::insert([
            [
                'id' => 6,
                'name' => 'magalu',
                'title' => 'Parceiro Magalu',
                'image' => 'https://mvc.mlcdn.com.br/magazinevoce/img/common/parceiro-magalu-logo-blue.svg',
                'url' => 'https://www.magazinevoce.com.br/magazineofertasleone'
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
}
