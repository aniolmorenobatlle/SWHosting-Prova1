<div class="flex flex-col gap-5 p-4 w-full max-w-full h-fit border border-slate-200 rounded-xl bg-white shadow-md">
    <h2 class="text-2xl font-bold text-slate-800">Carrito</h2>

    <div class="flex flex-col gap-4 w-full h-fit items-center rounded-md">
        @forelse($carrito as $domini => $preu)
            <div
                class="flex flex-col sm:flex-row w-full items-start sm:items-center border-b border-b-gray-300 justify-between gap-3 px-3 py-2">

                <div class="flex flex-col gap-1">
                    <p class="w-full sm:w-40 font-medium text-slate-800">
                        {{ $domini }}
                    </p>

                    <span class="font-bold text-sm text-slate-500 italic">
                        {{ number_format($preu, 2) }} €/any
                    </span>
                </div>

                <svg wire:click="eliminarDelCarrito('{{ $domini }}')" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 cursor-pointer">
                    <g>
                        <path
                            d="M5.73708 6.54391V18.9857C5.73708 19.7449 6.35257 20.3604 7.11182 20.3604H16.8893C17.6485 20.3604 18.264 19.7449 18.264 18.9857V6.54391M2.90906 6.54391H21.0909"
                            stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                        <path d="M8 6V4.41421C8 3.63317 8.63317 3 9.41421 3H14.5858C15.3668 3 16 3.63317 16 4.41421V6"
                            stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                    </g>
                </svg>
            </div>
        @empty
            <p class="text-sm text-slate-500 italic text-center">El carrito està buit</p>
        @endforelse
    </div>
</div>
