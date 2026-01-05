 <!-- Info Pemesan -->
 <div class="bg-indigo-50 rounded-xl p-4 mb-6">
     <div class="flex items-center gap-2 mb-3">
         <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
             <i data-lucide="user" class="size-4 text-indigo-600"></i>
         </div>
         <p class="font-medium text-gray-800">Data Pemesan</p>
     </div>

     @if (isset($user))
         <p class="text-xs text-gray-500 mb-3">Data terisi otomatis dari akun Anda dan tidak dapat
             diubah di sini. <a href="{{ route('profile.edit') }}" class="text-indigo-600 underline">Ubah di profil</a>
         </p>
     @endif

     <div class="space-y-3">
         <div>
             <label class="text-xs text-gray-500 mb-1 block">Nama Lengkap <span class="text-red-500">*</span></label>
             <input type="text" name="nama_pemesan" required value="{{ old('nama_pemesan', $user->name ?? '') }}"
                 @if (isset($user)) readonly aria-readonly="true" @endif
                 class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 {{ isset($user) ? 'bg-gray-100 cursor-not-allowed focus:ring-0 focus:border-gray-200' : '' }}"
                 placeholder="Masukkan nama lengkap">
         </div>
         <div class="grid grid-cols-2 gap-3">
             <div>
                 <label class="text-xs text-gray-500 mb-1 block">Email <span class="text-red-500">*</span></label>
                 <input type="email" name="email_pemesan" required
                     value="{{ old('email_pemesan', $user->email ?? '') }}"
                     @if (isset($user)) readonly aria-readonly="true" @endif
                     class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 {{ isset($user) ? 'bg-gray-100 cursor-not-allowed focus:ring-0 focus:border-gray-200' : '' }}"
                     placeholder="email@example.com">
             </div>
             <div>
                 <label class="text-xs text-gray-500 mb-1 block">No. Telepon</label>
                 <input type="tel" name="no_telp_pemesan"
                     value="{{ old('no_telp_pemesan', $user->nomor_hp ?? ($user->no_telepon ?? ($user->phone ?? ''))) }}"
                     @if (isset($user)) readonly aria-readonly="true" @endif
                     class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 {{ isset($user) ? 'bg-gray-100 cursor-not-allowed focus:ring-0 focus:border-gray-200' : '' }}"
                     placeholder="08xxxxxxxxxx">
             </div>
         </div>
     </div>
 </div>
