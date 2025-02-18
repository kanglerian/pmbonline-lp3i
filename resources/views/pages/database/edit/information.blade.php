<div class="p-8 bg-gray-50 border border-gray-200 rounded-3xl">
    <div class="w-full">
        <section class="space-y-4">
            <header class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="w-full md:w-auto">
                    <h2 class="text-xl font-bold text-gray-900">
                        Informasi Aplikan
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Mahasiswa orangtua/wali mahasiswa Politeknik LP3I Kampus Tasikmalaya.
                    </p>
                </div>
            </header>
            <hr>
            <section class="space-y-4">
                @if ($applicant->program && $applicant->program_second && $applicant->programtype_id)
                    <header>
                        <ul class="text-sm text-gray-800 space-y-1 list-disc ml-4">
                            <li>Tipe: <span class="underline font-bold">{{ $applicant->programType->name }}</span></li>
                            <li>Prodi 1: <span
                                    class="underline font-bold">{{ $applicant->program ?? 'Belum diketahui' }}</span>
                            </li>
                            <li>Prodi 2: <span
                                    class="underline font-bold">{{ $applicant->program_second ?? 'Belum diketahui' }}</span>
                            </li>
                        </ul>
                        <button onclick="majorSetting()" type="button"
                            class="mt-2 text-xs text-white bg-yellow-500 hover:bg-yellow-600 px-5 py-1 rounded-lg">Ubah</button>
                    </header>
                    <div id="major-selected">
                        <input type="hidden" name="programtype_id" value="{{ $applicant->programtype_id }}">
                        <input type="hidden" name="program" value="{{ $applicant->program }}">
                        <input type="hidden" name="program_second" value="{{ $applicant->program_second }}">
                    </div>
                @endif
                <div class="@if ($applicant->programtype_id && $applicant->program && $applicant->program_second) hidden @endif space-y-2 bg-gray-50 border p-4 rounded-xl"
                    id="major-options">
                    <div class="grid grid-cols-1">
                        <div class="relative z-0 w-full group">
                            <x-label for="programtype_id" :value="__('Program Kuliah')" />
                            @if ($applicant->programtype_id && $applicant->program && $applicant->program_second)
                                <x-select id="programtype_id" name="programtype_id" onchange="filterProgram()" required
                                    disabled>
                                    <option>Pilih program</option>
                                    @foreach ($programtypes as $programtype)
                                        <option value="{{ $programtype->id }}" data-code="{{ $programtype->code }}">
                                            {{ $programtype->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            @else
                                <x-select id="programtype_id" name="programtype_id" onchange="filterProgram()" required>
                                    <option>Pilih program</option>
                                    @foreach ($programtypes as $programtype)
                                        <option value="{{ $programtype->id }}" data-code="{{ $programtype->code }}">
                                            {{ $programtype->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            @endif
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('programtype_id'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('programtype_id') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="relative z-0 w-full group">
                            <x-label for="program" :value="__('Program Pilihan 1')" />
                            <x-select id="program" name="program" disabled>
                                <option>Pilih Program Studi</option>
                            </x-select>
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('program'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('program') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                        <div class="relative z-0 w-full group">
                            <x-label for="program_second" :value="__('Program Pilihan 2')" />
                            <x-select id="program_second" name="program_second" disabled>
                                <option>Pilih Program Studi</option>
                            </x-select>
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('program_second'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('program_second') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <hr>
            <section class="space-y-4">
                <x-input class="hidden" name="isread" value="{{ $applicant->isread }}" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @if (Auth::check() && Auth::user()->role == 'P')
                        <input type="hidden" value="{{ $applicant->identity_user }}" name="identity_user">
                    @else
                        <div class="relative z-0 w-full group">
                            <x-label for="identity_user" :value="__('Presenter')" />
                            <x-select id="identity_user" name="identity_user" required>
                                @if ($applicant->identity_user == null)
                                    <option value="Pilih presenter">Pilih presenter</option>
                                    @foreach ($presenters as $presenter)
                                        <option value="{{ $presenter->identity }}">
                                            {{ $presenter->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="{{ $applicant->identity_user }}">
                                        @if ($applicant->identity_user)
                                            @if ($applicant->presenter)
                                                {{ $applicant->presenter->name }}
                                            @else
                                                <span class="text-red-500">Presenter tidak ditemukan</span>
                                            @endif
                                        @else
                                            Tidak diketahui
                                        @endif
                                    </option>
                                    @foreach ($presenters as $presenter)
                                        <option value="{{ $presenter->identity }}">
                                            {{ $presenter->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </x-select>
                            <p class="mt-2 text-xs text-gray-500">
                                @if ($errors->has('identity_user'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('identity_user') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </p>
                        </div>
                    @endif
                    <div class="relative z-0 w-full group">
                        <x-label for="pmb" :value="__('Tahun Akademik')" />
                        <x-input id="pmb" type="number" name="pmb" maxlength="4"
                            value="{{ $applicant->pmb }}" placeholder="Tahun Akademik" required />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('pmb'))
                                <span class="text-red-500 text-xs">{{ $errors->first('pmb') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="source_id" :value="__('Sumber Database')" />
                        <x-select id="source_id" name="source_id" required>
                            @if ($applicant->source_id)
                                <option value="{{ $applicant->source_id }}" selected>
                                    {{ $applicant->sourceSetting->name }}
                                </option>
                            @else
                                <option value="0" selected>Pilih Sumber Database</option>
                            @endif
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('source_id'))
                                <span class="text-red-500 text-xs">{{ $errors->first('source_id') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="source_daftar_id" :value="__('Sumber Informasi')" />
                        <x-select id="source_daftar_id" name="source_daftar_id" required>
                            @if ($applicant->source_daftar_id)
                                <option value="{{ $applicant->source_daftar_id }}" selected>
                                    {{ $applicant->sourceDaftarSetting->name }}
                                </option>
                            @else
                                <option value="0" selected>Pilih Sumber informasi</option>
                            @endif
                            @foreach ($sources as $source)
                                <option value="{{ $source->id }}">
                                    {{ $source->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('source_daftar_id'))
                                <span class="text-red-500 text-xs">{{ $errors->first('source_daftar_id') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="followup_id" :value="__('Keterangan Follow Up')" />
                        <x-select id="followup_id" name="followup_id">
                            @if ($applicant->followup_id)
                                <option value="{{ $applicant->followup_id }}">{{ $applicant->FollowUp->name }}
                                </option>
                            @endif
                            @foreach ($follows as $follow)
                                <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('followup_id'))
                                <span class="text-red-500 text-xs">{{ $errors->first('followup_id') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="status_id" :value="__('Status')" />
                        <x-select id="status_id" name="status_id" required>
                            <option value="{{ $applicant->status_id }}" selected>
                                {{ $applicant->applicantStatus->name }}
                            </option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('status_id'))
                                <span class="text-red-500 text-xs">{{ $errors->first('status_id') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" type="email" name="email" maxlength="50"
                            value="{{ $applicant->email }}" placeholder="Email" />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('email'))
                                <span class="text-red-500 text-xs">{{ $errors->first('email') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="phone" :value="__('No. Whatsapp')" />
                        <x-input id="phone" type="number" name="phone" maxlength="14"
                            value="{{ $applicant->phone }}" placeholder="Tulis no. Whatsapp disini..." />
                        <p class="mt-2 text-xs text-gray-500">
                            @if ($errors->has('phone'))
                                <span class="text-red-500 text-xs">{{ $errors->first('phone') }}</span>
                            @else
                                <span class="text-red-500 text-xs">*Wajib diisi.</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="known" :value="__('Mengetahui LP3I?')" />
                        <x-select id="known" name="known">
                            @if ($applicant->known != null)
                                @switch($applicant->known)
                                    @case(1)
                                        <option value="1">Ya</option>
                                    @break

                                    @case(0)
                                        <option value="0">Tidak</option>
                                    @break
                                @endswitch
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('known') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="come" :value="__('Datang Ke Kampus?')" />
                        <x-select id="come" name="come">
                            @if ($applicant->come)
                                @switch($applicant->come)
                                    @case(1)
                                        <option value="1">Ya</option>
                                    @break

                                    @case(0)
                                        <option value="0">Tidak</option>
                                    @break
                                @endswitch
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('come') }}</span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="relative z-0 w-full group">
                        <x-label for="planning" :value="__('Rencana Setelah Lulus')" />
                        <x-select id="planning" name="planning">
                            @if ($applicant->planning != null)
                                <option value="{{ $applicant->planning }}">{{ $applicant->planning }}</option>
                            @else
                                <option value="null">Pilih</option>
                            @endif
                            <option value="Kuliah">Kuliah</option>
                            <option value="Kerja">Kerja</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="Nikah">Nikah</option>
                        </x-select>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('planning') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="other_campus" :value="__('Pilihan Kampus Selain LP3I')" />
                        <x-input id="other_campus" type="text" name="other_campus"
                            value="{{ $applicant->other_campus }}" placeholder="Kampus Pilihan Lain" />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('other_campus') }}</span>
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <div class="relative z-0 w-full group">
                        <x-label for="place_of_working" :value="__('Tempat Bekerja')" />
                        <x-input id="place_of_working" type="text" name="place_of_working"
                            value="{{ $applicant->place_of_working }}" placeholder="Tempat bekerja" />
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('place_of_working') }}</span>
                        </p>
                    </div>
                    <div class="relative z-0 w-full group">
                        <x-label for="note" :value="__('Catatan')" />
                        <x-textarea id="note" name="note" value="{{ $applicant->note }}"
                            placeholder="Catatan">
                            {{ $applicant->note }}
                        </x-textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            <span class="text-red-500 text-xs">{{ $errors->first('note') }}</span>
                        </p>
                    </div>
                </div>
            </section>
        </section>
    </div>
</div>

@push('scripts')
    <script>
        const majorSetting = () => {
            let majorOptionsElement = document.getElementById('major-options');
            let majorSelectedElement = document.getElementById('major-selected');
            majorOptionsElement.classList.toggle('hidden');
            majorSelectedElement.classList.toggle('hidden');

            if (!majorOptionsElement.classList.contains('hidden')) {
                let programType = majorOptionsElement.querySelector('[name="programtype_id"]');
                let program = majorOptionsElement.querySelector('[name="program"]');
                let programSecond = majorOptionsElement.querySelector('[name="program_second"]');
                programType.disabled = false;
                program.disabled = true;
                programSecond.disabled = true;
            }
        }
    </script>
    <script>
        const filterProgram = async () => {
            let programTypeElement = document.getElementById('programtype_id');
            let selectedOption = programTypeElement.options[programTypeElement.selectedIndex];
            let programType = selectedOption.getAttribute('data-code');
            await axios.get('https://endpoint.politekniklp3i-tasikmalaya.ac.id/programs', {
                    headers: {
                        'lp3i-api-key': 'b35e0a901904d293'
                    }
                })
                .then((res) => {
                    let programs = res.data;
                    var results;
                    let bucket = '';
                    switch (programType) {
                        case "R":
                            results = programs.filter(program => program.type === "R");
                            break;
                        case "N":
                            results = programs.filter(program => program.type === "N");
                            break;
                        case "RPL":
                            results = programs.filter(program => program.type === "RPL");
                            break;
                        default:
                            results = [];
                            break;
                            document.getElementById('program').innerHTML =
                                `<option value="0">Pilih Program Studi</option>`;
                            document.getElementById('program').disabled = true;
                            document.getElementById('program_second').innerHTML =
                                `<option value="0">Pilih Program Studi</option>`;
                            document.getElementById('program_second').disabled = true;
                    }

                    if (programType !== 'NONE') {
                        if (results.length > 0) {
                            results.map((result) => {
                                let option = '';
                                result.interests.map((inter, index) => {
                                    option +=
                                        `<option value="${result.level} ${result.title}">${inter.name}</option>`;
                                })
                                bucket += `
                            <optgroup label="${result.level} ${result.title} (${result.campus})">
                                ${option}
                            </optgroup>`;
                            });
                            document.getElementById('program').innerHTML = bucket;
                            document.getElementById('program').disabled = false;
                            document.getElementById('program_second').innerHTML = bucket;
                            document.getElementById('program_second').disabled = false;
                        } else {
                            bucket = `<option value="0">Program Studi tidak tersedia</option>`;
                            document.getElementById('program').innerHTML = bucket;
                            document.getElementById('program').disabled = true;
                            document.getElementById('program_second').innerHTML = bucket;
                            document.getElementById('program_second').disabled = true;
                        }
                    }
                })
                .catch((err) => {
                    console.log(err.message);
                });

        }
    </script>
@endpush
