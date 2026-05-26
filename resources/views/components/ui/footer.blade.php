@props(['maxWidth' => 'max-w-4xl'])

<footer {{ $attributes->merge(['class' => 'w-full mx-auto px-6 lg:px-8 ' . $maxWidth . ' py-12 mt-auto']) }}>
 <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-[#706f6c] ">
 <p>&copy; {{ date('Y') }} {{ config('app.name', 'KOSIPI') }}. All rights reserved.</p>
 
 <div class="flex items-center gap-6">
 <a href="#" class="hover:text-[#1b1b18] transition">Kebijakan Privasi</a>
 <a href="#" class="hover:text-[#1b1b18] transition">Syarat & Ketentuan</a>
 <a href="#" class="hover:text-[#1b1b18] transition">Bantuan</a>
 </div>
 </div>
</footer>
