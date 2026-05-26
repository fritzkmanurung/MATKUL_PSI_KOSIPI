<x-filament-widgets::widget>
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-slate-800 dark:from-indigo-900 dark:to-slate-900 rounded-2xl border-0 shadow-lg">
        <div class="absolute inset-0 bg-white/10 dark:bg-black/10 backdrop-blur-sm"></div>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 dark:bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute right-20 -bottom-10 w-32 h-32 bg-indigo-400/20 dark:bg-indigo-500/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-6 gap-6 text-white text-center md:text-left">
            <div class="flex items-center gap-6">
                <div class="h-20 w-20 rounded-full border-4 border-white/30 overflow-hidden shadow-lg flex-shrink-0 bg-white dark:bg-gray-800 flex items-center justify-center">
                    @if(filament()->getUserAvatarUrl(auth()->user()))
                        <img src="{{ filament()->getUserAvatarUrl(auth()->user()) }}" alt="Profile" class="h-full w-full object-cover">
                    @else
                        <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-xs font-semibold text-white/80 uppercase tracking-wider mb-1">Area Administrator</h2>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight mb-2">{{ auth()->user()->name }}</h1>
                    
                    @if($pendingSimpanan > 0 || $pendingPinjaman > 0)
                        <div class="flex flex-wrap gap-2 mt-2 justify-center md:justify-start">
                            @if($pendingSimpanan > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-500/20 text-amber-200 border border-amber-500/30">
                                    <x-heroicon-m-clock class="w-4 h-4" />
                                    {{ $pendingSimpanan }} Simpanan Menunggu
                                </span>
                            @endif
                            @if($pendingPinjaman > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-500/20 text-rose-200 border border-rose-500/30">
                                    <x-heroicon-m-exclamation-circle class="w-4 h-4" />
                                    {{ $pendingPinjaman }} Pinjaman Menunggu
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-indigo-200 mt-1">Semua data operasional telah diverifikasi. Sistem berjalan dengan baik.</p>
                    @endif
                </div>
            </div>
            
            @if($pendingSimpanan > 0 || $pendingPinjaman > 0)
            <div class="flex flex-col gap-2 mt-4 md:mt-0 w-full md:w-auto">
                @if($pendingSimpanan > 0)
                <x-filament::button 
                    tag="a" 
                    href="{{ url('/admin/simpanans') }}" 
                    color="gray"
                    class="!bg-white !text-indigo-700 hover:!bg-gray-50 flex-1 md:flex-none shadow-md"
                    icon="heroicon-m-check-circle">
                    Verifikasi Simpanan
                </x-filament::button>
                @endif
                
                @if($pendingPinjaman > 0)
                <x-filament::button 
                    tag="a" 
                    href="{{ url('/admin/pinjamen') }}" 
                    color="gray" 
                    class="!bg-transparent !border !border-white/50 !text-white hover:!bg-white/10 flex-1 md:flex-none"
                    icon="heroicon-m-clipboard-document-check">
                    Tinjau Pinjaman
                </x-filament::button>
                @endif
            </div>
            @endif
        </div>
    </div>
</x-filament-widgets::widget>
