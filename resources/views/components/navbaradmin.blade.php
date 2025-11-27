<nav class="bg-[#940000] fixed top-0 left-0 w-full z-50">
    <div class="text-white container mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-3xl font-extrabold tracking-tight">UrHomey</a>
        </div>

        <div class="flex justify-center">
            <div class=" md:flex items-center ml-6 rounded-lg px-3 py-2">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                    Dashboard
                </a>
            </div>

            <div class=" md:flex items-center ml-6 rounded-lg px-3 py-2">
                <a href="{{ route('kamar.index') }}" class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                    Data Kamar
                </a>
            </div>

            <div class=" md:flex items-center ml-6 rounded-lg px-3 py-2">
                <a href="{{ route('penyewa.index') }}" class="text-xl font-semibold px-3 py-1 rounded-md hover:bg-white/30 transition">
                    Data Penyewa
                </a>
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}"
            class=" text-white text-lg font-bold px-4 py-2 transition">
                {{ session('pemilik.username') }}
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-block bg-white text-black font-semibold px-4 py-2 rounded-lg shadow hover:opacity-90 transition">Logout</button>
            </form>
        </div>
    </div>
</nav>
