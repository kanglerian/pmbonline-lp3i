<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <main>
        @if (session('message'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if ($errors->any())
        <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div class="ml-3 text-sm font-reguler">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if ($errors->first('berkas'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif
    </main>

    <div id="identity_user" class="hidden">{{ $user->identity }}</div>

    <main class="flex flex-col md:flex-row px-5 md:px-0 gap-5">
        <div class="w-full md:w-4/6">
            <div class="p-8 bg-gray-50 border border-gray-100 rounded-3xl">
                <div class="w-full">
                    <section class="space-y-4">
                        <header class="flex justify-between items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Daftar Riwayat Hidup
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                                </p>
                            </div>
                            <div class="flex gap-2">
                                @if ($account > 0 && $user->programtype_id && $user->program)
                                    <a href="{{ route('database.print', $user->identity) }}"
                                        class="inline-block bg-lp3i-100 hover:bg-lp3i-200 px-4 py-1 rounded-lg text-sm text-white"><i
                                            class="fa-solid fa-print"></i></a>
                                @else
                                    @if (!$user->programtype_id && !$user->program)
                                        <button onclick="return alert('Program Studi / Program Kuliah belum dipilih.')"
                                            class="inline-block bg-lp3i-100 hover:bg-lp3i-200 px-4 py-1 rounded-lg text-sm text-white"><i
                                                class="fa-solid fa-print"></i></button>
                                    @endif
                                @endif
                                <a href="{{ route('database.edit', $user->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 px-4 py-1 rounded-lg text-sm text-yellow-50"><i
                                        class="fa-regular fa-pen-to-square"></i></a>
                                @if (!$user->is_daftar && !$user->is_register)
                                    <form action="{{ route('database.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-block bg-red-500 hover:bg-red-600 px-4 py-1 rounded-lg text-sm text-red-50">
                                            <i class="fa-solid fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </header>
                        <hr>
                        <section class="space-y-4">
                            <div class="space-y-2">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Mahasiswa</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span class="border-b">{{ $user->name == null ? '___' : $user->name }}</span>
                                    </li>
                                    @if (Auth::user()->role == 'A')
                                        <li class="space-x-2">
                                            <span>Presenter:</span>
                                            <span
                                                class="border-b">{{ $user->identity_user == null ? '___' : $user->presenter->name }}</span>
                                        </li>
                                    @endif
                                    <li class="space-x-2">
                                        <span>Program Kuliah:</span>
                                        <span
                                            class="border-b">{{ $user->programtype_id == null ? '___' : $user->programtype->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Program Studi:</span>
                                        <span
                                            class="border-b">{{ $user->program == null ? '___' : $user->program }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $user->place_of_birth == null ? '___' : $user->place_of_birth }}
                                            /
                                            {{ $user->date_of_birth == null ? '___' : $user->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $user->SchoolApplicant == null ? '___' : $user->SchoolApplicant->name }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $user->address == null ? '___' : $user->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $user->phone == null ? '___' : $user->phone }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Catatan:</span>
                                        <span class="border-b">
                                            {{ $user->note == null ? '___' : $user->note }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-2">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ayah</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $father->name == null ? '___' : $father->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pekerjaan:</span>
                                        <span class="border-b">{{ $father->job == null ? '___' : $father->job }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $father->place_of_birth == null ? '___' : $father->place_of_birth }}
                                            /
                                            {{ $father->date_of_birth == null ? '___' : $father->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $father->education == null ? '___' : $father->education }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $father->address == null ? '___' : $father->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $father->phone == null ? '___' : $father->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-2">
                                <h2 class="text-lg font-bold text-gray-900">Biodata Ibu</h2>
                                <ul class="text-sm space-y-1 text-gray-800">
                                    <li class="space-x-2">
                                        <span>Nama Lengkap:</span>
                                        <span
                                            class="border-b">{{ $mother->name == null ? '___' : $mother->name }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pekerjaan:</span>
                                        <span class="border-b">{{ $mother->job == null ? '___' : $mother->job }}</span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Tempat / Tanggal Lahir:</span>
                                        <span class="border-b">
                                            {{ $mother->place_of_birth == null ? '___' : $mother->place_of_birth }}
                                            /
                                            {{ $mother->date_of_birth == null ? '___' : $mother->date_of_birth }}
                                    </li>
                                    <li class="space-x-2">
                                        <span>Pendidikan Terakhir:</span>
                                        <span class="border-b">
                                            {{ $mother->education == null ? '___' : $mother->education }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>Alamat:</span>
                                        <span class="border-b">
                                            {{ $mother->address == null ? '___' : $mother->address }}
                                        </span>
                                    </li>
                                    <li class="space-x-2">
                                        <span>No. Telpon:</span>
                                        <span class="border-b">
                                            {{ $mother->phone == null ? '___' : $mother->phone }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </section>
                </div>
            </div>
        </div>

        <div class="w-full md:w-2/6 mx-auto space-y-6">
            <div class="p-8 bg-gray-50 border border-gray-100 rounded-3xl">
                <div class="w-full">
                    <section class="space-y-4">
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Pengaturan
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Berikut ini pengaturan mahasiswa.
                                </p>
                            </div>
                        </header>
                        <hr>
                        <section class="flex flex-col justify-between gap-5">
                            @if ($account == 0 && $user->is_applicant == 1)
                                <div class="w-full space-y-2">
                                    <button type="button" onclick="modalAccount()"
                                        class="w-full bg-red-500 hover:bg-red-600 px-4 py-2 rounded-xl text-white text-sm">
                                        <i class="fa-solid fa-user-plus mr-1"></i>
                                        <span>Buat Akun</span>
                                    </button>
                                    <p class="text-xs text-center text-gray-700">
                                        Untuk registrasi, buat akun terlebih dahulu.
                                    </p>
                                </div>
                            @elseif($account > 0)
                                <div class="w-full space-y-2">
                                    <button type="button"
                                        class="w-full bg-emerald-500 hover:bg-emerald-600 px-4 py-2 rounded-xl text-white text-sm">
                                        <i class="fa-solid fa-circle-check mr-1"></i>
                                        <span>Sudah memiliki akun</span>
                                    </button>
                                </div>
                            @endif
                            @if ($user->identity_user === '6281313608558')
                                <p class="text-xs text-center text-red-500">
                                    Presenter belum diubah, silahkan untuk ubah terlebih dahulu.
                                </p>
                            @else
                                <div class="space-y-2">
                                    <div>
                                        <form action="{{ route('database.is_schoolarship', $user->id) }}"
                                            method="GET" onsubmit="return confirmAction()">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" value="{{ $user->schoolarship }}"
                                                    class="sr-only peer"
                                                    {{ $user->schoolarship == 1 ? 'checked' : '' }}>
                                                <button type="submit"
                                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                </button>
                                                <span class="ml-3 text-sm font-medium text-gray-900">Beasiswa</span>
                                            </label>
                                        </form>
                                    </div>
                                    @if ($user->identity_user !== '6281313608558')
                                        <div class="flex justify-between items-center gap-2">
                                            @if ($user->is_applicant)
                                                <form action="{{ route('statusdatabaseaplikan.destroy', $user->id) }}" method="POST" onsubmit="return confirmAction()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <button type="submit"
                                                            {{ $user->is_register || $user->is_daftar ? 'disabled' : '' }}
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></button>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-emerald-600">Aplikan</span>
                                                    </label>
                                                </form>
                                            @else
                                                <form action="{{ route('database.is_applicant', $user->id) }}" method="GET" onsubmit="return confirmAction()">
                                                    <input type="hidden" name="change_pmb"
                                                        value="{{ $user->pmb }}">
                                                    <input type="hidden" id="session_aplikan" maxlength="1"
                                                        name="session">
                                                    <input type="hidden" name="identity_user"
                                                        value="{{ $user->identity }}">
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer">
                                                        <button type="submit"
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                        </button>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-gray-900">Aplikan</span>
                                                    </label>
                                                </form>
                                            @endif
                                            @if ($user->is_applicant && $status_applicant)
                                                <div class="flex items-center gap-3 mt-1">
                                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                    <button onclick="modalEditAplikan()">
                                                        <i
                                                            class="fa-solid fa-pen-to-square text-yellow-500 hover:text-yellow-600"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($user->is_applicant == 1)
                                        <div class="flex justify-between items-center gap-2">
                                            @if ($user->is_daftar && $enrollment)
                                                <form action="{{ route('statusdatabasedaftar.destroy', $user->id) }}" method="POST" onsubmit="return confirmAction()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <button type="submit"
                                                            {{ $user->is_register ? 'disabled' : '' }}
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></button>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-emerald-600">Daftar</span>
                                                    </label>
                                                </form>
                                                <div class="flex items-center gap-3 mt-1">
                                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                    @if ($enrollment->approve)
                                                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                    @else
                                                        <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                                    @endif
                                                    <button onclick="modalEditDaftar()">
                                                        <i
                                                            class="fa-solid fa-pen-to-square text-yellow-500 hover:text-yellow-600"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div>
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer">
                                                        <button disabled
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                        </button>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-gray-900">Daftar</span>
                                                    </label>
                                                </div>
                                                <button type="button" onclick="modalDaftar()"
                                                    class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center mr-2"><i
                                                        class="fa-solid fa-receipt mr-1"></i>
                                                    Masukan nominal
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                    @if ($enrollment && !$enrollment->approve)
                                        <p class="text-[11px] text-red-500 text-center">Belum bisa di registrasikan
                                            karena pendaftaran belum disetujui.<br />Silahkan hubungi Admin bagian
                                            Approval.</p>
                                    @endif
                                    @if ($user->is_applicant == 1 && $user->is_daftar == 1 && $enrollment->approve && $account > 0)
                                        <div class="flex justify-between items-center gap-2">
                                            @if ($user->is_register && $registration)
                                                <form
                                                    action="{{ route('statusdatabaseregistrasi.destroy', $user->id) }}" method="POST" onsubmit="return confirmAction()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" class="sr-only peer" checked>
                                                        <button type="submit"
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></button>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-emerald-600">Registrasi</span>
                                                    </label>
                                                </form>
                                                <div class="flex items-center gap-3">
                                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                                    <button onclick="modalEditRegistrasi()">
                                                        <i
                                                            class="fa-solid fa-pen-to-square text-yellow-500 hover:text-yellow-600"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <div>
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox"class="sr-only peer">
                                                        <button disabled
                                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer  peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                                                        </button>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-gray-900">Registrasi</span>
                                                    </label>
                                                </div>
                                                <button type="button" onclick="modalRegistrasi()"
                                                    class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-xs px-5 py-2.5 text-center inline-flex items-center mr-2"><i
                                                        class="fa-solid fa-receipt mr-1"></i>
                                                    Masukan nominal
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if (
                                $user->pmb &&
                                    $user->nik &&
                                    $user->nisn &&
                                    $user->name &&
                                    $user->gender !== null &&
                                    $user->date_of_birth &&
                                    $user->place_of_birth &&
                                    $user->programtype_id &&
                                    $user->address &&
                                    $user->program &&
                                    $user->presenter &&
                                    $user->school &&
                                    $user->year &&
                                    $user->major &&
                                    $user->email &&
                                    $user->phone)
                                @if ($user->is_applicant == 1 && $user->is_daftar == 1 && $user->is_register == 1 && $account > 0 && $registration)
                                    <hr>
                                    <button type="button" id="button-misil" onclick="getTokenMisil()"
                                        class="flex justify-center items-center gap-2 cursor-pointer text-center text-xs bg-sky-500 hover:bg-sky-600 text-white px-5 py-2.5 rounded-xl">
                                        <span>
                                            <i class="fa-solid fa-circle-nodes"></i> Integrasi MISIL & SIAKAD Tasik
                                        </span>
                                        <span id="loading-misil" class="hidden">
                                            <svg aria-hidden="true"
                                                class="w-4 h-4 text-gray-200 animate-spin fill-sky-300"
                                                viewBox="0 0 100 101" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentFill" />
                                            </svg>
                                        </span>
                                    </button>
                                    @if ($integration_misil)
                                        <p class="text-xs text-center text-red-500">Aplikan sudah
                                            terintegrasi.<br />Jika terjadi <b>perubahan data</b>, silahkan <b>klik
                                                kembali</b> Integrasi.</p>
                                    @endif
                                @endif
                            @else
                                @if ($user->is_applicant == 1 && $user->is_daftar == 1 && $user->is_register == 1 && $account > 0 && $registration)
                                    <hr>
                                    <button type="button" onclick="modalCheck()"
                                        class="text-center text-xs bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-lg">
                                        <span>
                                            <i class="fa-solid fa-circle-nodes"></i> Periksa Kelengkapan Integrasi
                                        </span>
                                    </button>
                                    <p class="text-xs text-center text-gray-500">Fitur ini belum dapat dilakukan karena
                                        biodata belum lengkap. <a href="{{ route('database.edit', $user->id) }}"
                                            class="underline">Ubah sekarang</a></p>
                                @endif
                            @endif
                        </section>
                    </section>
                </div>
            </div>
            <div class="p-8 bg-gray-50 border border-gray-100 rounded-3xl">
                <div class="w-full">
                    <section class="space-y-4">
                        <header class="flex md:justify-between flex-col md:flex-row items-start md:items-center gap-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">
                                    Informasi Aplikan
                                </h2>
                                <p class="mt-1 text-sm text-gray-600">
                                    Berikut ini adalah informasi tentang status aplikan.
                                </p>
                            </div>
                        </header>
                        <hr>
                        <section class="flex flex-col gap-3">
                            @if ($user->is_applicant && $status_applicant)
                                <div class="flex justify-between items-end">
                                    <div class="space-y-2">
                                        <h2 class="text-sm font-semibold text-gray-900">Aplikan:</h2>
                                        <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-regular fa-calendar text-gray-400"></i>
                                                <span class="inline-block mr-2">Tanggal:
                                                    <span class="underline">{{ $status_applicant->date }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-solid fa-timeline text-gray-400"></i>
                                                <span class="inline-block mr-2">Gelombang:
                                                    <span class="underline">{{ $status_applicant->session }}</span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    @if ($status_applicant && !$enrollment)
                                        <form action="{{ route('database.delete_is_applicant', $user->id) }}"
                                            method="POST" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-5 py-2.5 rounded-xl transition-all ease-in-out">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                                    <span>Belum aplikan</span>
                                </p>
                            @endif
                            @if ($enrollment)
                                <div class="flex justify-between items-end">
                                    <div class="space-y-2">
                                        <h2 class="text-sm font-semibold text-gray-900">Daftar:</h2>
                                        <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-solid fa-receipt text-gray-400"></i>
                                                <span class="inline-block mr-2">No. Kwitansi:
                                                    <span class="underline">{{ $enrollment->receipt }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-regular fa-calendar text-gray-400"></i>
                                                <span class="inline-block mr-2">Tanggal:
                                                    <span class="underline">{{ $enrollment->date }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-solid fa-timeline text-gray-400"></i>
                                                <span class="inline-block mr-2">Gelombang:
                                                    <span class="underline">{{ $enrollment->session }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="fa-regular fa-note-sticky block text-gray-400"></i>
                                                <span class="inline-block mr-2">Keterangan:
                                                    <span class="underline">{{ $enrollment->register }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="fa-regular fa-note-sticky block text-gray-400"></i>
                                                <span class="inline-block mr-2">Keterangan Daftar:
                                                    <span class="underline">{{ $enrollment->register_end }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="fa-solid fa-coins block text-gray-400"></i>
                                                <span class="inline-block mr-2">Nominal:
                                                    <span
                                                        class="underline">Rp{{ number_format($enrollment->nominal, 0, ',', '.') }}</span>
                                                </span>
                                            </li>
                                            @if ($enrollment->repayment)
                                                <li class="flex items-center space-x-2">
                                                    <i class="block fa-regular fa-calendar text-gray-400"></i>
                                                    <span class="inline-block mr-2">Pengembalian BK:
                                                        <span class="underline">{{ $enrollment->repayment }}</span>
                                                    </span>
                                                </li>
                                                <li class="flex items-center space-x-2">
                                                    <i class="fa-solid fa-money-bill-transfer block text-gray-400"></i>
                                                    <span class="inline-block mr-2">Debit:
                                                        <span
                                                            class="underline">Rp{{ number_format($enrollment->debit, 0, ',', '.') }}</span>
                                                    </span>
                                                </li>
                                            @endif
                                            <li class="flex items-center space-x-2">
                                                <i class="fa-regular fa-credit-card block text-gray-400"></i>
                                                <span class="inline-block mr-2">Kas Pendaftaran:
                                                    <span
                                                        class="underline">Rp{{ number_format($enrollment->nominal - $enrollment->debit, 0, ',', '.') }}</span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    @if ($status_applicant && $enrollment && !$registration)
                                        <form action="{{ route('enrollment.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white text-xs px-5 py-2.5 rounded-xl transition-all ease-in-out">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                                    <span>Belum daftar</span>
                                </p>
                            @endif
                            @if ($registration)
                                <div class="flex justify-between items-end">
                                    <div class="space-y-2">
                                        <h2 class="text-sm font-semibold text-gray-900">Registrasi:</h2>
                                        <ul class="max-w-md space-y-1 text-sm text-gray-500 list-inside">
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-regular fa-calendar text-gray-400"></i>
                                                <span class="inline-block mr-2">Tanggal:
                                                    <span class="underline">{{ $registration->date }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="fa-solid fa-coins block text-gray-400"></i>
                                                <span class="inline-block mr-2">Nominal:
                                                    <span
                                                        class="underline">Rp{{ number_format($registration->nominal, 0, ',', '.') }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-solid fa-money-bills text-gray-400"></i>
                                                <span class="inline-block mr-2">Harga Deal:
                                                    <span
                                                        class="underline">Rp{{ number_format($registration->deal, 0, ',', '.') }}</span>
                                                </span>
                                            </li>
                                            <li class="flex items-center space-x-2">
                                                <i class="block fa-solid fa-percent text-gray-400"></i>
                                                <span class="inline-block mr-2">Potongan:
                                                    <span
                                                        class="underline">Rp{{ number_format($registration->discount, 0, ',', '.') }}</span>
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <form action="{{ route('registration.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-xs px-5 py-2.5 rounded-xl transition-all ease-in-out">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">
                                    <i class="fa-solid fa-circle-xmark text-red-500 mr-1"></i>
                                    <span>Belum registrasi</span>
                                </p>
                            @endif
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </main>
    @include('pages.database.show.modal.account')
    @include('pages.database.show.modal.aplikan')
    @include('pages.database.show.modal.daftar')
    @if ($account)
        @include('pages.database.show.modal.registrasi')
    @endif
    @if ($registration && $enrollment && $account)
        @include('pages.database.show.modal.check')
    @endif
    @push('scripts')
        <script>
            function confirmDelete() {
                return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
            }
            function confirmAction() {
                return confirm('Apakah Anda yakin akan melakukan tindakan ini?');
            }
        </script>

        @if (!$user->is_applicant && !$status_applicant)
            <script>
                const aplikanSetting = () => {
                    const currentDate = new Date();
                    const currentMonth = currentDate.getMonth() + 1;

                    let session = 'all';

                    if (currentMonth >= 1 && currentMonth <= 3) {
                        session = 2;
                    } else if (currentMonth >= 4 && currentMonth <= 6) {
                        session = 3;
                    } else if (currentMonth >= 7 && currentMonth <= 9) {
                        session = 4;
                    } else if (currentMonth >= 10 && currentMonth <= 12) {
                        session = 1;
                    }

                    document.getElementById('session_aplikan').value = session;
                    console.log(session);
                }

                aplikanSetting();
            </script>
        @endif
        <script>
            const validateNumber = (e) => {
                let number = e.target.value.replace(/[^0-9]/g, '');
                let parsedNumber = parseInt(number);

                if (!isNaN(parsedNumber)) {
                    let formattedNumber = parsedNumber.toLocaleString('id-ID');
                    e.target.value = formattedNumber;
                } else {
                    e.target.value = null;
                }
            }
        </script>
        <script>
            const modalAccount = () => {
                let modal = document.getElementById('modal-account');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            const modalRegistrasi = () => {
                let modal = document.getElementById('modal-registrasi');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            const modalEditRegistrasi = () => {
                let modal = document.getElementById('modal-edit-registrasi');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            const modalEditAplikan = () => {
                let modal = document.getElementById('modal-edit-aplikan');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            const modalDaftar = () => {
                let modal = document.getElementById('modal-daftar');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            const modalEditDaftar = () => {
                let modal = document.getElementById('modal-edit-daftar');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }

            const modalCheck = () => {
                let modal = document.getElementById('modal-check');
                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            }
        </script>
        <script src="{{ asset('js/axios.min.js') }}"></script>
        <script>
            const copyRecord = (name, phone, school, year, program, source, programtype, status) => {
                const textarea = document.createElement("textarea");
                textarea.value =
                    `Nama lengkap: ${name} \nNo. Telp (Whatsapp): ${phone} \nAsal sekolah dan tahun lulus: ${school} (${year})\nMinat Prodi: ${program}\nProgram Kuliah: ${programtype}\nSumber: ${source}`;
                textarea.style.position = "fixed";
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand("copy");
                document.body.removeChild(textarea);
                alert('Data sudah disalin.');
            }
        </script>
        <script>
            const saveAplikan = async (data, token, identity) => {
                const headers = {
                    'X-Auth-Token': `${token}`,
                    'X-Fullname': 'Database Marketing',
                    'X-Url': '#/dashboard-mkt',
                    'X-User': 'integrasi',
                    'Content-Type': 'application/json',
                };

                try {
                    const misilResponse = await axios.post(
                        `https://backend-misilv4.politekniklp3i-tasikmalaya.ac.id/service/integration/marketing/save-aplikan`,
                        data, {
                            headers: headers
                        });

                    alert(misilResponse.data.message);

                    await axios.post(`/integration`, {
                        identity_user: identity,
                        platform: 'misil',
                    });
                    const responseSiakad = await axios.post(
                        "https://sie.politekniklp3i-tasikmalaya.ac.id/api/integration/pmb", {
                            identity_user: data.identity_user,
                            nik: data.nik,
                            name: data.nama_lengkap,
                            major: data.kode_jurusan,
                            place_of_birth: data.tempat_lahir,
                            date_of_birth: data.tgl_lahir,
                            email: data.email,
                            phone: data.no_hp,
                            pmb: data.pmb,
                        });
                    location.reload();
                } catch (error) {
                    console.log(error);
                }
            }

            const getTokenMisil = async () => {
                let identityVal = document.getElementById('identity_user').innerText;
                let loadingMisil = document.getElementById('loading-misil');
                loadingMisil.classList.toggle('hidden');
                try {
                    const database = axios.get(`/api/database/${identityVal}`);
                    const programs = axios.get(`https://endpoint.politekniklp3i-tasikmalaya.ac.id/programs`, {
                        headers: {
                            'lp3i-api-key': 'b35e0a901904d293'
                        }
                    });
                    const misilAuth = axios.post(
                        `https://backend-misilv4.politekniklp3i-tasikmalaya.ac.id/service/auth/sign-in`, {
                            namaUser: "integrasi",
                            kataSandi: "IntegrasiMisil311"
                        });
                    await axios.all([database, programs, misilAuth])
                        .then(axios.spread((database, programs, misilAuth) => {
                            let token = misilAuth.data.messages['X-AUTH-TOKEN'];
                            let program_studi = database.data.user.program;
                            let program = programs.data.find((result) =>
                                `${result.level} ${result.title}` == program_studi)
                            const addressParts = database.data.user.address.split(',');
                            const addressRtRw = addressParts[1].split(' ');
                            if (!program) {
                                alert(
                                    'Program studi tidak ditemukan. Silakan perbarui jurusan di bagian Edit Profil melalui akun Presenter.'
                                    );
                                window.location.href = `/database/${database.data.user.id}/edit`;
                                loadingMisil.classList.toggle('hidden');
                                return;
                            } else {
                                const confirmed = confirm(
                                    `Program studi yang dipilih adalah ${program.title} dengan kode jurusan ${program.code}. Apakah data sudah benar?`
                                );
                                if (!confirmed) {
                                    alert(
                                        'Jika ini salah, maka silakan perbarui jurusan di bagian Edit Profil melalui akun Presenter.');
                                    window.location.href = `/database/${database.data.user.id}/edit`;
                                    loadingMisil.classList.toggle('hidden');
                                    return;
                                }
                            }
                            const data = {
                                // Aplikan datang
                                method: 'simpan',
                                nik: database.data.user.nik,
                                tahun_akademik: `${database.data.user.pmb}/${parseInt(database.data.user.pmb) + 1}`,
                                nama_lengkap: database.data.user.name,
                                tempat_lahir: database.data.user.place_of_birth,
                                tgl_lahir: database.data.user.date_of_birth,
                                jenis_kelamin: database.data.user.gender == 1 ? 'L' : 'P',
                                no_hp: database.data.user.phone,
                                dusun: addressParts[0],
                                rtrw: `${addressRtRw[1]}/${addressRtRw[3]}`,
                                kelurahan: addressParts[2].replace('Desa/Kelurahan ', ''),
                                kecamatan: addressParts[3].replace('Kecamatan ', ''),
                                kota: addressParts[4].replace('Kota/Kabupaten ', ''),
                                kode_pos: addressParts[6].replace('Kode Pos ', ''),
                                whatsapp: database.data.user.phone,
                                facebook: '-',
                                instagram: '-',
                                pendidikan_terakhir: database.data.user.school_applicant.type,
                                asal_sekolah: database.data.user.school_applicant.name,
                                jurusan_sekolah: database.data.user.major,
                                tahun_lulus: database.data.user.year,
                                email: database.data.user.email,
                                nama_ortu: database.data.user.father.name || database.data.user.mother.name,
                                pekerjaan_ortu: database.data.user.father.job || database.data.user.mother
                                    .job,
                                penghasilan_ortu: database.data.user.income_parent,
                                nohp_ortu: database.data.user.father.phone || database.data.user.mother
                                    .phone,
                                kode_jurusan: program.code,
                                sumber_informasi: database.data.user.source_daftar_setting.name,
                                sumber_aplikan: database.data.user.source_setting.name,
                                kode_presenter: database.data.user.presenter.code,
                                gelombang: database.data.registration.session,
                                tgl_datang: database.data.registration.date,
                                kode_siswa: "-",
                                // Aplikan Daftar
                                isnew: true,
                                kode_aplikan: null,
                                tgl_daftar: database.data.enrollment.date,
                                gelombang_daftar: database.data.registration.session,
                                nomor_bukti: database.data.enrollment.receipt,
                                biaya_pendaftaran: database.data.enrollment.nominal,
                                diskon: 0,
                                sumber_daftar: database.data.user.source_daftar_setting.name,
                                keterangan: database.data.enrollment.register,
                                ket_daftar: database.data.enrollment.register_end,
                                // SIAKAD
                                identity_user: database.data.user.identity,
                                pmb: database.data.user.pmb,
                            };

                            if (!(data.nik).length == 16) {
                                return alert('NIK kurang dari 16!');
                            }

                            if ((data.nama_lengkap).length > 50) {
                                return alert('Nama lengkap harus kurang dari 50 karakter!')
                            }

                            if ((data.tempat_lahir).length > 50) {
                                return alert('Tempat lahir harus kurang dari 50 karakter!')
                            }

                            if ((data.dusun).length > 100) {
                                return alert('Dusun harus kurang dari 100 karakter!')
                            }

                            if ((data.rtrw).length > 10) {
                                return alert('RT/RW harus kurang dari 10 karakter!')
                            }

                            if ((data.kelurahan).length > 30) {
                                return alert('Kelurahan harus kurang dari 30 karakter!')
                            }

                            if ((data.kecamatan).length > 30) {
                                return alert('Kecamatan harus kurang dari 30 karakter!')
                            }

                            if ((data.kota).length > 30) {
                                return alert('Kota harus kurang dari 30 karakter!')
                            }

                            if ((data.kode_pos).length > 7) {
                                return alert('Kode Pos harus kurang dari 7 karakter!')
                            }

                            if ((data.no_hp).length > 14) {
                                return alert('No Telpon harus kurang dari 14 karakter!')
                            }

                            if ((data.whatsapp).length > 14) {
                                return alert('No Whatsapp harus kurang dari 14 karakter!')
                            }

                            if (!data.pendidikan_terakhir) {
                                return alert('Sekolah tidak terdaftar, silahkan edit di bagian Administrator.')
                            } else if ((data.pendidikan_terakhir).length > 10) {
                                return alert('Pendidikan terakhir harus kurang dari 10 karakter!')
                            }

                            if ((data.asal_sekolah).length > 100) {
                                return alert('Asal sekolah harus kurang dari 100 karakter!')
                            }

                            if ((data.jurusan_sekolah).length > 100) {
                                return alert('Jurusan sekolah harus kurang dari 100 karakter!')
                            }

                            if ((data.tahun_lulus).length > 4) {
                                return alert('Tahun lulus harus kurang dari 4 karakter!')
                            }

                            if ((data.email).length > 50) {
                                return alert('Email harus kurang dari 50 karakter!')
                            }

                            if ((data.nama_ortu).length > 50) {
                                return alert('Nama orang tua harus kurang dari 50 karakter!')
                            }

                            if ((data.pekerjaan_ortu).length > 50) {
                                return alert('Pekerjaan orang tua harus kurang dari 50 karakter!')
                            }

                            if ((data.penghasilan_ortu).length > 50) {
                                return alert('Penghasilan orang tua harus kurang dari 50 karakter!')
                            }

                            if ((data.nohp_ortu).length > 100) {
                                return alert('Nomor telpon orang tua harus kurang dari 100 karakter!')
                            }

                            if ((data.kode_jurusan).length > 9) {
                                return alert('Kode jurusan harus kurang dari 9 karakter!')
                            }

                            if ((data.sumber_informasi).length > 30) {
                                return alert('Sumber informasi harus kurang dari 30 karakter!')
                            }

                            if ((data.sumber_aplikan).length > 30) {
                                return alert('Sumber aplikan harus kurang dari 30 karakter!')
                            }

                            if (!data.kode_presenter) {
                                return alert('Kode presenter kosong!')
                            } else if ((data.kode_presenter).length > 5) {
                                return alert('Kode presenter harus kurang dari 5 karakter!')
                            }

                            if ((data.gelombang).length > 1) {
                                return alert('Data gelombang harus 1 karakter!')
                            }

                            if ((data.tahun_akademik).length > 9) {
                                return alert('Tahun akademik harus kurang dari 9 karakter!')
                            }

                            saveAplikan(data, token, identityVal);

                            loadingMisil.classList.toggle('hidden');
                        }))
                        .catch((error) => {
                            console.log(error);
                            alert('Ada masalah di Server, silahkan hubungi Administrator!');
                            document.getElementById('button-misil').setAttribute('onclick', "alert('maintenance')");
                        });

                } catch (error) {
                    console.log(error);
                    alert('Ada masalah di Server, silahkan hubungi Administrator!');
                    document.getElementById('button-misil').setAttribute('onclick', "alert('maintenance')");
                }
            }
        </script>
    @endpush
</x-app-layout>
