<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'id' => 77,
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'icon' => 'mobile-button'
            ], [
                'id' => 2,
                'name' => 'Informática',
                'slug' => 'informatica',
                'icon' => 'laptop'
            ], [
                'id' => 1,
                'name' => 'Eletrônicos',
                'slug' => 'eletronicos',
                'icon' => 'headphones'
            ], [
                'id' => 116,
                'name' => 'Eletrodomésticos',
                'slug' => 'eletrodomesticos',
                'icon' => 'blender'
            ], [
                'id' => 22,
                'name' => 'PCs',
                'slug' => 'pc',
                'icon' => 'desktop'
            ], [
                'id' => 194,
                'name' => 'Bonecas',
                'slug' => 'bonecas',
                'icon' => 'child'
            ], [
                'id' => 2852,
                'name' => 'TVs',
                'slug' => 'tv',
                'icon' => 'tv'
            ], [
                'id' => 138,
                'name' => 'Fogão',
                'slug' => 'fogao',
                'icon' => 'fire'
            ], [
                'id' => 3673,
                'name' => 'Geladeira',
                'slug' => 'geladeira',
                'icon' => 'temperature-low'
            ], [
                'id' => 3671,
                'name' => 'Lava-Roupas',
                'slug' => 'lavaroupas',
                'icon' => 'tshirt'
            ], [
                'id' => 7690,
                'name' => 'Roupas Masculinas',
                'slug' => 'roupasm',
                'icon' => 'male'
            ], [
                'id' => 7691,
                'name' => 'Roupas Femininas',
                'slug' => 'roupasf',
                'icon' => 'female'
            ], [
                'id' => 2735,
                'name' => 'Talheres',
                'slug' => 'talheres',
                'icon' => 'utensils'
            ], [
                'id' => 2712,
                'name' => 'Camas',
                'slug' => 'camas',
                'icon' => 'bed'
            ], [
                'id' => 2701,
                'name' => 'Casa e decoração',
                'slug' => 'casaedeco',
                'icon' => 'home'
            ], [
                'id' => 2916,
                'name' => 'Mesas',
                'slug' => 'mesas',
                'icon' => 'chair'
            ]
        ]);
    }
}
