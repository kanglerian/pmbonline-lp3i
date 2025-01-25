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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Master Kegiatan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <main class="space-y-5">
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
        <section class="flex flex-col md:flex-row items-center justify-between gap-3 md:gap-0">
            <a href="{{ route('event.create') }}"
                class="bg-lp3i-100 hover:bg-lp3i-200 px-5 py-2.5 text-sm rounded-xl text-white"><i
                    class="fa-solid fa-circle-plus"></i> Tambah Data</a>
            <div class="bg-white">
                <label for="table-search" class="sr-only">Search</label>
                <form method="GET" action="{{ route('event.index') }}" class="relative flex items-center gap-3 mt-1">
                    <input type="text" name="pmb" id="pmb" value="{{ request()->input('pmb') }}"
                        class="block text-sm text-gray-900 border border-gray-300 rounded-xl w-32 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tahun PMB" autofocus>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="title" id="title" value="{{ request()->input('title') }}"
                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-xl w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Cari judul disini..." autofocus>
                    </div>
                    <button type="submit" class="hidden">Cari</button>
                </form>
            </div>
        </section>
        <section class="space-y-4">
            <div class="relative overflow-x-auto border border-gray-200 rounded-3xl">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-4 bg-gray-50">
                                No.
                            </th>
                            <th scope="col" class="px-6 py-4">
                                PMB
                            </th>
                            <th scope="col" class="px-6 py-4 bg-gray-50">
                                Kode Kegiatan
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Judul Kegiatan
                            </th>
                            <th scope="col" class="px-6 py-4 bg-gray-50">
                                Pengaturan
                            </th>
                            <th scope="col" class="px-6 py-4 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $key => $event)
                            <tr class="border-b border-gray-200">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50">
                                    {{ $events->perPage() * ($events->currentPage() - 1) + $key + 1 }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $event->pmb }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-700 bg-gray-50">
                                    <span class="underline underline-offset-4 font-medium">{{ $event->code }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $event->title }}
                                </td>
                                <td class="px-6 py-4 bg-gray-50">
                                    <form action="{{ route('event.scholarship', $event->id) }}" method="GET"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $event->is_scholarship ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-red-500 hover:bg-red-600' }} px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                            {!! $event->is_scholarship
                                                ? '<i class="fa-solid fa-graduation-cap"></i>'
                                                : '<i class="fa-solid fa-graduation-cap"></i>' !!}
                                        </button>
                                    </form>
                                    <form action="{{ route('event.files', $event->id) }}" method="GET"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $event->is_files ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-red-500 hover:bg-red-600' }} px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                            {!! $event->is_files ? '<i class="fa-solid fa-file"></i>' : '<i class="fa-solid fa-file"></i>' !!}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('event.status', $event->id) }}" method="GET"
                                        class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="{{ $event->is_status ? 'bg-emerald-500 hover:bg-emerald-600' : 'bg-red-500 hover:bg-red-600' }} px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                            {!! $event->is_status ? '<i class="fa-solid fa-toggle-on"></i>' : '<i class="fa-solid fa-toggle-off"></i>' !!}
                                        </button>
                                    </form>
                                    <button type="button"
                                        onclick="copyToClipboard('{{ $event->code }}', '{{ config('app.url') }}')"
                                        class="inline-block bg-sky-500 hover:bg-sky-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                        <i class="fa-solid fa-link"></i>
                                    </button>
                                    <a target="_blank" href="{{ route('event.show', $event->code) }}"
                                        class="inline-block bg-blue-500 hover:bg-blue-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('event.edit', $event->id) }}"
                                        class="inline-block bg-amber-500 hover:bg-amber-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('event.destroy', $event->id) }}" method="post"
                                        class="inline-block" onsubmit="return confirmDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 px-3 py-2 rounded-xl text-white transition-all ease-in-out">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-5 bg-gray-50">
                    {{ $events->links() }}
                </div>
            </div>
        </section>
        <script>
            const getYearPMB = () => {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;
                const startYear = currentMonth >= 10 ? currentYear + 1 : currentYear;
                document.getElementById('pmb').value = startYear;
            }
            getYearPMB();
        </script>
        <script>
            function getUrlParams() {
                const urlParams = new URLSearchParams(window.location.search);
                const pmb = urlParams.get('pmb');
                const title = urlParams.get('title');
                if (pmb) {
                    document.getElementById('pmb').value = pmb;
                } else {
                    getYearPMB();
                }
                document.getElementById('title').value = title;
            }
            getUrlParams();

            function copyToClipboard(code, url) {
                const clipboard = `${url}/events/${code}`;
                navigator.clipboard.writeText(clipboard);
                alert('Link kegiatan berhasil disalin!');
            }

            function confirmDelete() {
                return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');
            }
        </script>
</x-app-layout>
