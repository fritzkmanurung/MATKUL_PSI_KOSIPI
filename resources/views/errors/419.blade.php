<x-errors.layout>
 <div class="mb-6">
 <span class="text-9xl font-black tracking-tighter text-gray-200 select-none">419</span>
 </div>

 <x-ui.section-header
 title="Sesi Telah Berakhir"
 description="Halaman ini telah kedaluwarsa karena tidak ada aktivitas. Silakan coba lagi."
 />

 <div class="mt-8 flex flex-col sm:flex-row gap-3">
 <x-ui.button href="{{ url()->previous() }}" variant="primary">
 Muat Ulang Halaman
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
 Masuk Kembali
 </x-ui.button>
 @endauth
 </div>
</x-errors.layout>
