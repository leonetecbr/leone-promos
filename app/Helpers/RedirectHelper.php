<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\TopStores;
use Exception;

class RedirectHelper
{
    /**
     * Gera os links de afiliado para produtos da Magazine Luiza
     * @param string $url
     * @return string
     */
    public static function processMagalu(string $url): string
    {
        $partes = explode('/', $url, 7);
        if (strpos($url, 'https://www.magazinevoce.com.br') !== 0) {
            return 'https://www.magazinevoce.com.br/magazineofertasleone/p/' . $partes[3] . '/' . $partes[5];
        } else {
            $partes[3] = 'magazineofertasleone';
            return implode('/', $partes);
        }
    }

    /**
     *  Gera os links de afiliado para as lojas parceira pelo awin, por enquanto apenas Aliexpress, Extra, Ponto e Casas Bahia
     * @param string $url
     * @param int $advertiserId
     * @param int|null $uid
     * @return string
     */
    public static function processAwin(string $url, int $advertiserId, int $uid = null): string
    {
        if (empty($uid)) {
            $uid = $_ENV['ID_AFILIADO_AWIN'];
        }

        return 'https://www.awin1.com/cread.php?awinmid=' . $advertiserId . '&awinaffid=' . $uid . '&clickref=deeplink&ued=' . urlencode($url);
    }

    /**
     * Gera os links de afiliado para produtos das demais lojas parceiras pela Lomadee
     * @param string $url
     * @return string
     */
    public static function processLomadee(string $url): string
    {
        return 'https://redir.lomadee.com/v2/deeplink?sourceId=' . $_ENV['SOURCE_ID_LOMADEE'] . '&url=' . urlencode($url);
    }

    /**
     * Encontra o link da página da ofertas
     *
     * @param integer $catId
     * @param integer $page
     * @param null|integer $ofertaId
     * @return string
     * @throws Exception
     */
    public static function processPage(int $catId, int $page, ?int $ofertaId = null): string
    {
        if ($catId !== 0) {
            $data = Category::find($catId);
            if (empty($data)) {
                $data = TopStores::find($catId);
                if (empty($data)): return ''; endif;
                $path = 'lojas/'.$data['name'];
            }else{
                $path = 'categorias/'.$data['name'];
            }
        } else{
            $path = '';
        }

        $path .= ($page === 1) ? '' : '/' . $page;

        if ($ofertaId) {
            $path .= '#promo-' . $catId . '-' . $page . '-' . $ofertaId;
        }

        return $path;
    }
}
