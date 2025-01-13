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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="background-image: url('{{ asset('img/background-campus.jpg') }}')" class="bg-center bg-cover bg-gray-700 bg-blend-multiply flex flex-col justify-center items-center py-10">
    <div class="container max-w-lg mx-auto flex flex-col items-center justify-center gap-5 px-5 md:px-0">
        <div class="profile-card bg-white rounded-2xl shadow-lg p-3 space-y-4">
            <div class="flex flex-col justify-center items-center gap-4 bg-gray-100 p-5 rounded-2xl">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/lp3i-logo.svg') }}" alt="" class="h-16">
                    <img src="{{ asset('img/akreditasi.png') }}" alt="" class="h-16">
                </div>
                <div class="text-center space-y-1">
                    <h3 class="font-bold text-base text-gray-900">PMB Politeknik LP3I Kampus Tasikmalaya</h3>
                    <p class="text-sm text-gray-700">Tanya-Tanya, Daftar, Registrasi Ulang. Klik Kontak
                        & Link yang tertera.</p>
                </div>
            </div>
            <div class="flex items-center justify-center gap-3">
                <a href="https://www.instagram.com/lp3i.tasik" target="_blank" class="text-gray-700 hover:text-gray-800">
                    <i class="fa-brands fa-instagram text-2xl"></i>
                </a>
                <a href="https://www.facebook.com/lp3i.tasik" target="_blank" class="text-gray-700 hover:text-gray-800">
                    <i class="fa-brands fa-facebook text-2xl"></i>
                </a>
                <a href="https://www.threads.net/@lp3i.tasik" target="_blank" class="text-gray-700 hover:text-gray-800">
                    <i class="fa-brands fa-threads text-2xl"></i>
                </a>
                <a href="https://www.tiktok.com/@lp3i.tasik" target="_blank" class="text-gray-700 hover:text-gray-800">
                    <i class="fa-brands fa-tiktok text-2xl"></i>
                </a>
                <a href="https://www.youtube.com/lp3itasik" target="_blank" class="text-gray-700 hover:text-gray-800">
                    <i class="fa-brands fa-youtube text-2xl"></i>
                </a>
            </div>
        </div>
        <div id="links" class="w-full text-center space-y-3 text-sm">
            <a href="https://pmb.politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-lp3i-100 hover:bg-lp3i-200 text-white font-medium drop-shadow py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Website Pendaftaran
            </a>
            <a href="https://politekniklp3i-tasikmalaya.ac.id/penerimaan-mahasiswa" target="_blank" class="block bg-lp3i-100 hover:bg-lp3i-200 text-white font-medium drop-shadow py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Info PMB
            </a>
            <a href="https://forms.gle/UqLyNAdcafMQF4PB8" target="_blank" class="block bg-lp3i-100 hover:bg-lp3i-200 text-white font-medium drop-shadow py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Beasiswa Kuliah di Politeknik LP3I
            </a>
            <a href="#" target="_blank" class="block bg-lp3i-100 hover:bg-lp3i-200 text-white font-medium drop-shadow py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Brosur Digital
            </a>
            <a href="https://politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-lp3i-100 hover:bg-lp3i-200 text-white font-medium drop-shadow py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Website Kampus
            </a>
            <a href="https://virtualkampus.politekniklp3i-tasikmalaya.ac.id" target="_blank" class="block bg-lp3i-100 hover:bg-lp3i-200 text-white font-medium drop-shadow py-2.5 px-4 transition-all ease-in-out rounded-xl">
                Virtual Tour
            </a>
        </div>
        <div class="w-full grid grid-cols-3 gap-3">
            <a id="link-one" href="https://forms.gle/UqLyNAdcafMQF4PB8" target="_blank" class="bg-lp3i-100 hover:bg-lp3i-200 transition-all ease-in-out p-4 rounded-xl space-y-2 drop-shadow-lg">
                <img src="{{ asset('ads/link-ads-1.jpg') }}" alt="" class="rounded-lg">
                <h4 class="text-white text-center font-bold text-sm">Beasiswa Kuliah</h4>
            </a>
            <a id="link-two" href="https://politekniklp3i-tasikmalaya.ac.id/reguler-sore" target="_blank" class="bg-lp3i-100 hover:bg-lp3i-200 transition-all ease-in-out p-4 rounded-xl space-y-2 drop-shadow-lg">
                <img src="{{ asset('ads/link-ads-1.jpg') }}" alt="" class="rounded-lg">
                <h4 class="text-white text-center font-bold text-sm">Kelas Karyawan</h4>
            </a>
            <a id="link-three" href="https://www.figma.com/proto/dqHywQMvS5boF2V5t02P4V/POLITEKNIK-LP3I-KAMPUS-TASIKMALAYA-2024?node-id=201-2&node-type=canvas&t=ykbl6KPhOf6ZTikl-1&scaling=scale-down&content-scaling=fixed&page-id=0%3A1&starting-point-node-id=387%3A16589" target="_blank" class="bg-lp3i-100 hover:bg-lp3i-200 transition-all ease-in-out p-4 rounded-xl space-y-2 drop-shadow-lg">
                <img src="{{ asset('ads/link-ads-1.jpg') }}" alt="" class="rounded-lg">
                <h4 class="text-white text-center font-bold text-sm">Brosur Digital</h4>
            </a>
        </div>
        <div class="w-full flex flex-col md:flex-row items-center gap-3 bg-hijau-200 p-5 rounded-2xl drop-shadow-lg">
            <div class="text-white flex gap-2 order-2 md:order-1">
                <i class="fa-solid fa-location-dot mt-1"></i>
                <p class="text-sm">Jl. Ir. H. Juanda, No. 106, KM. 2, Panglayungan, Kec. Cipedes, Kota Tasikmalaya, Jawa Barat</p>
            </div>
            <img src="{{ asset('img/tagline-warna.svg') }}" alt="" class="order-1 md:order-2 bg-white px-4 py-2.5 rounded-lg">
        </div>
    </div>
    <div class="fixed right-0 bottom-0">
        <a href="https://politekniklp3i-tasikmalaya.ac.id/penerimaan-mahasiswa" target="_blank"
            class="flex items-center justify-center">
            <lottie-player src="{{ asset('animations/whatsapp.json') }}" background="Transparent" speed="1"
                style="width: 100px; height: 100px" direction="1" mode="normal" loop autoplay></lottie-player>
        </a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>
    <script>
        gsap.from(".profile-card", {
            duration: 2.5,
            scale: 0,
            delay: 0.3,
            rotation: -30,
            ease: "elastic.out(1,0.3)"
        });
        gsap.from(".profile-photo", {
            duration: 2.5,
            y: -200,
            rotation: -30,
            delay: 0.4,
            ease: "elastic.out(1,0.3)"
        });
        gsap.from(".profile-name", {
            duration: 0.7,
            opacity: 0,
            delay: 0.7,
            y: 100
        });
        gsap.from(".profile-title", {
            duration: 0.7,
            opacity: 0,
            delay: 0.8,
            y: 100
        });
        gsap.from(".youtube", {
            duration: 2.5,
            y: -500,
            rotation: -30,
            delay: 0.5,
            ease: "elastic.out(1,0.3)"
        });
        gsap.from(".facebook", {
            duration: 2.5,
            y: -500,
            rotation: -30,
            delay: 0.6,
            ease: "elastic.out(1,0.3)"
        });
        gsap.from(".email", {
            duration: 2.5,
            y: -500,
            rotation: -30,
            delay: 0.7,
            ease: "elastic.out(1,0.3)"
        });
        gsap.from("#links", {
            duration: 0.7,
            opacity: 0,
            delay: 1,
            y: 100
        });
        gsap.from("#link-one", {
            duration: 2.5,
            opacity: 0,
            delay: 1,
            y: 100,
            ease: "elastic.out(1,0.5)"
        });
        gsap.from("#link-two", {
            duration: 2.5,
            opacity: 0,
            delay: 1.5,
            y: 100,
            ease: "elastic.out(1,0.5)"
        });
        gsap.from("#link-three", {
            duration: 2.5,
            opacity: 0,
            delay: 2,
            y: 100,
            ease: "elastic.out(1,0.5)"
        });
        gsap.from("#footer", {
            duration: 2.5,
            opacity: 0,
            delay: 2.5,
            y: 100,
            ease: "elastic.out(1,0.5)"
        });
    </script>
</body>

</html>
