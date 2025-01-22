<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.png') }}">
    <title>{{ config('app.name', 'Politeknik LP3I Kampus Tasikmalaya') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Source+Code+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="{{ asset('js/leaflet.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @stack('styles')
    <style>
        html,
        body {
            scroll-behavior: smooth;
        }
        #map, #map-school { height: 500px; }
        body {
            font-family: 'Roboto Mono', monospace;
            font-family: 'Source Code Pro', monospace;
        }

        td,
        th {
            white-space: nowrap;
        }

        .dataTables_length>label {
            font-size: 14px !important;
            color: #6b7280 !important;
        }

        .dataTables_info,
        .paginate_button {
            font-size: 14px !important;
            color: #6b7280 !important;
        }

        .dataTables_length>label>select {
            font-size: 14px !important;
            padding: 3px 20px 3px 15px !important;
            border-radius: 10px !important;
            margin: 5px !important;
        }

        .dataTables_filter>label {
            font-size: 14px !important;
        }

        .dataTables_filter>label>input {
            margin: 5px !important;
            border-radius: 10px !important;
        }

        #progress_bar {
            transition: width 0.5s ease;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="font-sans scroll-smooth">
    <div id="api_endpoint_lp3i" class="hidden">{{ env('API_LP3I') }}</div>

    <div class="flex flex-col items-center justify-center bg-black bg-opacity-90 w-full h-full z-50 fixed hidden"
        id="data-loading">
        <lottie-player src="{{ asset('animations/server.json') }}" background="Transparent" speed="1"
            style="width: 300px; height: 300px" direction="1" mode="normal" loop autoplay></lottie-player>
        <h1 class="text-white relative top-[-40px] text-sm">Sedang memuat data...</h1>
    </div>
    <div class="min-h-screen bg-white">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-gray-50">
            <div class="w-full max-w-7xl mx-auto pt-4 pb-8 px-5 md:px-0">
                {{ $header }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="w-full max-w-7xl mx-auto py-10 px-5 md:px-0">
            {{ $slot }}
        </main>
    </div>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/chart.umd.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script>
        const showLoadingAnimation = () => {
            document.getElementById('data-loading').classList.remove('hidden');
        }

        const hideLoadingAnimation = () => {
            document.getElementById('data-loading').classList.add('hidden');
        }
    </script>
    <script>
        const URL_API_LP3I = document.getElementById('api_endpoint_lp3i').innerText;
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.js-example-input-single').select2();
        });
    </script>
    @stack('utilities')
    @stack('scripts')
    @stack('script2')
</body>

</html>
