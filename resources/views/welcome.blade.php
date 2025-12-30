<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PLN - Job Safety Observation</title>

    {{-- Font Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Mendefinisikan warna PLN */
        .pln-blue { background-color: #0076a3; } /* Biru primer PLN */
        .pln-blue-hover:hover { background-color: #005a7d; }
        /* Warna oranye sekunder PLN untuk Register */
        .pln-orange { background-color: #f7931e; }
        .pln-orange-hover:hover { background-color: #d17c15; }

        /* Menggunakan font Poppins yang lebih ringan */
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gray-50">

    {{-- Container Utama: Membuat halaman terpusat dan penuh layar --}}
    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        
        {{-- Card Minimalis: Kontainer utama yang bersih --}}
        <div class="w-full max-w-sm bg-white rounded-lg p-8 shadow-lg border border-gray-100">
            
            <div class="flex flex-col items-center">
                
                {{-- Logo PLN (Placeholder, asumsi Anda memiliki file di public/images/) --}}
                <div class="mb-6 text-center">
                    {{-- Ganti dengan logo PLN jika ada --}}
                    <img src="{{ asset('images/logo-pln.png') }}" alt="Logo PLN" class="h-16 w-auto mx-auto">
                </div>
                
                {{-- Teks Aplikasi --}}
                <div class="mb-6 text-center">
                    {{-- PERUBAHAN: text-xl menjadi text-lg untuk mengecilkan judul --}}
                    <h2 class="text-lg font-bold text-gray-800 tracking-tight">
                        APLIKASI JOB SAFETY OBSERVATION KESELAMATAN KESEHATAN KERJA
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        PT PLN (Persero) UP3 BANJARMASIN
                    </p>
                </div>

                @if (Route::has('login'))
                    <div class="w-full space-y-4 mt-2">
                        @auth
                            {{-- Jika Sudah Login --}}
                            <a href="{{ url('/dashboard') }}" 
                                class="w-full flex justify-center text-white font-semibold py-2.5 px-4 rounded-md pln-blue pln-blue-hover transition duration-300 shadow-md">
                                MASUK KE DASHBOARD
                            </a>
                        @else
                            {{-- Tombol Login --}}
                            <a href="{{ route('login') }}" 
                                class="w-full flex justify-center text-white font-semibold py-2.5 px-4 rounded-md pln-blue pln-blue-hover transition duration-300 shadow-md">
                                LOGIN
                            </a>

                            @if (Route::has('register'))
                                {{-- Tombol Register --}}
                                <a href="{{ route('register') }}" 
                                    class="w-full flex justify-center text-white font-semibold py-2.5 px-4 rounded-md pln-orange pln-orange-hover transition duration-300 shadow-md">
                                    REGISTER
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
            
        </div>
        
    </div>
    
</body>
</html>