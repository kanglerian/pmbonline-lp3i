@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-guest-layout>
    <section class="flex items-center justify-center bg-gray-50 py-14">
        <div class="max-w-4xl flex flex-col items-center w-full mx-auto">
            <div class="w-full flex items-center justify-center mb-6">
                <a href="{{ route('welcome') }}" class="flex items-center gap-5">
                    <img src="{{ asset('img/lp3i-logo.svg') }}" alt="Politeknik LP3I Kampus Tasikmalaya" class="w-48">
                    <img src="{{ asset('logo/logo-kampusglobalmandiri.png') }}" alt="Kampus Global Mandiri"
                        class="w-36">
                </a>
            </div>
            <header class="text-center space-y-1 mb-5">
                <h2 class="font-bold text-2xl">Form Kuesioner Pengisian Data</h2>
                <p class="text-gray-700">Silahkan mengisi formulir ini untuk mengetahui persentase tingkat melanjutkan
                    pendidikan tinggi</p>
            </header>
            <form method="POST" action="{{ route('recommendation-data.store-kkn') }}"
                class="w-full mx-auto space-y-5 px-10 md:px-0">
                @csrf
                @if (session('message'))
                    <div id="alert" class="flex items-center p-4 bg-emerald-500 text-white rounded-xl"
                        role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <div class="ml-3 text-sm font-reguler">
                            {{ session('message') }}
                        </div>
                    </div>
                @endif
                @if (session('error'))
                    <div id="alert" class="flex items-center p-4 bg-red-500 text-white rounded-xl" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="ml-3 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900">Nama lengkap</label>
                        <input type="text" id="name" name="name"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Nama lengkap" required />
                        @if ($errors->has('name'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No. Whatsapp</label>
                        <input type="number" id="phone" name="phone"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="No. Whatsapp" required />
                        @if ($errors->has('phone'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                    <div>
                        <x-label for="school_id" class="mb-[3px]" :value="__('Sekolah')" />
                        <x-select id="school_id" name="school_id" class="js-example-input-single" required>
                            <option value="">Pilih Sekolah</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                        @if ($errors->has('school_id'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('school_id') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="class" class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                        <input type="text" id="class" name="class"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Kelas" required />
                        @if ($errors->has('class'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('class') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Tahun lulus</label>
                        <input type="number" id="year" name="year"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Tahun lulus" required />
                        @if ($errors->has('year'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('year') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="plan" class="block mb-2 text-sm font-medium text-gray-900">Rencana Setelah
                            Lulus</label>
                        <select id="plan" name="plan"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            required>
                            <option value="">Pilih</option>
                            <option value="Kuliah">Kuliah</option>
                            <option value="Kerja">Kerja</option>
                            <option value="Wirausaha">Wirausaha</option>
                        </select>
                        @if ($errors->has('plant'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('plant') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="parent_phone" class="block mb-2 text-sm font-medium text-gray-900">No. HP Orang
                            Tua</label>
                        <input type="number" id="parent_phone" name="parent_phone"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="No. HP" required />
                        @if ($errors->has('parent_phone'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('parent_phone') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="parent_job" class="block mb-2 text-sm font-medium text-gray-900">Pekerjaan Orang
                            Tua</label>
                        <input type="text" id="parent_job" name="parent_job"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            placeholder="Pekerjaan Orang Tua" required />
                        @if ($errors->has('parent_job'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('parent_job') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="income_parent" class="block mb-2 text-sm font-medium text-gray-900">Pendapatan Orang
                            Tua</label>
                        <select id="income_parent" name="income_parent"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            required>
                            <option value="">Pilih</option>
                            <option value="< 1.000.000">
                                < 1.000.000</option>
                            <option value="1.000.000 - 2.000.000">1.000.000 - 2.000.000</option>
                            <option value="2.000.000 - 4.000.000">2.000.000 - 4.000.000</option>
                            <option value="> 5.000.000">> 5.000.000</option>
                        </select>
                        @if ($errors->has('income_parent'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('income_parent') }}</p>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label for="reference" class="block mb-2 text-sm font-medium text-gray-900">Referensi</label>
                        <select id="reference" name="reference"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-3"
                            required>
                            <option value="">Pilih</option>
                            <option value="Kelompok 1 - Jayamukti">Kelompok 1 - Jayamukti</option>
                            <option value="Kelompok 2 - Cimari">Kelompok 2 - Cimari</option>
                            <option value="Kelompok 3 - Pasirsalam">Kelompok 3 - Pasirsalam</option>
                            <option value="Kelompok 4 - Ciawi">Kelompok 4 - Ciawi</option>
                            <option value="Kelompok 5 - Jatijaya">Kelompok 5 - Jatijaya</option>
                            <option value="Kelompok 6 - Cikukulu">Kelompok 6 - Cikukulu</option>
                            <option value="Kelompok 7 - Panyungagung">Kelompok 7 - Panyungagung</option>
                            <option value="Kelompok 8 - Jayagiri">Kelompok 8 - Jayagiri</option>
                            <option value="Kelompok 9 - Cihaurbeuti">Kelompok 9 - Cihaurbeuti</option>
                            <option value="Kelompok 10 - Sukarasa">Kelompok 10 - Sukarasa</option>
                        </select>
                        @if ($errors->has('reference'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('reference') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                        <textarea id="address" name="address" rows="4"
                            class="block px-4 py-3 w-full text-sm text-gray-900 bg-white rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tulis alamat lengkap disini..." required></textarea>
                        @if ($errors->has('address'))
                            <p class="mt-2 text-red-500 text-xs">{{ $errors->first('address') }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="w-full md:w-1/3 text-white bg-lp3i-300 hover:bg-lp3i-400 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                        <i class="fa fa-solid fa-save"></i>
                        <span>Submit Data</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });

        let phoneInput = document.getElementById('phone');
        let parentPhoneInput = document.getElementById('parent_phone');

        phoneInput.addEventListener('input', function() {
            let phone = phoneInput.value;

            if (phone.length > 14) {
                phone = phone.substring(0, 14);
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

        parentPhoneInput.addEventListener('input', function() {
            let phone = parentPhoneInput.value;

            if (phone.length > 14) {
                phone = phone.substring(0, 14);
            }

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
</x-guest-layout>
