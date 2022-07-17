<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopStores extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'top_stores';
    protected $fillable = ['id', 'name', 'title', 'image', 'url'];

    /**
     * Cria os registros padrões no banco de dados
     * @return void
     */
    public static function initialize(): void
    {
        self::insert([
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
}
