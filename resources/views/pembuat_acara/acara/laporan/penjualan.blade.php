<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mx-auto max-w-5xl">
            <i data-lucide="calendar" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="text-gray-400 ">Laporan penjualan <span
                    class="font-medium text-gray-600">{{ $acara->nama_acara }}</span></p>
        </div>
    </x-slot>
    <div class="max-w-5xl mx-auto pb-6 md:py-10 ">

        {{-- Header --}}
        <div class="relative rounded-xl px-6 py-12 mb-8 text-white overflow-hidden">
            {{-- Background banner_acara --}}
            @if (!empty($acara->banner_acara))
                <div class="absolute inset-0">
                    <img src="{{ \Illuminate\Support\Str::startsWith($acara->banner_acara, ['http://', 'https://']) ? $acara->banner_acara : asset('storage/' . $acara->banner_acara) }}"
                        alt="Banner Acara" class="w-full h-full object-cover">
                </div>
            @endif
            {{-- Overlay gradient agar teks tetap terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-r from-gray-600/80 to-gray-50/10"></div>

            <div class="relative flex items-center justify-between">
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
            <div class="bg-white rounded-lg shadow-sm p-5 border border-indigo-500">
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

            <div class="bg-white rounded-lg shadow-sm p-5 border border-purple-500">
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

            <div class="bg-white rounded-lg shadow-sm p-5 border border-green-500">
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

            <div class="bg-white rounded-lg shadow-sm p-5 border border-blue-500">
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
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Detail Penjualan Per Jenis Tiket</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Jenis Tiket</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Harga</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Kuota</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Terjual</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Sisa</th>
                            <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Pendapatan</th>
                            <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Check-in</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @foreach ($rekapJenisTiket as $jt)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $jt->nama_jenis }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    Rp {{ number_format($jt->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center text-gray-700">{{ $jt->kuota }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-indigo-600 font-medium">{{ $jt->tiket_terjual }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="{{ $jt->sisa_kuota > 0 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                        {{ $jt->sisa_kuota }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right font-medium text-green-600">
                                    Rp {{ number_format($jt->pendapatan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center text-blue-600 font-medium">
                                    {{ $jt->checkin_count }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="bg-gray-50">
                        <tr class="font-semibold">
                            <td class="px-6 py-4 text-gray-900">Total</td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $rekapJenisTiket->sum('kuota') }}</td>
                            <td class="px-6 py-4 text-center text-indigo-600">
                                {{ $rekapJenisTiket->sum('tiket_terjual') }}</td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $rekapJenisTiket->sum('sisa_kuota') }}
                            </td>
                            <td class="px-6 py-4 text-right text-green-600">
                                Rp {{ number_format($rekapJenisTiket->sum('pendapatan'), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center text-blue-600">
                                {{ $rekapJenisTiket->sum('checkin_count') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
