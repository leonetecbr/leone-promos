<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{

    /**
     * Faz pesquisas na API da Lomadee
     * @param Request $request
     * @param string $query
     * @param integer $page
     * @return View
     * @throws Exception
     */
    public static function search(Request $request, string $query, int $page = 1): View
    {
        try {
            $recaptchaResponse = $request->input('g-recaptcha-response');

            $validator = Validator::make([
                'query' => $query,
                'g-recaptcha-response' => $recaptchaResponse
            ], [
                'query' => 'required|min:3|max:20',
                'g-recaptcha-response' => 'required|min:20'
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                $code = ($errors->has('g-recaptcha-response')) ? 401 : 400;
                throw new RequestException($errors->all()[0], $code);
            }

            $type = $request->input('type', 'v3');
            $robot = new Helpers\RecaptchaHelper($request, $recaptchaResponse, $type);

            $isRobot = $robot->isOrNot();

            if ($isRobot) {
                throw new RequestException('Não temos certeza que você não é um robô, marque a caixa de verificação abaixo para continuar com sua pesquisa:', 401);
            }

            $data = Helpers\ApiHelper::search($request, $query, $page);
            $offers = $data['offers'];
            $endPage = $data['totalPage'];
            $subtitle = 'Pesquisa por "' . $query . '"';
            $title = 'Pesquisa: "' . $query . '" - Página ' . $page . ' de ' . $endPage;
        } catch (RequestException $e) {
            $title = 'Erro encontrado';
            if ($e->getCode() === 401) {
                $offers = '<div class="alert alert-danger fs-4 text-center mt-3">' . $e->getMessage() . '</div>
        <div class="mt-4 mx-auto mw-304">
            <form id="checkbox" method="post">
                <input type="hidden" name="type" value="v2">
                <div class="g-recaptcha" data-sitekey="' . env('PUBLIC_RECAPTCHA_V2') . '" data-callback="submit"></div>
            </form>
        </div>';
                $headers = '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
            } else {
                $offers = '<div class="alert alert-danger fs-4 mt-3 text-center">' . $e->getMessage() . '</div>';
            }
            $subtitle = 'Erro encontrado!';
        } finally {
            return view('promos', [
                'title' => $title,
                'subtitle' => $subtitle,
                'promos' => $offers,
                'endPage' => $endPage ?? '',
                'top' => $top ?? true,
                'headers' => $headers ?? '',
                'catId' => 0,
                'page' => $page,
                'query' => $query,
                'robots' => 'noindex',
                'isLoja' => false,
                'groupName' => $query,
                'share' => false
            ]);
        }
    }
}
