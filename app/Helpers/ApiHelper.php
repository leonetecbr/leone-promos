<?php

namespace App\Helpers;

use App\Exceptions\RequestException;
use App\Models\Coupon;
use App\Models\Page;
use App\Models\Promo;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;

/**
 * Obtém dados das API ou do banco de dados
 */
class ApiHelper
{
    /**
     * Id da categoria
     * @var int $id
     */
    private static int $id;

    /**
     * Página atual
     * @var int $page
     */
    private static int $page;

    /**
     * Id da loja
     * @var int $store
     */
    private static int $store;

    /**
     * Id do grupo (id categoria ou da loja)
     * @var int $groupId
     */
    private static int $groupId;

    /**
     * Verifica se as promoções salvas no banco de dados ainda estão adequadas para uso, se sim, as usa, se não pega da API
     * @param int $id
     * @param int $page
     * @param int $loja
     * @return array|array[]
     * @throws Exception
     */
    public static function getPromo(int $id, int $page = 1, int $loja = 0): array
    {
        $groupId = ($loja == 0) ? $id : $loja;
        $promos = ($id == 9999) ? Promo::where('group_id', $groupId)->where('page', $page)->take(12)->orderBy('created_at', 'DESC') : Promo::where('group_id', $groupId)->where('page', $page)->take(12);
        $promotions = [];

        // Verifica se tem as promoções solicitadas no banco de dados
        if ($promos->exists()) {
            $promos = $promos->get();

            // Verifica se o horário da última atualização é maior que 24 horas atrás
            if (time() - strtotime($promos[0]->created_at) > 86400 && $id !== 9999) {
                self::$id = $id;
                self::$page = $page;
                self::$store = $loja;
                self::$groupId = $groupId;
                return self::toCachedPromos(true);
            }

            $store = [];
            for ($i = 0; $i < count($promos); $i++) {
                $promotions['offers'][$i] = $promos[$i]->toArray();

                // Adiciona informações das lojas
                if ($loja !== 0) {
                    if (empty($store)) {
                        $store = Store::find($promos[$i]->store_id)->toArray();
                    }
                    $promotions['offers'][$i]['store'] = $store;
                } else {
                    if (empty($store)) {
                        $store[$promos[$i]->store_id] = Store::find($promos[$i]->store_id)->toArray();
                    } elseif (!array_key_exists($promos[$i]->store_id, $store)) {
                        $store[$promos[$i]->store_id] = Store::find($promos[$i]->store_id)->toArray();
                    }
                    $promotions['offers'][$i]['store'] = $store[$promos[$i]->store_id];
                }
            }
            $promotions['totalPage'] = Page::find($promotions['offers'][0]['group_id'])->total;
            return $promotions;
        }
        if ($id == 9999) {
            return ['offers' => []];
        }

        self::$id = $id;
        self::$page = $page;
        self::$store = $loja;
        self::$groupId = $groupId;
        return self::toCachedPromos();
    }

