<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\On;
use Livewire\Component;

class Resultats extends Component
{
    public string $tokenApi;

    public int $limit = 5;
    public string $domini = '';
    public bool $mostrarPromocions = false;

    public array $preus = [];
    public array $dominis = [];
    public array $preusMap = [];
    public array $consulta = [];
    public array $carrito = [];

    public function mount()
    {
        $this->carrito = session()->get('carrito', []);

        $this->tokenApi = env('TOKEN_API');

        $this->preus = Http::withToken($this->tokenApi)
            ->get('https://api.swhosting.com/v1/domains/prices?EUR')
            ->json();


        $ordrePrioritari = ['com', 'es', 'cat', 'org', 'info', 'net'];

        $mapPreusTemp = [];
        $dominisTemp = [];

        foreach ($this->preus as $p) {
            $tld = array_keys($p)[0] ?? null;

            if ($tld) {
                $dades = $p[$tld];
                $dominisTemp[$tld] = $tld;

                $preuNormal = $dades['register_price'] ?? null;

                // Mirar si hi ha promoció
                if (!$dades['promotion'] === 'N' && isset($dades['promo_register_price'])) {
                    $mapPreusTemp[$tld] = [
                        'original' => $preuNormal,
                        'promocional' => $dades['promo_register_price']
                    ];
                } else {
                    $mapPreusTemp[$tld] = [
                        'original' => $preuNormal,
                        'promocional' => null
                    ];
                }
            }
        }

        // Ordenar els dominis segons la prioritat
        usort($dominisTemp, function ($a, $b) use ($ordrePrioritari) {
            $posA = array_search($a, $ordrePrioritari);
            $posB = array_search($b, $ordrePrioritari);

            // Si son prioritat, ordenar per posició
            if ($posA !== false && $posB !== false) {
                return $posA <=> $posB;
            }

            if ($posA !== false) {
                return -1;
            }

            if ($posB !== false) {
                return 1;
            }

            // Si no son prioritat, ordenar per nom
            return strcmp($a, $b);
        });

        $this->dominis = $dominisTemp;
        $this->preusMap = $mapPreusTemp;
    }

    public function carregarMes()
    {
        $this->limit += 5;
    }

    #[On('domini')]
    public function comprovarDisponibilitat($dominiBuscar)
    {
        $this->domini = $dominiBuscar;

        $tldsQuery = implode('&tlds=', $this->dominis);

        $this->consulta = Http::withToken($this->tokenApi)
            ->get('https://api.swhosting.com/v1/domains/available?name=' . $this->domini . '&tlds=' . $tldsQuery)
            ->json();

        if (!empty($this->consulta['domains'])) {
            foreach ($this->consulta['domains'] as &$dom) {
                $tld = explode('.', $dom['domain'])[1] ?? null;

                $preus = $this->preusMap[$tld] ?? null;

                if ($preus && is_array($preus)) {
                    $original = $preus['original'] ?? null;
                    $promo = $preus['promocional'] ?? null;

                    if ($promo !== null) {
                        $dom['price'] = $promo;
                        $dom['promo_price'] = $promo;
                        $dom['original_price'] = $original;
                    } else {
                        $dom['price'] = $original;
                    }
                }
            }
        }
    }

    public function afegirCarrito($domini, $preu)
    {
        if (!isset($this->carrito[$domini])) {
            $this->carrito[$domini] = $preu;

            session()->put('carrito', $this->carrito);

            $this->dispatch('afegirCarrito', $domini);
        }
    }

    #[On('eliminarCarrito')]
    public function actualitzarCarritoDesDeFora()
    {
        $this->carrito = session()->get('carrito', []);
    }

    public function render()
    {
        return view('livewire.resultats', [
            'consulta' => $this->consulta,
            'carrito' => $this->carrito,
        ]);
    }
}
