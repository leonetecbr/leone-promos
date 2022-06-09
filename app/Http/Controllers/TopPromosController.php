<?php

namespace App\Http\Controllers;

use App\Models\Store;
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
        $promo = Promo::find($id);

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
        $promo = Promo::find($id);

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

        $button = '<a href="' . route('promos.new') . '"><button type="submit" class="btn btn-primary text-light mb-4 mt-2 btn-lg w-75">Nova promoção</button></a>';

        return view('promos', ['title' => 'Top Promos', 'subtitle' => 'Top Promos', 'promos' => $promos['offers'], 'catId' => 0, 'page' => 1, 'top' => $top ?? true, 'share' => false, 'add' => $button]);
    }

    /**
     * Salva uma nova promoção ou as alterações de uma existente
     * @param Request $request
     * @return RedirectResponse
     * @throws ErrorException
     * @throws ValidationException
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

        if (empty(Store::find($dados['store_id']))){
            return redirect()->back()->withErrors([
                'store_id' => ['Loja não cadastrada!']
            ])->withInput();
        }

        if (empty(Page::find(9999))) {
            Page::create([
                'id' => 9999,
                'total' => 1
            ]);
        }

        if ($request->filled('id')) {
            $promo = Promo::firstOrNew([
                'id' => $request->input('id')
            ]);

            if (empty($promo->name)) {
                $promo->id = 9 . date('dHis');
            }
        } else {
            $promo = new Promo;
            $promo->id = 9 . date('dHis');
        }

        $promo->name = mb_strimwidth($dados['name'], 0, 60, '...', 'UTF-8');
        $promo->group_id = 9999;
        $promo->store_id = $dados['store_id'];
        $promo->link = ($request->filled('redirect') && !$request->filled('id')) ? '/redirect?url=' . $dados['link'] : $dados['link'];
        $promo->for = $dados['price'];
        $promo->image = $dados['thumbnail'];
        $promo->from = $request->input('priceFrom');
        $promo->code = $request->input('code');
        $promo->description = $request->input('description');
        $promo->installments =  $request->input('installment_value');
        $promo->times = $request->input('installment_quantity');

        if ($promo->save()) {
            if ($request->filled('notification')) {
                $payload = [
                    'title' => $promo->name,
                    'link' => '/#promo-0-1-' . substr($promo->id, -3)
                ];

                if ($promo->for <= 0) {
                    $payload['msg'] = 'Grátis!';
                    $payload['msg'] .= ($promo->description) ? "\n" . mb_strimwidth($promo->description, 0, 60, '...', 'UTF-8') : '';
                } elseif ($promo->from) {
                    $payload['msg'] = 'De: R$' . number_format($promo->from, 2, ',', '.') . "\nPor apenas R$" . number_format($promo->for, 2, ',', '.') . '!';
                } else {
                    $payload['msg'] = 'Por apenas R$' . number_format($promo->for, 2, ',', '.') . '!';
                    $payload['msg'] .= ($promo->description) ? "\n" . mb_strimwidth($promo->description, 0, 60, '...', 'UTF-8') : '';
                }

                if ($promo->image) {
                    $payload['img'] = $promo->image;
                }

                $success = $this->sendNotification($request, $payload);
            } else {
                $success = true;
            }
            if ($success) {
                return redirect()->route('promos.list');
            } else {
                return redirect()->route('promos.list')->withErrors([
                    'notification' => ['Erro ao enviar a notificação para um ou mais destinatários!']
                ]);
            }
        } else {
            return redirect()->back()->withErrors([
                'form' => ['Erro ao salvar!']
            ])->withInput();
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
