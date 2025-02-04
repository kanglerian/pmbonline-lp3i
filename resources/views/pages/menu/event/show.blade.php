<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('database.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-regular fa-window-restore mr-2"></i>
                            Others
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <a href="{{ route('event.index') }}"
                                class="ml-1 text-sm font-medium text-gray-700 md:ml-2">Master Kegiatan</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $event->title }} ({{ $event->code }})</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <div class="flex flex-wrap justify-center gap-1 px-2 text-gray-600">
                <div class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-users"></i>
                    <h2>{{ $total }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <main class="max-w-7xl mx-auto space-y-3">
        @if (session('message'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-500 text-emerald-50 rounded-2xl"
                role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
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

        <section class="overflow-hidden border rounded-3xl">
            <section class="px-6 py-4">
                <div class="bg-white">
                    <label for="table-search" class="sr-only">Search</label>
                    <form method="GET" action="{{ route('event.show', $event->id) }}" class="relative mt-1">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="name"
                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-xl w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari nama disini..." autofocus required>
                    </form>
                </div>
            </section>
            <div class="p-6 bg-gray-50">
                <div class="relative overflow-x-auto sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr class="border-b border-gray-100">
                                <th scope="col" class="px-6 py-3 bg-gray-100 text-center">
                                    <i class="fa-solid fa-user"></i>
                                </th>
                                <th scope="col" class="px-6 py-3 bg-white text-center">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-100 text-center">
                                    Nama lengkap
                                </th>
                                <th scope="col" class="px-6 py-3 bg-white text-center">
                                    No. Telpon (Whatsapp)
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-100 text-center">
                                    Presenter
                                </th>
                                <th scope="col" class="px-6 py-3 bg-white text-center">
                                    Asal sekolah
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-100 text-center">
                                    Jurusan
                                </th>
                                <th scope="col" class="px-6 py-3 bg-white text-center">
                                    Tahun lulus
                                </th>
                                <th scope="col" class="px-6 py-3 bg-gray-100 text-center">
                                    Rating
                                </th>
                                <th scope="col" class="px-6 py-3 bg-white text-center">
                                    Komentar
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applicants as $applicant)
                                <tr class="border-b border-gray-100">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                        <button type="button"
                                            class="bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-lg text-xs text-white"
                                            onclick="copyRecord(
                                                `{{ $applicant->applicant->name }}`,
                                                `{{ $applicant->applicant->phone }}`,
                                                `{{ $applicant->applicant->schoolapplicant ? $applicant->applicant->schoolapplicant->name : 'Tidak diketahui' }}`,
                                                `{{ $applicant->applicant->year ?? 'Tidak diketahui' }}`,
                                                `{{ $applicant->applicant->program ?? 'Tidak diketahui' }}`,
                                                `{{ $applicant->applicant->source_id ? $applicant->applicant->sourcesetting->name : 'Tidak diketahui' }}`,
                                                `{{ $applicant->applicant->programtype ? $applicant->applicant->programtype->name : 'Tidak diketahui' }}`,
                                                `{{ $applicant->applicant->applicantstatus ? $applicant->applicant->applicantstatus->name : 'Tidak diketahui' }}`,
                                                );">
                                            <i class="fa-solid fa-copy"></i>
                                        </button>
                                    </th>
                                    <td class="px-6 py-4 bg-white text-center">
                                        <div class="flex gap-2">
                                            <span
                                                class="text-sm {{ $applicant->applicant->is_applicant ? 'text-yellow-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-file-lines"></i></span>
                                            <span
                                                class="text-sm {{ $applicant->applicant->is_daftar ? 'text-sky-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-id-badge"></i></span>
                                            <span
                                                class="text-sm {{ $applicant->applicant->is_register ? 'text-emerald-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-user-check"></i></span>
                                            <span
                                                class="text-sm {{ $applicant->applicant->schoolarship ? 'text-cyan-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-graduation-cap"></i></span>
                                        </div>
                                    </td>
                                    <td
                                        class="px-6 py-4 bg-gray-50 text-center  {{ $applicant->applicant->identity_user == '6281313608558' ? 'text-red-500' : 'text-gray-600' }}">
                                        <a target="_blank" href="{{ route('database.show', $applicant->applicant->identity) }}"
                                            class="font-bold underline">{{ $applicant->applicant->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->applicant->phone ?? 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 text-center">
                                        @if ($applicant->applicant->identity_user)
                                            @if ($applicant->applicant->presenter)
                                                {{ $applicant->applicant->presenter->name }}
                                            @else
                                                <span class="text-red-500">Presenter tidak ditemukan</span>
                                            @endif
                                        @else
                                            Tidak diketahui
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->applicant->school ? $applicant->applicant->schoolapplicant->name : 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 text-center">
                                        {{ $applicant->applicant->major ?? 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->applicant->year ?? 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 text-center">
                                        {{ $applicant->rating }}
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->comment ?? 'Tidak ada komentar' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-4 text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="p-1">
                        {{ $applicants->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>

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
</x-app-layout>
