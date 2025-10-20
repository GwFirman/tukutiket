<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Beranda
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @role('pembuat_event')
                        <h3 class="text-lg font-semibold mb-4">Daftar Acara Saya</h3>
                        @if (count($acaras) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th
                                                class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Acara</th>
                                            <th
                                                class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Lokasi</th>
                                            <th
                                                class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Waktu</th>
                                            <th
                                                class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($acaras as $acara)
                                            <tr>
                                                <td class="py-3 px-4">
                                                    <div class="flex items-center">
                                                        @if ($acara->banner_acara)
                                                            <img src="{{ Storage::url($acara->banner_acara) }}"
                                                                alt="{{ $acara->nama_acara }}"
                                                                class="h-10 w-10 rounded-md object-cover mr-3">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 rounded-md bg-gray-200 mr-3 flex items-center justify-center">
                                                                <span class="text-gray-500 text-xs">No img</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="font-medium text-gray-900">{{ $acara->nama_acara }}
                                                            </div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ Str::limit($acara->deskripsi, 50) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4 text-sm text-gray-500">{{ $acara->lokasi }}</td>
                                                <td class="py-3 px-4 text-sm text-gray-500">
                                                    <div>Mulai:
                                                        {{ \Carbon\Carbon::parse($acara->waktu_mulai)->format('d M Y, H:i') }}
                                                    </div>
                                                    <div>Selesai:
                                                        {{ \Carbon\Carbon::parse($acara->waktu_selesai)->format('d M Y, H:i') }}
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $acara->status === 'published'
                                                            ? 'bg-green-100 text-green-800'
                                                            : ($acara->status === 'draft'
                                                                ? 'bg-yellow-100 text-yellow-800'
                                                                : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($acara->status) }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4 text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('pembuat.acara.edit', $acara->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                                        <a href="{{ route('pembuat.acara.show', $acara->slug) }}" class="text-green-600 hover:text-green-900">Lihat</a>
                                                        <form method="POST" action="{{ route('pembuat.acara.destroy', $acara->id) }}" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus acara ini?')">Hapus</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Anda belum memiliki acara. <a href="{{ route('pembuat.acara.create') }}"
                                                  class="font-medium underline text-yellow-700 hover:text-yellow-600">Buat
                                                acara baru</a> sekarang!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('pembuat.acara.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Buat Acara Baru
                            </a>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
