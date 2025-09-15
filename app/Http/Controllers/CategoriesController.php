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
     */
    #[Route('/categorias', name: 'categorias')]
    public static function get(): View
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    /**
     * Encontra o código corresponde a categoria através do nome para poder buscar os dados corretos no banco de dados
     */
    #[Route('/categorias/{categoria}', name: 'categoria')]
    public static function process(string $category): View
    {
        $category = Category::select(['id', 'name'])->where('slug', $category)->firstOrFail();

        $promotions = $category->promotions()->with('store:id,name,image,link')->paginate(12);

        $title = "Promoções $category->name - Página {$promotions->currentPage()} de {$promotions->lastPage()}";
        $subtitle = $category->name;

        return view('promotions', compact('title', 'subtitle', 'promotions'));
    }
}
