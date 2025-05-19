<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Carrito extends Component
{
    public array $carrito = [];

    public function mount()
    {
        $this->carrito = session()->get('carrito', []);
    }

    #[On('afegirCarrito')]
    public function actualitzarCarrito() {
        $this->carrito = session()->get('carrito', []);
    }

    public function eliminarDelCarrito(string $domini) {
        if (isset($this->carrito[$domini])) {
            unset($this->carrito[$domini]);

            session()->put('carrito', $this->carrito);

            $this->dispatch('eliminarCarrito', $domini);
        }
    }

    public function render()
    {
        return view('livewire.carrito');
    }
}
