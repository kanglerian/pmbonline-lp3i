<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight py-2">
                {{ __('Tambah Akun Baru') }}
            </h2>
        </div>
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

        <div class="w-full md:w-2/3 rounded-3xl bg-gray-50 p-8 border border-gray-200">
            <form method="POST" action="{{ route('user.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
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
                            placeholder="Tulis no. telpon / whatsapp disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
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
                            placeholder="Tulis konfirmasi password disini..." required />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('password_confirmation') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="role" :value="__('Peran')" />
                        <x-select id="role" name="role" required>
                            <option>Pilih peran</option>
                            <option value="P">Presenter</option>
                            <option value="K">Kepala Kampus</option>
                            <option value="A">Administrator</option>
                            <option value="E">Pendidikan</option>
                            <option value="C">C&P</option>
                        </x-select>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="status" :value="__('Status')" />
                        <x-select id="status" name="status" required>
                            <option>Pilih status</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </x-select>
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
