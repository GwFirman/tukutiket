<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 mb-4">
            <i data-lucide="calendar" class="size-5 text-gray-600"></i>
            <i data-lucide="chevron-right" class="size-4 font-medium text-gray-400"></i>
            <p class="font-medium">Buat Acara</p>
        </div>
    </x-slot>

    <div class="">
        <div class="mx-auto px-24">
            <div class="">
                {{-- <x-buat-acara /> --}}
                <livewire:buat-acara />
            </div>
        </div>
    </div>
</x-app-layout>
