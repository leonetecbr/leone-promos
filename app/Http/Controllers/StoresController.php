<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;

class StoresController extends Controller
{

    /**
     * Retorna a lista com as principais lojas
     */
    #[Route('/lojas', name: 'lojas')]
    public static function get(): View
    {
        $stores = Store::where('is_top', 1)->select(['id', 'slug', 'name', 'image', 'link'])->get();

        return view('stores', ['stores' => $stores]);
    }

    /**
     * Encontra o código corresponde a loja através do nome para poder buscar os dados corretos no banco de dados
     */
    #[Route('/lojas/{store}', name: 'loja')]
    public static function process(string $store): View|RedirectResponse
    {
        $store = Store::select(['id', 'name'])->where('slug', $store)->firstOrFail();

        $promotions = $store->promotions()->with('store:id,name,image,link')->paginate(12);

        $title = "Promoções $store->name - Página {$promotions->currentPage()} de {$promotions->lastPage()}";
        $subtitle = $store->name;

        return view('promotions', compact('title', 'subtitle', 'promotions'));
    }

    /**
     * Gera a página para adição de uma nova loja no sistema
     * @returns View
     */
    #[Route('/lojas/new', name: 'lojas.new')]
    public function new(): View
    {
        return view('admin.loja');
    }

    /**
     * Salva a nova loja
     */
    #[Route('/lojas/save', name: 'lojas.save')]
    public function save(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'id' => 'required|integer',
            'name' => 'required',
            'image' => 'required',
            'link' => 'required'
        ]);

        $loja = Store::find($dados['id']);

        if (empty($loja)) {
            $store = [
                'id' => $dados['id'],
                'name' => $dados['name'],
                'image' => $dados['image'],
                'link' => ($request->filled('redirect')) ? '/redirect?url=' . $dados['link'] : $dados['link']
            ];

            if (Store::create($store)) {
                return to_route('lojas.new', ['save' => 'A loja foi salva com sucesso!']);
            } else {
                return to_route('lojas.new')->withErrors([
                    'form' => ['Erro interno ao salvar a nova loja!']
                ])->withInput();
            }
        } else {
            return to_route('lojas.new')->withErrors([
                'id' => ['O id informado já existe no banco de dados.']
            ])->withInput();
        }
    }
}
