@props(['maxWidth' => 'max-w-7xl'])

<header {{ $attributes->merge(['class' => 'fixed top-0 left-0 right-0 z-50 w-full bg-white shadow-md py-4 px-6 lg:px-8 transition-all duration-200']) }}>
    <nav class="flex items-center justify-between gap-4 mx-auto {{ $maxWidth }}">
 <!-- Logo / Brand -->
 <a href="/" class="flex items-center gap-3 group">
 <img src="{{ asset('images/logo-koperasi.png') }}" alt="Logo Koperasi Indonesia" class="h-12 w-auto object-contain transition-transform group-hover:scale-105 duration-300">
 <div class="flex flex-col justify-center leading-none">
 <span class="text-2xl font-extrabold tracking-tight text-[#1b1b18] font-outfit">
 KoSiPi
 </span>
 <span class="text-[11px] font-bold tracking-wider text-[#059669] uppercase font-outfit mt-0.5">
 IT Del
 </span>
 </div>
 </a>

 <!-- Auth Links -->
 <div class="flex items-center gap-2 lg:gap-4">
 @if (Route::has('login'))
 @auth
 @php
 $dashboardUrl = auth()->user()->hasRole('anggota') ? '/member' : '/admin';
 @endphp
 <a href="{{ url($dashboardUrl) }}" 
 class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] rounded-sm text-sm font-medium transition">
 Dashboard
 </a>
 @else
 <a href="{{ route('login') }}" 
 class="inline-block px-5 py-1.5 text-[#1b1b18] border border-transparent hover:border-[#19140035] rounded-sm text-sm font-medium transition">
 Log in
 </a>

 @if (Route::has('register'))
 <a href="{{ route('register') }}" 
 class="inline-block px-5 py-1.5 bg-[#1b1b18] text-white hover:bg-black rounded-sm text-sm font-medium transition">
 Register
 </a>
 @endif
 @endauth
 @endif
 </div>
 </nav>
</header>
