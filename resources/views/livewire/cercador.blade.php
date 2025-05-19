<form wire:submit.prevent="enviarDomini" class="flex flex-col justify-center">
    <div class="flex flex-col sm:flex-row gap-3 w-full">
        <input wire:model.blur="domini"
            class="w-full bg-white placeholder:text-slate-400 text-slate-700 text-base border border-slate-400 rounded-lg px-4 py-2 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-blue-400 shadow-sm"
            placeholder="Busca el domini" />

        <button type="submit"
            class="rounded-lg bg-blue-600 py-2 px-6 border border-transparent text-sm text-white font-semibold transition-all duration-300 shadow-md hover:bg-blue-700 active:bg-blue-800 active:scale-95 disabled:pointer-events-none disabled:opacity-50 cursor-pointer">
            Buscar
        </button>
    </div>

    @error('domini')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</form>
