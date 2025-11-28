<nav class="bg-[#940000] fixed top-0 left-0 w-full z-50">
    <div class="text-white container mx-auto px-6 py-4 flex items-center justify-between">

        <a href="{{ route('dashboard') }}" class="text-3xl font-extrabold tracking-tight">
            UrHomey
        </a>

        <div class="flex justify-center gap-6">

            <a href="{{ route('dashboard') }}"
               class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                Dashboard
            </a>

            <a href="{{ route('kamar.index') }}"
               class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                Data Kamar
            </a>

            <a href="{{ route('penyewa.index') }}"
               class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                Data Penyewa
            </a>

            <a href="{{ route('transaksi.data') }}"
               class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                Data Transaksi
            </a>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-lg font-bold">
                {{ session('pemilik.username') }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-white text-black font-semibold px-4 py-2 rounded-lg shadow">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
