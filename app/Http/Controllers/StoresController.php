<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers;
use App\Models\Store;
use App\Models\TopStores;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StoresController extends Controller
{

    /**
     * Retorna a lista com as principais lojas
     * @returns View
     */
    public static function get(): View
    {
        $stores = TopStores::all()->toArray();
        return view('stores', ['stores' => $stores]);
    }

    /**
     * Encontra o código corresponde a loja através do nome para poder buscar os dados corretos no banco de dados
     * @param string $name
     * @param int $page
     * @return View|RedirectResponse
     * @throws Exception
     */
    public static function process(string $name, int $page = 1)
    {
        try {

            $title = '';
            $stores = TopStores::all()->toArray();

            foreach ($stores as $store) {
                if ($store['name'] == $name) {
                    if (!is_null($store['url'])) {
                        return redirect($store['url']);
                    }

                    $id = $store['id'];
                    $title = $store['title'];
                }
            }

            if (empty($id)) {
                throw new RequestException('Loja não encontrada!');
            }

            $dado = Helpers\ApiHelper::getPromo(999, $page, $id);
            $offers = $dado['offers'];
            $endPage = $dado['totalPage'];
            $subtitle = $title;
            $title = 'Loja: ' . $title . " - Página {$page} de {$endPage}";
        } catch (RequestException $e) {
            $title = 'Não encontrada';
            $offers = '<div class="alert alert-danger fs-4 mt-3 text-center">' . $e->getMessage() . '</div>';
            $top = false;
        }

        return view('promos', ['title' => $title, 'subtitle' => $subtitle ?? $title, 'promos' => $offers, 'catId' => $id ?? 0, 'page' => $page ?? 1, 'endPage' => $endPage ?? 1, 'top' => $top ?? true, 'isStore' => true, 'groupName' => $loja ?? '']);
    }

    /**
     * Gera a página para adição de uma nova loja no sistema
     * @returns View
     */
    public function new(): View
    {
        return view('admin.loja');
    }

    /**
     * Salva a nova loja
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function save(Request $request): RedirectResponse
    {
        $dados = $this->validate($request, [
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
                return redirect()->route('lojas.new')->with([
                    'save' => 'A loja foi salva com sucesso!'
                ]);
            } else {
                return redirect()->route('lojas.new')->withErrors([
                    'form' => ['Erro interno ao salvar a nova loja!']
                ])->withInput();
            }
        } else {
            return redirect()->route('lojas.new')->withErrors([
                'id' => ['O id informado já existe no banco de dados.']
            ])->withInput();
        }
    }
}
