<x-app-layout>
    <x-slot name="header">
        <div
            class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-5">
            @if (!$account)
                @if (Auth::user()->role == 'S')
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">Registrasi Pembayaran</h2>
                @else
                    <h2 class="font-bold text-xl text-gray-800 leading-tight">Dashboard</h2>
                @endif
            @else
                <h2 class="text-sm">Halo, <span class="font-medium">{{ Auth::user()->name }}</span> 👋</h2>
            @endif
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
            <div class="py-10">
                <div>
                    @if (session('error'))
                        <div id="alert"
                            class="mb-3 flex items-center px-5 py-4 bg-red-500 text-white rounded-2xl"
                            role="alert">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <div class="ml-3 text-sm font-reguler">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row justify-between items-center gap-5 px-5 md:px-0">
                        <div class="w-full md:w-6/12 space-y-5 order-2 md:order-none">
                            @if ($account)
                                <div class="space-y-3">
                                    <h3 class="text-3xl font-bold text-gray-800">Selamat Datang di LP3I</h3>
                                    <p class="text-gray-700">Selamat datang di LP3I! Mulai hari ini, perjalanan
                                        pendidikan Anda telah dimulai. Ini adalah awal dari perjalanan yang menarik dan
                                        penuh tantangan. Tetaplah semangat dan berikan yang terbaik dalam setiap langkah
                                        Anda. Setiap harinya adalah kesempatan baru untuk belajar, tumbuh, dan
                                        berkembang. Bersama-sama, kita akan menjelajahi dunia pengetahuan, memperluas
                                        wawasan, dan mencapai impian kita. Mari kita tunjukkan dedikasi, kerja keras,
                                        dan ketekunan dalam mengejar tujuan kita. Selamat belajar, selamat berkarya, dan
                                        jadilah yang terbaik dari yang terbaik!</p>
                                    <a href="https://wa.me/{{ $applicant->identity_user }}" target="_blank"
                                        class="inline-block bg-emerald-500 hover:bg-emerald-600 px-5 py-2 rounded-xl text-sm text-white">
                                        <i class="fa-brands fa-whatsapp"></i>
                                        <span>Ada pertanyaan?</span>
                                    </a>

                                </div>
                            @else
                                <div class="space-y-3">
                                    <h3 class="text-2xl font-bold text-gray-800">Silahkan untuk lakukan Transfer!</h3>
                                    <p class="text-gray-700">Isi formulir pendaftaran dan raih kesempatan yang luar
                                        biasa di
                                        depan mata.</p>
                                </div>
                            @endif
                            @if (!$account)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-end">
                                    <div class="space-y-3">
                                        <img src="{{ asset('logo/btn.png') }}" alt="Logo BTN" width="150px">
                                        <div onclick="copyRecord('0003401300001406')"
                                            class="bg-gray-50 cursor-pointer flex justify-between items-center border px-5 py-2 rounded-xl">
                                            <div class="space-y-1">
                                                <h1 class="font-bold text-sm text-gray-800">BANK BTN LP3I Tasikmalaya
                                                </h1>
                                                <p class="text-sm text-gray-700">0003401300001406</p>
                                            </div>
                                            <button onclick="copyRecord('0003401300001406')"><i
                                                    class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <img src="{{ asset('logo/bsi.png') }}" alt="Logo BSI" width="150px">
                                        <div onclick="copyRecord('1025845605')"
                                            class="bg-gray-50 cursor-pointer flex justify-between items-center border px-5 py-2 rounded-xl">
                                            <div class="space-y-1">
                                                <h1 class="font-bold text-sm text-gray-800">BANK BSI (LPPPI TASIKMALAYA)
                                                </h1>
                                                <p class="text-sm text-gray-700">1025845605</p>
                                            </div>
                                            <button onclick="copyRecord('1025845605')"><i
                                                    class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <img src="{{ asset('logo/bni.png') }}" alt="Logo BNI" width="100px">
                                        <div onclick="copyRecord('4549998888')"
                                            class="bg-gray-50 cursor-pointer flex justify-between items-center border px-5 py-2 rounded-xl">
                                            <div class="space-y-1">
                                                <h1 class="font-bold text-sm text-gray-800">BANK BNI (LP3I Tasikmalaya)
                                                </h1>
                                                <p class="text-sm text-gray-700">4549998888</p>
                                            </div>
                                            <button onclick="copyRecord('4549998888')"><i
                                                    class="fa-solid fa-clipboard text-gray-500 hover:text-blue-500"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="w-full md:w-5/12 order-1 md:order-none">
                            <div class="flex items-center justify-center">
                                @if ($account)
                                    <lottie-player src="{{ asset('animations/laptop.json') }}" background="Transparent"
                                        speed="1" style="width: 400px; height: 400px" direction="1" mode="normal"
                                        loop autoplay></lottie-player>
                                @else
                                    <lottie-player src="{{ asset('animations/transfer.json') }}"
                                        background="Transparent" speed="1" style="width: 400px; height: 400px"
                                        direction="1" mode="normal" loop autoplay></lottie-player>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
