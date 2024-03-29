<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'categories';
    protected $fillable = ['title', 'id', 'name', 'icon'];

    /**
     * Cria os registros padrões no banco de dados
     * @return void
     */
    public static function initialize(): void
    {
        self::insert([[
            'id' => 77,
            'name' => 'smartphones',
            'title' => 'Smartphones',
            'icon' => 'mobile-button'
        ], [
            'id' => 2,
            'name' => 'informatica',
            'title' => 'Informática',
            'icon' => 'laptop'
        ], [
            'id' => 1,
            'name' => 'eletronicos',
            'title' => 'Eletrônicos',
            'icon' => 'headphones'
        ], [
            'id' => 116,
            'name' => 'eletrodomesticos',
            'title' => 'Eletrodomésticos',
            'icon' => 'blender'
        ], [
            'id' => 22,
            'name' => 'pc',
            'title' => 'PCs',
            'icon' => 'desktop'
        ], [
            'id' => 194,
            'name' => 'bonecas',
            'title' => 'Bonecas',
            'icon' => 'child'
        ], [
            'id' => 2852,
            'name' => 'tv',
            'title' => 'TVs',
            'icon' => 'tv'
        ], [
            'id' => 138,
            'name' => 'fogao',
            'title' => 'Fogão',
            'icon' => 'fire'
        ], [
            'id' => 3673,
            'name' => 'geladeira',
            'title' => 'Geladeira',
            'icon' => 'temperature-low'
        ], [
            'id' => 3671,
            'name' => 'lavaroupas',
            'title' => 'Lava-Roupas',
            'icon' => 'tshirt'
        ], [
            'id' => 7690,
            'name' => 'roupasm',
            'title' => 'Roupas Masculinas',
            'icon' => 'male'
        ], [
            'id' => 7691,
            'name' => 'roupasf',
            'title' => 'Roupas Femininas',
            'icon' => 'female'
        ], [
            'id' => 2735,
            'name' => 'talheres',
            'title' => 'Talheres',
            'icon' => 'utensils'
        ], [
            'id' => 2712,
            'name' => 'camas',
            'title' => 'Camas',
            'icon' => 'bed'
        ], [
            'id' => 2701,
            'name' => 'casaedeco',
            'title' => 'Casa e decoração',
            'icon' => 'home'
        ], [
            'id' => 2916,
            'name' => 'mesas',
            'title' => 'Mesas',
            'icon' => 'chair'
        ]]);
    }
}
