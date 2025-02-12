@push('styles')
    <link href="{{ asset('css/select2-input.css') }}" rel="stylesheet" />
@endpush
<x-guest-layout>
    <x-auth-card-register>
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-3 bg-red-500 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        <div class="text-center bg-lp3i-500 py-5 rounded-2xl">
            <h2 class="text-xl font-bold text-white">Formulir Pendaftaran Online</h2>
        </div>
        <hr class="my-7">
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1">
                    <x-label for="programtype_id" :value="__('Program Kuliah')" />
                    <x-select id="programtype_id" onchange="filterProgram()" name="programtype_id" required>
                        <option value="0">Pilih program</option>
                        @forelse ($programtypes as $programtype)
                            <option value="{{ $programtype->id }}" data-code="{{ $programtype->code }}">
                                {{ $programtype->name }}</option>
                        @empty
                            <option value="Reguler">Reguler</option>
                        @endforelse
                    </x-select>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('programtype_id'))
                            <span class="text-red-500 text-xs">{{ $errors->first('programtype_id') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="program" :value="__('Program')" />
                    <x-select id="program" name="program" required disabled>
                        <option value="0">Pilih Program Studi</option>
                    </x-select>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('program'))
                            <span class="text-red-500 text-xs">{{ $errors->first('program') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="inline-flex items-center justify-center w-full">
                <hr class="w-64 h-px my-8 bg-gray-200 border-0">
                <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2">Biodata</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-1">
                    <x-label for="name" :value="__('Nama Lengkap')" />
                    <x-input id="name" type="text" name="name" maxlength="50" :value="old('name')"
                        placeholder="Nama lengkap disini.." required />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="gender" :value="__('Jenis Kelamin')" />
                    <x-select id="gender" name="gender" required>
                        <option value="null">Pilih jenis kelamin</option>
                        <option value="1">Laki-laki</option>
                        <option value="0">Perempuan</option>
                    </x-select>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('gender'))
                            <span class="text-red-500 text-xs">{{ $errors->first('gender') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="place_of_birth" :value="__('Tempat Lahir')" />
                    <x-input id="place_of_birth" type="text" name="place_of_birth" maxlength="50" :value="old('place_of_birth')"
                        placeholder="Tulis tempat lahir disini..." />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('place_of_birth'))
                            <span class="text-red-500 text-xs">{{ $errors->first('place_of_birth') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                    <x-input id="date_of_birth" type="date" name="date_of_birth" :value="old('date_of_birth')"
                        placeholder="Tulis tempat lahir disini..." />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('date_of_birth'))
                            <span class="text-red-500 text-xs">{{ $errors->first('date_of_birth') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="religion" :value="__('Agama')" />
                    <x-select id="religion" name="religion">
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </x-select>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('religion'))
                            <span class="text-red-500 text-xs">{{ $errors->first('religion') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="school" :value="__('Sekolah')" />
                    <x-select id="school" name="school" class="js-example-input-single">
                        <option>Pilih Sekolah</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </x-select>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('school'))
                            <span class="text-red-500 text-xs">{{ $errors->first('school') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="year" :value="__('Tahun Lulus')" />
                    <x-input type="number" min="1945" max="3000" name="year" id="year"
                        :value="old('year')" placeholder="Tulis tahun lulus disini..." required />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('year'))
                            <span class="text-red-500 text-xs">{{ $errors->first('year') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="major" :value="__('Jurusan')" />
                    <x-input id="major" type="text" name="major" maxlength="100" :value="old('major')"
                        placeholder="Tulis jurusan disini..." />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('major'))
                            <span class="text-red-500 text-xs">{{ $errors->first('major') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="class" :value="__('Kelas')" />
                    <x-input id="class" type="text" name="class" :value="old('class')"
                        placeholder="Tulis kelas disini..." />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('class'))
                            <span class="text-red-500 text-xs">{{ $errors->first('class') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="inline-flex items-center justify-center w-full">
                <hr class="w-64 h-px my-8 bg-gray-200 border-0">
                <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2">Pendaftaran
                    Akun</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-1">
                    <x-label for="email" :value="__('Email')" />
                    <x-input id="email" class="block w-full text-sm" type="email" name="email"
                        maxlength="50" :value="old('email')" placeholder="Masukkan Alamat Email Anda" required />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('email'))
                            <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="phone" :value="__('No. Telpon')" />
                    <x-input id="phone" class="block w-full text-sm" type="number" name="phone"
                        maxlength="14" :value="old('phone')" placeholder="Masukkan Nomor WhatsApp Anda" required />
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('phone'))
                            <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <x-label for="password" :value="__('Password')" />
                    <div class="relative">
                        <x-input id="password" class="block w-full text-sm" type="password" name="password"
                            autocomplete="new-password" placeholder="Masukkan Password Anda" required />
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300"
                            id="see-password" onclick="seePassword()"><i class="fa-solid fa-eye"></i></button>
                    </div>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('password'))
                            <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>

                <div class="space-y-1">
                    <x-label for="password_confirmation" :value="__('Konfirmasi password')" />
                    <div class="relative">
                        <x-input id="password_confirmation" class="block w-full text-sm" type="password"
                            name="password_confirmation" placeholder="Konfirmasi Password Anda" required />
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-300"
                            id="see-password" onclick="seePasswordConfirmation()"><i
                                class="fa-solid fa-eye"></i></button>
                    </div>
                    <p class="text-xs text-gray-500">
                        @if ($errors->has('password'))
                            <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                        @else
                            <span class="text-red-500 text-xs">*Wajib diisi.</span>
                        @endif
                    </p>
                </div>

                <input type="hidden" name="pmb" maxlength="4" id="pmb" value="">
            </div>
            <section>
                <button type="submit"
                    class="w-full text-white bg-lp3i-100 hover:bg-lp3i-200 font-medium rounded-xl text-sm mt-4 px-5 py-2.5 focus:outline-none">
                    {{ __('Daftar') }}
                </button>

                <div class="flex flex-col md:flex-row justify-center items-center gap-3 md:gap-5 mt-5">
                    <a class="underline text-sm text-gray-600 hover:text-gray-700" href="{{ route('login') }}">
                        {{ __('Sudah memiliki akun?') }}
                    </a>
                    <a class="underline text-sm text-gray-600 hover:text-gray-700"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi?') }}
                    </a>
                    <a class="underline text-sm text-gray-600 hover:text-gray-700" target="_blank"
                        href="https://politekniklp3i-tasikmalaya.ac.id/conflict-register">
                        {{ __('Bantuan?') }}
                    </a>
                </div>
            </section>
        </form>
    </x-auth-card-register>
</x-guest-layout>
<script src="{{ asset('js/indonesia.js') }}"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2({
            tags: true,
        });
    });

    const filterProgram = async () => {
        let programTypeElement = document.getElementById('programtype_id');
        let selectedOption = programTypeElement.options[programTypeElement.selectedIndex];
        let programType = selectedOption.getAttribute('data-code');
        await axios.get('https://endpoint.politekniklp3i-tasikmalaya.ac.id/programs',{
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
                        document.getElementById('program').innerHTML =
                            `<option value="0">Pilih Program Studi</option>`;
                        document.getElementById('program').disabled = true;
                        break
                }
                if (programType !== 'NONE') {
                    if (results.length > 0) {
                        results.map((result) => {
                            let option = '';
                            result.interests.map((inter, index) => {
                                option +=
                                    `<option value="${result.level} ${result.title}">${inter.name}</option>`;
                            })
                            bucket += `
                            <optgroup label="${result.level} ${result.title} (${result.campus})">
                                ${option}
                            </optgroup>`;
                        });
                        document.getElementById('program').innerHTML = bucket;
                        document.getElementById('program').disabled = false;
                    } else {
                        bucket = `<option value="0">Program Studi tidak tersedia</option>`;
                        document.getElementById('program').innerHTML = bucket;
                        document.getElementById('program').disabled = true;
                    }

                }
            })
            .catch((err) => {
                console.log(err.message);
            });

    }

    const seePassword = () => {
        let passwordElement = document.getElementById('password');
        let seeElement = document.getElementById('see-password');
        let attribute = passwordElement.getAttribute('type');
        if (attribute === 'text') {
            passwordElement.setAttribute('type', 'password');
            seeElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
        } else {
            passwordElement.setAttribute('type', 'text');
            seeElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        }
    }

    const seePasswordConfirmation = () => {
        let passwordElement = document.getElementById('password_confirmation');
        let seeElement = document.getElementById('see-password-confirmation');
        let attribute = passwordElement.getAttribute('type');
        if (attribute === 'text') {
            passwordElement.setAttribute('type', 'password');
            seeElement.innerHTML = '<i class="fa-solid fa-eye"></i>';
        } else {
            passwordElement.setAttribute('type', 'text');
            seeElement.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        }
    }

    const getYearPMB = () => {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth() + 1;
        const startYear = currentMonth >= 10 ? currentYear + 1 : currentYear;
        document.getElementById('pmb').value = startYear;
    }
    getYearPMB();
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
</script>
