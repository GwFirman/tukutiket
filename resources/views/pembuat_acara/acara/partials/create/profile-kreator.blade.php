<div class="w-full mb-6 p-5">
    <label class="mb-4 block text-sm font-medium text-gray-700">
        Diselenggarakan oleh
    </label>

    <div class="flex items-center gap-3 ">
        <!-- Foto Kreator -->
        @if ($kreator && $kreator->logo)
            <img src="{{ Storage::url($kreator->logo) }}" alt="{{ $kreator->nama_kreator }}"
                class="h-20 w-20 rounded-full object-cover object-center border-2 border-gray-300 shadow-sm flex-shrink-0">
        @else
            <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 flex-shrink-0">
                <i data-lucide="user" class="size-6"></i>
            </div>
        @endif

        <!-- Nama Kreator -->
        <div>
            <p class="font-semibold text-gray-900 text-md">
                {{ $kreator->nama_kreator ?? 'Belum Ada Profil Kreator' }}
            </p>
            <input type="hidden" name="id_kreator" id="id_kreator" value={{ $kreator->id }}>
            <p class="text-xs text-gray-500">
                Profil kreator akan tampil di halaman event Anda.
            </p>
        </div>
    </div>
</div>
