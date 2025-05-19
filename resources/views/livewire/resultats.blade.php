<div class="flex flex-col gap-6">
    <div class="flex flex-col sm:flex-row gap-3 justify-center sm:justify-start">
        <button wire:click="$set('mostrarPromocions', false)"
            class="{{ !$mostrarPromocions ? 'bg-blue-600 text-white' : 'bg-white text-blue-600' }} font-semibold py-2 px-5 rounded-md border border-blue-500 hover:bg-blue-600 hover:text-white transition cursor-pointer">
            Tots els resultats
        </button>

        <button wire:click="$set('mostrarPromocions', true)"
            class="{{ $mostrarPromocions ? 'bg-blue-600 text-white' : 'bg-white text-blue-600' }} font-semibold py-2 px-5 rounded-md border border-blue-500 hover:bg-blue-600 hover:text-white transition cursor-pointer">
            Promocions
        </button>
    </div>

    <div class="relative flex flex-col rounded-xl bg-white shadow-md border border-slate-200 overflow-hidden">

        <div wire:loading class="flex flex-row items-center p-4">
            <p class="text-sm text-blue-500 italic">Buscant...</p>
        </div>

        <div wire:loading.remove class="flex flex-col gap-4 w-full items-center rounded-md p-4">
            @if (!empty($consulta['domains']))
                @php
                    $resultats = array_filter($consulta['domains'], function ($dom) use ($mostrarPromocions) {
                        return !$mostrarPromocions || isset($dom['promo_price']);
                    });
                @endphp

                @foreach (array_slice($resultats, 0, $limit) as $domini)
                    <div
                        class="flex flex-col sm:flex-row w-full items-start sm:items-center justify-between gap-3 px-3 py-2 border rounded-md hover:shadow-sm transition">

                        <p class="w-full sm:w-40 font-medium text-slate-800">
                            {{ $domini['domain'] ?? 'No Disponible' }}
                        </p>

                        <div
                            class="flex flex-col justify-between sm:flex-row items-start sm:items-center gap-2 sm:gap-3 sm:justify-end">

                            @if (isset($domini['promo_price']))
                                <div class="flex flex-col sm:items-end text-left sm:text-right">
                                    <span class="line-through text-sm text-slate-400">
                                        {{ number_format($domini['original_price'], 2) }} €
                                    </span>
                                    <span class="text-green-600 font-bold">
                                        {{ number_format($domini['promo_price'], 2) }} €/any
                                    </span>
                                    <span class="text-xs text-green-500 font-semibold">Promoció!</span>
                                </div>
                            @else
                                <span class="font-bold text-slate-500 italic text-left sm:text-right w-full sm:w-28">
                                    {{ isset($domini['price']) ? number_format($domini['price'], 2) . ' €/any' : 'Preu no disponible' }}
                                </span>
                            @endif


                            <p
                                class="px-3 py-1.5 rounded-md text-white text-xs font-medium text-center w-fit
                                {{ $domini['available'] ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $domini['available'] ? 'Disponible' : 'Ocupat' }}
                            </p>
                        </div>

                        @php
                            $estaAlCarrito = isset($carrito[$domini['domain']]);
                        @endphp

                        <button
                            @if (!$estaAlCarrito) wire:click="afegirCarrito('{{ $domini['domain'] }}', '{{ $domini['price'] ?? '0.00' }}')" @endif
                            class="py-1.5 px-4 text-sm font-medium rounded-md w-full sm:w-auto
                            {{ $estaAlCarrito
                                ? 'bg-gray-300 text-gray-600 cursor-not-allowed border border-gray-400'
                                : 'border border-blue-500 text-blue-500 hover:bg-blue-700 hover:text-white transition cursor-pointer' }}"
                            {{ $estaAlCarrito ? 'disabled' : '' }}>
                            {{ $estaAlCarrito ? 'Carrito' : 'Comprar' }}
                        </button>

                    </div>
                @endforeach

                @if (count($consulta['domains']) > $limit)
                    <button wire:click="carregarMes"
                        class="mt-4 px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition cursor-pointer">
                        Carregar més
                    </button>
                @endif
            @else
                <p class="text-sm text-slate-500 italic text-center">Introdueix un domini i fes clic a buscar.</p>
            @endif
        </div>
    </div>
</div>
