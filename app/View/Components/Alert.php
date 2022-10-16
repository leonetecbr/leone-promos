<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Cria uma instância do componente.
     *
     * @param string $message
     * @param string $type
     */
    public function __construct(protected string $message, protected string $type = 'warning')
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
        return view('components.alert', ['type' => $this->type, 'message' => $this->message]);
    }
}
