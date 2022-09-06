<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\TopStores;

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
        if (!str_starts_with($url, 'https://www.magazinevoce.com.br')) {
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
            $uid = env('ID_AFILIADO_AWIN');
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
        return 'https://redir.lomadee.com/v2/deeplink?sourceId=' . env('SOURCE_ID_LOMADEE') . '&url=' . urlencode($url);
    }

    /**
     * Encontra o link da página da ofertas
     *
     * @paramint $catId
     * @paramint $page
     * @paramint|null $ofertaId
     * @param int $catId
     * @param int $page
     * @param int|null $ofertaId
     * @param bool|null $pageNumber
     * @return string
     */
    public static function processPage(int $catId, int $page, ?int $ofertaId = null, ?bool $pageNumber = false): string
    {
        if ($catId !== 0) {
            $data = Category::find($catId);
            if (empty($data)) {
                $data = TopStores::find($catId);
                if (empty($data)): return ''; endif;
                $path = 'lojas/' . $data['name'];
            } else {
                $path = 'categorias/' . $data['name'];
            }
        } else {
            $path = '';
        }

        $path .= ($page === 1 && !$pageNumber) ? '' : '/' . $page;

        if ($ofertaId) {
            $path .= '#promo-' . $catId . '-' . $page . '-' . $ofertaId;
        }

        return $path;
    }
}
