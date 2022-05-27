<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Helpers;
use App\Models\Promo;
use App\Models\Page;
use App\Models\Notification;
use Illuminate\Validation\ValidationException;

class TopPromosController extends Controller
{

    /**
     * Gera a página para edição de uma promoção
     * @param integer $id
     * @return View|RedirectResponse
     */
    public function edit(int $id)
    {
        $promo = Promo::where('id', $id)->first();

        if (empty($promo)) {
            return redirect()->route('promos.list')->withErrors([
                'promo' => ['A promoção solicitada não existe!']
            ]);
        } else {
            $promo = $promo->toArray();
            $promo['redirect'] = (strpos($promo['link'], '/redirect?url=') === 0) ? 'checked' : '';
            $title = 'Editar promoção';
        }

        return view('admin.promo', ['title' => $title, 'promo' => $promo, 'id' => $id]);
    }


    /**
     * Gera a página para a criação de uma promoção
     * @returns View
     */
    public function new(): View
    {
        return view('admin.promo', ['title' => 'Nova promoção']);
    }

    /**
     * Deleta uma promoção
     * @param integer $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $promo = Promo::where('id', $id)->first();

        if (empty($promo)) {
            return redirect()->route('promos.list')->withErrors([
                'promo' => ['A promoção solicitada não existe!']
            ]);
        }

        $promo->delete();

        return redirect()->route('promos.list');
    }

    /**
     * Lista as melhores promoções
     * @returns View
     */
    public function list(): View
    {
        $promos = Helpers\ApiHelper::getPromo(9999);
        for ($i = 0; $i < count($promos['offers']); $i++) {
            $promos['offers'][$i]['link'] = '/admin/promos/edit/' .  $promos['offers'][$i]['id'];
            $promos['offers'][$i]['store']['link'] = '/admin/promos/edit/' . $promos['offers'][$i]['id'];
        }

        $botao = '<a href="' . route('promos.new') . '"><button type="submit" class="btn btn-primary text-light mb-4 mt-2 btn-lg w-75">Nova promoção</button></a>';

        return view('promos', ['title' => 'Top Promos', 'subtitle' => 'Top Promos', 'promos' => $promos['offers'], 'cat_id' => 0, 'page' => 1, 'topo' => $topo ?? true, 'share' => false, 'add' => $botao]);
    }

    /**
     * Salva uma nova promoção ou as alterações de uma existente
     * @param Request $request
     * @throws ValidationException
     * @returns RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $dados = $this->validate($request, [
            'name' => 'required',
            'link' => 'required',
            'thumbnail' => 'required',
            'price' => 'required',
            'store_id' => 'required'
        ]);

        $pages = Page::where('id', 9999)->first();

        if (empty($pages)) {
            $pages = new Page();
            $pages->id = 9999;
            $pages->total = 1;
            $pages->save();
        }

        if ($request->filled('id')) {
            $p = Promo::where('id', $request->input('id'))->first();
            if (empty($p)) {
                $p = new Promo();
                $p->id = 9 . date('dHis');
            }
        } else {
            $p = new Promo();
            $p->id = 9 . date('dHis');
        }

        $p->nome = mb_strimwidth($dados['name'], 0, 60, '...', 'UTF-8');
        $p->group_id = 9999;
        $p->store_id = $dados['store_id'];
        $p->link = ($request->filled('redirect') && !$request->filled('id')) ? '/redirect?url=' . $dados['link'] : $dados['link'];
        $p->por = $dados['price'];
        $p->imagem = $dados['thumbnail'];
        $p->de = $request->input('priceFrom');
        $p->code = $request->input('code');
        $p->desc = $request->input('description');
        $p->parcelas =  $request->input('installment_value');
        $p->vezes = $request->input('installment_quantity');

        if ($p->save()) {
            if ($request->filled('notify')) {
                $payload = [
                    'title' => $p->nome,
                    'link' => '/#promo-0-1-' . substr($p->id, -3)
                ];

                if ($p->por <= 0) {
                    $payload['msg'] = 'Grátis!';
                    $payload['msg'] .= ($p->desc) ? "\n" . mb_strimwidth($p->desc, 0, 60, '...', 'UTF-8') : '';
                } elseif ($p->de) {
                    $payload['msg'] = 'De: R$' . number_format($p->de, 2, ',', '.') . "\nPor apenas R$" . number_format($p->por, 2, ',', '.') . '!';
                } else {
                    $payload['msg'] = 'Por apenas R$' . number_format($p->por, 2, ',', '.') . '!';
                    $payload['msg'] .= ($p->desc) ? "\n" . mb_strimwidth($p->desc, 0, 60, '...', 'UTF-8') : '';
                }

                if ($p->imagem) {
                    $payload['img'] = $p->imagem;
                }

                $success = $this->sendNotification($request, $payload);
            } else {
                $success = true;
            }
            if ($success) {
                return redirect()->route('promos.list');
            } else {
                return redirect()->route('promos.list')->withErrors([
                    'notify' => ['Erro ao enviar a notificação para um ou mais destinatários!']
                ]);
            }
        } else {
            return redirect()->route('promos.list')->withErrors([
                'store_id' => ['Erro ao salvar, provável erro no store_id!']
            ]);
        }
    }

    /**
     * Gera a payload da notificação que será enviada
     * @param Request $request
     * @param array $payload
     * @return boolean
     * @throws ErrorException
     */
    private function sendNotification(Request $request, array $payload): bool
    {
        $todos = $request->input('para', false);

        $notification = new Helpers\NotificationHelper;

        if (!$todos) {
            for ($i = 1; $i <= 9; $i++){
                if ($request->filled('p'.$i)) {
                    if (empty($where)) {
                        $where = 'p'.$i.' = 1';
                    } else {
                        $where .= ' or p'.$i.' = 1';
                    }
                }
            }

            if (empty($where)) {
                return false;
            } else {
                $subscriptions = Notification::whereRaw($where)->get();

                $to = [];
                foreach ($subscriptions as $subscription) {
                    $to[] = $subscription->toArray();
                }
                $success = $notification->sendManyNotifications($to, $payload);
            }
        } else {
            $to = [];
            $subscriptions = Notification::all();
            foreach ($subscriptions as $subscription) {
                $to[] = $subscription->toArray();
            }
            $success = $notification->sendManyNotifications($to, $payload);
        }

        return $success;
    }
}
