<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Pengaturan') }}
            </h2>
        </div>
    </x-slot>

    <main>
        <section class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <a href="{{ route('event.index') }}" class="relative bg-hijau-200 transition-all ease-in-out text-white p-8 rounded-3xl">
                <div class="space-y-1">
                    <h2 class="font-bold">Master Kegiatan</h2>
                    <p class="text-sm">Ini adalah halaman master data untuk kegiatan.</p>
                </div>
                <i class="fa-solid fa-chalkboard-user absolute z-50 fa-3x top-1/2 right-10 transform -translate-y-1/2  opacity-10"></i>
            </a>
            <a href="{{ route('applicantstatus.index') }}" class="relative bg-lp3i-200 transition-all ease-in-out text-white p-8 rounded-3xl">
                <div class="space-y-1">
                    <h2 class="font-bold">Master Status Aplikan</h2>
                    <p class="text-sm">Ini adalah halaman master data untuk status aplikan.</p>
                </div>
                <i class="fa-solid fa-gear absolute z-50 fa-3x top-1/2 right-10 transform -translate-y-1/2  opacity-10"></i>
            </a>
            <a href="{{ route('followup.index') }}" class="relative bg-lp3i-200 transition-all ease-in-out text-white p-8 rounded-3xl">
                <div class="space-y-1">
                    <h2 class="font-bold">Master Follow Up</h2>
                    <p class="text-sm">Ini adalah halaman master data untuk follow up.</p>
                </div>
                <i class="fa-solid fa-gear absolute z-50 fa-3x top-1/2 right-10 transform -translate-y-1/2  opacity-10"></i>
            </a>
            <a href="{{ route('programtype.index') }}" class="relative bg-lp3i-200 transition-all ease-in-out text-white p-8 rounded-3xl">
                <div class="space-y-1">
                    <h2 class="font-bold">Master Tipe Program</h2>
                    <p class="text-sm">Ini adalah halaman master data untuk tipe program.</p>
                </div>
                <i class="fa-solid fa-gear absolute z-50 fa-3x top-1/2 right-10 transform -translate-y-1/2  opacity-10"></i>
            </a>
            <a href="{{ route('source.index') }}" class="relative bg-lp3i-200 transition-all ease-in-out text-white p-8 rounded-3xl">
                <div class="space-y-1">
                    <h2 class="font-bold">Master Sumber Data</h2>
                    <p class="text-sm">Ini adalah halaman master data untuk sumber data.</p>
                </div>
                <i class="fa-solid fa-gear absolute z-50 fa-3x top-1/2 right-10 transform -translate-y-1/2  opacity-10"></i>
            </a>
            <a href="{{ route('fileupload.index') }}" class="relative bg-lp3i-200 transition-all ease-in-out text-white p-8 rounded-3xl">
                <div class="space-y-1">
                    <h2 class="font-bold">Master Berkas</h2>
                    <p class="text-sm">Ini adalah halaman master data untuk berkas.</p>
                </div>
                <i class="fa-solid fa-gear absolute z-50 fa-3x top-1/2 right-10 transform -translate-y-1/2  opacity-10"></i>
            </a>
        </section>
    </main>
</x-app-layout>
