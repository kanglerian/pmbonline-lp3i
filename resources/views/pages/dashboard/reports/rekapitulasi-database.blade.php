<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5">
            <nav class="flex">
                <ol class="inline-flex items-center space-x-2 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">
                            <i class="fa-solid fa-table-columns mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fa-solid fa-chevron-right text-gray-300 mr-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Rekapitulasi Database</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <main class="space-y-5">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <div class="flex items-end flex-wrap md:flex-nowrap text-gray-500 md:gap-3 order-2 md:order-none">
                <input type="hidden" id="identity_val" value="{{ Auth::user()->identity }}">
                <input type="hidden" id="role_val" value="{{ Auth::user()->role }}">
                <div class="inline-block flex flex-col space-y-1 p-1 md:p-0">
                    <label for="change_pmb" class="text-xs">Periode PMB:</label>
                    <input type="number" id="change_pmb" onchange="changeTrigger()"
                        class="w-full md:w-[150px] bg-white border border-gray-300 px-3 py-2 text-xs rounded-lg text-gray-800"
                        placeholder="Tahun PMB">
                </div>
            </div>
            <div class="px-6 py-2 rounded-xl text-sm bg-gray-50 border border-gray-200 order-1 md:order-none">
                <div>
                    <span class="font-bold">{{ Auth::user()->name }}</span>
                    (<span onclick="copyIdentity('{{ Auth::user()->identity }}')">ID:
                        {{ Auth::user()->identity }}</span>)
                    <button onclick="copyIdentity('{{ Auth::user()->identity }}')" class="text-blue-500"><i
                            class="fa-regular fa-copy"></i></button>
                </div>
                <span class="text-xs text-gray-600">Gunakan Key Identity ini di aplikasi Whatsapp
                    Sender.</span>
            </div>
        </div>
        <section class="bg-gray-50 p-6 md:rounded-3xl border border-gray-200 space-y-5">
            @if (Auth::user()->role == 'A')
                <header class="space-y-1">
                    <h2 class="font-bold text-xl text-gray-800">Rekapitulasi Database</h2>
                    <p class="text-sm text-gray-700 text-sm">
                        Berikut ini adalah menu rekapitulasi database.
                    </p>
                </header>
                <hr>
            @endif
            @include('pages.dashboard.utilities.all')
            @include('pages.dashboard.utilities.pmb')
            @if (Auth::user()->role == 'P')
                @include('pages.dashboard.presenter.report.sourcedatabasebywilayah')
            @endif
            @if (Auth::user()->role == 'A' || Auth::user()->role == 'K')
                @include('pages.dashboard.admin.report.wilayahdatabasebypresenter')
                @include('pages.dashboard.admin.report.sourcedatabasebypresenter')
                @include('pages.dashboard.admin.report.scripts')
            @endif
        </section>
    </main>
</x-app-layout>
