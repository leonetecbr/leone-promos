<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers\RedirectHelper;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('/{dados}')]
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
    #[Route('/redirect', name: 'redirect.api')]
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
            if (empty($url) || !str_starts_with($url, 'https://')) {
                throw new RequestException();
            }
            if (str_contains($url, '?')) {
                $url = strstr($url, '?', true);
            }

            if (str_starts_with($url, 'https://www.amazon.com.br') || str_starts_with($url, 'https://amazon.com.br')) {
                if (str_contains($url, '/ref')) {
                    $url = strstr($url, '/ref', true);
                }
                $to = $url . '?tag=leonepromos08-20';
            } elseif (str_starts_with($url, 'https://redir.lomadee.com/') || str_starts_with($url, 'https://www.awin1.com/cread.php') || str_starts_with($url, 'https://amzn.to/')) {
                $to = $url;
            } elseif (str_starts_with($url, 'https://m.magazineluiza.com.br') || str_starts_with($url, 'https://www.magazineluiza.com.br') || str_starts_with($url, 'https://magazineluiza.com.br') || str_starts_with($url, 'https://www.magazinevoce.com.br')) {
                $to = RedirectHelper::processMagalu($url);
            } elseif (str_starts_with($url, 'https://mbest.aliexpress.com') || str_starts_with($url, 'https://m.pt.aliexpress.com') || str_starts_with($url, 'https://best.aliexpress.com') || str_starts_with($url, 'https://pt.aliexpress.com') || str_starts_with($url, 'https://aliexpress.com') || str_starts_with($url, 'https://m.aliexpress.com')) {
                $to = RedirectHelper::processAwin($url, 18879);
            } elseif (str_starts_with($url, 'https://m.pontofrio.com.br') || str_starts_with($url, 'https://www.pontofrio.com.br') || str_starts_with($url, 'https://pontofrio.com.br')) {
                $to = RedirectHelper::processAwin($url, 17621);
            } elseif (str_starts_with($url, 'https://m.extra.com.br') || str_starts_with($url, 'https://www.extra.com.br') || str_starts_with($url, 'https://extra.com.br')) {
                $to = RedirectHelper::processAwin($url, 17874);
            } elseif (str_starts_with($url, 'https://m.casasbahia.com.br') || str_starts_with($url, 'https://www.casasbahia.com.br') || str_starts_with($url, 'https://casasbahia.com.br')) {
                $to = RedirectHelper::processAwin($url, 17629);
            } elseif (str_starts_with($url, 'https://www.soubarato.com.br') || str_starts_with($url, 'https://soubarato.com.br')) {
                $to = RedirectHelper::processAwin($url, 23281, env('ID_AFILIADO_B2W'));
            } elseif (str_starts_with($url, 'https://www.submarino.com.br') || str_starts_with($url, 'https://submarino.com.br')) {
                $to = RedirectHelper::processAwin($url, 22195, env('ID_AFILIADO_B2W'));
            } elseif (str_starts_with($url, 'https://www.shoptime.com.br') || str_starts_with($url, 'https://shoptime.com.br')) {
                $to = RedirectHelper::processAwin($url, 22194, env('ID_AFILIADO_B2W'));
            } elseif (str_starts_with($url, 'https://www.americanas.com.br') || str_starts_with($url, 'https://americanas.com.br')) {
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
    #[Route('/redirect', name: 'redirect.page')]
    public function get(): View
    {
        return view('redirect');
    }
}
