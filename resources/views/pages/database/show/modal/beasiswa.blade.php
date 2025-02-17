@if ($user->is_applicant && $status_applicant)
    <!-- Main modal -->
    <div id="modal-edit-beasiswa" tabindex="-1" aria-hidden="true"
        class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
        <div class="relative w-full max-w-3xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow">
                <button type="button" onclick="modalEditBeasiswa()"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="modal-aplikan">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <div class="space-y-1 mb-3">
                        <h3 class="text-lg font-bold text-gray-900">Ubah Status Beasiswa</h3>
                        <p class="text-sm text-gray-600">Berikut ini adalah menu untuk mengubah status beasiswa.</p>
                    </div>
                    <hr class="mb-4">
                    <form class="space-y-3" action="{{ route('statusdatabasebeasiswa.update', $user->id) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-3 md:gap-3">
                            <div>
                                <label for="scholarship_date"
                                    class="block mb-2 text-sm font-medium text-gray-900">Tanggal Beasiswa</label>
                                <input type="date" name="scholarship_date" id="scholarship_date"
                                    value="{{ $user->scholarship_date ? \Carbon\Carbon::parse($user->scholarship_date)->format('Y-m-d') : '' }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Tanggal Daftar" required>
                                @if ($errors->has('scholarship_date'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('scholarship_date') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="achievement"
                                    class="block mb-2 text-sm font-medium text-gray-900">Prestasi</label>
                                <input type="text" name="achievement" id="achievement"
                                    value="{{ $user->achievement }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Prestasi" required>
                                @if ($errors->has('scholarship_date'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('achievement') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="scholarship_type"
                                    class="block mb-2 text-sm font-medium text-gray-900">Beasiswa</label>
                                <select id="scholarship_type" name="scholarship_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    <option value="Beasiswa Akademik" {{ $user->scholarship_type == 'Beasiswa Akademik' ? 'selected' : '' }}>Beasiswa Akademik</option>
                                    <option value="Beasiswa Non Akademik" {{ $user->scholarship_type == 'Beasiswa Non Akademik' ? 'selected' : '' }}>Beasiswa Non Akademik</option>
                                    <option value="Beasiswa Ranking 1 - 10" {{ $user->scholarship_type == 'Beasiswa Ranking 1 - 10' ? 'selected' : '' }}>Beasiswa Ranking 1 - 10</option>
                                    <option value="Beasiswa Hafidz Qur'an 5 - 30 Juz" {{ $user->scholarship_type == "Beasiswa Hafidz Qur'an 5 - 30 Juz" ? 'selected' : '' }}>Beasiswa Hafidz Qur'an 5 - 30 Juz</option>
                                    <option value="Beasiswa Aktivis Sekolah" {{ $user->scholarship_type == 'Beasiswa Aktivis Sekolah' ? 'selected' : '' }}>Beasiswa Aktivis Sekolah</option>
                                    <option value="Beasiswa Atlet" {{ $user->scholarship_type == 'Beasiswa Atlet' ? 'selected' : '' }}>Beasiswa Atlet</option>
                                </select>
                                @if ($errors->has('scholarship_type'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('scholarship_type') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2 text-center">Simpan
                            Perubahan</button>
                        <p class="text-xs text-gray-600 text-center">Periksa terlebih dahulu apakah sudah benar?</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
