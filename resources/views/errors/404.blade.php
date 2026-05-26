<x-errors.layout>
 <div class="mb-6">
 <span class="text-9xl font-black tracking-tighter text-gray-200 select-none">404</span>
 </div>

 <x-ui.section-header
 title="Halaman Tidak Ditemukan"
 description="Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan."
 />

 <div class="mt-8 flex flex-col sm:flex-row gap-3">
 <x-ui.button href="{{ url('/') }}" variant="primary">
 Kembali ke Beranda
 </x-ui.button>

 @auth
 @php
 $dashboardUrl = auth()->user()->hasRole('anggota') ? '/member' : '/admin';
 @endphp
 <x-ui.button href="{{ url($dashboardUrl) }}" variant="secondary">
 Ke Dashboard
 </x-ui.button>
 @else
 <x-ui.button href="{{ route('login') }}" variant="secondary">
 Masuk
 </x-ui.button>
 @endauth
 </div>

 <p class="mt-10 text-xs text-[#706f6c] ">
 Jika Anda yakin ini adalah kesalahan, silakan hubungi administrator.
 </p>
</x-errors.layout>
