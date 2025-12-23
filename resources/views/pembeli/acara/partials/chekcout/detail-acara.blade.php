 <div
     class="h-64 w-full border-2 border-gray-200 border-dashed rounded-t-lg flex items-center justify-center overflow-hidden bg-gray-50">
     @if ($acara->banner_acara)
         <img src="{{ asset('storage/' . $acara->banner_acara) }}" alt="Banner Acara"
             class="h-full w-full object-cover rounded-t-lg">
     @else
         <span class="text-gray-400 text-sm">Belum ada banner acara</span>
     @endif
 </div>
 <div class=" text-gray-900 mt-4 text-2xl px-5">
     {{ $acara->nama_acara }}
 </div>
