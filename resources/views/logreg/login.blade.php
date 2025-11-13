<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen" style="background-color: #F3F4F6;">

    <div class="shadow-xl rounded-2xl flex overflow-hidden max-w-6xl w-full" style="background-color: #FFFFFF;">
        <!-- Bagian kiri (Form Login) -->
        <div class="w-1/2 p-10 flex flex-col justify-center">
            <h1 class="text-5xl font-extrabold mb-3 text-center" style="color: #111827;">Welcome</h1>
            <p class="mb-8 text-center" style="color: #6B7280;">Please login to continue your journey with us</p>

            <form action="{{ route('logreg.login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block mb-1" style="color: #374151;">Username</label>
                    <div class="flex items-center rounded-xl px-3 py-2" style="border: 1px solid #D1D5DB;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="#9CA3AF">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.878 6.197M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <input type="text" name="username" id="username" required class="w-full outline-none border-none" style="color: #374151; placeholder-color: #9CA3AF;" placeholder="Username">
                    </div>
                </div>

                <div>
                    <label for="password" class="block mb-1" style="color: #374151;">Password</label>
                    <div class="flex items-center rounded-xl px-3 py-2" style="border: 1px solid #D1D5DB;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="#9CA3AF">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3V5a3 3 0 00-6 0v3c0 1.657 1.343 3 3 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11h14v10H5z" />
                        </svg>
                        <input type="password" name="password" id="password" required class="w-full outline-none border-none" style="color: #374151; placeholder-color: #9CA3AF;" placeholder="Password">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl font-semibold transition"
                        style="background-color: #000000; color: #FFFFFF;"
                        onmouseover="this.style.backgroundColor='#1F2937'"
                        onmouseout="this.style.backgroundColor='#000000'">
                    LOGIN
                </button>

                <div class="flex items-center justify-center my-4">
                    <span class="border-b" style="width: 20%; border-color: #D1D5DB;"></span>
                    <span class="text-sm mx-2" style="color: #9CA3AF;">or login with others</span>
                    <span class="border-b" style="width: 20%; border-color: #D1D5DB;"></span>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="button" class="flex items-center justify-center gap-2 rounded-xl py-2 transition border"
                            style="border-color: #D1D5DB;"
                            onmouseover="this.style.backgroundColor='#F9FAFB'"
                            onmouseout="this.style.backgroundColor='transparent'">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="google">
                        <span style="color: #374151;">Login with Google</span>
                    </button>

                    <button type="button" class="flex items-center justify-center gap-2 rounded-xl py-2 transition border"
                            style="border-color: #D1D5DB;"
                            onmouseover="this.style.backgroundColor='#F9FAFB'"
                            onmouseout="this.style.backgroundColor='transparent'">
                        <img src="https://www.svgrepo.com/show/448224/facebook.svg" class="w-5 h-5" alt="facebook">
                        <span style="color: #374151;">Login with Facebook</span>
                    </button>
                </div>

                <div>
                    <p class="text-center" style="color: #6B7280;">
                        Don't have an account?
                        <a href="{{ route('logreg.register') }}" style="color: #BF4141; font-weight: 600; text-decoration: underline;">Register</a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Bagian kanan (Gambar Ilustrasi) -->
        <div class="w-1/2 flex items-center justify-center p-6" style="background-color: #BF4141;">
            <img src="{{ asset('images/kos.webp') }}" alt="illustration" class="rounded-2xl shadow-lg w-full object-cover">
        </div>
    </div>

</body>
</html>
