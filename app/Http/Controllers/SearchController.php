<?php

namespace App\Http\Controllers;

use App\Helpers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Exception;

class SearchController extends Controller
{

    /**
     * Faz pesquisas na API da Lomadee
     * @param Request $request
     * @param string $q
     * @param integer $page
     * @return View
     */
    public static function search(Request $request, string $q, int $page = 1): View
    {
        try {
            if (empty($q) || mb_strlen($q, 'UTF-8') < 3 || mb_strlen($q, 'UTF-8') > 20) {
                throw new Exception('Pesquisa inválida!');
            }

            $g_response = $request->input('g-recaptcha-response');
            if (empty($g_response) || strlen($g_response) < 20) {
                throw new Exception('Não temos certeza que você não é um robô, marque a caixa de verificação abaixo para continuar com sua pesquisa:', 499);
            }

            $type = $request->input('type', 'v3');
            $robot = new Helpers\RecaptchaHelper($request, $g_response, $type);

            $isRobot = $robot->isOrNot();

            if ($isRobot) {
                throw new Exception('Não temos certeza que você não é um robô, marque a caixa de verificação abaixo para continuar com sua pesquisa:', 499);
            }

            $dado = Helpers\ApiHelper::search($request, $q, $page);
            $ofertas = $dado['offers'];
            $pages = $dado['totalPage'];
            $subtitle = 'Pesquisa por "' . $q . '"';
            $title = 'Pesquisa: "' . $q . '" - Página ' . $page . ' de ' . $pages;
        } catch (Exception $e) {
            $title = 'Erro encontrado';
            if ($e->getCode() === 499) {
                $ofertas = '<p class="fs-4 text-danger my-3">' . $e->getMessage() . '</p>
        <div class="text-center mt-2"><form id="checkbox" method="post"><input type="hidden" name="type" value="v2"><div class="g-recaptcha" data-sitekey="' . $_ENV['PUBLIC_RECAPTCHA_V2'] . '" data-callback="submit"></div></form></div>';
                $headers = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            } else {
                $ofertas = '<p class="fs-4 text-danger mt-3">' . $e->getMessage() . '</p>';
            }
            $subtitle = 'Erro encontrado!';
        } finally {
            return view('promos', ['title' => $title, 'subtitle' => $subtitle, 'promos' => $ofertas, 'final' => $pages ?? '', 'topo' => $topo ?? true, 'headers' => $headers ?? '', 'cat_id' => 0, 'page' => $page, 'query' => $q, 'robots' => 'noindex', 'isLoja' => false, 'group_name' => $q, 'share' => false]);
        }
    }
}
