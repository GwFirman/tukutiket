<div class="flex items-center justify-between mb-4">
    <p class="text-gray-800 font-medium">Data Peserta</p>
    <span class="text-xs text-gray-500">Maks
        {{ $maksTiket ?? ($acara->maks_tiket_per_transaksi ?? 5) }}
        peserta</span>
</div>
<div class="border-t border-gray-200 mb-4"></div>

<div id="peserta_forms_container" class="space-y-4 max-h-96 overflow-y-auto">
    <div class="text-center text-gray-400 text-sm py-6">
        <i data-lucide="users" class="size-8 mx-auto mb-2 opacity-50"></i>
        <p>Pilih tiket untuk mengisi data peserta</p>
    </div>
</div>
