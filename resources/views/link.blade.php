<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Politeknik LP3I Kampus Tasikmalaya adalah kampus vokasi di Priangan Timur dengan penempatan kerja. Tepat dan Cepat Kerja!">
    <meta name="author" content="Politeknik LP3I Kampus Tasikmalaya" />
    <meta name="keywords"
        content="Kampus Penempatan Kerja, Kampus Tasikmalaya, Kuliah di Tasikmalaya, Kampus Dengan Penempatan kerja, Kuliah Sambil Kerja, Tasikmalaya, Kampus Vokasi, LP3I Tasikmalaya, Politeknik LP3I Kampus Tasikmalaya, LP3I, Tepat dan Cepat Kerja, Kuliah murah di Tasikmalaya">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fontss -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Source+Code+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-gradient-to-tr from-[#00426D] to-[#009DA5] h-screen flex flex-col justify-center items-center">
    <div class="container max-w-sm mx-auto flex flex-col items-center justify-center gap-8">
        <img src="{{ asset('img/lp3i-logo-white.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="h-16 drop-shadow">
        <div class="text-center space-y-1 drop-shadow">
            <h2 class="font-bold text-base text-white">PMB Politeknik LP3I Kampus Tasikmalaya</h2>
            <p class="text-sm text-white">Tanya-Tanya, Daftar, Registrasi Ulang. Klik Kontak & Link yang tertera.</p>
        </div>
        <div class="w-full text-center space-y-3 text-sm">
            <a href="https://pmb.politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-white hover:bg-gray-100 py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Website Pendaftaran
            </a>
            <a href="https://politekniklp3i-tasikmalaya.ac.id/penerimaan-mahasiswa" target="_blank" class="block bg-white hover:bg-gray-100 py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Info PMB
            </a>
            <a href="https://sbpmb.politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-white hover:bg-gray-100 py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Beasiswa Kuliah di Politeknik LP3I
            </a>
            <a href="#" target="_blank" class="block bg-white hover:bg-gray-100 py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Brosur Digital
            </a>
            <a href="https://politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-white hover:bg-gray-100 py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Website Kampus
            </a>
            <a href="https://virtualkampus.politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-white hover:bg-gray-100 py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Virtual Tour
            </a>
        </div>
    </div>
    <div class="fixed right-0 bottom-0">
        <a href="https://politekniklp3i-tasikmalaya.ac.id/penerimaan-mahasiswa" target="_blank" class="flex items-center justify-center">
            <lottie-player src="{{ asset('animations/whatsapp.json') }}" background="Transparent" speed="1"
                style="width: 100px; height: 100px" direction="1" mode="normal" loop autoplay></lottie-player>
        </a>
    </div>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>
</body>

</html>
