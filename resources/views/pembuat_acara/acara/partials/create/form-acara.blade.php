<div class="px-5">
    <label for="nama_acara" class="block text-sm font-medium text-gray-700">
        Nama Acara <span class="text-red-400">*</span>
    </label>

    <input type="text" name="nama_acara" id="nama_acara" value="{{ old('nama_acara', $acara->nama_acara ?? '') }}"
        required @disabled(isset($acara) && $acara->status == 'published')
        class="mt-1 h-10 block w-full border-b-2 outline-0 border-gray-100 text-xl font-medium focus:border-sky-500 disabled:bg-gray-50 disabled:text-gray-500 disabled:cursor-not-allowed disabled:border-gray-200">

    {{-- PENTING: Kirim value via hidden input jika status published agar validasi controller tidak error --}}
    @if (isset($acara) && $acara->status == 'published')
        <input type="hidden" name="nama_acara" value="{{ $acara->nama_acara }}">
    @endif
</div>
