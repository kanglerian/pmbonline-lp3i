<x-app-layout>
    @push('styles')
        <link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />
        <style>
            .js-example-input-single {
                width: 100%;
            }

            .select2-selection {
                border-radius: 0.75rem !important;
                padding-top: 10px !important;
                padding-bottom: 10px !important;
            }

            .select2-selection__rendered {
                top: -8px !important;
            }
        </style>
    @endpush
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5">
            <ul class="flex items-center gap-6">
                <li>
                    <a href="{{ route('database.index') }}"
                        class="{{ request()->routeIs(['database.index']) ? 'inline-flex border-b-2 border-lp3i-100 leading-loose' : '' }} font-bold text-md text-gray-800">Database</a>
                </li>
                <li>
                    <a href="{{ route('recommendation.index') }}"
                        class="{{ request()->routeIs(['recommendation.index']) ? 'inline-flex border-b-2 border-lp3i-100 leading-loose' : '' }} font-bold text-md text-gray-800">Rekomendasi</a>
                </li>
            </ul>
            <div class="flex flex-wrap justify-center items-center gap-2 px-2 text-gray-600">
                {{-- <div onclick="getDataTableRecommendation()"
                    class="flex bg-gray-200 px-4 py-2 text-sm rounded-xl items-center gap-2">
                    <i class="fa-solid fa-database"></i>
                    <h2 id="count_filter">0</h2>
                </div> --}}
                <button type="button" onclick="excelDownload()"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm space-x-1">
                    <i class="fa-solid fa-file-excel"></i>
                </button>
                <button type="button" onclick="whatsappDownload()"
                    class="cursor-pointer bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-sm space-x-1">
                    <i class="fa-solid fa-download"></i>
                </button>
                <button type="button" onclick="pixelDownload()"
                    class="cursor-pointer bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-sm space-x-1">
                    <i class="fa-solid fa-bullhorn"></i>
                </button>
                <button type="button" onclick="csvDownload()"
                    class="cursor-pointer bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-sm space-x-1">
                    <i class="fa-solid fa-file-csv"></i>
                </button>
                <button type="button" onclick="vcfDownload()"
                    class="cursor-pointer bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-sm space-x-1">
                    <i class="fa-solid fa-address-book"></i>
                </button>
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

        <form method="GET" action="{{ route('database.index') }}" class="space-y-3">
            <div class="flex justify-between items-center gap-3 px-3">
                <a href="{{ route('database.create') }}"
                    class="bg-lp3i-100 hover:bg-lp3i-200 px-4 py-2 text-sm rounded-xl text-white"><i
                        class="fa-solid fa-circle-plus mr-1"></i> Tambah Data</a>
                <div class="flex items-center gap-2">
                    @if (Auth::user()->role == 'P' && Auth::user()->sheet)
                    {{-- @if(Auth::user()->identity == '6282211780631' || Auth::user()->role == 'A') --}}
                        <button type="button" onclick="syncSpreadsheet('{{ Auth::user()->sheet }}')"
                            class="bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-xs space-x-1">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                    @endif
                    <button type="submit"
                        class="bg-emerald-500 hover:bg-emerald-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-filter"></i>
                    </button>
                    <a href="{{ route('database.index') }}"
                        class="bg-red-500 hover:bg-red-600 px-4 py-2 text-xs rounded-xl text-white">
                        <i class="fa-solid fa-filter-circle-xmark"></i>
                    </a>
                </div>
            </div>

            <section class="flex flex-col justify-center gap-3">
                <div
                    class="w-full bg-gray-50 rounded-3xl border flex flex-wrap md:flex-nowrap overflow-x-auto border-gray-200 text-gray-500 p-5 md:gap-3">
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_pmb" class="text-xs">Periode PMB:</label>
                        <input type="number" id="change_pmb" name="pmb" onkeyup="changePMBQuick()"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun PMB">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_applicant" class="text-xs">Status Aplikan</label>
                        <select id="change_applicant" name="applicantstatus"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="database">Database</option>
                            <option value="aplikan">Aplikan</option>
                            <option value="daftar">Daftar</option>
                            <option value="registrasi">Registrasi</option>
                            <option value="schoolarship">Beasiswa</option>
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_source_daftar" class="text-xs">Sumber Informasi:</label>
                        <select id="change_source_daftar" name="sourcedaftar"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Sumber</option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_source" class="text-xs">Sumber Database:</label>
                        <select id="change_source" name="source"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Sumber</option>
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">{{ $source->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_status" class="text-xs">Status Database:</label>
                        <select id="change_status" name="status"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (Auth::user()->role == 'A')
                        <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                            <label for="identity_user" class="text-xs">Presenter:</label>
                            <select id="identity_user" name="presenter"
                                class="js-example-basic-single bg-white border border-gray-200 w-full md:w-[150px] px-3 py-2 text-xs rounded-xl text-gray-800">
                                <option value="all">Pilih presenter</option>
                                <option value="6281313608558">Administrator</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->identity }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" id="identity_user" value="{{ Auth::user()->identity }}">
                    @endif
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="date_start" class="text-xs">Tanggal awal:</label>
                        <input type="date" id="date_start" name="datestart"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="date_end" class="text-xs">Tanggal akhir:</label>
                        <input type="date" id="date_end" name="dateend"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_follow" class="text-xs">Ket. Follow Up:</label>
                        <select id="change_follow" name="follow"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Keterangan</option>
                            @foreach ($follows as $follow)
                                <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div
                    class="w-full bg-gray-50 rounded-3xl border flex flex-wrap md:flex-nowrap overflow-x-auto border-gray-200 text-gray-500 p-4 md:gap-3">
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="school" class="text-xs">Asal sekolah:</label>
                        <select id="school" name="school"
                            class="js-example-basic-single w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih sekolah</option>
                            <option value="0">Tidak diketahui</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_major" class="text-xs">Jurusan:</label>
                        <input type="text" id="change_major" name="major"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Jurusan">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="year_grad" class="text-xs">Tahun lulus:</label>
                        <input type="number" id="year_grad" name="year"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tahun lulus">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="birthday" class="text-xs">Tanggal lahir:</label>
                        <input type="date" id="birthday" name="dateofbirth"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Tanggal Lahir">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_phone" class="text-xs">No. Telpon:</label>
                        <select id="change_phone" name="phone"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Valid</option>
                            <option value="0">Tidak Valid</option>
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_achievement" class="text-xs">Prestasi:</label>
                        <input type="text" id="change_achievement" name="achievement"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Prestasi">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_relation" class="text-xs">Relasi:</label>
                        <input type="text" id="change_relation" name="relation"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Relasi">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_jobfather" class="text-xs">Pekerjaan Ayah:</label>
                        <input type="text" id="change_jobfather" name="jobfather"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Pekerjaan Ayah">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_jobmother" class="text-xs">Pekerjaan Ibu:</label>
                        <input type="text" id="change_jobmother" name="jobmother"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800"
                            placeholder="Pekerjaan Ibu">
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_plan" class="text-xs">Rencana Aplikan</label>
                        <select id="change_plan" name="plan"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="Kuliah">Kuliah</option>
                            <option value="Kerja">Kerja</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="Nikah">Nikah</option>
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_come" class="text-xs">Datang ke LP3I</label>
                        <select id="change_come" name="come"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_income" class="text-xs">Penghasilan Orang Tua</label>
                        <select id="change_income" name="incomeparent"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="Rp1.000.000">
                                < Rp1.000.000</option>
                            <option value="Rp1.000.000 - Rp2.000.000">Rp1.000.000 - Rp2.000.000</option>
                            <option value="Rp2.000.000 - Rp4.000.000">Rp2.000.000 - Rp4.000.000</option>
                            <option value="Rp5.000.000">> Rp5.000.000</option>
                        </select>
                    </div>
                    <div class="w-1/2 md:w-full flex flex-col space-y-1 p-1 md:p-0">
                        <label for="change_kip" class="text-xs">KIP</label>
                        <select id="change_kip" name="kip"
                            class="w-full md:w-[150px] bg-white border border-gray-200 px-3 py-2 text-xs rounded-xl text-gray-800">
                            <option value="all">Pilih</option>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
            </section>
        </form>

        <section class="overflow-hidden border rounded-3xl">
            <section class="px-6 py-4">
                <div class="bg-white">
                    <label for="table-search" class="sr-only">Search</label>
                    <form method="GET" action="{{ route('database.index') }}" class="relative mt-1">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400"></i>
                        </div>
                        <input type="hidden" name="pmbVal" id="change_pmb_quick">
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
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 bg-white text-center">
                                    Sumber Database
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
                                                `{{ $applicant->name }}`,
                                                `{{ $applicant->phone }}`,
                                                `{{ $applicant->schoolapplicant ? $applicant->schoolapplicant->name : 'Tidak diketahui' }}`,
                                                `{{ $applicant->year ?? 'Tidak diketahui' }}`,
                                                `{{ $applicant->program ?? 'Tidak diketahui' }}`,
                                                `{{ $applicant->source_id ? $applicant->sourcesetting->name : 'Tidak diketahui' }}`,
                                                `{{ $applicant->programtype ? $applicant->programtype->name : 'Tidak diketahui' }}`,
                                                `{{ $applicant->applicantstatus ? $applicant->applicantstatus->name : 'Tidak diketahui' }}`,
                                                );">
                                            <i class="fa-solid fa-copy"></i>
                                        </button>
                                    </th>
                                    <td class="px-6 py-4 bg-white text-center">
                                        <div class="flex gap-2">
                                            <span
                                                class="text-sm {{ $applicant->is_applicant ? 'text-yellow-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-file-lines"></i></span>
                                            <span
                                                class="text-sm {{ $applicant->is_daftar ? 'text-sky-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-id-badge"></i></span>
                                            <span
                                                class="text-sm {{ $applicant->is_register ? 'text-emerald-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-user-check"></i></span>
                                            <span
                                                class="text-sm {{ $applicant->schoolarship ? 'text-cyan-500' : 'text-gray-300' }}"><i
                                                    class="fa-solid fa-graduation-cap"></i></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 text-center">
                                        {{ $applicant->created_at->format('M j, Y g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->sourcesetting->name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 bg-gray-50 text-center  {{ $applicant->identity_user == '6281313608558' ? 'text-red-500' : 'text-gray-600' }}">
                                        <a href="{{ route('database.show', $applicant->identity) }}"
                                            class="font-bold underline">{{ $applicant->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->phone ?? 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 text-center">
                                        @if ($applicant->identity_user)
                                            @if ($applicant->presenter)
                                                {{ $applicant->presenter->name }}
                                            @else
                                                <span class="text-red-500">Presenter tidak ditemukan</span>
                                            @endif
                                        @else
                                            Tidak diketahui
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->school ? $applicant->schoolapplicant->name : 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 text-center">
                                        {{ $applicant->major ?? 'Tidak diketahui' }}
                                    </td>
                                    <td class="px-6 py-4 bg-white text-center">
                                        {{ $applicant->year ?? 'Tidak diketahui' }}
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

    @if (Auth::user()->sheet)
        @include('pages.database.modal.sync')
    @endif

    @push('scripts')
        <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
        <script src="{{ asset('js/moment-timezone-with-data.min.js') }}"></script>
        <script src="{{ asset('js/exceljs.min.js') }}"></script>
        <script>
            const getYearPMB = () => {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;
                const startYear = currentMonth >= 10 ? currentYear + 1 : currentYear;
                document.getElementById('change_pmb').value = startYear;
                document.getElementById('change_pmb_quick').value = startYear;
            }
            
            const changePMBQuick = () => {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;
                const startYear = currentMonth >= 10 ? currentYear + 1 : currentYear;
                document.getElementById('change_pmb').value = startYear;
                document.getElementById('change_pmb_quick').value = startYear;
            }

            getYearPMB();

            const changeFilter = () => {
                let queryParams = [];

                let dateStart = document.getElementById('date_start').value || 'all';
                let dateEnd = document.getElementById('date_end').value || 'all';
                let yearGrad = document.getElementById('year_grad').value || 'all';
                let presenterVal = document.getElementById('identity_user').value || 'all';
                let schoolVal = document.getElementById('school').value || 'all';
                let majorVal = document.getElementById('change_major').value || 'all';
                let birthdayVal = document.getElementById('birthday').value || 'all';
                let phoneVal = document.getElementById('change_phone').value || 'all';
                let pmbVal = document.getElementById('change_pmb').value || 'all';
                let comeVal = document.getElementById('change_come').value || 'all';
                let planVal = document.getElementById('change_plan').value || 'all';
                let incomeVal = document.getElementById('change_income').value || 'all';
                let achievementVal = document.getElementById('change_achievement').value || 'all';
                let followVal = document.getElementById('change_follow').value || 'all';
                let sourceVal = document.getElementById('change_source').value || 'all';
                let sourceDaftarVal = document.getElementById('change_source_daftar').value || 'all';
                let statusVal = document.getElementById('change_status').value || 'all';
                let kipVal = document.getElementById('change_kip').value || 'all';
                let relationVal = document.getElementById('change_relation').value || 'all';
                let jobFatherVal = document.getElementById('change_jobfather').value || 'all';
                let jobMotherVal = document.getElementById('change_jobmother').value || 'all';
                let statusApplicant = document.getElementById('change_applicant').value || 'all';

                if (statusApplicant !== 'all') {
                    queryParams.push(`statusApplicant=${statusApplicant}`);
                }
                if (dateStart !== 'all') {
                    queryParams.push(`dateStart=${dateStart}`);
                }
                if (dateEnd !== 'all') {
                    queryParams.push(`dateEnd=${dateEnd}`);
                }
                if (yearGrad !== 'all') {
                    queryParams.push(`yearGrad=${yearGrad}`);
                }
                if (presenterVal !== 'all') {
                    queryParams.push(`presenterVal=${presenterVal}`);
                }
                if (schoolVal !== 'all') {
                    queryParams.push(`schoolVal=${schoolVal}`);
                }
                if (birthdayVal !== 'all') {
                    queryParams.push(`birthdayVal=${birthdayVal}`);
                }
                if (phoneVal !== 'all') {
                    queryParams.push(`phoneVal=${phoneVal}`);
                }
                if (achievementVal !== 'all') {
                    queryParams.push(`achievementVal=${achievementVal}`);
                }
                if (pmbVal !== 'all') {
                    queryParams.push(`pmbVal=${pmbVal}`);
                }
                if (sourceVal !== 'all') {
                    queryParams.push(`sourceVal=${sourceVal}`);
                }
                if (sourceDaftarVal !== 'all') {
                    queryParams.push(`sourceDaftarVal=${sourceDaftarVal}`);
                }
                if (statusVal !== 'all') {
                    queryParams.push(`statusVal=${statusVal}`);
                }
                if (followVal !== 'all') {
                    queryParams.push(`followVal=${followVal}`);
                }
                if (comeVal !== 'all') {
                    queryParams.push(`comeVal=${comeVal}`);
                }
                if (incomeVal !== 'all') {
                    queryParams.push(`incomeVal=${incomeVal}`);
                }
                if (planVal !== 'all') {
                    queryParams.push(`planVal=${planVal}`);
                }
                if (kipVal !== 'all') {
                    queryParams.push(`kipVal=${kipVal}`);
                }
                if (relationVal !== 'all') {
                    queryParams.push(`relationVal=${relationVal}`);
                }
                if (jobFatherVal !== 'all') {
                    queryParams.push(`jobFatherVal=${jobFatherVal}`);
                }
                if (jobMotherVal !== 'all') {
                    queryParams.push(`jobMotherVal=${jobMotherVal}`);
                }
                if (majorVal !== 'all') {
                    queryParams.push(`majorVal=${majorVal}`);
                }

                let queryString = queryParams.join('&');

                window.location.href = `/database?${queryString}`
            }

            const clearFilter = () => {
                window.location.href = `/database`
            }

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

            const whatsappDownload = async () => {
                const url = window.location.href;
                const queryStringStart = url.indexOf('?');
                if (queryStringStart === -1) {
                    alert('Mohon difilter terlebih dahulu!');
                    console.error('URL tidak memiliki query string');
                    return;
                }
                const queryString = url.substring(queryStringStart + 1);
                try {
                    showLoadingAnimation();
                    const response = await axios.get(`get/databases?${queryString}`)
                    const applicants = response.data.applicants;
                    let content = '';
                    let schoolSelect = document.getElementById('school');
                    let selectedSchoolOption = schoolSelect.options[schoolSelect.selectedIndex];
                    let schoolVal = selectedSchoolOption.innerText || 'all';
                    if (schoolVal == 'Pilih sekolah') {
                        schoolVal = 'all';
                    }
                    let majorVal = document.getElementById('change_major').value || 'all';
                    applicants.forEach(applicant => {
                        content +=
                            `${applicant.name},${applicant.phone == null ? '0000000000' : applicant.phone}\n`
                    });
                    var blob = new Blob([content], {
                        type: "text/plain"
                    });
                    var urlData = URL.createObjectURL(blob);
                    var link = document.createElement('a');
                    link.setAttribute('href', urlData);
                    link.setAttribute('download', `whatsapp-${schoolVal}-${majorVal}.txt`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    hideLoadingAnimation();
                } catch (error) {
                    const status = error.response.status;
                    const message = error.response.data.message;
                    const exhausted = message.includes('exhausted');
                    if (status == 500 && exhausted) {
                        alert(
                            'Silakan filter data terlebih dahulu. Aplikasi tidak memungkinkan untuk mengunduh semua data.'
                        );
                        hideLoadingAnimation();
                    } else if (status == 500) {
                        alert('Ada masalah di server. Harap tunggu sementara kami mengatasi masalah ini.');
                        hideLoadingAnimation();
                    }
                }
            }

            const excelDownload = async () => {
                const url = window.location.href;
                const queryStringStart = url.indexOf('?');
                if (queryStringStart === -1) {
                    alert('Mohon difilter terlebih dahulu!');
                    console.error('URL tidak memiliki query string');
                    return;
                }
                const queryString = url.substring(queryStringStart + 1);
                try {
                    showLoadingAnimation();
                    const response = await axios.get(`get/databases?${queryString}`);
                    const applicants = response.data.applicants;
                    const workbook = new ExcelJS.Workbook();
                    const worksheet = workbook.addWorksheet('Data');
                    let header = ['No', 'Nama Lengkap', 'No. Telpon', 'Presenter', 'Asal Sekolah',
                        'Jurusan',
                        'Tahun Lulus', 'Tipe Kelas', 'Minat Prodi', 'Sumber Database',
                        'Sumber Informasi'
                    ];
                    let dataExcel = [
                        header,
                    ];
                    applicants.forEach((applicant, index) => {
                        let studentBucket = [];
                        studentBucket.push(
                            `${index + 1}`,
                            `${applicant.name ? applicant.name : 'Tidak diketahui'}`,
                            `${applicant.phone ? applicant.phone : 'Tidak diketahui'}`,
                            `${applicant.identity_user ? applicant.presenter.name : 'Tidak diketahui'}`,
                            `${applicant.school ? applicant.school_applicant.name : 'Tidak diketahui'}`,
                            `${applicant.major ? applicant.major : 'Tidak diketahui'}`,
                            `${applicant.year ? applicant.year : 'Tidak diketahui'}`,
                            `${applicant.programtype_id ? applicant.program_type.name : 'Tidak diketahui'}`,
                            `${applicant.program ? applicant.program : 'Tidak diketahui'}`,
                            `${applicant.source_id ? applicant.source_setting.name : 'Tidak diketahui'}`,
                            `${applicant.source_daftar_id ? applicant.source_daftar_setting.name : 'Tidak diketahui'}`,
                        );
                        dataExcel.push(studentBucket);
                    });
                    let dateTime = new Date();
                    const day = dateTime.getDate();
                    const month = dateTime.getMonth();
                    const year = dateTime.getFullYear();
                    const hours = dateTime.getHours();
                    const minutes = dateTime.getMinutes();
                    const seconds = dateTime.getSeconds();
                    const formattedDate = `export_database_${hours}${minutes}${seconds}${day}${month}${year}`;
                    worksheet.addRows(dataExcel);
                    const blob = await workbook.xlsx.writeBuffer();
                    const blobData = new Blob([blob], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blobData);
                    link.download = `${formattedDate}.xlsx`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    hideLoadingAnimation();
                } catch (error) {
                    const status = error.response.status;
                    const message = error.response.data.message;
                    const exhausted = message.includes('exhausted');
                    if (status == 500 && exhausted) {
                        alert(
                            'Silakan filter data terlebih dahulu. Aplikasi tidak memungkinkan untuk mengunduh semua data.'
                        );
                        hideLoadingAnimation();
                    } else if (status == 500) {
                        alert('Ada masalah di server. Harap tunggu sementara kami mengatasi masalah ini.');
                        hideLoadingAnimation();
                    }
                }
            }

            const pixelDownload = async () => {
                const url = window.location.href;
                const queryStringStart = url.indexOf('?');
                if (queryStringStart === -1) {
                    alert('Mohon difilter terlebih dahulu!');
                    console.error('URL tidak memiliki query string');
                    return;
                }
                const queryString = url.substring(queryStringStart + 1);
                showLoadingAnimation();
                try {
                    const response = await axios.get(`get/databases?${queryString}`);
                    const applicants = response.data.applicants;
                    let content =
                        'email,email,email,phone,phone,phone,madid,fn,ln,zip,ct,st,country,dob,doby,gen,age,uid\n';
                    applicants.forEach(applicant => {
                        let fullName = applicant.name;
                        let nameParts = fullName.split(' ');
                        let fn = nameParts[0];
                        let kotaKab = applicant.address ? (applicant.address.split("KOTA/KAB.")[1] ? applicant
                            .address
                            .split("KOTA/KAB.")[1].trim() : "") : '';
                        let dateOfBirth = applicant.date_of_birth !== null ? applicant.date_of_birth : '';
                        let tahun = dateOfBirth ? new Date(dateOfBirth).getFullYear() : '';
                        let genderCode = applicant.gender;
                        let gender = genderCode === 1 ? 'M' : 'F';
                        let tahunSekarang = new Date().getFullYear();

                        let ln = nameParts.slice(1).join(' ');

                        let phoneNumber = applicant.phone;
                        let formattedPhoneNumber = phoneNumber !== null ?
                            `+${phoneNumber.slice(0, 2)} ${phoneNumber.slice(2, 5)} ${phoneNumber.slice(5, 7)} ${phoneNumber.slice(7, 9)} ${phoneNumber.slice(9, 11)}` :
                            "";
                        content +=
                            `${applicant.email},${applicant.email},${applicant.email},${formattedPhoneNumber},${formattedPhoneNumber},${formattedPhoneNumber},,${fn},${ln},,${kotaKab},Jawa Barat,ID,${dateOfBirth},${tahun},${gender},${tahunSekarang - tahun},,\n`

                    });

                    var blob = new Blob([content], {
                        type: "text/plain"
                    });
                    var urlData = URL.createObjectURL(blob);
                    var link = document.createElement('a');
                    link.setAttribute('href', urlData);
                    link.setAttribute('download', 'facebook-pixel.txt');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    hideLoadingAnimation();
                } catch (error) {
                    const status = error.response.status;
                    const message = error.response.data.message;
                    const exhausted = message.includes('exhausted');
                    if (status == 500 && exhausted) {
                        alert(
                            'Silakan filter data terlebih dahulu. Aplikasi tidak memungkinkan untuk mengunduh semua data.'
                        );
                        hideLoadingAnimation();
                    } else if (status == 500) {
                        alert('Ada masalah di server. Harap tunggu sementara kami mengatasi masalah ini.');
                        hideLoadingAnimation();
                    }
                }
            }

            const csvDownload = async () => {
                const url = window.location.href;
                const queryStringStart = url.indexOf('?');
                if (queryStringStart === -1) {
                    alert('Mohon difilter terlebih dahulu!');
                    console.error('URL tidak memiliki query string');
                    return;
                }
                const queryString = url.substring(queryStringStart + 1);
                showLoadingAnimation();
                try {
                    const response = await axios.get(`get/databases?${queryString}`);
                    const applicants = response.data.applicants;
                    let content = 'Name,Group Membership,Phone 1 - Type,Phone 1 - Value\n';
                    let schoolSelect = document.getElementById('school');
                    let selectedSchoolOption = schoolSelect.options[schoolSelect.selectedIndex];
                    let schoolVal = selectedSchoolOption.innerText || 'all';
                    let majorVal = document.getElementById('change_major').value || 'all';
                    applicants.forEach(applicant => {
                        let schoolNameWithoutSpace = applicant.school_applicant ? applicant.school_applicant
                            .name
                            .replace(/[\s-]/g, '') : null;
                        let majorWithoutSpace = applicant.major == null ? '' : applicant.major.replace(/[\s-]/g,
                            '');
                        content +=
                            `${applicant.name} ${schoolNameWithoutSpace} ${majorWithoutSpace} ${applicant.year == null ? '' : applicant.year},* myContacts,Mobile,+${applicant.phone}\n`
                    });

                    var blob = new Blob([content], {
                        type: "text/plain"
                    });
                    var urlData = URL.createObjectURL(blob);
                    var link = document.createElement('a');
                    link.setAttribute('href', urlData);
                    link.setAttribute('download', 'contact.csv');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    hideLoadingAnimation();
                } catch (error) {
                    const status = error.response.status;
                    const message = error.response.data.message;
                    const exhausted = message.includes('exhausted');
                    if (status == 500 && exhausted) {
                        alert(
                            'Silakan filter data terlebih dahulu. Aplikasi tidak memungkinkan untuk mengunduh semua data.'
                        );
                        hideLoadingAnimation();
                    } else if (status == 500) {
                        alert('Ada masalah di server. Harap tunggu sementara kami mengatasi masalah ini.');
                        hideLoadingAnimation();
                    }
                }
            }

            const vcfDownload = async () => {
                const url = window.location.href;
                const queryStringStart = url.indexOf('?');
                if (queryStringStart === -1) {
                    alert('Mohon difilter terlebih dahulu!');
                    console.error('URL tidak memiliki query string');
                    return;
                }
                const queryString = url.substring(queryStringStart + 1);
                showLoadingAnimation();
                try {
                    const response = await axios.get(`get/databases?${queryString}`);
                    const applicants = response.data.applicants;
                    let content = '';
                    let schoolSelect = document.getElementById('school');
                    let selectedSchoolOption = schoolSelect.options[schoolSelect.selectedIndex];
                    let schoolVal = selectedSchoolOption.innerText || 'all';
                    let majorVal = document.getElementById('change_major').value || 'all';
                    applicants.forEach(applicant => {
                        let schoolNameWithoutSpace = applicant.school_applicant ? applicant.school_applicant
                            .name
                            .replace(/[\s-]/g, '') : null;
                        let majorWithoutSpace = applicant.major == null ? '' : applicant.major.replace(/[\s-]/g,
                            '');
                        content +=
                            `BEGIN:VCARD\nVERSION:3.0\nFN:${applicant.name} ${schoolNameWithoutSpace} ${majorWithoutSpace} ${applicant.year == null ? '' : applicant.year}\nN:;${applicant.name} ${schoolNameWithoutSpace} ${majorWithoutSpace} ${applicant.year == null ? '' : applicant.year};;;\nTEL;TYPE=CELL:+${applicant.phone}\nCATEGORIES:myContacts\nEND:VCARD\n`
                    });
                    var blob = new Blob([content], {
                        type: "text/vcard"
                    });
                    var urlData = URL.createObjectURL(blob);
                    var link = document.createElement('a');
                    link.setAttribute('href', urlData);
                    link.setAttribute('download', 'contact.vcf');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    hideLoadingAnimation();
                } catch (error) {
                    const status = error.response.status;
                    const message = error.response.data.message;
                    const exhausted = message.includes('exhausted');
                    if (status == 500 && exhausted) {
                        alert(
                            'Silakan filter data terlebih dahulu. Aplikasi tidak memungkinkan untuk mengunduh semua data.'
                        );
                        hideLoadingAnimation();
                    } else if (status == 500) {
                        alert('Ada masalah di server. Harap tunggu sementara kami mengatasi masalah ini.');
                        hideLoadingAnimation();
                    }
                }
            }

            const started = () => {
                const currentDate = new Date();
                const currentYear = currentDate.getFullYear();
                const currentMonth = currentDate.getMonth() + 1;
                const startYear = currentMonth >= 10 ? currentYear + 1 : currentYear;
                const url = window.location.href;
                const queryStringStart = url.indexOf('?');
                if (queryStringStart === -1) {
                    console.error('URL tidak memiliki query string');
                    return;
                }
                const queryString = url.substring(queryStringStart + 1);
                const params = queryString.split('&');
                const queryParams = {};
                params.forEach(param => {
                    const [key, value] = param.split('=');
                    queryParams[key] = value;
                });
                document.getElementById('change_pmb').value = queryParams.pmb ?? startYear;
                document.getElementById('change_applicant').value = queryParams.applicantstatus ?? 'all';
                document.getElementById('change_source_daftar').value = queryParams.sourcedaftar ?? 'all';
                document.getElementById('change_source').value = queryParams.source ?? 'all';
                document.getElementById('change_status').value = queryParams.status ?? 'all';
                document.getElementById('change_status').value = queryParams.status ?? 'all';
                document.getElementById('identity_user').value = queryParams.presenter ?? 'all';
                document.getElementById('date_start').value = queryParams.datestart ?? '';
                document.getElementById('date_end').value = queryParams.dateend ?? '';
                document.getElementById('change_follow').value = queryParams.follow ?? 'all';
                document.getElementById('school').value = queryParams.school ?? 'all';
                document.getElementById('change_major').value = queryParams.major ?? '';
                document.getElementById('year_grad').value = queryParams.year ?? '';
                document.getElementById('birthday').value = queryParams.dateofbirth ?? '';
                document.getElementById('change_phone').value = queryParams.phone ?? 'all';
                document.getElementById('change_achievement').value = queryParams.achievement ?? '';
                document.getElementById('change_relation').value = queryParams.relation ?? '';
                document.getElementById('change_jobfather').value = queryParams.jobfather ?? '';
                document.getElementById('change_jobmother').value = queryParams.jobmother ?? '';
                document.getElementById('change_plan').value = queryParams.plan ?? 'all';
                document.getElementById('change_come').value = queryParams.come ?? 'all';
                document.getElementById('change_income').value = queryParams.income ?? 'all';
                document.getElementById('change_kip').value = queryParams.kip ?? 'all';
            }

            started();
        </script>
    @endpush
</x-app-layout>
