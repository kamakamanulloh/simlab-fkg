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
<!-- GLOBAL LOADING -->

<div id="globalLoading"
class="fixed inset-0 bg-black/40 z-[9999] hidden items-center justify-center">

<div class="bg-white rounded-xl shadow-lg px-6 py-4 flex items-center gap-3">

<svg class="animate-spin h-5 w-5 text-blue-600"
xmlns="http://www.w3.org/2000/svg"
fill="none"
viewBox="0 0 24 24">

<circle
class="opacity-25"
cx="12"
cy="12"
r="10"
stroke="currentColor"
stroke-width="4">
</circle>

<path
class="opacity-75"
fill="currentColor"
d="M4 12a8 8 0 018-8v8H4z">
</path>

</svg>

<span class="text-sm font-medium text-gray-700">
Memproses...
</span>

</div>

</div>
@if(auth()->user()->role === 'Dosen')
    @include('partials.sidebar-dosen')
@elseif(auth()->user()->role === 'Mahasiswa')
    @include('partials.sidebar-mahasiswa')
@else
    @include('partials.sidebar')
@endif
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

  
@stack('scripts')
 
</body>
</html>
