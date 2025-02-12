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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html {
            scroll-behavior: smooth !important;
        }

        .js-example-input-single {
            width: 100%;
        }

        .select2-selection {
            border-radius: 0.75rem !important;
            padding-top: 22px !important;
            padding-bottom: 22px !important;
        }

        .select2-selection__rendered {
            top: -13px !important;
        }
    </style>
</head>

<body class="bg-gray-200">
    <div class="flex flex-col items-center justify-center bg-black bg-opacity-90 w-full h-full z-50 fixed hidden"
        id="data-loading">
        <lottie-player src="{{ asset('animations/server.json') }}" background="Transparent" speed="1"
            style="width: 300px; height: 300px" direction="1" mode="normal" loop autoplay></lottie-player>
        <h1 class="text-white relative top-[-40px] text-sm">Sedang memuat data...</h1>
    </div>
    <div class="container max-w-2xl mx-auto flex flex-col items-center justify-center gap-5 px-5 md:px-0 py-10">
        <div id="banner"
            class="w-full bg-white border-b-8 border-lp3i-200 py-8 px-5 rounded-3xl shadow-lg space-y-4">
            <div class="flex justify-center gap-2">
                <img src="{{ asset('img/lp3i-logo.svg') }}" alt="" class="w-36 md:w-48">
                <img src="{{ asset('logo/logo-kampusglobalmandiri.png') }}" alt="" class="w-28 md:w-36">
            </div>
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-center text-gray-900">{{ $event->title }}</h2>
                <hr>
                <p class="text-center text-gray-700 text-md">{{ $event->description }}</p>
            </div>
        </div>
        <form id="event-form" method="POST" class="w-full space-y-5" enctype="multipart/form-data">
            @csrf
            <div id="profile" class="bg-white border-l-4 border-lp3i-100 shadow-lg px-5 py-8">
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                            placeholder="Your full name..." />
                        <li id="error-name" class="hidden text-red-500 text-xs ml-2 list-disc mt-2"></li>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No. Whatsapp <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="phone" id="phone" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                            placeholder="Your phone..." />
                        <li id="error-phone" class="hidden text-red-500 text-xs ml-2 list-disc mt-2"></li>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="school" class="block text-sm font-medium text-gray-900">Sekolah <span
                                class="text-red-500">*</span></label>
                        <select name="school" id="school"
                            class="js-example-input-single bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5">
                            <option>Pilih Sekolah</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                        <li id="error-school" class="hidden text-red-500 text-xs ml-2 list-disc mt-2"></li>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="major" class="block mb-2 text-sm font-medium text-gray-900">Jurusan
                            SMA/K/MA <span class="text-red-500">*</span></label>
                        <input type="text" name="major" id="major"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                            placeholder="Your major..." />
                        <li id="error-major" class="hidden text-red-500 text-xs ml-2 list-disc mt-2"></li>
                    </div>
                    @if ($event->is_employee)
                        <div class="col-span-2 md:col-span-1">
                            <label for="class" class="block mb-2 text-sm font-medium text-gray-900">Kelas <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="class" id="class"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Your class..." />
                            <li id="error-class" class="hidden text-red-500 text-xs ml-2 list-disc mt-2"></li>
                        </div>
                    @endif
                    @if ($event->is_employee)
                        <div class="col-span-2 md:col-span-1">
                            <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Tahun Lulus
                                <span class="text-red-500">*</span></label>
                            <input type="number" min="1945" max="3000" name="year" id="year"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Your graduation year..." />
                            <li id="error-year" class="hidden text-red-500 text-xs ml-2 list-disc mt-2"></li>
                        </div>
                    @endif
                    @if ($event->is_employee)
                        <div class="col-span-2 md:col-span-2">
                            <label for="place_of_working" class="block mb-2 text-sm font-medium text-gray-900">Tempat
                                Bekerja
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="place_of_working" id="place_of_working"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Your place of working..." />
                            <li id="error-place-of-working" class="hidden text-red-500 text-xs ml-2 list-disc mt-2">
                            </li>
                        </div>
                    @endif
                </div>
            </div>
            @if ($event->is_scholarship)
                <div id="address" class="bg-white border-l-4 border-lp3i-100 shadow-lg px-5 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="place" class="block mb-2 text-sm font-medium text-gray-900">Jl/Kp/Perum
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="place" id="place"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Your place..." required />
                        </div>
                        <div>
                            <label for="postal_code" class="block mb-2 text-sm font-medium text-gray-900">Kode Pos
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="postal_code" id="postal_code" maxlength="7"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="00000" required />
                        </div>
                        <div>
                            <label for="rt" class="block mb-2 text-sm font-medium text-gray-900">RT <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="rt" id="rt" maxlength="2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="00" required />
                        </div>
                        <div>
                            <label for="rw" class="block mb-2 text-sm font-medium text-gray-900">RW <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="rw" id="rw" maxlength="2"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="00" required />
                        </div>
                        <div>
                            <label for="provinces" class="block mb-2 text-sm font-medium text-gray-900">Provinsi <span
                                    class="text-red-500">*</span></label>
                            <select name="provinces" id="provinces"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                disabled required>
                                <option value="0">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div>
                            <label for="regencies" class="block mb-2 text-sm font-medium text-gray-900">Kota/Kabupaten
                                <span class="text-red-500">*</span></label>
                            <select name="regencies" id="regencies"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                disabled required>
                                <option>Pilih Kota / Kabupaten</option>
                            </select>
                        </div>
                        <div>
                            <label for="districts" class="block mb-2 text-sm font-medium text-gray-900">Kecamatan
                                <span class="text-red-500">*</span></label>
                            <select name="districts" id="districts"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                disabled required>
                                <option>Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div>
                            <label for="villages" class="block mb-2 text-sm font-medium text-gray-900">Desa/Kelurahan
                                <span class="text-red-500">*</span></label>
                            <select name="villages" id="villages"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                disabled required>
                                <option>Pilih Desa / Kelurahan</option>
                            </select>
                        </div>
                    </div>
                </div>
            @endif
            @if ($event->is_scholarship)
                <div id="scholarship" class="bg-white border-l-4 border-lp3i-100 shadow-lg px-5 py-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <label for="scholarship_type"
                                class="block mb-2 text-sm font-medium text-gray-900">Kategori
                                Beasiswa <span class="text-red-500">*</span></label>
                            <select name="scholarship_type" id="scholarship_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                required>
                                <option value="Beasiswa Akademik">Beasiswa Akademik</option>
                                <option value="Beasiswa Non Akademik">Beasiswa Non Akademik</option>
                                <option value="Beasiswa Ranking 1 - 10">Beasiswa Ranking 1 - 10</option>
                                <option value="Beasiswa Hafidz Qur'an 5 - 30 Juz">Beasiswa Hafidz Qur'an 5 - 30 Juz
                                </option>
                                <option value="Beasiswa Aktivis Sekolah">Beasiswa Aktivis Sekolah</option>
                                <option value="Beasiswa Atlet">Beasiswa Atlet</option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="achievement"
                                class="block mb-2 text-sm font-medium text-gray-900">Prestasi</label>
                            <input type="text" id="achievement" name="achievement"
                                value="{{ old('achievement') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Contoh: Ranking 1" />
                        </div>
                    </div>
                </div>
            @endif
            @if ($event->is_files)
                <div id="upload" class="bg-white border-l-4 border-lp3i-100 shadow-lg px-5 py-8">
                    <div class="grid grid-cols-1 gap-5">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="kartu_keluarga">Kartu
                                Keluarga</label>
                            <input
                                class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 px-3 py-2.5"
                                id="kartu_keluarga" type="file" accept=".pdf" required />
                            <p class="mt-1 text-xs text-red-500">*Format file .pdf | maksimal 1 MB</p>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900"
                                for="foto_rumah_luar_dan_dalam">Foto Rumah (Luar & Dalam)</label>
                            <input
                                class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 px-3 py-2.5"
                                id="foto_rumah_luar_dan_dalam" type="file" accept="image/*" required />
                            <p class="mt-1 text-xs text-red-500">*Format file .jpg, .jpeg, .png | maksimal 1 MB</p>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900"
                                for="sertifikat_pendukung">Sertifikat Pendukung (Prestasi)</label>
                            <input
                                class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 px-3 py-2.5"
                                id="sertifikat_pendukung" type="file" accept=".pdf" required />
                            <p class="mt-1 text-xs text-red-500">*Format file .pdf | maksimal 1 MB</p>
                        </div>
                    </div>
                </div>
            @endif
            @if ($event->is_program)
                <div id="prodi" class="bg-white border-l-4 border-lp3i-100 shadow-lg px-5 py-8">
                    <div class="grid grid-cols-1">
                        <input type="hidden" name="code" id="code" value="{{ $event->program }}">
                        <div class="space-y-4">
                            <label for="program" class="block mb-2 text-sm font-medium text-gray-900">Program Studi &
                                Peminatan <span class="text-red-500">*</span></label>
                            <div class="space-y-5" id="program"></div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($event->is_scholarship)
                <div id="parent" class="bg-white border-l-4 border-lp3i-100 shadow-lg px-5 py-8">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 md:col-span-1">
                            <label for="parent_name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                Orangtua <span class="text-red-500">*</span></label>
                            <input type="text" id="parent_name" name="parent_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Your full parent name..." required />
                            <div class="flex items-center gap-3 mt-3 ml-2">
                                <div class="flex items-center">
                                    <input checked id="parent-radio-0" type="radio" value="0"
                                        name="parent_gender"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="parent-radio-0"
                                        class="ms-2 text-xs font-medium text-gray-900">Ibu</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="parent-radio-1" type="radio" value="1" name="parent_gender"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="parent-radio-1"
                                        class="ms-2 text-xs font-medium text-gray-900">Ayah</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="parent_phone" class="block mb-2 text-sm font-medium text-gray-900">No.
                                Handphone <span class="text-red-500">*</span></label>
                            <input type="number" name="parent_phone" id="parent_phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                                placeholder="Your parent phone..." required />
                        </div>
                    </div>
                </div>
            @endif
            <div id="event-submit" class="w-full flex items-center gap-5">
                <div class="w-full">
                    <select name="information" id="information"
                        class="bg-gray-50 border-2 border-lp3i-100 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2.5"
                        required>
                        <option value="6281313608558">Pilih Sumber Informasi</option>
                        @foreach ($informations as $information)
                            <option value="{{ $information->identity }}">{{ $information->name }}</option>
                        @endforeach
                        <option value="6281313608558">Sosial Media</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-1/2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
            </div>
        </form>
    </div>
    <div class="fixed" style="z-index: -9;left: 0;top:20px">
        <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_snisb0ad.json" background="transparent"
            speed="1" style="width: 300px; height: 300px;" loop autoplay></lottie-player>
    </div>
    <div class="fixed" style="z-index: -9;right: 0">
        <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_vubims6l.json" background="transparent"
            speed="1" style="width: 700px; height: 700px;" loop autoplay></lottie-player>
    </div>
    <div class="fixed bottom-20 right-0">
        <a href="https://politekniklp3i-tasikmalaya.ac.id/penerimaan-beasiswa"><lottie-player
                src="{{ asset('animations/whatsapp.json') }}" background="Transparent" speed="1"
                style="width: 100px; height: 100px" direction="1" mode="normal" loop autoplay></lottie-player>
        </a>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"
        integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/lottie.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    @if ($event->is_scholarship)
        <script src="{{ asset('js/indonesia.js') }}"></script>
        <script>
            let parentPhoneInput = document.getElementById('parent_phone');
            parentPhoneInput.addEventListener('input', function() {
                let phone = parentPhoneInput.value;

                if (phone.startsWith("62")) {
                    if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                        parentPhoneInput.value = '62';
                    } else {
                        parentPhoneInput.value = phone;
                    }
                } else if (phone.startsWith("0")) {
                    parentPhoneInput.value = '62' + phone.substring(1);
                } else {
                    parentPhoneInput.value = '62';
                }
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });

        let phoneInput = document.getElementById('phone');
        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;

            if (phone.length > 15) {
                phone = phone.substring(0, 15);
            }

            if (phone.startsWith("62")) {
                if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                    phoneInput.value = '62';
                } else {
                    phoneInput.value = phone;
                }
            } else if (phone.startsWith("0")) {
                phoneInput.value = '62' + phone.substring(1);
            } else {
                phoneInput.value = '62';
            }
        });
    </script>
    <script>
        document.getElementById("event-form").addEventListener("submit", async function(e) {
            e.preventDefault();
            document.getElementById('data-loading').classList.remove('hidden');

            const form = e.target;
            const formData = new FormData(form);

            await axios.post(`/eventstore`, formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (response.data.event.is_files) {
                        const filesToUpload = [{
                                id: 'kartu_keluarga',
                                name: 'kartu-keluarga',
                                fileupload_id: 7
                            },
                            {
                                id: 'sertifikat_pendukung',
                                name: 'sertifikat-pendukung',
                                fileupload_id: 8
                            },
                            {
                                id: 'foto_rumah_luar_dan_dalam',
                                name: 'foto-rumah-luar-dan-dalam',
                                fileupload_id: 13
                            }
                        ];

                        const uploadFile = async (fileInput, data_file) => {
                            return new Promise((resolve, reject) => {
                                const file = document.getElementById(fileInput).files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = async (event) => {
                                        let data = {
                                            identity: response.data.data
                                                .identity,
                                            image: event.target.result.split(
                                                ';base64,').pop(),
                                            namefile: data_file.name,
                                            typefile: file.name.split('.')
                                                .pop(),
                                        };

                                        let status = {
                                            fileupload_id: data_file
                                                .fileupload_id,
                                            identity: response.data.data
                                                .identity,
                                            typefile: file.name.split('.')
                                                .pop(),
                                        };

                                        try {
                                            // Upload ke server eksternal
                                            const res = await axios.post(
                                                `https://uploadhub.politekniklp3i-tasikmalaya.ac.id/upload`,
                                                data, {
                                                    headers: {
                                                        'lp3i-api-key': 'cdbdb5ea29b98565'
                                                    }
                                                }
                                            );

                                            // Upload ke server Laravel
                                            const userupload = await axios.post(
                                                '/useruploadevent', status, {
                                                    headers: {
                                                        'X-CSRF-TOKEN': $(
                                                            'meta[name="csrf-token"]'
                                                        ).attr(
                                                            'content')
                                                    }
                                                });

                                            console.log(userupload.data);
                                            resolve();
                                        } catch (err) {
                                            console.error("Error:", err.response ?
                                                err.response.data : err.message);
                                            reject(err);
                                        }
                                    };
                                    reader.readAsDataURL(file);
                                } else {
                                    resolve(); // Jika tidak ada file, langsung resolve
                                }
                            });
                        };

                        Promise.all(filesToUpload.map(file => uploadFile(file.id, file)))
                            .then(() => {
                                document.getElementById('data-loading').classList.add('hidden');
                                alert('Yay! Semua file sudah terunggah 🎉');
                                location.reload();
                            })
                            .catch((err) => {
                                console.error('Terjadi kesalahan saat upload:', err);
                            });
                    } else {
                        document.getElementById('data-loading').classList.add('hidden');
                        alert('Proses selesai, semua sudah aman! ✅');
                        location.reload();
                    }
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        alert(
                            'Tidak bisa mengikuti, anda sudah terdaftar di LP3I. Hubungi administrator untuk mengubah aturan.'
                        );
                        location.reload();
                    }
                    if (error.response.status === 422) {
                        let errors = error.response.data;
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                const elements = errors[key];
                                const newErrors = {
                                    name: elements.name || [],
                                    phone: elements.phone || [],
                                    school: elements.school || [],
                                    major: elements.major || []
                                }
                                if (newErrors.name.length > 0) {
                                    let errorElement = '';
                                    newErrors.name.forEach(error => {
                                        errorElement += `<li>${error}</li>`;
                                    });
                                    document.getElementById('error-name').style.display = 'block';
                                    document.getElementById('error-name').innerHTML = errorElement;
                                    window.scrollTo(0, 0);
                                }
                                if (newErrors.phone.length > 0) {
                                    let errorElement = '';
                                    newErrors.phone.forEach(error => {
                                        errorElement += `<li>${error}</li>`;
                                    });
                                    document.getElementById('error-phone').style.display = 'block';
                                    document.getElementById('error-phone').innerHTML = errorElement;
                                    window.scrollTo(0, 0);
                                }
                                if (newErrors.school.length > 0) {
                                    let errorElement = '';
                                    newErrors.school.forEach(error => {
                                        errorElement += `<li>${error}</li>`;
                                    });
                                    document.getElementById('error-school').style.display = 'block';
                                    document.getElementById('error-school').innerHTML = errorElement;
                                    window.scrollTo(0, 0);
                                }
                                if (newErrors.major.length > 0) {
                                    let errorElement = '';
                                    newErrors.major.forEach(error => {
                                        errorElement += `<li>${error}</li>`;
                                    });
                                    document.getElementById('error-major').style.display = 'block';
                                    document.getElementById('error-major').innerHTML = errorElement;
                                    window.scrollTo(0, 0);
                                }
                            }
                        }
                    }
                });
        });
    </script>
    @if ($event->is_program)
        <script>
            const filterProgram = async () => {
                let programType = document.getElementById('code').value;
                await axios.get('https://endpoint.politekniklp3i-tasikmalaya.ac.id/programs', {
                        headers: {
                            'lp3i-api-key': 'b35e0a901904d293'
                        }
                    })
                    .then((res) => {
                        let programs = res.data;
                        var results;
                        let bucket = '';
                        switch (programType) {
                            case "R":
                                results = programs.filter(program => program.type === "R");
                                break;
                            case "N":
                                results = programs.filter(program => program.type === "N");
                                break;
                            case "RPL":
                                results = programs.filter(program => program.type === "RPL");
                                break;
                            default:
                                results = [];
                                break;
                        }

                        if (programType !== 'NONE') {
                            if (results.length > 0) {
                                results.map((result) => {
                                    let option = '';
                                    result.interests.map((inter, index) => {
                                        option += `
                                    <div class="flex">
                                        <div class="flex items-center h-5">
                                            <input id="helper-radio-${index}" type="radio" name="program" value="${result.level} ${result.title}"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 mt-1">
                                        </div>
                                        <div class="ms-2 text-sm">
                                            <label for="helper-radio-${index}" class="font-medium text-gray-900">
                                            ${inter.name}
                                            </label>
                                            <p id="helper-radio-${index}-text" class="text-xs font-normal text-gray-500">
                                                ${result.level} ${result.title} (${result.campus})
                                            </p>
                                        </div>
                                    </div>`
                                    })
                                    bucket += `<div class="space-y-4">${option}</div>`;
                                });
                                document.getElementById('program').innerHTML = bucket;
                            } else {
                                bucket = `<div>Program Studi tidak tersedia</div>`;
                                document.getElementById('program').innerHTML = bucket;
                                document.getElementById('program').disabled = true;
                            }
                        }
                    })
                    .catch((err) => {
                        console.log(err.message);
                    });

            }
            filterProgram();
        </script>
    @endif
    <script>
        gsap.from("#banner", {
            duration: 3.5,
            opacity: 0,
            delay: 0.5,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#profile", {
            duration: 3.5,
            opacity: 0,
            delay: 1,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#address", {
            duration: 3.5,
            opacity: 0,
            delay: 1.1,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#scholarship", {
            duration: 3.5,
            opacity: 0,
            delay: 1.2,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#upload", {
            duration: 3.5,
            opacity: 0,
            delay: 1.3,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#prodi", {
            duration: 3.5,
            opacity: 0,
            delay: 1.4,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#parent", {
            duration: 3.5,
            opacity: 0,
            delay: 1.5,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
        gsap.from("#event-submit", {
            duration: 3.5,
            opacity: 0,
            delay: 1.6,
            y: 100,
            ease: "elastic.out(1,0.2)"
        });
    </script>
</body>

</html>
