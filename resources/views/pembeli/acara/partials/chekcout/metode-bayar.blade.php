<div class="flex items-center gap-2 mt-4">
    <i data-lucide="credit-card" class="size-5 text-indigo-400"></i>
    <x-input-label :value="__('Metode Pembayaran')" class="text-gray-300" />
</div>

<select name="metode_pembayaran" required
    class="mt-2 w-full text-gray-600 outline-gray-300 rounded-lg p-2 outline-2 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
    <option value="" disabled selected>Pilih metode pembayaran</option>
    <option value="bank_transfer">Transfer Bank</option>
    <option value="e_wallet">E-Wallet (OVO/GoPay/DANA)</option>
    <option value="virtual_account">Virtual Account</option>
</select>
