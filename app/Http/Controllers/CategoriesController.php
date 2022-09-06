<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers;
use App\Models\Category;
use Exception;
use Illuminate\Contracts\View\View;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends Controller
{

    /**
     * Retorna a lista com as principais categorias
     * @return View
     */
    #[Route('/categorias', name: 'categorias')]
    public static function get(): View
    {
        $categories = Category::all()->toArray();
        return view('categories', ['categories' => $categories]);
    }

    /**
     * Encontra o código corresponde a categoria através do nome para poder buscar os dados corretos no banco de dados
     * @param string $name
     * @param int $page
     * @return View
     * @throws Exception
     */
    #[Route('/categorias/{categoria}/{page?}', name: 'categoria')]
    public static function process(string $name, int $page = 1): View
    {
        try {
            $title = '';
            $categories = Category::all()->toArray();

            foreach ($categories as $category) {
                if ($category['name'] == $name) {
                    $id = $category['id'];
                    $title = $category['title'];
                }
            }

            if (empty($id)) {
                throw new RequestException('Categoria não encontrada!');
            }

            $data = Helpers\ApiHelper::getPromo($id, $page);
            $offers = $data['offers'];
            $endPage = $data['totalPage'];
            $subtitle = $title;
            $title = 'Categoria: ' . $title . " - Página {$page} de {$endPage}";
        } catch (RequestException $e) {
            $title = 'Não encontrada';
            $offers = '<div class="alert alert-danger mt-3 text-center">' . $e->getMessage() . '</div>';
            $top = false;
        }

        return view('promos', ['title' => $title, 'subtitle' => $subtitle ?? $title, 'promos' => $offers, 'catId' => $id ?? 0, 'page' => $page, 'endPage' => $endPage ?? '', 'top' => $top ?? true, 'isLoja' => false, 'groupName' => $name ?? '']);
    }
}
