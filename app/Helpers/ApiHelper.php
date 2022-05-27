<?php

namespace App\Helpers;

use Exception;
use App\Models\Promo;
use App\Models\Page;
use App\Models\Store;
use App\Models\Cupom;
use App\Helpers\CsvHelper;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Obtém dados das API ou do Cache
 */
class ApiHelper
{
    /**
     * Id da categoria
     * @var int
     */
    private static int $id;

    /**
     * Página atual
     * @var int
     */
    private static int $page;

    /**
     * Id da loja
     * @var int
     */
    private static int $loja;

    /**
     * Id do grupo (id categoria ou da loja)
     * @var int
     */
    private static int $group_id;

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
        $cupons = array_merge_recursive($awin, $lomadee['coupons']);

        if ($exists) {
            Cupom::truncate();
        }

        $lojas = [];
        $a = 0;
        for ($i = 0; $i < count($cupons); $i++) {
            $store_id = $cupons[$i]['store']['id'];
            if (!array_key_exists($store_id, $lojas)) {
                $store = Store::where('id', $store_id)->take(1);
                if (!$store->exists()) {
                    $s = new Store();
                    $s->id = $store_id;
                    $s->nome = $cupons[$i]['store']['name'];
                    $s->link = $cupons[$i]['store']['link'];
                    $s->imagem =  $cupons[$i]['store']['image'];
                    $s->save();
                } else {
                    $s = $store->first();
                }
                $lojas[$store_id] = $s->toArray();
            }

            $c = new Cupom();
            $c->code = $cupons[$i]['code'];
            $c->link = $cupons[$i]['link'];
            $c->desc = mb_strimwidth($cupons[$i]['description'], 0, 60, '...', 'UTF-8');
            $c->ate = str_replace(":59:00", ":59:59", $cupons[$i]['vigency']);
            $c->store_id = $cupons[$i]['store']['id'];
            $c->save();
            if ($loja == 0) {
                if (($i >= (self::$page - 1) * 18) && ($i < self::$page * 18)) {
                    $cupom['coupons'][$a] = $c->toArray();
                    $cupom['coupons'][$a]['store'] = $lojas[$store_id];
                    $a++;
                }
            } elseif ($loja == $cupons[$i]['store']['id']) {
                $cupom['coupons'][$a] = $c->toArray();
                $cupom['coupons'][$a]['store'] = $lojas[$store_id];
                $a++;
            }
        }

        $cupom['totalPage'] = ($loja == 0) ? ceil($i / 18) : ceil($i / 18);
        $cupom['store'] = $store;
        return $cupom;
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

