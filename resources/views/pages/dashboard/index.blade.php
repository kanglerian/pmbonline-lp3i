<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-5">
            <h2 class="text-base">Halo, <span class="font-medium">{{ Auth::user()->name }}</span> 👋</h2>
            <div class="flex flex-wrap justify-center items-center gap-3 px-2 text-gray-600">
                @if (Auth::user()->status != 1)
                    <div class="px-6 py-2 rounded-lg bg-red-500 text-white text-sm">
                        <p><i class="fa-solid fa-lock mr-1"></i> Akun anda belum di aktifkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <section class="space-y-5">
        @if (Auth::user()->role == 'S')

            @if ($event)
                <div class="max-w-lg">
                    @if (session('message'))
                        <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                            role="alert">
                            <i class="fa-solid fa-circle-check"></i>
                            <div class="ml-3 text-sm font-reguler">
                                {{ session('message') }}
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl"
                            role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div class="ml-3 text-sm font-reguler">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
                <form action="{{ route('events.rating', $event->id) }}" method="POST"
                    class="relative max-w-lg bg-gray-50 p-5 border-l-8 border-lp3i-100 drop-shadow-lg"
                    id="rating-container">
                    @csrf
                    @method('PATCH')
                    <button type="button" onclick="hiddenRating()" class="absolute right-[-5px] top-[-10px]">
                        <i class="fa-solid fa-circle-xmark text-lg text-red-500"></i>
                    </button>
                    <div class="space-y-3">
                        <div class="space-y-1">
                            <h2 class="font-bold text-gray-800">{{ $event->event->title }} ({{ $event->event->code }})
                            </h2>
                            <p class="text-sm text-gray-600">{{ $event->event->description }}</p>
                        </div>
                        <input type="hidden" id="rating" value="0" name="rating" required>
                        <div class="relative z-0 w-full group me-auto">
                            <ul class="flex items-center gap-1 text-amber-400">
                                <li onclick="ratingButton(1)" id="rating-1">
                                    <i class="fa-regular fa-star"></i>
                                </li>
                                <li onclick="ratingButton(2)" id="rating-2">
                                    <i class="fa-regular fa-star"></i>
                                </li>
                                <li onclick="ratingButton(3)" id="rating-3">
                                    <i class="fa-regular fa-star"></i>
                                </li>
                                <li onclick="ratingButton(4)" id="rating-4">
                                    <i class="fa-regular fa-star"></i>
                                </li>
                                <li onclick="ratingButton(5)" id="rating-5">
                                    <i class="fa-regular fa-star"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="relative z-0 w-full group">
                            <textarea name="comment" id="comment" value="{{ old('comment') }}"
                                class="block mt-2 px-4 py-3 w-full text-sm rounded-xl border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Berikan rating dan ulasan Anda..." required>{{ old('comment') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500 text-xs">{{ $errors->first('comment') }}</span>
                            </p>
                            <button type="submit"
                                class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-xs w-full sm:w-auto px-5 py-2.5 text-center"><i
                                    class="fa-regular fa-comments mr-1"></i> Beri rating</button>
                        </div>
                    </div>
                </form>
                <script>
                    function hiddenRating() {
                        document.getElementById('rating-container').hidden = true;
                    }

                    function ratingButton(rating) {
                        document.getElementById('rating').value = rating;
                        switch (rating) {
                            case 1:
                                document.getElementById('rating-1').classList.add('text-amber-500');
                                document.getElementById('rating-2').classList.remove('text-amber-500');
                                document.getElementById('rating-3').classList.remove('text-amber-500');
                                document.getElementById('rating-4').classList.remove('text-amber-500');
                                document.getElementById('rating-5').classList.remove('text-amber-500');
                                document.getElementById('rating-1').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-2').innerHTML = '<i class="fa-regular fa-star"></i>';
                                document.getElementById('rating-3').innerHTML = '<i class="fa-regular fa-star"></i>';
                                document.getElementById('rating-4').innerHTML = '<i class="fa-regular fa-star"></i>';
                                document.getElementById('rating-5').innerHTML = '<i class="fa-regular fa-star"></i>';
                                break;
                            case 2:
                                document.getElementById('rating-1').classList.add('text-amber-500');
                                document.getElementById('rating-2').classList.add('text-amber-500');
                                document.getElementById('rating-3').classList.remove('text-amber-500');
                                document.getElementById('rating-4').classList.remove('text-amber-500');
                                document.getElementById('rating-5').classList.remove('text-amber-500');
                                document.getElementById('rating-1').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-2').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-3').innerHTML = '<i class="fa-regular fa-star"></i>';
                                document.getElementById('rating-4').innerHTML = '<i class="fa-regular fa-star"></i>';
                                document.getElementById('rating-5').innerHTML = '<i class="fa-regular fa-star"></i>';
                                break;
                            case 3:
                                document.getElementById('rating-1').classList.add('text-amber-500');
                                document.getElementById('rating-2').classList.add('text-amber-500');
                                document.getElementById('rating-3').classList.add('text-amber-500');
                                document.getElementById('rating-4').classList.remove('text-amber-500');
                                document.getElementById('rating-5').classList.remove('text-amber-500');
                                document.getElementById('rating-1').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-2').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-3').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-4').innerHTML = '<i class="fa-regular fa-star"></i>';
                                document.getElementById('rating-5').innerHTML = '<i class="fa-regular fa-star"></i>';
                                break;
                            case 4:
                                document.getElementById('rating-1').classList.add('text-amber-500');
                                document.getElementById('rating-2').classList.add('text-amber-500');
                                document.getElementById('rating-3').classList.add('text-amber-500');
                                document.getElementById('rating-4').classList.add('text-amber-500');
                                document.getElementById('rating-5').classList.remove('text-amber-500');
                                document.getElementById('rating-1').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-2').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-3').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-4').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-5').innerHTML = '<i class="fa-regular fa-star"></i>';
                                break;
                            case 5:
                                document.getElementById('rating-1').classList.add('text-amber-500');
                                document.getElementById('rating-2').classList.add('text-amber-500');
                                document.getElementById('rating-3').classList.add('text-amber-500');
                                document.getElementById('rating-4').classList.add('text-amber-500');
                                document.getElementById('rating-5').classList.add('text-amber-500');
                                document.getElementById('rating-1').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-2').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-3').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-4').innerHTML = '<i class="fa-solid fa-star"></i>';
                                document.getElementById('rating-5').innerHTML = '<i class="fa-solid fa-star"></i>';
                                break;
                            default:
                                break;
                        }
                    }
                </script>
            @endif

            <div class="max-w-5xl mx-auto">
                <section class=" flex flex-col items-center gap-5">
                    <div class="w-full flex flex-col items-center justify-center">
                        <lottie-player src="{{ asset('animations/underconstruct.json') }}" background="Transparent"
                            speed="1" style="width: 250px; height: 250px" direction="1" mode="normal" loop
                            autoplay></lottie-player>
                    </div>
                    <div class="text-center space-y-1 px-5">
                        <h2 class="font-bold text-xl">Sedang Melakukan Pengembangan 🚧</h2>
                        <p class="text-gray-700">Kami sedang melakukan pengembangan pada halaman ini untuk meningkatkan
                            kualitas dan
                            menambahkan fitur baru. Silakan kembali lagi di lain waktu untuk melihat pembaruan terbaru.
                            Terima kasih atas pengertiannya!</p>
                    </div>
                </section>
            </div>
        @endif

        @if (Auth::user()->role != 'S')
            <div>
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div
                        class="flex justify-center items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                        <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                        <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                        <div class="w-full flex flex-col space-y-1 p-1 md:p-0">
                            <label for="change_pmb" class="text-xs">Periode PMB:</label>
                            <input type="number" id="change_pmb" onchange="changeTrigger()"
                                class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                                placeholder="Tahun PMB">
                        </div>
                    </div>
                    <div class="px-5 py-3 rounded-2xl text-sm bg-gray-50 border border-gray-200 order-1 md:order-none">
                        <div>
                            <span class="font-bold">{{ Auth::user()->name }}</span>
                            (<span onclick="copyIdentity('{{ Auth::user()->identity }}')">ID:
                                {{ Auth::user()->identity }}</span>)
                            <button onclick="copyIdentity('{{ Auth::user()->identity }}')" class="text-blue-500"><i
                                    class="fa-regular fa-copy"></i></button>
                        </div>
                        <span class="text-xs text-gray-600">Gunakan Key Identity ini di aplikasi Whatsapp
                            Sender.</span>
                    </div>
                </div>
            </div>

            @include('pages.dashboard.database.database')
            @include('pages.dashboard.database.scripts')

            @if ($slepets > 0)
                <section>
                    <div class="px-6 py-5 mb-4 text-red-800 rounded-3xl bg-red-50 border border-red-200">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-info mr-2"></i>
                            <span class="sr-only">Info</span>
                            <h3 class="text-lg font-medium">Lakukan Update Data Sekolah!</h3>
                        </div>
                        <div class="mt-2 mb-4 text-sm">
                            Dalam daftar ini, terdapat sekitar <span class="font-bold">{{ $slepets }}</span>
                            entri
                            sekolah yang masih menunggu penyesuaian wilayah, status, dan jenisnya. Penting untuk
                            mengubahnya
                            agar laporan menjadi lebih akurat.
                        </div>
                        @if (Auth::user()->role == 'A')
                            <div class="flex">
                                <a target="_blank" href="{{ route('schools.index') }}"
                                    class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-reguler rounded-xl text-xs px-4 py-1.5 me-2 text-center inline-flex items-center">
                                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i>
                                    lihat selengkapnya
                                </a>
                            </div>
                        @else
                            <div class="flex">
                                <span
                                    class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-reguler rounded-xl text-xs px-4 py-1.5 me-2 text-center inline-flex items-center">
                                    Segera ubah data, hubungi Administrator.
                                </span>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <section>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <a href="{{ route('dashboard.rekapitulasi_database') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-database"></i>
                                <h2 class="font-bold">Rekapitulasi Database</h2>
                            </div>
                            <p class="text-xs">Berikut ini menu dari rekapitulasi database berdasarkan sumber data.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                    <a href="{{ route('dashboard.rekapitulasi_perolehan_pmb_page') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-coins"></i>
                                <h2 class="font-bold">Rekap Perolehan PMB</h2>
                            </div>
                            <p class="text-xs">Berikut ini menu dari rekapitukasi perolehan PMB serta pencapaian PMB.
                            </p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                    <a href="{{ route('dashboard.rekapitulasi_history') }}"
                        class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl">
                        <div class="space-y-1 z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-comments"></i>
                                <h2 class="font-bold">Rekapitulasi Follow Up Presenter</h2>
                            </div>
                            <p class="text-xs">Berikut ini adalah menu dari rekapitulasi Follow Up riwayat chat dari
                                Presenter.</p>
                        </div>
                        <i
                            class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                    </a>
                    @if (Auth::user()->role == 'P')
                        <a href="{{ route('dashboard.rekapitulasi_aplikan') }}"
                            class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl">
                            <div class="space-y-1 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-users"></i>
                                    <h2 class="font-bold">Rekapitulasi Data Aplikan</h2>
                                </div>
                                <p class="text-xs">Berikut ini adalah menu dari rekapitulasi data aplikan yang sudah
                                    terekap.</p>
                            </div>
                            <i
                                class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                        </a>
                    @endif
                    @if (Auth::user()->role == 'P')
                        <a href="{{ route('dashboard.rekapitulasi_persyaratan') }}"
                            class="relative bg-lp3i-200 hover:bg-lp3i-300 text-white cursor-pointer px-6 py-5 rounded-3xl">
                            <div class="space-y-1 z-10">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <h2 class="font-bold">Data Persyaratan Aplikan</h2>
                                </div>
                                <p class="text-xs">Berikut ini adalah menu dari rekapitulasi persyaratan-persyaratan
                                    aplikan.</p>
                            </div>
                            <i
                                class="absolute opacity-10 z-1 bottom-5 right-5 fa-solid fa-hand-pointer fa-3x -rotate-45"></i>
                        </a>
                    @endif
                </div>
            </section>

            @include('pages.dashboard.utilities.all')
            @include('pages.dashboard.utilities.pmb')

            @if (Auth::user()->role != 'P')
                @include('pages.dashboard.dashboard.dashboard-sales')
                @include('pages.dashboard.approval-enrollment.enrollment')
            @endif

            @include('pages.dashboard.target.target')
            @include('pages.dashboard.search.search')

            @include('pages.dashboard.harta.database')


            @include('pages.dashboard.dashboard.dashboard-school')

            @include('pages.dashboard.dashboard.dashboard-register-school-year')
            @include('pages.dashboard.dashboard.dashboard-register-program')
            @include('pages.dashboard.dashboard.dashboard-rekap-perolehan-pmb')

            {{-- @include('pages.dashboard.source.source') --}}
        @endif
        @push('scripts')
            <script>
                const copyRecord = (number) => {
                    const textarea = document.createElement("textarea");
                    textarea.value = number;
                    textarea.style.position = "fixed";
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand("copy");
                    document.body.removeChild(textarea);
                    alert('Nomor rekening sudah disalin!');
                }
            </script>
        @endpush
    </section>
</x-app-layout>
