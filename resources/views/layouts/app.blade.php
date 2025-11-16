<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">

    @if(session()->has('penyewa.username'))
        @include('components.navbar')
    @else

        @unless(Request::routeIs('login'))
        <nav class="bg-[#940000]">
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


    <main class='grow container mx-auto'>
        @yield('content')
    </main>

</body>
</html>