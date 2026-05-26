<x-ui.layout>
    <x-slot:head>
        <script>
            // Force light mode (white theme) for the landing page using MutationObserver to prevent other scripts from turning it dark
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class' && document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        </script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
            
            .font-outfit {
                font-family: 'Outfit', sans-serif;
            }
            .font-jakarta {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            
            body {
                background-color: #ffffff !important;
                color: #1f2937 !important;
            }

            /* Micro-animations */
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
        </style>
    </x-slot:head>

    <div class="relative min-h-screen flex flex-col bg-white overflow-hidden font-jakarta pt-20">
        <x-ui.navbar maxWidth="max-w-7xl" />

        <!-- HERO SECTION -->
        <section class="relative w-full py-16 lg:py-24 max-w-7xl mx-auto px-6 lg:px-8 flex-grow flex items-center">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center w-full">
                
                <!-- Left Column: Slogan and CTAs -->
                <div class="lg:col-span-7 text-left flex flex-col justify-center">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200/50 w-fit mb-6 shadow-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>
                        Koperasi Simpan Pinjam Digital IT Del
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15] text-gray-900 font-outfit">
                        Masa Depan Koperasi <br>
                        <span class="text-emerald-600">
                            Lebih Mudah & Digital
                        </span>
                    </h1>
                    
                    <p class="text-base md:text-lg text-gray-600 mt-6 leading-relaxed max-w-xl">
                        KoSiPi (Koperasi Simpan Pinjam) IT Del hadir sebagai solusi finansial modern terintegrasi bagi seluruh civitas akademika IT Del. Kelola simpanan dan ajukan pinjaman secara online dengan transparan, aman, dan tanpa proses berbelit-belit.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="{{ route('login') }}" class="group px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-sm transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                            Mulai Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        <a href="#fitur" class="group px-6 py-3 border border-gray-200 text-gray-700 hover:bg-gray-50 rounded-lg font-bold text-sm transition duration-200 flex items-center gap-2">
                            Pelajari Fitur
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-y-0.5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Database Statistics Section -->
                    <div class="grid grid-cols-3 gap-6 pt-10 mt-10 border-t border-gray-100">
                        <div>
                            <div class="text-2xl md:text-3xl font-extrabold text-gray-900 font-outfit">{{ number_format($totalMembers) }}</div>
                            <div class="text-xs text-gray-500 mt-1">Anggota Aktif</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-extrabold text-gray-900 font-outfit">Rp {{ number_format($totalSavings, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500 mt-1">Dana Simpanan</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-extrabold text-gray-900 font-outfit">Rp {{ number_format($totalLoans, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500 mt-1">Pinjaman Tersalurkan</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Simulasi Widget -->
                <div class="lg:col-span-5 flex justify-center items-center">
                    <div class="relative w-full max-w-md mx-auto lg:mx-0 animate-float">
                        <div class="relative bg-white rounded-2xl border border-gray-100 shadow-2xl p-6 md:p-8">
                            <!-- Widget Header -->
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2 font-outfit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Simulasi Layanan Koperasi
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">Hitung estimasi simpanan atau pinjaman Anda secara instan.</p>
                            </div>

                            <!-- Tabs -->
                            <div class="flex gap-2 p-1 bg-gray-50 rounded-lg mb-6 border border-gray-100">
                                <button id="tab-loan" class="flex-1 py-2 text-xs font-semibold rounded-md transition duration-200 text-center bg-white text-red-600 shadow-sm border border-red-100" onclick="switchTab('loan')">
                                    Simulasi Pinjaman
                                </button>
                                <button id="tab-save" class="flex-1 py-2 text-xs font-semibold rounded-md transition duration-200 text-center text-gray-500 hover:text-gray-700" onclick="switchTab('save')">
                                    Simulasi Simpanan
                                </button>
                            </div>

                            <!-- Loan Calculator Content -->
                            <div id="calc-loan-content">
                                <div class="mb-5">
                                    <div class="flex justify-between text-xs font-semibold text-gray-600 mb-2">
                                        <span>Jumlah Pinjaman</span>
                                        <span id="loan-amount-text" class="text-red-600 font-bold">Rp 5.000.000</span>
                                    </div>
                                    <input type="range" id="loan-amount" min="500000" max="20000000" step="500000" value="5000000" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-red-600" oninput="updateLoanCalc()">
                                    <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                                        <span>Rp 500 Ribu</span>
                                        <span>Rp 20 Juta</span>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <div class="flex justify-between text-xs font-semibold text-gray-600 mb-2">
                                        <span>Tenor (Jangka Waktu)</span>
                                        <span id="loan-tenor-text" class="text-red-600 font-bold">12 Bulan</span>
                                    </div>
                                    <input type="range" id="loan-tenor" min="3" max="24" step="3" value="12" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-red-600" oninput="updateLoanCalc()">
                                    <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                                        <span>3 Bulan</span>
                                        <span>24 Bulan</span>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                                        <span>Bunga (Flat 1.2% / bln)</span>
                                        <span id="loan-interest" class="font-medium text-gray-700">Rp 60.000 / bln</span>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 mb-4 pb-2 border-b border-gray-200/50">
                                        <span>Biaya Admin</span>
                                        <span class="font-medium text-gray-700">Rp 50.000</span>
                                    </div>
                                    <div class="flex justify-between items-baseline">
                                        <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Estimasi Angsuran:</span>
                                        <div class="text-right">
                                            <span id="loan-installment" class="text-2xl font-black text-red-600 font-outfit">Rp 476.667</span>
                                            <span class="text-[10px] text-gray-400 block">/ bulan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Savings Calculator Content (Hidden by default) -->
                            <div id="calc-save-content" class="hidden">
                                <div class="mb-5">
                                    <div class="flex justify-between text-xs font-semibold text-gray-600 mb-2">
                                        <span>Simpanan Bulanan</span>
                                        <span id="save-amount-text" class="text-emerald-600 font-bold">Rp 500.000</span>
                                    </div>
                                    <input type="range" id="save-amount" min="50000" max="5000000" step="50000" value="500000" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-emerald-500" oninput="updateSaveCalc()">
                                    <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                                        <span>Rp 50 Ribu</span>
                                        <span>Rp 5 Juta</span>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <div class="flex justify-between text-xs font-semibold text-gray-600 mb-2">
                                        <span>Jangka Waktu</span>
                                        <span id="save-tenor-text" class="text-emerald-600 font-bold">12 Bulan</span>
                                    </div>
                                    <input type="range" id="save-tenor" min="6" max="36" step="6" value="12" class="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-emerald-500" oninput="updateSaveCalc()">
                                    <div class="flex justify-between text-[10px] text-gray-400 mt-1">
                                        <span>6 Bulan</span>
                                        <span>36 Bulan</span>
                                    </div>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                                        <span>Total Setoran Pokok</span>
                                        <span id="save-principal" class="font-medium text-gray-700">Rp 6.000.000</span>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-500 mb-4 pb-2 border-b border-gray-200/50">
                                        <span>Bagi Hasil (Est. 5% p.a.)</span>
                                        <span id="save-interest" class="text-emerald-500 font-bold">+ Rp 162.500</span>
                                    </div>
                                    <div class="flex justify-between items-baseline">
                                        <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Estimasi Hasil Akhir:</span>
                                        <div class="text-right">
                                            <span id="save-total" class="text-2xl font-black text-emerald-600 font-outfit">Rp 6.162.500</span>
                                            <span class="text-[10px] text-gray-400 block">pada akhir tenor</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('login') }}" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-sm transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                Mulai Ajukan Sekarang
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- FEATURES SECTION (ACCENT COLOR MATCHING LOGO THEME) -->
        <section id="fitur" class="py-20 bg-white border-y border-gray-100 relative">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-base font-bold text-emerald-600 uppercase tracking-wider font-outfit">Fitur Unggulan</h2>
                    <p class="text-3xl md:text-4xl font-extrabold text-gray-900 font-outfit mt-2">
                        Kemudahan Finansial di Tangan Anda
                    </p>
                    <p class="text-sm md:text-base text-gray-500 mt-4 leading-relaxed">
                        Kami menyediakan layanan simpan pinjam berbasis digital yang dirancang untuk kenyamanan, transparansi, dan kecepatan akses anggota.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Feature 1: Simpanan Fleksibel (GREEN ACCENT from Logo Tree) -->
                    <a href="{{ route('login') }}" class="bg-gray-50/50 p-8 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 group hover:-translate-y-2 hover:border-emerald-500/50 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3">Simpanan Fleksibel</h3>
                            <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                                Simpan dana Anda dalam bentuk Simpanan Sukarela atau Berjangka dengan bagi hasil transparan yang menguntungkan.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center gap-1 text-xs font-bold text-emerald-600 group-hover:text-emerald-700">
                            Pelajari Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <!-- Feature 2: Pinjaman Cepat (RED ACCENT from Logo Flag/Chain) -->
                    <a href="{{ route('login') }}" class="bg-gray-50/50 p-8 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 group hover:-translate-y-2 hover:border-red-500/50 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3">Pinjaman Cepat</h3>
                            <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                                Ajukan pinjaman dana darurat atau kebutuhan lainnya langsung dari dashboard Anda dengan validasi dan pencairan cepat.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center gap-1 text-xs font-bold text-red-600 group-hover:text-red-700">
                            Pelajari Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <!-- Feature 3: Akses Mandiri (GOLD ACCENT from Logo Gear/Ribbon) -->
                    <a href="{{ route('login') }}" class="bg-gray-50/50 p-8 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 group hover:-translate-y-2 hover:border-amber-500/50 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3">Akses Mandiri</h3>
                            <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                                Pantau riwayat saldo simpanan, detail tagihan pinjaman, dan angsuran bulanan kapan saja secara mandiri 24/7.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center gap-1 text-xs font-bold text-amber-600 group-hover:text-amber-700">
                            Pelajari Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>

                    <!-- Feature 4: Keamanan Terjamin (BLACK/SLATE ACCENT from Logo Outlines) -->
                    <a href="{{ route('login') }}" class="bg-gray-50/50 p-8 rounded-2xl border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 group hover:-translate-y-2 hover:border-slate-400/50 flex flex-col justify-between">
                        <div>
                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3">Keamanan Terjamin</h3>
                            <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                                Dilengkapi enkripsi data transaksi dan sistem proteksi berlapis untuk menjamin keamanan finansial dan privasi seluruh anggota.
                            </p>
                        </div>
                        <div class="mt-6 flex items-center gap-1 text-xs font-bold text-slate-700 group-hover:text-slate-900">
                            Pelajari Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS SECTION -->
        <section class="py-20 bg-gray-50/30 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-base font-bold text-emerald-600 uppercase tracking-wider font-outfit">Alur Kerja</h2>
                    <p class="text-3xl md:text-4xl font-extrabold text-gray-900 font-outfit mt-2">
                        Mudahnya Mengelola Finansial Bersama KoSiPi
                    </p>
                    <p class="text-sm md:text-base text-gray-500 mt-4 leading-relaxed">
                        Hanya butuh 4 langkah mudah untuk mulai menabung atau mengajukan pinjaman digital di Koperasi IT Del.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative">
                    <!-- Step 1 (Gold Step Outline matching Gear) -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 relative group hover:border-amber-400">
                        <div class="text-5xl font-black text-amber-100 group-hover:text-amber-300 transition duration-300 font-outfit absolute top-4 right-6 select-none">01</div>
                        <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3 pr-8">Daftar Anggota</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                            Hubungi pengurus Koperasi IT Del untuk pendaftaran akun dan verifikasi status keanggotaan resmi Anda.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 relative group hover:border-amber-400">
                        <div class="text-5xl font-black text-amber-100 group-hover:text-amber-300 transition duration-300 font-outfit absolute top-4 right-6 select-none">02</div>
                        <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3 pr-8">Simulasi Mandiri</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                            Gunakan kalkulator simulasi interaktif di landing page untuk menghitung estimasi tabungan atau pinjaman Anda.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 relative group hover:border-amber-400">
                        <div class="text-5xl font-black text-amber-100 group-hover:text-amber-300 transition duration-300 font-outfit absolute top-4 right-6 select-none">03</div>
                        <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3 pr-8">Ajukan Layanan</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                            Masuk ke dashboard anggota untuk mengajukan produk simpanan sukarela atau permohonan pinjaman secara online.
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200/80 shadow-sm hover:shadow-md transition-all duration-300 relative group hover:border-amber-400">
                        <div class="text-5xl font-black text-amber-100 group-hover:text-amber-300 transition duration-300 font-outfit absolute top-4 right-6 select-none">04</div>
                        <h3 class="text-lg font-bold text-gray-900 font-outfit mb-3 pr-8">Pencairan & Pantau</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">
                            Terima pencairan pinjaman secara langsung ke rekening Anda dan pantau seluruh transaksi langsung dari handphone.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ SECTION -->
        <section class="py-20 max-w-4xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base font-bold text-emerald-600 uppercase tracking-wider font-outfit">FAQ</h2>
                <p class="text-3xl font-extrabold text-gray-900 font-outfit mt-2">Pertanyaan Populer</p>
                <p class="text-xs md:text-sm text-gray-500 mt-2">Informasi cepat mengenai layanan Koperasi Simpan Pinjam Digital IT Del.</p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(1)">
                        <span class="font-semibold text-sm md:text-base text-gray-900 ">Bagaimana cara menjadi anggota KoSiPi IT Del?</span>
                        <svg id="faq-icon-1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-content-1" class="hidden px-6 pb-5 text-xs md:text-sm text-gray-500 leading-relaxed border-t border-gray-100 pt-4">
                        Pendaftaran anggota dilakukan secara terpusat oleh administrator koperasi. Anda dapat menghubungi pengurus koperasi IT Del untuk proses pembuatan akun dan verifikasi keanggotaan Anda.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(2)">
                        <span class="font-semibold text-sm md:text-base text-gray-900 ">Berapa suku bunga pinjaman di KoSiPi IT Del?</span>
                        <svg id="faq-icon-2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-content-2" class="hidden px-6 pb-5 text-xs md:text-sm text-gray-500 leading-relaxed border-t border-gray-100 pt-4">
                        Suku bunga pinjaman flat berkisar 1.2% per bulan. Bunga ini bersifat kompetitif dan seluruh bagi hasil pengelolaan dana dikembalikan kepada anggota dalam bentuk Sisa Hasil Usaha (SHU) setiap tahunnya.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-gray-200 bg-white rounded-xl overflow-hidden shadow-sm">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFaq(3)">
                        <span class="font-semibold text-sm md:text-base text-gray-900 ">Apakah simpanan sukarela bisa ditarik kapan saja?</span>
                        <svg id="faq-icon-3" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq-content-3" class="hidden px-6 pb-5 text-xs md:text-sm text-gray-500 leading-relaxed border-t border-gray-100 pt-4">
                        Ya, Simpanan Sukarela dapat Anda tarik sewaktu-waktu sesuai ketentuan penarikan yang berlaku. Anda dapat mengajukan permohonan penarikan langsung melalui dashboard Member KoSiPi Anda.
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS SECTION (LOGO ACCENTED AVATARS) -->
        <section class="py-20 bg-gray-50/30 border-t border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-base font-bold text-emerald-600 uppercase tracking-wider font-outfit">Testimoni</h2>
                    <p class="text-3xl font-extrabold text-gray-900 font-outfit mt-2">Apa Kata Mereka tentang KoSiPi?</p>
                    <p class="text-xs md:text-sm text-gray-500 mt-2">Dengarkan pengalaman langsung dari civitas akademika IT Del.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1: Red Avatar matching logo Red -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                        <p class="text-sm text-gray-600 italic leading-relaxed">
                            "Proses pengajuan pinjaman darurat sangat mudah dan cepat. Seluruh persyaratan diunggah secara online, dan status approval-nya sangat transparan."
                        </p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-red-50 text-red-700 flex items-center justify-center font-bold text-sm select-none font-outfit">
                                AS
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 font-outfit">Andry S.</h4>
                                <p class="text-[10px] text-gray-400">Staff Akademik IT Del</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Green Avatar matching logo Green -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                        <p class="text-sm text-gray-600 italic leading-relaxed">
                            "Sistem bagi hasil dari simpanan sukarela sangat bersaing. Saya bisa melihat pertumbuhan saldo simpanan pokok dan wajib secara real-time setiap bulan."
                        </p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-sm select-none font-outfit">
                                RM
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 font-outfit">Rina M.</h4>
                                <p class="text-[10px] text-gray-400">Dosen Fakultas Informatika</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Gold Avatar matching logo Gold -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
                        <p class="text-sm text-gray-600 italic leading-relaxed">
                            "Dengan adanya platform digital KoSiPi, kami selaku pengurus tidak lagi dipusingkan oleh tumpukan formulir kertas. Semua rekapitulasi data tersimpan aman dan akurat."
                        </p>
                        <div class="mt-6 flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-sm select-none font-outfit">
                                HT
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 font-outfit">Hendri T.</h4>
                                <p class="text-[10px] text-gray-400">Pengurus Koperasi IT Del</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA BANNER SECTION (RED ACTION BUTTON matching brand red) -->
        <section class="py-16 max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="relative bg-white border border-gray-200 rounded-3xl overflow-hidden p-8 md:p-12 shadow-xl flex flex-col md:flex-row items-center justify-between gap-6">
                
                <div class="relative z-10 max-w-xl text-left">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 font-outfit">Siap Mengelola Finansial Anda Secara Digital?</h2>
                    <p class="text-xs md:text-sm text-gray-500 mt-2 leading-relaxed">
                        Masuk ke dashboard anggota untuk melihat histori tabungan, ajukan pinjaman cepat, dan kelola akun koperasi Anda sekarang juga.
                    </p>
                </div>
                <div class="relative z-10 shrink-0">
                    <a href="{{ route('login') }}" class="px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-sm transition-all duration-200 shadow-md hover:shadow-lg inline-flex items-center gap-2">
                        Masuk Dashboard
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <x-ui.footer maxWidth="max-w-7xl" />
    </div>

    <!-- Interactive script for calculator and FAQ accordion -->
    <x-slot:scripts>
        <script>
            // TAB SWITCHER
            function switchTab(type) {
                const loanBtn = document.getElementById('tab-loan');
                const saveBtn = document.getElementById('tab-save');
                const loanContent = document.getElementById('calc-loan-content');
                const saveContent = document.getElementById('calc-save-content');

                if (type === 'loan') {
                    loanBtn.className = "flex-1 py-2 text-xs font-semibold rounded-md transition duration-200 text-center bg-white text-red-600 shadow-sm border border-red-100";
                    saveBtn.className = "flex-1 py-2 text-xs font-semibold rounded-md transition duration-200 text-center text-gray-500 hover:text-gray-700";
                    loanContent.classList.remove('hidden');
                    saveContent.classList.add('hidden');
                } else {
                    saveBtn.className = "flex-1 py-2 text-xs font-semibold rounded-md transition duration-200 text-center bg-white text-emerald-600 shadow-sm border border-emerald-100";
                    loanBtn.className = "flex-1 py-2 text-xs font-semibold rounded-md transition duration-200 text-center text-gray-500 hover:text-gray-700";
                    saveContent.classList.remove('hidden');
                    loanContent.classList.add('hidden');
                }
            }

            // FORMAT NUMBER TO RUPIAH
            function formatRupiah(value) {
                return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            // LOAN CALCULATOR LOGIC
            function updateLoanCalc() {
                const amountInput = document.getElementById('loan-amount');
                const tenorInput = document.getElementById('loan-tenor');
                
                const amount = parseInt(amountInput.value);
                const tenor = parseInt(tenorInput.value);

                document.getElementById('loan-amount-text').innerText = formatRupiah(amount);
                document.getElementById('loan-tenor-text').innerText = tenor + ' Bulan';

                // Calculation details
                const interestRate = 0.012; // Flat 1.2% per month
                const monthlyInterest = Math.round(amount * interestRate);
                const monthlyPrincipal = Math.round(amount / tenor);
                const monthlyInstallment = monthlyPrincipal + monthlyInterest;

                document.getElementById('loan-interest').innerText = formatRupiah(monthlyInterest) + ' / bln';
                document.getElementById('loan-installment').innerText = formatRupiah(monthlyInstallment);
            }

            // SAVINGS CALCULATOR LOGIC
            function updateSaveCalc() {
                const amountInput = document.getElementById('save-amount');
                const tenorInput = document.getElementById('save-tenor');

                const monthlySave = parseInt(amountInput.value);
                const tenor = parseInt(tenorInput.value);

                document.getElementById('save-amount-text').innerText = formatRupiah(monthlySave);
                document.getElementById('save-tenor-text').innerText = tenor + ' Bulan';

                // Calculation details
                const annualInterestRate = 0.05; // Est. 5% p.a.
                const monthlyInterestRate = annualInterestRate / 12;
                
                const principal = monthlySave * tenor;
                
                // Future value of ordinary annuity formula
                // FV = PMT * [((1 + r)^n - 1) / r]
                let total = 0;
                for(let i = 0; i < tenor; i++) {
                    total = (total + monthlySave) * (1 + monthlyInterestRate);
                }
                total = Math.round(total);
                const interestEarned = total - principal;

                document.getElementById('save-principal').innerText = formatRupiah(principal);
                document.getElementById('save-interest').innerText = '+ ' + formatRupiah(interestEarned);
                document.getElementById('save-total').innerText = formatRupiah(total);
            }

            // FAQ ACCORDION TOGGLE
            function toggleFaq(id) {
                const content = document.getElementById('faq-content-' + id);
                const icon = document.getElementById('faq-icon-' + id);

                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.classList.add('rotate-180');
                } else {
                    content.classList.add('hidden');
                    icon.classList.remove('rotate-180');
                }
            }

            // Initialize calculators
            window.addEventListener('DOMContentLoaded', () => {
                updateLoanCalc();
                updateSaveCalc();
            });
        </script>
    </x-slot:scripts>
</x-ui.layout>
