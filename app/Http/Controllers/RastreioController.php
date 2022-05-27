<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Helpers\RecaptchaHelper;

class RastreioController extends Controller
{

    /**
     * Gera a página de rastreio de pedidos
     * @returns View
     */
    public function get(): View
    {
        return view('rastreio');
    }

    /**
     * Responde à solicitação de rastreio com os dados do rastreamento
     * @param Request $request
     * @return array
     */
    public function post(Request $request): array
    {
        $response['success'] = false;
        try {
            $validator = Validator::make($request->all(), [
                'codigo' => 'required|size:13',
                'g-recaptcha-response' => 'required|min:12'
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors()->all()[0], 400);
            }

            $token = $request->input('g-recaptcha-response');
            $recaptcha = new RecaptchaHelper($request, $token);

            if ($recaptcha->isOrNot()) {
                throw new Exception('Talvez você seja um robô, tente novamente mais tarde!');
            }

            $codigo = strtoupper($request->input('codigo'));

            $rastreio = json_decode(file_get_contents('https://proxyapp.correios.com.br/v1/sro-rastro/' . $codigo), true)['objetos'][0];
            $aviso = $rastreio['mensagem'] ?? '';

            if (!empty($aviso)) {
                $mensagem = ltrim(explode(':', $aviso)[1]);
                throw new Exception($mensagem, 400);
            }

            $rastreamento['codObjeto'] = $rastreio['codObjeto'];
            $rastreamento['eventos'] = $rastreio['eventos'];
            $rastreamento['tipoPostal'] = $rastreio['tipoPostal']['categoria'];
            $rastreamento['dtPrevista'] = $rastreio['dtPrevista'] ?? '';

            $response['rastreio'] = $rastreamento;
            $response['success'] = true;
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = $e->getCode();
        } finally {
            return $response;
        }
    }
}
