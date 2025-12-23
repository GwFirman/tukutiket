<div class="mt-4 rounded-2xl border border-gray-100">
    <div class="flex items-center gap-2 p-5">
        <i data-lucide="text-initial" class="size-5 text-indigo-600"></i>
        <h3 class="text-lg font-semibold text-gray-900">Deskripsi acara</h3>
    </div>
    <div class="p-5 border-t border-gray-100">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
        <input id="deskripsi_acara" name="deskripsi_acara" type="hidden"
            value="{{ old('deskripsi_acara', $acara->deskripsi ?? '') }}">
        <trix-editor input="deskripsi_acara" style="min-height: 300px;"></trix-editor>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    </div>
</div>
