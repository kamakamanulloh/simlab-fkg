<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>SIM-Lab FKG Unhas - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tailwind CDN (bisa nanti dipindah ke Vite) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            background: radial-gradient(circle at top left, #e9f8f1 0, #f8fbfa 40%, #f2f5f4 100%);
            min-height: 100vh;
        }
        .glass-card {
            background: rgba(255,255,255,0.9);
            box-shadow: 0 20px 40px rgba(15, 118, 110, 0.12);
            backdrop-filter: blur(18px);
        }
        .soft-card {
            box-shadow: 0 20px 40px rgba(148, 163, 184, 0.25);
        }
    </style>
</head>
<body class="flex items-center justify-center px-4 py-10">

<div class="max-w-6xl w-full grid md:grid-cols-2 gap-10 items-center">
    {{-- LEFT PANEL --}}
    <div class="space-y-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-emerald-700 flex items-center justify-center">
                {{-- Ikon daun --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.7">
                    <path d="M5 20c12 0 14-9 14-15-6 0-15 2-15 14 0 .34.02.67.05 1"/>
                    <path d="M9 14c1 1 2 2 3 2 2 0 3-2 3-4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl md:text-4xl font-semibold text-emerald-900">SIM-Lab</h1>
                <p class="text-sm text-emerald-700">
                    Sistem Informasi Pengelolaan Laboratorium<br>
                    <span class="text-xs text-emerald-600">
                        Laboratorium Keterampilan Klinik FKG Unhas
                    </span>
                </p>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden bg-white soft-card">
            {{-- ganti asset() dengan gambar lokal kalau sudah ada --}}
            <img src="{{ asset('images/mikroskop.png') }}"
                 alt="Microscope" class="w-full h-72 object-cover">
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="glass-card rounded-3xl p-8 md:p-10">
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-emerald-900 mb-2">Selamat Datang Kembali</h2>
            <p class="text-sm text-emerald-700">
                Masukkan kredensial Anda untuk melanjutkan.
            </p>
        </div>

        <div id="errorBox"
             class="hidden mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700"></div>

        <form id="loginForm" class="space-y-5">
            @csrf
            {{-- Username --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-emerald-900">Username</label>
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16 14a4 4 0 10-8 0m8 0a4 4 0 01-8 0m8 0v1a4 4 0 004 4h1m-13-5v1a4 4 0 01-4 4H3m9-13a3 3 0 110 6 3 3 0 010-6z" />
                    </svg>
                    <input type="text" name="username" autocomplete="username"
                           class="flex-1 bg-transparent border-none focus:outline-none focus:ring-0 text-sm text-emerald-900 placeholder-emerald-400"
                           placeholder="Masukkan username Anda">
                </div>
            </div>

            {{-- Password --}}
            <div class="space-y-2">
                <label class="block text-sm font-medium text-emerald-900">Password</label>
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 15v2m-6-7h12v10H6V10zm3-2a3 3 0 016 0v2H9V8z" />
                    </svg>
                    <input type="password" name="password" autocomplete="current-password"
                           class="flex-1 bg-transparent border-none focus:outline-none focus:ring-0 text-sm text-emerald-900 placeholder-emerald-400"
                           placeholder="Masukkan password Anda">
                </div>
            </div>

            {{-- Tombol --}}
            <div class="pt-2">
                <button id="btnLogin" type="submit"
                        class="w-full rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-3 shadow-lg shadow-emerald-300/40 transition">
                    Masuk ke Sistem
                </button>
            </div>

            <div class="text-center">
                <a href="#" class="text-xs text-emerald-700 hover:underline">Lupa password?</a>
            </div>
        </form>

        <div class="mt-8">
            <div class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-2 text-[11px] text-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Sesuai standar GLP, ISO 15189/17025, dan SPMI</span>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });

    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        $('#errorBox').addClass('hidden').text('');
        $('#btnLogin').prop('disabled', true).text('Memproses...');

        $.post({
            url: "{{ route('login.ajax') }}",
            data: $(this).serialize(),
            success: function (res) {
                if (res.redirect) {
                    window.location.href = res.redirect;
                } else {
                    window.location.reload();
                }
            },
            error: function (xhr) {
                $('#btnLogin').prop('disabled', false).text('Masuk ke Sistem');

                if (xhr.status === 422 || xhr.status === 401 || xhr.status === 429) {
                    let msg = xhr.responseJSON?.message || 'Login gagal.';
                    $('#errorBox').removeClass('hidden').text(msg);
                } else {
                    alert('Terjadi kesalahan pada server.');
                }
            }
        });
    });
</script>
</body>
</html>
