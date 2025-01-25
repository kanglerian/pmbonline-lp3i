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
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Create Event</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
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
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-2xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <div class="w-full md:w-2/3 rounded-3xl bg-gray-50 p-8 border border-gray-200">
            <form method="POST" action="{{ route('event.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="pmb" :value="__('PMB')" />
                        <input id="pmb" type="number" name="pmb" maxlength="4" :value="old('pmb')"
                            placeholder="PMB" required
                            class="block mt-2 px-4 py-3 w-full text-sm rounded-xl border-gray-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('pmb') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="code" :value="__('Kode Kegiatan')" />
                        <input id="code" type="text" name="code" maxlength="10" value="{{ old('code') }}"
                            placeholder="Kode Kegiatan" required
                            class="block mt-2 px-4 py-3 w-full text-sm rounded-xl border-gray-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('code') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="title" :value="__('Judul Kegiatan')" />
                        <input id="title" type="text" name="title" value="{{ old('title') }}"
                            placeholder="Judul Kegiatan" required
                            class="block mt-2 px-4 py-3 w-full text-sm rounded-xl border-gray-200 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('title') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="description" :value="__('Deskripsi')" />
                        <textarea name="description" id="description" value="{{ old('description') }}"
                            class="block mt-2 px-4 py-3 w-full text-sm rounded-xl border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="Deskripsi kegiatan" required>{{ old('description') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('description') }}</span>
                        </p>
                    </div>
                </div>
                <button type="submit"
                    class="text-white bg-lp3i-100 hover:bg-lp3i-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm w-full sm:w-auto px-5 py-2.5 text-center"><i
                        class="fa-solid fa-floppy-disk mr-1"></i> Simpan</button>
            </form>
        </div>
    </main>
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
</x-app-layout>
