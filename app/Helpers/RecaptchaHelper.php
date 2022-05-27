<?php

namespace App\Helpers;

use Illuminate\Http\Request;

/**
 * Classe responsável por validar a verificação robótica do ReCaptcha
 */
class RecaptchaHelper
{
    private $response, $ip, $secret, $type;

    /**
     * Preenche as variáveis nescessárias para a verificação
     * @param Illuminate\Http\Request $request
     * @params string $response $type
     */
    public function __construct(Request $request, string $response, string $type = 'v3')
    {
        $this->ip = $request->ip();
        if ($type == 'v3') {
            $this->secret = env('SECRET_RECAPTCHA_V3');
        } else {
            $this->secret =  env('SECRET_RECAPTCHA_V2');
        }
        $this->response = $response;
    }

    /**
     * Faz a consulta na API
     * @return array
     */
    private function getApi(): array
    {
        $dados = array(
            "secret" => $this->secret,
            "response" => $this->response,
            "remoteip" => $this->ip
        );
        $curlReCaptcha = curl_init();
        $options = [
            CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($dados),
            CURLOPT_RETURNTRANSFER => true
        ];
        curl_setopt_array($curlReCaptcha, $options);
        $result = json_decode(curl_exec($curlReCaptcha), true);
        curl_close($curlReCaptcha);
        return $result;
    }

    /**
     * Direciona a verificação robótica para o método correto
     * @param float $min
     * @return bool
     */
    public function isOrNot(float $min = 0.6): bool
    {
        if (env('APP_DEBUG')) : return false;
        endif;
        if ($this->type == 'v3') {
            return $this->isOrNotV3($min);
        } else {
            return $this->isOrNotV2();
        }
    }

    /**
     * Faz a validação usando a API V3
     * @param float $min 0 a 1
     * @return bool (false caso não seja um robô)
     */
    private function isOrNotV3(float $min): bool
    {
        $response = $this->getApi();
        if (!empty($response['success'])) {
            if ($response['success'] == 1 && $response['score'] >= $min) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Faz a validação usando a API V2
     * @return bool (false caso não seja um robô)
     */
    private function isOrNotV2(): bool
    {
        $response = $this->getApi();
        if (!empty($response['success'])) {
            if ($response['success'] == 1) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
}
