<nav class="fixed top-0 left-0 w-full z-50 bg-[#940000]/95 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 sm:h-20 items-center justify-between">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-2xl bg-white/15 flex items-center justify-center shadow-md">
                    <span class="text-white text-lg font-extrabold">U</span>
                </div>
                <span class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    UrHomey
                </span>
            </a>

            <div class="hidden md:flex items-center gap-4 lg:gap-6">
                <a href="{{ route('dashboard') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/15 transition">
                    Dashboard
                </a>

                <a href="{{ route('kamar.index') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/15 transition">
                    Data Kamar
                </a>

                <a href="{{ route('penyewa.index') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/15 transition">
                    Data Penyewa
                </a>

                <a href="{{ route('transaksi.data') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/15 transition">
                    Data Transaksi
                </a>

                <a href="{{ route('laporan.index') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/15 transition">
                    Daftar Laporan
                </a>
            </div>
=
            <div class="flex items-center gap-3 sm:gap-4">
                <span class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-white">
                    <span class="inline-flex w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    {{ session('pemilik.username') }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="text-sm sm:text-base font-semibold px-4 py-2 rounded-lg bg-white text-black hover:bg-slate-100 shadow-md hover:shadow-lg transition">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
