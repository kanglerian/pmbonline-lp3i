@if ($user->is_applicant && $status_applicant)
    <!-- Main modal -->
    <div id="modal-edit-aplikan" tabindex="-1" aria-hidden="true"
        class="hidden flex justify-center items-center fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="fixed top-0 left-0 right-0 bottom-0 bg-black opacity-50"></div>
        <div class="relative w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow">
                <button type="button" onclick="modalEditAplikan()"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                    data-modal-hide="modal-aplikan">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <div class="space-y-1 mb-3">
                        <h3 class="text-lg font-bold text-gray-900">Ubah Status Aplikan</h3>
                        <p class="text-sm text-gray-600">Berikut ini adalah menu untuk mengubah status aplikan.</p>
                    </div>
                    <hr class="mb-4">
                    <form class="space-y-3" action="{{ route('statusdatabaseaplikan.update', $user->id) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-3 md:gap-3">
                            <div>
                                <label for="is_applicant_pmb"
                                    class="block mb-2 text-sm font-medium text-gray-900">PMB</label>
                                <input type="year" name="is_applicant_pmb" id="is_applicant_pmb"
                                    value="{{ $status_applicant->pmb }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Tanggal Daftar" required>
                                @if ($errors->has('is_applicant_pmb'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('is_applicant_pmb') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="is_applicant_date"
                                    class="block mb-2 text-sm font-medium text-gray-900">Tanggal Aplikan</label>
                                <input type="date" name="is_applicant_date" id="is_applicant_date"
                                    value="{{ $status_applicant->date }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Tanggal Daftar" required>
                                @if ($errors->has('is_applicant_date'))
                                    <span class="text-red-500 text-xs">{{ $errors->first('is_applicant_date') }}</span>
                                @else
                                    <span class="text-red-500 text-xs">*Wajib diisi.</span>
                                @endif
                            </div>
                            <div>
                                <label for="is_applicant_session"
                                    class="block mb-2 text-sm font-medium text-gray-900">Gelombang</label>
                                <select id="is_applicant_session" name="is_applicant_session"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                                    @if ($status_applicant->session)
                                        <option value="{{ $status_applicant->session }}">
                                            {{ $status_applicant->session }}
                                        </option>
                                    @endif
                                    <hr>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                @if ($errors->has('is_applicant_session'))
                                    <span
                                        class="text-red-500 text-xs">{{ $errors->first('is_applicant_session') }}</span>
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