    /**
     * Obtém as promoções atualizadas, exclui as antigas e passa as novas para o banco de dados
     * @param bool $exists
     * @return array
     * @throws Exception
     */
    private static function toCachedPromos(bool $exists = false): array
    {
        $dados = self::getAPI();
        $promos = $dados['offers'];

        // Atualiza o número total de páginas
        $page = Page::firstOrNew([
            'id' => self::$groupId
        ]);
        $page->total = $dados['pagination']['totalPage'];
        $page->save();

        // Limpa os itens antigos do banco
        if ($exists) {
            Promo::where('group_id', self::$groupId)->where('page', self::$page)->take(12)->delete();
        }

        $lojas = [];
        $promotions = [];
        for ($i = 0; $i < count($promos); $i++) {
            $storeId = $promos[$i]['store']['id'];

            // Verifica se a loja já está na lista de lojas e adiciona se não tiver// Verifica se a loja já está na lista de lojas e adiciona se não tiver
            if (!array_key_exists($storeId, $lojas)) {
                $store = Store::firstOrNew([
                    'id' => $storeId
                ]);

                if (empty($store->link)) {
                    $store->name = $promos[$i]['store']['name'];
                    $store->link = $promos[$i]['store']['link'];
                    $store->image = $promos[$i]['store']['thumbnail'];
                    $store->save();
                }

                $lojas[$storeId] = $store->toArray();
            }

            $id = (is_numeric($promos[$i]['id'])) ? self::$groupId . $promos[$i]['id'] : 9 . date('His') . $i;

            $from = ($promos[$i]['discount'] > 0) ? $promos[$i]['priceFrom'] : NULL;

            // Insere os dados da promoção no banco
            $promo = Promo::create([
                'id' => $id,
                'group_id' => self::$groupId,
                'store_id' => $storeId,
                'name' => mb_strimwidth($promos[$i]['name'], 0, 60, '...', 'UTF-8'),
                'link' => $promos[$i]['link'],
                'image' => $promos[$i]['thumbnail'],
                'from' => $from,
                'for' => $promos[$i]['price'],
                'times' => $promos[$i]['installment']['quantity'] ?? NULL,
                'installments' => $promos[$i]['installment']['value'] ?? NULL,
                'page' => self::$page
            ]);

            $promotions['offers'][$i] = $promo->toArray();
            $promotions['offers'][$i]['store'] = $lojas[$storeId];
        }
        $promotions['totalPage'] = $dados['pagination']['totalPage'];
        return $promotions;
    }

