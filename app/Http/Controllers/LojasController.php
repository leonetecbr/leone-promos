<?php

namespace App\Http\Controllers;

use App\Helpers;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;

class LojasController extends Controller
{

    /**
     * Retorna a lista com as principais lojas
     * @returns View
     */
    public static function get(): View
    {
        return view('lojas');
    }

    /**
     * Encontra o código corresponde a loja através do nome para poder buscar os dados corretos no banco de dados
     * @param string $loja
     * @param int $page
     * @return View|Redirector
     */
    public static function process(string $loja, int $page = 1)
    {
        try {
            switch ($loja) {
                case 'americanas':
                    $store = 5632;
                    $title = 'Americanas';
                    break;

                case 'magalu':
                    return redirect('https://www.magazinevoce.com.br/magazineofertasleone/');

                case 'submarino':
                    $store = 5766;
                    $title = 'Submarino';
                    break;

                case 'shoptime':
                    $store = 5644;
                    $title = 'Shoptime';
                    break;

                case 'brandili':
                    $store = 7863;
                    $title = 'Brandili';
                    break;

                case 'usaflex':
                    $store = 6358;
                    $title = 'Usaflex';
                    break;

                case 'electrolux':
                    $store = 6078;
                    $title = 'Electrolux';
                    break;

                case 'itatiaia':
                    $store = 7460;
                    $title = 'Itatiaia';
                    break;

                case 'brastemp':
                    $store = 5936;
                    $title = 'Brastemp';
                    break;

                case 'positivo':
                    $store = 6117;
                    $title = 'Positivo';
                    break;

                case 'etna':
                    $store = 6373;
                    $title = 'Etna';
                    break;

                case 'repassa':
                    $store = 6104;
                    $title = 'Repassa';
                    break;

                default:
                    throw new Exception('Loja não encontrada!');
                    break;
            }
            $dado = Helpers\ApiHelper::getPromo(999, $page, $store);
            $ofertas = $dado['offers'];
            $pages = $dado['totalPage'];
            $subtitle = $title;
            $title = 'Loja: ' . $title . " - Página {$page} de {$pages}";
        } catch (Exception $e) {
            $title = 'Não encontrada';
            $ofertas = '<p class="fs-4 text-danger error mt-3 mx-auto">' . $e->getMessage() . '</p>';
            $topo = false;
        }

        return view('promos', ['title' => $title, 'subtitle' => $subtitle ?? $title, 'promos' => $ofertas, 'cat_id' => $store ?? 0, 'page' => $page ?? 1, 'final' => $pages ?? 1, 'topo' => $topo ?? true, 'isLoja' => true, 'group_name' => $loja ?? '']);
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
            'imagem' => 'required',
            'link' => 'required'
        ]);

        $loja = Store::where('id', $dados['id'])->first();

        if (empty($loja)) {
            $store = new Store;
            $store->id = $dados['id'];
            $store->nome = $dados['name'];
            $store->imagem = $dados['imagem'];
            $store->link = ($request->filled('redirect')) ? '/redirect?url=' .  $dados['link'] : $dados['link'];

            if ($store->save()) {
                return redirect()->route('lojas.new')->with([
                    'save' => 'A loja foi salva com sucesso!'
                ]);
            } else {
                return redirect()->route('lojas.new')->withErrors([
                    'id' => ['Erro interno ao salvar a nova loja!']
                ]);
            }
        } else {
            return redirect()->route('lojas.new')->withErrors([
                'id' => ['O id informado já existe no banco de dados.']
            ]);
        }
    }
}
