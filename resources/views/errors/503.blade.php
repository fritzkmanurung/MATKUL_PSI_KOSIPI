<x-errors.layout>
    <div class="mb-6">
        <span class="text-9xl font-black tracking-tighter text-gray-200 dark:text-gray-800 select-none">503</span>
    </div>

    <x-ui.section-header
        title="Sedang Dalam Pemeliharaan"
        description="Kami sedang melakukan pemeliharaan rutin untuk meningkatkan kualitas layanan. Silakan kembali beberapa saat lagi."
    />

    <div class="mt-8">
        <x-ui.button href="{{ url('/') }}" variant="primary">
            Muat Ulang
        </x-ui.button>
    </div>

    <div class="mt-10 text-xs text-[#706f6c] dark:text-[#A1A09A]">
        <p>Estimasi waktu: <span class="font-semibold">15 - 30 menit</span></p>
        <p class="mt-1">Terima kasih atas kesabaran Anda.</p>
    </div>
</x-errors.layout>
