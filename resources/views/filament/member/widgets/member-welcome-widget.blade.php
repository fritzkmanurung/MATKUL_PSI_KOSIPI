<x-filament-widgets::widget>
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-900 dark:to-teal-900 rounded-2xl border-0 shadow-lg">
        <div class="absolute inset-0 bg-white/10 dark:bg-black/10 backdrop-blur-sm"></div>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/20 dark:bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute right-20 -bottom-10 w-32 h-32 bg-emerald-300/30 dark:bg-emerald-500/20 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-5 gap-4 text-white text-center md:text-left">
            <div class="flex items-center gap-5">
                <div class="h-16 w-16 rounded-full border-2 border-white/30 overflow-hidden shadow-sm flex-shrink-0 bg-white dark:bg-gray-800 flex items-center justify-center">
                    @if(filament()->getUserAvatarUrl(auth()->user()))
                        <img src="{{ filament()->getUserAvatarUrl(auth()->user()) }}" alt="Profile" class="h-full w-full object-cover">
                    @else
                        <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <h2 class="text-xs font-semibold text-white/80 uppercase tracking-wider mb-0.5">Selamat Datang</h2>
                    <h1 class="text-xl md:text-2xl font-bold tracking-tight">{{ auth()->user()->name }}</h1>
                </div>
            </div>
            <div class="flex gap-2 mt-3 md:mt-0 w-full md:w-auto">
                <x-filament::button 
                    tag="a" 
                    href="{{ url('/member/simpanan-anggotas/create') }}" 
                    color="gray"
                    class="!bg-white !text-emerald-600 hover:!bg-gray-50 flex-1 md:flex-none shadow-sm"
                    icon="heroicon-m-arrow-down-tray">
                    Setor
                </x-filament::button>
                <x-filament::button 
                    tag="a" 
                    href="{{ url('/member/pinjaman-anggotas/create') }}" 
                    color="gray" 
                    class="!bg-transparent !border !border-white/50 !text-white hover:!bg-white/10 flex-1 md:flex-none"
                    icon="heroicon-m-banknotes">
                    Ajukan
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