        if (empty(Page::where('id', self::$group_id)->first())) {
            $p = new Page();
            $p->id = self::$group_id;
            $p->total = $dados['pagination']['totalPage'];
            $p->save();
        }
        if ($exists) {
            Promo::where('group_id', self::$group_id)->where('page', self::$page)->take(12)->delete();
        }
        $lojas = [];
        $promotions = [];
        for ($i = 0; $i < count($promos); $i++) {
            $store_id = $promos[$i]['store']['id'];
            if (!array_key_exists($store_id, $lojas)) {
                $store = Store::where('id', $store_id)->take(1);
                if (!$store->exists()) {
                    $s = new Store();
                    $s->id = $store_id;
                    $s->nome = $promos[$i]['store']['name'];
                    $s->link = $promos[$i]['store']['link'];
                    $s->imagem =  $promos[$i]['store']['thumbnail'];
                    $s->save();
                } else {
                    $s = $store->first();
                }
                $lojas[$store_id] = $s->toArray();
            }

            $p = new Promo();
            if (is_numeric($promos[$i]['id'])) {
                $p->id = self::$group_id . $promos[$i]['id'];
            } else {
                $p->id = 9 . date('His') . $i;
            }
            $p->group_id = self::$group_id;
            $p->store_id = $store_id;
            $p->nome = mb_strimwidth($promos[$i]['name'], 0, 60, '...', 'UTF-8');
            $p->link = $promos[$i]['link'];
            $p->imagem = $promos[$i]['thumbnail'];
            if ($promos[$i]['discount'] > 0) {
                $p->de = $promos[$i]['priceFrom'];
            }
            $p->por = $promos[$i]['price'];
            $p->vezes = $promos[$i]['installment']['quantity'] ?? NULL;
            $p->parcelas = $promos[$i]['installment']['value'] ?? NULL;
            $p->page = self::$page;
            $p->save();
            $promotions['offers'][$i] = $p->toArray();
            $promotions['offers'][$i]['store'] = $lojas[$store_id];
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
        $dados = ['sourceId' => $_ENV['SOURCE_ID_LOMADEE']];
        if (self::$loja !== 0) {
            $dados['storeId'] = self::$loja;
        }
        if (self::$id === 999) {
            $dados['page'] = self::$page;
            $url = $_ENV['API_URL_LOMADEE'] . '/v3/' . $_ENV['APP_TOKEN_LOMADEE'] . '/offer/_store/' . self::$loja . '?' . http_build_query($dados);
        } elseif (self::$id !== 0) {
            $dados['page'] = self::$page;
            $url = $_ENV['API_URL_LOMADEE'] . '/v3/' . $_ENV['APP_TOKEN_LOMADEE'] . '/offer/_category/' . self::$id . '?' . http_build_query($dados);
        } else {
            $url = $_ENV['API_URL_LOMADEE'] . '/v2/' . $_ENV['APP_TOKEN_LOMADEE'] . '/coupon/_all?' . http_build_query($dados);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (empty($json) || $status !== 200) {
            throw new Exception('Parece que tivemos um probleminha, que tal tentar de novo ?');
        }
        return json_decode($json, true);
    }

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
        $group_id = ($loja == 0) ? $id : $loja;
        $promos = ($id == 9999) ? Promo::where('group_id', $group_id)->where('page', $page)->take(12)->orderBy('created_at', 'DESC') : $promos = Promo::where('group_id', $group_id)->where('page', $page)->take(12);

        if ($promos->exists()) {
            $promos = $promos->get();

            if (time() - strtotime($promos[0]->created_at) > 86400 && $id !== 9999) {
                self::$id = $id;
                self::$page = $page;
                self::$loja = $loja;
                self::$group_id = $group_id;
                return self::toCachedPromos(true);
            }

            $store = [];
            for ($i = 0; $i < count($promos); $i++) {
                $promotions['offers'][$i] = $promos[$i]->toArray();
                if ($loja !== 0) {
                    if (empty($store)) {
                        $store = Store::where('id', $promos[$i]->store_id)->first()->toArray();
                    }
                    $promotions['offers'][$i]['store'] = $store;
                } else {
                    if (empty($store)) {
                        $store[$promos[$i]->store_id] =
                            Store::where('id', $promos[$i]->store_id)->first()->toArray();
                        $promotions['offers'][$i]['store'] = $store[$promos[$i]->store_id];
                    } else {
                        if (array_key_exists($promos[$i]->store_id, $store)) {
                            $promotions['offers'][$i]['store'] = $store[$promos[$i]->store_id];
                            continue;
                        } else {
                            $store[$promos[$i]->store_id] =
                                Store::where('id', $promos[$i]->store_id)->first()->toArray();
                            $promotions['offers'][$i]['store'] = $store[$promos[$i]->store_id];
                        }
                    }
                }
            }
            $promotions['totalPage'] = Page::where('id', $promotions['offers'][0]['group_id'])->first()->total;
            return $promotions;
        }
        if ($id == 9999) {
            return ['offers' => []];
        }

        self::$id = $id;
        self::$page = $page;
        self::$loja = $loja;
        self::$group_id = $group_id;
        return self::toCachedPromos();
    }

