<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateRequest;
use App\Models\Promotion;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class PromotionsController extends Controller
{
    /**
     * Lista as promoções
     */
    #[Route('/admin/promotions', name: 'promotions.index')]
    public function index(): View
    {
        $promotions = Promotion::with('store:id,name,image,link')
                                ->orderByDesc('is_top')
                                ->orderByDesc('created_at')
                                ->paginate(12);

        $title = 'Gerenciar promoções';
        $manage = true;

        return view('promotions', compact('title', 'manage', 'promotions'));
    }

    /**
     * Cria uma promoção
     */
    #[Route('/admin/promotions/create', name: 'promotions.create')]
    public function create(): View
    {
        $stores = Store::select('id', 'name')->get();

        $title = 'Nova promoção';

        return view('admin.promotions', compact('title', 'stores'));
    }

    /**
     * Salva uma nova promoção
     */
    #[Route('/admin/promotions', name: 'promotions.store')]
    public function store(StoreOrUpdateRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['redirect', 'notification']);

        $this->processRedirect($data, $request);;

        Promotion::create($data);

        if ($request->filled('notification')) {
            // TODO: Send Notification
        }

        return to_route('promotions.index')->with('success', 'Promoção criada com sucesso!');
    }

    /**
     * Edita uma promoção
     */
    #[Route('/admin/promotions/{promotion}/edit', name: 'promotions.edit')]
    public function edit(Promotion $promotion): View|RedirectResponse
    {
        $stores = Store::select('id', 'name')->get();

        $title = 'Editar promoção';

        return view('admin.promotions', compact('title', 'stores', 'promotion'));
    }

    /**
     * Salva as alterações de uma promoção existente
     */
    #[Route('/admin/promotions/{promotion}', name: 'promotions.update')]
    public function update(StoreOrUpdateRequest $request, Promotion $promotion): RedirectResponse
    {
        $data = $request->safe()->except('redirect');

        $this->processRedirect($data, $request);;

        if (!$request->filled('is_top')) {
            $data['is_top'] = 0;
        }

        $promotion->update($data);

        return to_route('promotions.index')->with('success', 'Promoção atualizada com sucesso!');
    }

    private function processRedirect(&$data, &$request): void
    {
        if ($request->filled('redirect')) {
            $data['link'] = '/redirect?url=' . $data['link'];
        } elseif (str_starts_with($data['link'], '/redirect?url=')) {
            $data['link'] = substr($data['link'], 14);
        }
    }

    /**
     * Apaga uma promoção
     */
    #[Route('/admin/promotions/{promotion}', name: 'promotions.destroy')]
    public function destroy(Promotion $promotion): RedirectResponse
    {
        $promotion->delete();

        return to_route('promotions.index')->with('success', 'Promoção excluída com sucesso!');
    }
}
