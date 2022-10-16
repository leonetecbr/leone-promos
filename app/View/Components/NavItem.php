<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavItem extends Component
{
    /**
     * Cria uma instância do componente.
     *
     * @param string $route
     * @param string $title
     */
    public function __construct(protected string $route, protected string $title)
    {
        //
    }

    /**
     * Obtém a visualização do componente
     *
     * @return View
     */
    public function render(): View
    {
        $isActive = request()->routeIs($this->route);
        $url = route($this->route);

        return view('components.nav-item', [
            'isActive' => $isActive,
            'url' => $url,
            'title' => $this->title,
        ]);
    }
}
