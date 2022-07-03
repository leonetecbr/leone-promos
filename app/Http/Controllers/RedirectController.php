<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers\RedirectHelper;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Gera os links de afiliado para as lojas
 */
class RedirectController
{

    /**
     * Decodifica o link curto e redireciona
     * @param string $dados
     * @return RedirectResponse
     * @throws Exception
     */
    public function shortLink(string $dados): RedirectResponse
    {
        $dados = base64_decode($dados);
        $dados = explode('-', $dados, 4);
        if ($dados[0] == 'c' && count($dados) === 2) {
            $couponId = $dados[1];
            $page = ceil((abs(intval($couponId)) + 1) / 18);
            return redirect(env('APP_URL') . '/cupons/' . $page . '#cupom-' . $couponId);
        } elseif ($dados[0] == 'o' && count($dados) === 4) {
            $catId = $dados[1];
            $page = $dados[2];
            $ofertaId = $dados[3];
            return redirect(env('APP_URL') . '/' . RedirectHelper::processPage(intval($catId), intval($page), intval($ofertaId)));
        } else {
            return redirect(env('APP_URL'));
        }
    }

    /**
     * Gera a resposta para a api
     * @param Request $request
     * @return array
     */
    public function api(Request $request): array
    {
        $url = $request->input('url');
        $urlAfiliados = $this->process($url);
        $result['success'] = true;
        if ($urlAfiliados == '/') {
            $result['url'] = '/';
        } else {
            $result['url'] = $urlAfiliados;
        }
        return $result;
    }

    /**
     * Processa a URL recebida, encaminha para o método responsável e retorna o link já com parâmetros de afiliados
     * @param string $url
     * @return string
     */
    private static function process(string $url): string
    {
        try {
            if (empty($url) || strpos($url, 'https://') !== 0) {
                throw new RequestException();
            }
            if (strpos($url, '?') !== false) {
                $url = strstr($url, '?', true);
            }

            if (strpos($url, 'https://www.amazon.com.br') === 0 || strpos($url, 'https://amazon.com.br') === 0) {
                if (strpos($url, '/ref') !== false) {
                    $url = strstr($url, '/ref', true);
                }
                $to = $url . '?tag=leonepromos08-20';
            } elseif (strpos($url, 'https://redir.lomadee.com/') === 0 || strpos($url, 'https://www.awin1.com/cread.php') === 0 || strpos($url, 'https://amzn.to/') === 0) {
                $to = $url;
            } elseif (strpos($url, 'https://m.magazineluiza.com.br') === 0 || strpos($url, 'https://www.magazineluiza.com.br') === 0 || strpos($url, 'https://magazineluiza.com.br') === 0 || strpos($url, 'https://www.magazinevoce.com.br') === 0) {
                $to = RedirectHelper::processMagalu($url);
            } elseif (strpos($url, 'https://mbest.aliexpress.com') === 0 || strpos($url, 'https://m.pt.aliexpress.com') === 0 || strpos($url, 'https://best.aliexpress.com') === 0 || strpos($url, 'https://pt.aliexpress.com') === 0 || strpos($url, 'https://aliexpress.com') === 0 || strpos($url, 'https://m.aliexpress.com') === 0) {
                $to = RedirectHelper::processAwin($url, 18879);
            } elseif (strpos($url, 'https://m.pontofrio.com.br') === 0 || strpos($url, 'https://www.pontofrio.com.br') === 0 || strpos($url, 'https://pontofrio.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 17621);
            } elseif (strpos($url, 'https://m.extra.com.br') === 0 || strpos($url, 'https://www.extra.com.br') === 0 || strpos($url, 'https://extra.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 17874);
            } elseif (strpos($url, 'https://m.casasbahia.com.br') === 0 || strpos($url, 'https://www.casasbahia.com.br') === 0 || strpos($url, 'https://casasbahia.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 17629);
            } elseif (strpos($url, 'https://www.soubarato.com.br') === 0 || strpos($url, 'https://soubarato.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 23281, env('ID_AFILIADO_B2W'));
            } elseif (strpos($url, 'https://www.submarino.com.br') === 0 || strpos($url, 'https://submarino.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 22195, env('ID_AFILIADO_B2W'));
            } elseif (strpos($url, 'https://www.shoptime.com.br') === 0 || strpos($url, 'https://shoptime.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 22194, env('ID_AFILIADO_B2W'));
            } elseif (strpos($url, 'https://www.americanas.com.br') === 0 || strpos($url, 'https://americanas.com.br') === 0) {
                $to = RedirectHelper::processAwin($url, 22193, env('ID_AFILIADO_B2W'));
            } else {
                $to = RedirectHelper::processLomadee($url);
            }
        } catch (RequestException $e) {
            $to = '/';
        } finally {
            return $to;
        }
    }

    /**
     * Gera a página de redirecionamento
     * @return View
     */
    public function get(): View
    {
        return view('redirect');
    }
}
