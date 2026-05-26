<x-errors.layout>
    <div class="mb-6">
        <span class="text-9xl font-black tracking-tighter text-gray-200 dark:text-gray-800 select-none">500</span>
    </div>

    <x-ui.section-header
        title="Terjadi Kesalahan Server"
        description="Maaf, sistem sedang mengalami gangguan. Tim teknis kami telah diberitahu."
    />

    <div class="mt-8 flex flex-col sm:flex-row gap-3">
        <x-ui.button href="{{ url()->previous() }}" variant="primary">
            Coba Lagi
        </x-ui.button>

        <x-ui.button href="{{ url('/') }}" variant="secondary">
            Kembali ke Beranda
        </x-ui.button>
    </div>

    @if(app()->environment('local', 'staging'))
        <div class="mt-10 p-4 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 max-w-2xl text-left overflow-auto">
            <p class="text-xs font-mono text-gray-500 dark:text-gray-400 mb-2">DEBUG INFO (Local Only):</p>
            <p class="text-xs font-mono text-red-600 dark:text-red-400">{{ $exception->getMessage() }}</p>
            <p class="text-xs font-mono text-gray-400 mt-1">{{ $exception->getFile() }}:{{ $exception->getLine() }}</p>
        </div>
    @endif
</x-errors.layout>