    /**
     * Pega os cupons ou promoções da API da Lomadee
     * @return array
     * @throws Exception
     */
    private static function getAPI(): array
    {
        $dados = [
            'sourceId' => env('SOURCE_ID_LOMADEE')
        ];

        if (self::$store !== 0) {
            $dados['storeId'] = self::$store;
        }

        // Promoções por loja
        if (self::$id === 999) {
            $dados['page'] = self::$page;
            $url = env('API_URL_LOMADEE') . '/v3/' . env('APP_TOKEN_LOMADEE') . '/offer/_store/' . self::$store . '?' . http_build_query($dados);
        } // Promoções por categoria
        elseif (self::$id !== 0) {
            $dados['page'] = self::$page;
            $url = env('API_URL_LOMADEE') . '/v3/' . env('APP_TOKEN_LOMADEE') . '/offer/_category/' . self::$id . '?' . http_build_query($dados);
        } // Cupons
        else {
            $url = env('API_URL_LOMADEE') . '/v2/' . env('APP_TOKEN_LOMADEE') . '/coupon/_all?' . http_build_query($dados);
        }
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ]);
        $json = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (empty($json) || $status !== 200) {
            throw new RequestException('Parece que tivemos um probleminha, que tal tentar de novo ?');
        }
        return json_decode($json, true);
    }

    /**
     * Verifica se os cupons salvos no banco ainda estão adequados para uso, se sim, os usa, se não pega da API
     * @param int $page
     * @param int $loja
     * @return array
     * @throws Exception
     */
    public static function getCoupons(int $page, int $loja = 0): array
    {
        if (empty(Coupon::find(1))) {
            self::$page = $page;
            self::$store = $loja;
            return self::toCachedCoupons($loja);
        } else {
            $coupons = ($loja == 0) ? Coupon::paginate(18, '*', 'coupons', $page) : Coupon::where('store_id', $loja)->get();

            // Caso não exista cupons cadastrados
            if (empty($coupons[0]->id)) {
                return [];
            }

            // Verifica se o horário da última atualização é maior que 24 horas atrás
            if (time() - strtotime($coupons[0]->created_at) > 86400) {
                self::$page = $page;
                self::$store = $loja;
                return self::toCachedCoupons($loja, true);
            }

            $coupon['totalPage'] = ($loja == 0) ? $coupons->lastPage() : 1;
            $coupons = ($loja == 0) ? $coupons->items() : $coupons;

            // Adiciona informações das lojas
            $store = [];
            for ($i = 0; $i < count($coupons); $i++) {
                $coupon['coupons'][$i] = $coupons[$i]->toArray();
                if (empty($store)) {
                    $store[$coupons[$i]->store_id] = Store::find($coupons[$i]->store_id)->toArray();
                } elseif (!array_key_exists($coupons[$i]->store_id, $store)) {
                    $store[$coupons[$i]->store_id] = Store::find($coupons[$i]->store_id)->toArray();
                }
                $coupon['coupons'][$i]['store'] = $store[$coupons[$i]->store_id];
            }
        }

        return $coupon;
    }

    /**
     * Atualiza os cupons do banco de dados
     * @param int $loja
     * @param bool $exists
     * @return array
     * @throws Exception
     */
    private static function toCachedCoupons(int $loja = 0, bool $exists = false): array
    {
        self::$id = 0;
        $lomadee = self::getAPI();
        $awin = self::getAwin();
        $data = array_merge_recursive($awin, $lomadee['coupons']);

        // Limpa a tabela
        if ($exists) {
            Coupon::truncate();
        }

        $stores = [];
        $a = 0;
        for ($i = 0; $i < count($data); $i++) {
            $storeId = $data[$i]['store']['id'];

            // Verifica se a loja já está na lista de lojas e adiciona se não tiver
            if (!array_key_exists($storeId, $stores)) {
                $store = Store::firstOrNew([
                    'id' => $storeId
                ]);

                if (empty($store->link)) {
                    $store->name = $data[$i]['store']['name'];
                    $store->link = $data[$i]['store']['link'];
                    $store->image = $data[$i]['store']['image'];
                    $store->save();
                }
                $stores[$storeId] = $store->toArray();
            }

            // Insere os dados do cupom no banco
            $coupon = Coupon::create([
                'code' => $data[$i]['code'],
                'link' => $data[$i]['link'],
                'description' => mb_strimwidth($data[$i]['description'], 0, 60, '...', 'UTF-8'),
                'expiration' => str_replace(":59:00", ":59:59", $data[$i]['vigency']),
                'store_id' => $data[$i]['store']['id']
            ]);

            // Verifica se deve filtrar por loja
            if ($loja == 0) {
                if (($i >= (self::$page - 1) * 18) && ($i < self::$page * 18)) {
                    $coupons['coupons'][$a] = $coupon->toArray();
                    $coupons['coupons'][$a]['store'] = $stores[$storeId];
                    $a++;
                }
            } elseif ($loja == $data[$i]['store']['id']) {
                $coupons['coupons'][$a] = $coupon->toArray();
                $coupons['coupons'][$a]['store'] = $stores[$storeId];
                $a++;
            }
        }

        $coupons['totalPage'] = ceil($i / 18);
        $coupons['store'] = $stores;
        return $coupons;
    }

    /**
     * Pega os cupons da api do Awin em CVS e converte para array
     * @return array
     */
    private static function getAwin(): array
    {
        $coupon = [];
        $dado = CsvHelper::readCSV(env('API_URL_CSV_AWIN'));
        $a = 0;
        for ($i = 0; !empty($dado[$i][1]); $i++) {
            /**if ($dado[$i][1] === 'Aliexpress BR & LATAM') {
             * $coupon[$a] = [
             * 'code' => $dado[$i][4],
             * 'vigency' => $dado[$i][7],
             * 'description' => $dado[$i][5],
             * 'link' => $dado[$i][11],
             * 'store' => [
             * 'image' => 'https://ae01.alicdn.com/kf/H2111329c7f0e475aac3930a727edf058z.png',
             * 'name' => 'Aliexpress',
             * 'id' => 1,
             * 'link' => '/redirect?url=https%3A%2F%2Fpt.aliexpress.com%2F'
             * ]
             * ];
             * $a++;
             * } else**/
            if ($dado[$i][1] === 'Casas Bahia BR') {
                $coupon[$a] = [
                    'code' => $dado[$i][4],
                    'vigency' => $dado[$i][7],
                    'description' => ucfirst($dado[$i][5]),
                    'link' => $dado[$i][11],
                    'store' => [
                        'image' => 'https://m.casasbahia.com.br/assets/images/casasbahia-logo-new.svg',
                        'name' => 'Casas Bahia',
                        'id' => 2,
                        'link' => '/redirect?url=https%3A%2F%2Fwww.casasbahia.com.br%2F'
                    ]
                ];
                $a++;
            } elseif ($dado[$i][1] === 'Extra BR') {
                $coupon[$a] = [
                    'code' => $dado[$i][4],
                    'vigency' => $dado[$i][7],
                    'description' => ucfirst($dado[$i][5]),
                    'link' => $dado[$i][11],
                    'store' => [
                        'image' => 'https://m.extra.com.br/assets/images/ic-extra-navbar.svg',
                        'name' => 'Extra',
                        'id' => 3,
                        'link' => '/redirect?url=https%3A%2F%2Fwww.casasbahia.com.br%2F'
                    ]
                ];
                $a++;
            } elseif ($dado[$i][1] === 'Ponto BR') {
                $coupon[$a] = [
                    'code' => $dado[$i][4],
                    'vigency' => $dado[$i][7],
                    'description' => ucfirst($dado[$i][5]),
                    'link' => $dado[$i][11],
                    'store' => [
                        'image' => 'https://m.pontofrio.com.br/assets/images/ic-navbar-logo.svg',
                        'name' => 'Ponto',
                        'id' => 4,
                        'link' => '/redirect?url=https%3A%2F%2Fwww.pontofrio.com.br%2F'
                    ]
                ];
                $a++;
            }
        }

        return $coupon;
    }

    /**
     * Faz a pesquisa nas ofertas usando a API do Lomadee
     * @param Request $request
     * @param string $q
     * @param int $page
     * @return array
     * @throws Exception
     */
    public static function search(Request $request, string $q, int $page): array
    {
        $order = $request->get('order_by');
        $price = $request->get('price');
        $dados = [
            'keyword' => $q,
            'sourceId' => env('SOURCE_ID_LOMADEE'),
            'page' => $page
        ];

        // Verifica se foi definido um filtro de ordenação
        if (!empty($order)) {
            $dados['sort'] = ($order == 'discount') ? 'discount' : 'price';
        }

        // Verifica se foi definido um filtro de preço
        if (!empty($price)) {
            switch ($price) {
                case '0-1':
                    $dados['maxPrice'] = 1;
                    break;

                case '1-10':
                    $dados['minPrice'] = 1;
                    $dados['maxPrice'] = 10;
                    break;

                case '10-50':
                    $dados['minPrice'] = 10;
                    $dados['maxPrice'] = 50;
                    break;

                case '50-100':
                    $dados['minPrice'] = 50;
                    $dados['maxPrice'] = 100;
                    break;

                case '100-500':
                    $dados['minPrice'] = 100;
                    $dados['maxPrice'] = 500;
                    break;

                case '500-1000':
                    $dados['minPrice'] = 500;
                    $dados['maxPrice'] = 1000;
                    break;

                case '1000-':
                    $dados['minPrice'] = 1000;
                    break;
            }
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('API_URL_LOMADEE') . '/v3/' . env('APP_TOKEN_LOMADEE') . '/offer/_search?' . http_build_query($dados));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (empty($json) || $status !== 200) {
            throw new RequestException('Parece que tivemos um probleminha, que tal tentar de novo, escrevendo de outra forma ?');
        }

        $dados = json_decode($json, true);

        $promos = $dados['offers'];

        for ($i = 0; $i < count($promos); $i++) {
            $promo['offers'][$i] = [
                'name' => $promos[$i]['name'],
                'store' => [
                    'name' => $promos[$i]['store']['name'],
                    'image' => $promos[$i]['store']['thumbnail'],
                    'link' => $promos[$i]['store']['link']
                ],
                'link' => $promos[$i]['link'],
                'image' => $promos[$i]['thumbnail'],
                'from' => $promos[$i]['priceFrom'] ?? NULL,
                'for' => $promos[$i]['price'],
                'times' => $promos[$i]['installment']['quantity'] ?? NULL,
                'installments' => $promos[$i]['installment']['value'] ?? NULL
            ];
        }

        $promo['totalPage'] = $dados['pagination']['totalPage'];
        return $promo;
    }
}