    /**
     * Pega os cupons da api do Awin em CVS e converte para array
     * @return array
     */
    private static function getAwin(): array
    {
        $cupom = [];
        $dado = CsvHelper::readCSV($_ENV['API_URL_CSV_AWIN']);
        $a = 0;
        for ($i = 0; !empty($dado[$i][1]); $i++) {
            /**if ($dado[$i][1] === 'Aliexpress BR & LATAM') {
        $cupom[$a] = [
          'code' => $dado[$i][4],
          'vigency' => $dado[$i][7],
          'description' => $dado[$i][5],
          'link' => $dado[$i][11],
          'store' => [
            'image' => 'https://ae01.alicdn.com/kf/H2111329c7f0e475aac3930a727edf058z.png',
            'name' => 'Aliexpress',
            'id' => 1,
            'link' => '/redirect?url=https%3A%2F%2Fpt.aliexpress.com%2F'
          ]
        ];
        $a++;
      } else**/ if ($dado[$i][1] === 'Casas Bahia BR') {
                $cupom[$a] = [
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
                $cupom[$a] = [
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
                $cupom[$a] = [
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

        return $cupom;
    }

    /**
     * Verifica se os cupons salvos no banco ainda estão adequados para uso, se sim, os usa, se não pega da API
     * @param int $page
     * @param int $loja
     * @return array
     */
    public static function getCupons(int $page, int $loja = 0): array
    {
        if (empty(Cupom::where('id', 1)->first())) {
            self::$page = $page;
            return self::toCachedCoupons($loja);
        } else {
            $cupons = ($loja == 0) ? Cupom::paginate(18, '*', 'cupons', $page) : Cupom::where('store_id', $loja)->get();
            if (empty($cupons[0]->id)) {
                return [];
            }
            if (time() - strtotime($cupons[0]->created_at) > 86400) {
                self::$page = $page;
                return self::toCachedCoupons($loja, true);
            }
            $cupom['totalPage'] =  ($loja == 0) ? $cupons->lastPage() : 1;
            $cupons = ($loja == 0) ? $cupons->items() : $cupons;
            $a = 0;
            $store = [];
            for ($i = 0; $i < count($cupons); $i++) {
                $cupom['coupons'][$a] = $cupons[$i]->toArray();
                if (empty($store)) {
                    $store[$cupons[$i]->store_id] =
                        Store::where('id', $cupons[$i]->store_id)->first()->toArray();
                    $cupom['coupons'][$a]['store'] = $store[$cupons[$i]->store_id];
                } else {
                    if (array_key_exists($cupons[$i]->store_id, $store)) {
                        $cupom['coupons'][$a]['store'] = $store[$cupons[$i]->store_id];
                        $a++;
                        continue;
                    } else {
                        $store[$cupons[$i]->store_id] =
                            Store::where('id', $cupons[$i]->store_id)->first()->toArray();
                        $cupom['coupons'][$a]['store'] = $store[$cupons[$i]->store_id];
                    }
                }
                $a++;
            }
        }

        $cupom['store'] = $store;
        return $cupom;
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
            'sourceId' => $_ENV['SOURCE_ID_LOMADEE'],
            'page' => $page
        ];

        if (!empty($order)) {
            $dados['sort'] = ($order == 'discount') ? 'discount' : 'price';
        }

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
        curl_setopt($ch, CURLOPT_URL, $_ENV['API_URL_LOMADEE'] . '/v3/' . $_ENV['APP_TOKEN_LOMADEE'] . '/offer/_search?' . http_build_query($dados));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (empty($json) || $status !== 200) {
            throw new Exception('Parece que tivemos um probleminha, que tal tentar de novo, escrevendo de outra forma ?');
        }

        $dados = json_decode($json, true);

        $promos = $dados['offers'];

        for ($i = 0; $i < count($promos); $i++) {
            $promo['offers'][$i] = [
                'nome' => $promos[$i]['name'],
                'store' => [
                    'nome' => $promos[$i]['store']['name'],
                    'imagem' => $promos[$i]['store']['thumbnail'],
                    'link' => $promos[$i]['store']['link']
                ],
                'link' => $promos[$i]['link'],
                'imagem' => $promos[$i]['thumbnail'],
                'de' => $promos[$i]['priceFrom'] ?? NULL,
                'por' => $promos[$i]['price'],
                'vezes' => $promos[$i]['installment']['quantity'] ?? NULL,
                'parcelas' => $promos[$i]['installment']['value'] ?? NULL
            ];
        }

        $promo['totalPage'] = $dados['pagination']['totalPage'];
        return $promo;
    }
}
