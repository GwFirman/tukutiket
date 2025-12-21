<div class="mt-4">
    <label for="deskripsi_acara" class="block text-sm font-medium text-gray-700">Deskripsi</label>
    <div class="mt-4">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" />
        <input id="deskripsi_acara" name="deskripsi_acara" type="hidden" value="{{ old('deskripsi_acara') }}">
        <trix-editor input="deskripsi_acara" style="min-height: 300px;"></trix-editor>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
    </div>
</div>
