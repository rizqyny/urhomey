<nav class="fixed top-0 left-0 w-full z-50 bg-[#940000]/95 backdrop-blur-md border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 sm:h-20 items-center justify-between gap-4">

            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-2xl bg-white/15 flex items-center justify-center shadow-md">
                        <span class="text-white text-lg font-extrabold">U</span>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-white">
                        UrHomey
                    </span>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-4 lg:gap-6">
                <a href="{{ route('dashboard') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/20 transition">
                    Dashboard
                </a>

                <a href="{{ route('kamarku') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/20 transition">
                    KamarKu
                </a>

                <a href="{{ route('laporan') }}"
                   class="text-sm lg:text-base font-medium px-3 py-2 rounded-full text-white/80 hover:text-white hover:bg-white/20 transition">
                    Lapor Kerusakan
                </a>
            </div>

            <div class="relative">
                <button id="notifButton"
                    class="relative flex items-center justify-center w-10 h-10 rounded-full hover:bg-white/10 transition">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.8" stroke="white"
                        class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M14.857 17.657A2 2 0 0112.95 19h-1.9a2 2 0 01-1.907-1.343M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9z"/>
                    </svg>

                    @if(isset($notifikasiKamarHabis))
                        <span class="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
                        <span class="absolute top-1 right-1 w-3 h-3 bg-red-600 rounded-full"></span>
                    @endif
                </button>

            </div>

            <div id="notifModal" class="fixed inset-0 hidden bg-black/40 backdrop-blur-sm
           items-center justify-center">

                <div class="bg-white rounded-2xl shadow-xl p-6 w-80 animate-fadeIn items-center">
                    <h2 class="text-lg font-bold mb-3 text-gray-800">Notifikasi</h2>

                    @if(isset($notifikasiKamarHabis))
                        <p class="text-gray-700">
                            Masa sewa kamar <b>{{ $notifikasiKamarHabis->nomor_kamar }}</b>
                            akan berakhir dalam 24 jam.
                        </p>
                    @else
                        <p class="text-gray-600">Tidak ada notifikasi.</p>
                    @endif

                    <button id="closeNotif"
                        class="mt-5 w-full bg-[#940000] text-white py-2 rounded-xl hover:bg-red-700 transition">
                        Tutup
                    </button>
                </div>
            </div>


            <script>
                document.getElementById('notifButton').onclick = () => {
                    const modal = document.getElementById('notifModal');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');  // tampil & tengah
                };

                document.getElementById('closeNotif').onclick = () => {
                    const modal = document.getElementById('notifModal');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                };
            </script>

            <div class="flex items-center gap-3">
                <a href="{{ route('profile') }}"
                   class="hidden sm:inline-flex items-center text-sm sm:text-base font-semibold text-white px-3 py-2 rounded-full hover:bg-white/10 transition">
                    {{ session('penyewa.username') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-block bg-white text-black text-sm sm:text-base font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-slate-100 hover:shadow-lg transition">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
