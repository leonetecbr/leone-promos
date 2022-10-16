<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial.
     *
     * @return View
     */
    public function get(): View
    {
        $collection = collect([
            [
                'id' => 123,
                'group_id' => 1,
                'store_id' => 2,
                'name' => 'Testando',
                'link' => '#',
                'image' => '',
                'from' => 100,
                'for' => 10,
                'times' => NULL,
                'installments' => NULL,
                'page' => 1,
                'store' => [
                    'name' => 'Teste',
                    'link' => '#',
                    'image' => '',
                ]
            ],
            [
                'id' => 124,
                'group_id' => 1,
                'store_id' => 2,
                'name' => 'Testando',
                'link' => '#',
                'image' => '',
                'from' => 100,
                'for' => 10,
                'times' => NULL,
                'installments' => NULL,
                'page' => 1,
                'store' => [
                    'name' => 'Teste',
                    'link' => '#',
                    'image' => '',
                ]
            ],
            [
                'id' => 125,
                'group_id' => 1,
                'store_id' => 2,
                'name' => 'Testando',
                'link' => '#',
                'image' => '',
                'from' => 100,
                'for' => 10,
                'times' => NULL,
                'installments' => NULL,
                'page' => 1,
                'store' => [
                    'name' => 'Teste',
                    'link' => '#',
                    'image' => '',
                ]
            ]
        ]);

        return view('home', ['promos' => $collection]);
    }
}
