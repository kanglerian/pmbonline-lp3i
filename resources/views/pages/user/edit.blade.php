<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
            {{ __('Ubah Informasi Akun') }}
        </h2>
    </x-slot>
    <main class="max-w-7xl mx-auto">
        @if (session('message'))
            <div id="alert" class="mx-2 mb-4 flex items-center p-4 bg-emerald-500 text-emerald-50 rounded-lg"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="flex flex-col md:flex-row justify-start gap-5">
            @if ($user->role == 'S')
                <div class="w-full md:w-2/3 p-6 bg-white border-b border-gray-200 rounded-xl">
                    <form method="POST" action="{{ route('database.update', $user->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="grid md:grid-cols-1 md:gap-6">
                            @if ($programs !== null)
                                <div class="relative z-0 w-full group">
                                    <x-label for="program" :value="__('Program')" />
                                    <x-select id="program" name="program" required>
                                        @if ($applicant->program == null)
                                            <option value="Pilih program">Pilih program</option>
                                            @foreach ($programs as $prog)
                                                <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                    {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{ $applicant->program }}">
                                                {{ $applicant->program }}
                                            </option>
                                            @foreach ($programs as $prog)
                                                <option value="{{ $prog['level'] }} {{ $prog['title'] }}">
                                                    {{ $prog['level'] }} {{ $prog['title'] }}</option>
                                            @endforeach
                                        @endif
                                    </x-select>
                                    <p class="mt-2 text-xs text-gray-500">
                                        <span class="text-red-500 text-xs">{{ $errors->first('program') }}</span>
                                    </p>
                                </div>
                            @else
                                <input type="hidden" name="program" id="program" value="{{ $applicant->program }}">
                            @endif
                        </div>
                        <div class="grid md:grid-cols-3 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="education" id="education"
                                    value="{{ old('education', $applicant->education) }}"
                                    class="@error('education') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('education') }}
                                </div>
                                <label for="school"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pendidikan
                                    Terakhir</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="major" maxlength="100" id="major"
                                    value="{{ old('major', $applicant->major) }}"
                                    class="@error('major') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('major') }}
                                </div>
                                <label for="school"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jurusan</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="number" min="1945" max="3000" name="year" id="year"
                                    value="{{ old('year', $applicant->year) }}"
                                    class="@error('year') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('year') }}
                                </div>
                                <label for="year"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tahun
                                    lulus</label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="school" id="school"
                                    value="{{ old('school', $applicant->school) }}"
                                    class="@error('school') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('school') }}
                                </div>
                                <label for="school"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Asal
                                    Sekolah</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="class" id="class"
                                    value="{{ old('class', $applicant->class) }}"
                                    class="@error('class') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('class') }}
                                </div>
                                <label for="school"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Kelas</label>
                            </div>
                        </div>
                        <hr class="mb-10">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="place_of_birth" maxlength="50" id="place_of_birth"
                                    value="{{ old('place_of_birth', $applicant->place_of_birth) }}"
                                    class="@error('place_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('place_of_birth') }}
                                </div>
                                <label for="place_of_birth"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tempat
                                    Lahir</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="date" name="date_of_birth" id="date_of_birth"
                                    value="{{ old('date_of_birth', $applicant->date_of_birth) }}"
                                    class="@error('date_of_birth') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('date_of_birth') }}
                                </div>
                                <label for="date_of_birth"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                    Lahir</label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <label for="gender" class="sr-only">Jenis Kelamin</label>
                                <select id="gender" name="gender"
                                    class="@error('gender') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer"
                                    required>
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
                                        @break
                                    @endswitch
                                </select>
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('gender') }}
                                </div>
                            </div>
                        </div>
                        <hr class="mb-10">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="father_name" maxlength="50" id="father_name"
                                    value="{{ old('father_name', $applicant->father_name) }}"
                                    class="@error('father_name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('father_name') }}
                                </div>
                                <label for="father_name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                    Ayah</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="father_job" maxlength="100" id="father_job"
                                    value="{{ old('father_job', $applicant->father_job) }}"
                                    class="@error('father_job') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('father_job') }}
                                </div>
                                <label for="father_job"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pekerjaan
                                    Ayah</label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="mother_name" maxlength="50" id="mother_name"
                                    value="{{ old('mother_name', $applicant->mother_name) }}"
                                    class="@error('mother_name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('mother_name') }}
                                </div>
                                <label for="mother_name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                    Ibu</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="mother_job" maxlength="100" id="mother_job"
                                    value="{{ old('mother_job', $applicant->mother_job) }}"
                                    class="@error('mother_job') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('mother_job') }}
                                </div>
                                <label for="mother_job"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Pekerjaan
                                    Ibu</label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="parent_phone" id="parent_phone"
                                    value="{{ old('parent_phone', $applicant->parent_phone) }}"
                                    class="@error('parent_phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('parent_phone') }}
                                </div>
                                <label for="parent_phone"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                    HP Orang Tua</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="address" id="address"
                                    value="{{ old('address', $applicant->address) }}"
                                    class="@error('address') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('address') }}
                                </div>
                                <label for="address"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat</label>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                class="fa-solid fa-floppy-disk mr-1"></i> Simpan perubahan</button>
                    </form>
                </div>
            @endif
            <div class="w-full md:w-1/3 flex flex-col gap-3">
                <form method="POST" class="p-6 bg-white border-b border-gray-200 rounded-xl"
                    action="{{ route('user.update_account', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div>
                        <div>
                            <div class="relative z-0 w-full group">
                                <input type="text" name="name" maxlength="50" id="name"
                                    value="{{ $user->name }}"
                                    class="@error('name') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('name') }}
                                </div>
                                <label for="name"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                    lengkap</label>
                            </div>

                            <div class="relative z-0 w-full mb-6 group">
                                <input type="number" name="phone" maxlength="14" id="phone"
                                    value="{{ $user->phone }}"
                                    class="@error('phone') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('phone') }}
                                </div>
                                <label for="phone"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">No.
                                    Telpon (Whatsapp)</label>
                            </div>

                            <div class="relative z-0 w-full mb-6 group">
                                <input type="email" name="email" maxlength="50" id="email"
                                    value="{{ $user->email }}"
                                    class="@error('email') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('email') }}
                                </div>
                                <label for="email"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                            class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
                </form>

                <form method="POST" class="p-6 bg-white border-b border-gray-200 rounded-xl"
                    action="{{ route('user.change_password', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <div>
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="password" name="password" id="password"
                                class="@error('password') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " required />
                            <div class="text-sm text-gray-700 mt-3">
                                {{ $errors->first('password') }}
                                </p>
                                <label for="password"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password
                                    Baru</label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="@error('password_confirmation') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " required />
                                <div class="text-sm text-gray-700 mt-3">
                                    {{ $errors->first('password_confirmation') }}
                                    </p>
                                    <label for="password_confirmation"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Konfirmasi
                                        Password</label>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                                    class="fa-solid fa-floppy-disk mr-1"></i> Ubah Password</button>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>

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
</script>
