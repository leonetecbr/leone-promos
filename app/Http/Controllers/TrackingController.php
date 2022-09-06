<?php

namespace App\Http\Controllers;

use App\Exceptions\RequestException;
use App\Helpers\RecaptchaHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Routing\Annotation\Route;

class TrackingController extends Controller
{

    /**
     * Gera a página de track de pedidos
     * @returns View
     */
    #[Route('/rastreio', name: 'rastreio')]
    public function get(): View
    {
        return view('tracking');
    }

    /**
     * Responde à solicitação de rastreio com os dados do rastreamento
     * @param Request $request
     * @return array
     */
    #[Route('/api/v1/rastreio', name: 'rastreio.api')]
    public function post(Request $request): array
    {
        $response['success'] = false;
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required|size:13',
                'g-recaptcha-response' => 'required|min:12'
            ]);

            if ($validator->fails()) {
                throw new RequestException($validator->errors()->all()[0], 400);
            }

            $token = $request->input('g-recaptcha-response');
            $recaptcha = new RecaptchaHelper($request, $token);

            if ($recaptcha->isOrNot()) {
                throw new RequestException('Talvez você seja um robô, tente novamente mais tarde!');
            }

            $code = strtoupper($request->input('code'));

            $track = json_decode(file_get_contents('https://proxyapp.correios.com.br/v1/sro-rastro/' . $code), true)['objetos'][0];
            $message = $track['mensagem'] ?? '';

            if (!empty($message)) {
                $message = ltrim(explode(':', $message)[1]);
                throw new RequestException($message, 400);
            }

            $tracking['codObjeto'] = $track['codObjeto'];
            $tracking['eventos'] = $track['eventos'];
            $tracking['tipoPostal'] = $track['tipoPostal']['categoria'];
            $tracking['dtPrevista'] = $track['dtPrevista'] ?? '';

            $response['track'] = $tracking;
            $response['success'] = true;
        } catch (RequestException $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = $e->getCode();
        } finally {
            return $response;
        }
    }
}
