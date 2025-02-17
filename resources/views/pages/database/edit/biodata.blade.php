@push('styles')
    <style>
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
@endpush
<div class="w-full p-8 bg-gray-50 border border-gray-200 rounded-3xl">
    <div class="w-full">
        <section class="space-y-4">
            <header>
                <h2 class="text-xl font-bold text-gray-900">
                    Biodata Mahasiswa
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                </p>
            </header>
            <hr>
            <section class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <div id="popover-nik" role="tooltip"
                            class="absolute hidden top-[-75px] right-[-7px] z-10 visible inline-block w-72 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div
                                class="flex justify-between items-center px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg">
                                <h3 class="font-semibold text-gray-900">Bagaimana Cek NIK?</h3>
                                <span class="cursor-pointer" onclick="popoverNik()"><i
                                        class="fa-solid fa-xmark"></i></span>
                            </div>
                            <div class="px-3 py-2">
                                <p>Kalo belum punya KTP, bisa cek di <span class="font-medium">Kartu Keluarga</span>
                                    sih.</p>
                            </div>
                        </div>
                        <x-label for="nik" :value="__('Nomor Induk Kependudukan')" />
                        <x-input id="nik" type="number" name="nik" maxlength="16" maxlength="16"
                            value="{{ old('nik', $applicant->nik) }}" placeholder="Nomor Induk Kependudukan" />
                        <p class="mt-2 text-xs text-gray-500">
                            @if (Auth::user()->role == 'S')
                                @if ($errors->has('nik'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('nik') }}</span>
                                    <span onclick="popoverNik()" class="cursor-pointer text-sm text-yellow-500">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span class="text-xs">Gatau? Cek disini!</span>
                                    </span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                    <span onclick="popoverNik()" class="cursor-pointer text-sm text-yellow-500">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span class="text-xs">Gatau? Cek disini!</span>
                                    </span>
                                @endif
                            @else
                                <span class="text-red-500 text-xs">{{ $errors->first('nik') }}</span>
                                <span onclick="popoverNik()" class="cursor-pointer text-sm text-yellow-500">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span class="text-xs">Gatau? Cek disini!</span>
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <div id="popover-nisn" role="tooltip"
                            class="absolute hidden top-[-75px] z-10 visible inline-block w-72 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div
                                class="flex justify-between items-center px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg">
                                <h3 class="font-semibold text-gray-900">Bagaimana Cek NISN?</h3>
                                <span class="cursor-pointer" onclick="popoverNisn()">
                                    <i class="fa-solid fa-xmark"></i>
                                </span>
                            </div>
                            <div class="px-3 py-2">
                                <p>Bro, mampir ke web <a class="underline font-medium"
                                        href="https://nisn.data.kemdikbud.go.id/index.php/Cindex/formcaribynama">NISN
                                        Kemendikbud</a> ya, terus isi data dirimu.</p>
                            </div>
                        </div>
                        <x-label for="nisn" :value="__('Nomor Induk Siswa Nasional')" />
                        <x-input id="nisn" type="number" name="nisn"
                            value="{{ old('nisn', $applicant->nisn) }}" placeholder="Nomor Induk Siswa Nasional" />
                        <p class="mt-2 text-xs text-gray-500">
                            @if (Auth::user()->role == 'S')
                                @if ($errors->has('nisn'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('nisn') }}</span>
                                    <span onclick="popoverNisn()" class="cursor-pointer text-sm text-yellow-500">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span class="text-xs">Gatau? Cek disini!</span>
                                    </span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                    <span onclick="popoverNisn()" class="cursor-pointer text-sm text-yellow-500">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span class="text-xs">Gatau? Cek disini!</span>
                                    </span>
                                @endif
                            @else
                                <span class="text-red-500 text-xs">{{ $errors->first('nisn') }}</span>
                                <span onclick="popoverNisn()" class="cursor-pointer text-sm text-yellow-500">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span class="text-xs">Gatau? Cek disini!</span>
                                </span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="kip" :value="__('No. Kartu Indonesia Pintar')" />
                        <x-input id="kip" type="text" name="kip" value="{{ old('kip', $applicant->kip) }}"
                            placeholder="Nomor Kartu Indonesia Pintar" />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('kip') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="income_parent" :value="__('Penghasilan Orang Tua')" />
                        <x-select id="income_parent" name="income_parent">
                            @if ($applicant->income_parent)
                                <option value="{{ $applicant->income_parent }}">{{ $applicant->income_parent }}
                                </option>
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="< 1.000.000">
                                < 1.000.000</option>
                            <option value="1.000.000 - 2.000.000">1.000.000 - 2.000.000</option>
                            <option value="2.000.000 - 4.000.000">2.000.000 - 4.000.000</option>
                            <option value="> 5.000.000">> 5.000.000</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('income_parent') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="name" :value="__('Nama Lengkap')" />
                        <x-input id="name" type="text" name="name" maxlength="50"
                            value="{{ old('name', $applicant->name) }}" placeholder="Nama lengkap disini.."
                            required />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('name'))
                                <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="gender" :value="__('Jenis Kelamin')" />
                        <x-select id="gender" name="gender" required>
                            @switch($applicant->gender)
                                @case('0')
                                    <option value="0">Perempuan</option>
                                    <option value="1">Laki-laki</option>
                                @break

                                @case('1')
                                    <option value="1">Laki-laki</option>
                                    <option value="0">Perempuan</option>
                                @break

                                @default
                                    <option value="1">Laki-laki</option>
                                    <option value="0">Perempuan</option>
                                @break
                            @endswitch
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('gender'))
                                <span class="text-red-500 text-xs">{{ $errors->first('gender') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                        <x-input id="place_of_birth" type="text" name="place_of_birth" maxlength="50"
                            value="{{ old('place_of_birth', $applicant->place_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('place_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                        <x-input id="date_of_birth" type="date" name="date_of_birth"
                            value="{{ old('date_of_birth', $applicant->date_of_birth) }}"
                            placeholder="Tulis tempat lahir disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('date_of_birth') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="religion" :value="__('Agama')" />
                        <x-select id="religion" name="religion" required>
                            @if ($applicant->religion)
                                <option value="{{ $applicant->religion }}">{{ $applicant->religion }}
                                </option>
                            @else
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            @endif
                            @switch($applicant->religion)
                                @case('Islam')
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                @break

                                @case('Kristen')
                                    <option value="Islam">Islam</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                @break

                                @case('Hindu')
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                @break

                                @case('Buddha')
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Konghucu">Konghucu</option>
                                @break

                                @case('Konghucu')
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                @break
                            @endswitch
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('religion'))
                                <span class="text-red-500 text-xs">{{ $errors->first('religion') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="school" class="mb-[3px]" :value="__('Sekolah')" />
                        <x-select id="school" name="school" class="js-example-input-single">
                            @if ($applicant->school)
                                <option value="{{ $applicant->school }}">
                                    {{ $applicant->schoolapplicant->name }}</option>
                            @else
                                <option value="" disabled selected>Pilih Sekolah</option>
                            @endif
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('school'))
                                <span class="text-red-500 text-xs">{{ $errors->first('school') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="major" :value="__('Jurusan')" />
                        <x-input id="major" type="text" name="major" maxlength="100"
                            value="{{ old('major', $applicant->major) }}" placeholder="Tulis jurusan disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('major'))
                                <span class="text-red-500 text-xs">{{ $errors->first('major') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="year" :value="__('Tahun Lulus')" />
                        <x-input type="number" min="1945" max="3000" name="year" id="year"
                            value="{{ old('year', $applicant->year) }}" placeholder="Tulis tahun lulus disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('year'))
                                <span class="text-red-500 text-xs">{{ $errors->first('year') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="class" :value="__('Kelas')" />
                        <x-input id="class" type="text" name="class"
                            value="{{ old('class', $applicant->class) }}" placeholder="Tulis kelas disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('class') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="relative z-0 w-full group">
                        <div class="relative z-0 w-full group">
                            <x-label for="social_media" :value="__('Sosial Media')" />
                            <x-input id="social_media" type="text" name="social_media"
                                value="{{ old('social_media', $applicant->social_media) }}" placeholder="@" />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500 text-xs">{{ $errors->first('social_media') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="achievement" :value="__('Prestasi')" />
                        <x-input id="achievement" type="text" name="achievement"
                            value="{{ old('achievement', $applicant->achievement) }}"
                            placeholder="Tulis prestasi disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('achievement') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="relation" :value="__('Relasi')" />
                        <x-input id="relation" type="text" name="relation"
                            value="{{ old('relation', $applicant->relation) }}"
                            placeholder="Tulis relasi disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('relation') }}</span>
                        </p>
                    </div>
                </div>

                <div class="@if ($applicant->address) hidden @endif space-y-4" id="address-container">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="relative z-0 w-full group">
                            <x-label for="place" :value="__('Jl/Kp/Perum')" />
                            <x-input id="place" type="text" name="place" maxlength="100"
                                placeholder="Jl. / Kp. / Perum" />
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="rt" :value="__('RT')" />
                            <x-input id="rt" type="text" maxlength="2" name="rt"
                                placeholder="RT." />
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="rw" :value="__('RW')" />
                            <x-input id="rw" type="text" maxlength="2" name="rw"
                                placeholder="RW." />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="relative z-0 w-full group">
                            <x-label for="provinces" :value="__('Provinsi')" />
                            <x-select id="provinces" name="provinces" disabled></x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="regencies" :value="__('Kota/Kabupaten')" />
                            <x-select id="regencies" name="regencies" disabled>
                                <option>Pilih Kota / Kabupaten</option>
                            </x-select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <div class="relative z-0 w-full group">
                            <x-label for="districts" :value="__('Kecamatan')" />
                            <x-select id="districts" name="districts" disabled>
                                <option>Pilih Kecamatan</option>
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="villages" :value="__('Desa/Kelurahan')" />
                            <x-select id="villages" name="villages" disabled>
                                <option>Pilih Desa / Kelurahan</option>
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="postal_code" :value="__('Kode Pos')" />
                            <x-input id="postal_code" type="text" name="postal_code" maxlength="7"
                                placeholder="Kode Pos" />
                        </div>
                    </div>
                </div>
                @if ($applicant->address)
                    <div class="space-y-2" id="address-content">
                        <h3 class="font-bold text-gray-900 text-sm">Alamat:</h3>
                        <input type="hidden" id="address" name="address" value="{{ $applicant->address }}">
                        <p class="text-sm text-gray-700">{{ $applicant->address }}</p>
                        <span onclick="editAddress()"
                            class="inline-block cursor-pointer text-xs bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-lg">Ubah
                            Alamat</span>
                    </div>
                @endif
            </section>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-input-single').select2({
                tags: true,
            });
        });
    </script>
    <script>
        let phoneInput = document.getElementById('phone');
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

        const saveChanges = () => {
            const form = document.getElementById('formChanges');
            form.submit();
        }
    </script>
    <script>
        const popoverNisn = () => {
            let popover = document.getElementById('popover-nisn');
            if (popover.classList.contains('hidden')) {
                popover.classList.remove('hidden');
            } else {
                popover.classList.add('hidden');
            }
        }
        const popoverNik = () => {
            let popover = document.getElementById('popover-nik');
            if (popover.classList.contains('hidden')) {
                popover.classList.remove('hidden');
            } else {
                popover.classList.add('hidden');
            }
        }
    </script>
@endpush
