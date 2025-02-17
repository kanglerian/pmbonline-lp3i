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
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Presenter</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

    <main class="max-w-7xl mx-auto">
        @if (session('message'))
            <div id="alert" class="mx-2 mb-4 flex items-center p-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif

        <div class="w-full max-w-5xl p-8 bg-gray-50 border border-gray-200 rounded-3xl">
            <form method="POST" action="{{ route('presenters.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="relative z-0 w-full group">
                        <x-label for="name" :value="__('Nama lengkap')" />
                        <x-input id="name" type="text" name="name" maxlength="50" :value="old('name')"
                            placeholder="Tulis nama lengkap disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('name') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="gender" :value="__('Jenis Kelamin')" />
                        <x-select id="gender" name="gender" required>
                            <option>Pilih gender</option>
                            <option value="1">Laki-laki</option>
                            <option value="0">Perempuan</option>
                        </x-select>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="phone" :value="__('No. Telpon (Whatsapp)')" />
                        <x-input id="phone" type="number" name="phone" maxlength="14" :value="old('phone')"
                            placeholder="Tulis no. telpon / whatsapp disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" type="email" name="email" maxlength="50" :value="old('email')"
                            placeholder="Tulis email disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="sheet" :value="__('Sheet')" />
                        <x-input id="sheet" type="text" name="sheet" maxlength="50" :value="old('sheet')"
                            placeholder="Sheet Spreadsheet" required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('sheet') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" type="password" name="password" :value="old('password')"
                            placeholder="Tulis password disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('password') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-input id="password_confirmation" type="password" name="password_confirmation"
                            :value="old('password_confirmation')" placeholder="Tulis konfirmasi password disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('password_confirmation') }}</span>
                        </p>
                    </div>
                </div>
                <button type="submit"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2.5 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
            </form>
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
