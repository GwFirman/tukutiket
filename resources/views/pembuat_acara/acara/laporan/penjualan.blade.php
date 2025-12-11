<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 mb-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 text-indigo-200 text-sm mb-1">
                        <i data-lucide="bar-chart-3" class="size-4"></i>
                        Laporan Penjualan
                    </div>
                    <h1 class="text-2xl font-bold">{{ $acara->nama_acara }}</h1>
                </div>
                <div class="hidden md:flex items-center gap-2">
                    <button onclick="window.print()"
                        class="flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm px-4 py-2 rounded-lg transition">
                        <i data-lucide="printer" class="size-4"></i>
                        Cetak
                    </button>
                </div>
            </div>
        </div>

        {{-- --- REKAP ACARA --- --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Transaksi</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $rekapAcara->total_transaksi }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i data-lucide="receipt" class="size-6 text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Tiket Terjual</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $rekapAcara->total_tiket_terjual }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                        <i data-lucide="ticket" class="size-6 text-purple-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($rekapAcara->total_pendapatan, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center">
                        <i data-lucide="wallet" class="size-6 text-green-600"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Sudah Check-in</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $rekapAcara->total_sudah_checkin }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i data-lucide="user-check" class="size-6 text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- --- REKAP PER JENIS TIKET --- --}}
        <div class="bg-white shadow-sm rounded-xl overflow-hidden">
            <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                <h2 class="text-lg font-semibold text-indigo-900 flex items-center gap-2">
                    <i data-lucide="list" class="size-5"></i>
                    Detail Penjualan Per Jenis Tiket
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-indigo-50/50">
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Jenis Tiket
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Harga
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Kuota
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Terjual
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Sisa
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Pendapatan
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                Check-in
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($rekapJenisTiket as $jt)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                            <i data-lucide="ticket" class="size-5 text-white"></i>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $jt->nama_jenis }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-gray-700 font-medium">
                                        Rp {{ number_format($jt->harga, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $jt->kuota }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                        {{ $jt->tiket_terjual }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $jt->sisa_kuota > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $jt->sisa_kuota }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-green-600 font-semibold">
                                        Rp {{ number_format($jt->pendapatan, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        <i data-lucide="check-circle" class="size-3"></i>
                                        {{ $jt->checkin_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- Footer Total --}}
                    <tfoot class="bg-indigo-50">
                        <tr class="font-semibold">
                            <td class="px-6 py-4 text-indigo-900">Total</td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4 text-center text-indigo-700">{{ $rekapJenisTiket->sum('kuota') }}</td>
                            <td class="px-6 py-4 text-center text-indigo-700">
                                {{ $rekapJenisTiket->sum('tiket_terjual') }}</td>
                            <td class="px-6 py-4 text-center text-indigo-700">{{ $rekapJenisTiket->sum('sisa_kuota') }}
                            </td>
                            <td class="px-6 py-4 text-green-600">Rp
                                {{ number_format($rekapJenisTiket->sum('pendapatan'), 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center text-indigo-700">
                                {{ $rekapJenisTiket->sum('checkin_count') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
