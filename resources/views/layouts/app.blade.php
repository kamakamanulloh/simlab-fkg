<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SIM-Lab FKG')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

      @vite(['resources/css/app.css', 
      'resources/css/limbah-modal.css',
      'resources/js/app.js',
       'resources/js/jadwal-calendar.js',
       'resources/css/maintenance.css',
    'resources/js/maintenance-modal.js',
     'resources/js/logbook.js',
    ])

<meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Chart.js untuk grafik --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f6f7f5;
        }
    </style>
    @stack('head')
</head>
<body class="min-h-screen flex bg-[#f6f7f5] text-slate-900">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Main content --}}
    <div class="flex-1 flex flex-col min-h-screen">
        {{-- Header --}}
        @include('partials.header')

        <main class="flex-1 px-6 py-4 md:px-10 md:py-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('partials.footer')
    </div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="https://unpkg.com/html5-qrcode@2.3.8/minified/html5-qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  
@stack('scripts')
 
</body>
</html>
