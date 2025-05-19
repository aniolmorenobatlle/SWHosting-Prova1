<?php

namespace App\Livewire;

use Livewire\Component;

class Cercador extends Component
{
    public string $domini = '';

    public function validarICANN($domini): bool
    {
        return preg_match('/^(?!-)[A-Za-z0-9-]{1,63}(?<!-)$/', $domini);
    }

    public function enviarDomini()
    {
        $net = trim($this->domini);
        $net = explode('.', $net)[0] ?? $net;

        if (!$this->validarICANN($net)) {
            $this->addError('domini', 'El nom del domini no és vàlid segons la normativa ICANN');
            return;
        }

        $this->resetErrorBag('domini');
        $this->dispatch('domini', $net);
    }

    public function render()
    {
        return view('livewire.cercador');
    }
}
