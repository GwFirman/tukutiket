<div class="w-full space-y-4  mt-4">
    <!-- Section Title -->
    <div class="flex items-center gap-2 mb-4">
        <h3 class="text-base font-semibold text-gray-900">Informasi Narahubung</h3>
    </div>

    <!-- Nama Narahubung -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Narahubung
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="user" class="size-5 text-gray-400"></i>
            </div>
            <input type="text" name="info_narahubung" id="info_narahubung" value="{{ old('info_narahubung') }}"
                class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                placeholder="Masukkan nama narahubung">
        </div>
    </div>

    <!-- Email Narahubung -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Email Narahubung
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="mail" class="size-5 text-gray-400"></i>
            </div>
            <input type="email" name="email_narahubung" id="email_narahubung" value="{{ old('email_narahubung') }}"
                class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                placeholder="Masukkan email narahubung">
        </div>
    </div>

    <!-- No Telp Narahubung -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            No Telp Narahubung
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-lucide="phone" class="size-5 text-gray-400"></i>
            </div>
            <input type="text" name="no_telp_narahubung" id="no_telp_narahubung"
                value="{{ old('no_telp_narahubung') }}"
                class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-lg bg-white text-gray-800 placeholder:text-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition text-sm"
                placeholder="Masukkan nomor telepon">
        </div>
    </div>
</div>
