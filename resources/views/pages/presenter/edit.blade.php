<x-app-layout>
    <x-slot name="header">
        <nav class="flex">
            <ol class="inline-flex items-center space-x-2 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('presenters.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                        <i class="fa-solid fa-users mr-2"></i>
                        Presenter
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Ubah Presenter</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>
    <main class="max-w-7xl mx-auto">
        @if (session('message'))
            <div id="alert" class="mx-2 mb-4 flex items-center p-4 bg-emerald-500 text-emerald-50 rounded-xl"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        <div class="flex flex-col md:flex-row justify-center gap-5 p-4 md:p-0">
            <div class="w-full md:w-2/3 p-8 bg-gray-50 border border-gray-200 rounded-3xl">
                <form method="POST" class="space-y-2" action="{{ route('presenters.update', $presenter->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="relative z-0 w-full group">
                            <x-label for="name" :value="__('Nama lengkap')" />
                            <x-input id="name" type="text" name="name" maxlength="50"
                                value="{{ $presenter->name }}" placeholder="Tulis nama lengkap disini..." required />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                            </p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="sheet" :value="__('Sheet')" />
                            <x-input id="sheet" type="text" name="sheet" maxlength="50"
                                value="{{ $presenter->sheet }}" placeholder="Sheet Spreadsheet" required />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500 text-xs">{{ $errors->first('sheet') }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="relative z-0 w-full group">
                            <x-label for="gender" :value="__('Jenis Kelamin')" />
                            <x-select id="gender" name="gender" required>
                                @switch($presenter->gender)
                                    @case('0')
                                        <option value="0">Perempuan</option>
                                        <option value="1">Laki-laki</option>
                                    @break

                                    @case('1')
                                        <option value="1">Laki-laki</option>
                                        <option value="0">Perempuan</option>
                                    @break
                                @endswitch
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="status" :value="__('Status')" />
                            <x-select id="status" name="status" required>
                                @switch($presenter->status)
                                    @case('0')
                                        <option value="0">Tidak aktif</option>
                                        <option value="1">Aktif</option>
                                    @break

                                    @case('1')
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak aktif</option>
                                    @break
                                @endswitch
                            </x-select>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" type="email" name="email" maxlength="50"
                                value="{{ $presenter->email }}" placeholder="Tulis email disini..." required />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                            </p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="phone" :value="__('No. Telpon (Whatsapp)')" />
                            <x-input id="phone" type="number" name="phone" maxlength="14"
                                value="{{ $presenter->phone }}" placeholder="Tulis no. telpon / whatsapp disini..."
                                required />
                            <p class="mt-2 text-xs text-gray-500">
                                <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                            </p>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
                            class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan</button>
                </form>
            </div>
            <div class="w-full md:w-1/3 p-6 bg-gray-50 border border-gray-200 rounded-3xl">
                <form method="POST" action="{{ route('presenters.password', $presenter->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="password" name="password" id="password"
                            class="@error('password') border-red-500 @enderror block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " required />
                        <p class="mt-2 text-xs text-gray-500">
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
                        <p class="mt-2 text-xs text-gray-500">
                            {{ $errors->first('password_confirmation') }}
                        </p>
                        <label for="password_confirmation"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Konfirmasi
                            Password</label>
                    </div>
                    <button type="submit"
                        class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2 text-center"><i
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
