<x-app-layout>
    <x-slot name="header">
        <div
            class="flex flex-col md:flex-row justify-center md:justify-between items-center gap-5">
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
            <div class="max-w-5xl mx-auto">
                <section class=" flex flex-col items-center gap-5">
                    <div class="w-full flex flex-col items-center justify-center">
                        <lottie-player src="{{ asset('animations/underconstruct.json') }}" background="Transparent" speed="1"
                            style="width: 250px; height: 250px" direction="1" mode="normal" loop autoplay></lottie-player>
                    </div>
                    <div class="text-center space-y-1 px-5">
                        <h2 class="font-bold text-xl">Sedang Melakukan Pengembangan 🚧</h2>
                        <p class="text-gray-700">Kami sedang melakukan pengembangan pada halaman ini untuk meningkatkan kualitas dan 
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
