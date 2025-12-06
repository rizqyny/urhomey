<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">

    @if(session()->has('penyewa'))
        @include('components.navbar')

    @elseif(session()->has('pemilik'))
        @include('components.navbaradmin')

    @else
        @unless(Request::routeIs('login'))
        <nav class="bg-[#940000] fixed top-0 left-0 w-full z-50">
            <div class="text-white container mx-auto px-6 py-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-3xl font-extrabold tracking-tight">
                        UrHomey
                    </a>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('login') }}"
                    class="inline-block bg-white text-black font-semibold px-4 py-2 rounded-lg shadow hover:opacity-90 transition">
                        Login
                    </a>
                </div>
            </div>
        </nav>
        @endunless
    @endif

    <main class='grow container mx-auto pt-16 pb-8'>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>
