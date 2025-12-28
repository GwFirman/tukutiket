{{-- filepath: d:\Kulyeah\magang\Project\tukutiket\resources\views\beranda\partials\kreator-populer.blade.php --}}
<div class="py-4 bg-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-8 sm:mb-12 text-center">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2">
                Kreator Populer
            </h2>
        </div>

        @if ($kreatorsPopuler->count() > 0)
            <!-- Kreator Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 sm:gap-8">
                @foreach ($kreatorsPopuler as $kreator)
                    <a href="{{ route('beranda.kreator', $kreator->slug) }}"
                        class="group flex flex-col items-center text-center">
                        <!-- Logo Kreator -->
                        <div class="relative mb-3">
                            @if ($kreator->logo)
                                <img src="{{ Storage::url($kreator->logo) }}" alt="{{ $kreator->nama_kreator }}"
                                    class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-full object-cover border-2 border-gray-200 group-hover:border-indigo-500 transition-all duration-200 group-hover:scale-105">
                            @else
                                <div
                                    class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                    <span class="text-white text-2xl sm:text-3xl font-bold">
                                        {{ strtoupper(substr($kreator->nama_kreator, 0, 1)) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Badge Verified -->
                            <div class="absolute -bottom-1 -right-1 bg-white rounded-full p-1">
                                <i data-lucide="badge-check" class="size-5 sm:size-6 text-white fill-blue-500"></i>
                            </div>
                        </div>

                        <!-- Nama Kreator -->
                        <h3
                            class="text-sm sm:text-base font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                            {{ $kreator->nama_kreator }}
                        </h3>

                        <!-- Jumlah Acara -->
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">
                            {{ $kreator->acara_count }} Acara
                        </p>
                    </a>
                @endforeach
            </div>

            {{-- <!-- View All Button -->
            <div class="mt-8 sm:mt-12 text-center">
                <a href="{{ route('kreator.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-50 transition-colors">
                    <span>Lihat Semua Kreator</span>
                    <i data-lucide="arrow-right" class="size-5"></i>
                </a>
            </div> --}}
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div
                    class="bg-gray-50 w-16 h-16 sm:w-20 sm:h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="size-8 sm:size-10 text-gray-400"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                    Belum Ada Kreator Terverifikasi
                </h3>
                <p class="text-sm sm:text-base text-gray-600">
                    Kreator terverifikasi akan segera ditampilkan di sini
                </p>
            </div>
        @endif
    </div>
</div>
