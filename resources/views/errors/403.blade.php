<x-errors.layout>
 <div class="mb-6">
 <span class="text-9xl font-black tracking-tighter text-gray-200 select-none">403</span>
 </div>

 <x-ui.section-header
 title="Akses Ditolak"
 description="Anda tidak memiliki izin untuk mengakses halaman ini."
 />

 <div class="mt-8 flex flex-col sm:flex-row gap-3">
 @auth
 @php
 $dashboardUrl = auth()->user()->hasRole('anggota') ? '/member' : '/admin';
 @endphp
 <x-ui.button href="{{ url($dashboardUrl) }}" variant="primary">
 Ke Dashboard
 </x-ui.button>
 @else
 <x-ui.button href="{{ route('login') }}" variant="primary">
 Masuk
 </x-ui.button>
 @endauth

 <x-ui.button href="{{ url('/') }}" variant="secondary">
 Kembali ke Beranda
 </x-ui.button>
 </div>

 <div class="mt-10 p-4 rounded-lg bg-amber-50 border border-amber-200 max-w-md">
 <div class="flex items-start gap-3">
 <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
 </svg>
 <div class="text-left">
 <p class="text-sm font-semibold text-amber-800 ">Butuh Akses?</p>
 <p class="text-xs text-amber-700 mt-0.5">
 Jika Anda merasa ini adalah kesalahan, hubungi administrator koperasi untuk mendapatkan akses yang sesuai.
 </p>
 </div>
 </div>
 </div>
</x-errors.layout>
