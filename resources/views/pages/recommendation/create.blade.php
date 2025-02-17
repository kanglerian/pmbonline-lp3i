@push('styles')
    <style>
        .js-example-input-single {
            display: flex;
            width: 100% !important;
        }

        .select2-selection {
            font-size: 12px !important;
            border-radius: 0.75rem !important;
            padding-top: 18px !important;
            padding-bottom: 18px !important;
            background: #ffffff !important;
            border: 1px solid #d1d5db !important;
        }

        .select2-results__option {
            font-size: 12px !important;
        }

        .select2-selection__rendered {
            position: absolute;
            top: 5px !important;
            font-size: 12px !important;
            left: 5px !important;
        }

        .select2-selection__arrow {
            position: absolute;
            top: 6px !important;
            right: 5px !important;
        }
    </style>
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-5 pb-3">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Data Rekomendasi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">

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
                <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

        </div>


        <div class="max-w-7xl mx-auto px-5 md:p-0 space-y-5">
            <form action="{{ route('recommendation.store') }}" method="POST" id="form-add-contact"
                class="space-y-3 bg-gray-50 p-8 rounded-3xl border border-gray-200">
                @csrf
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    <div>
                        <input type="text" name="name[]"
                            class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Nama lengkap" required />
                    </div>
                    <div>
                        <input type="text" name="phone[]"
                            class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="No. HP" required />
                    </div>
                    <div>
                        <select name="school_id[]" style="width: 100%"
                            class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 js-example-input-single"
                            required>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="text" name="class[]"
                            class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Kelas" required />
                    </div>
                    <div>
                        <input type="number" name="year[]"
                            class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Tahun Lulus" required />
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2({
            tags: true,
        });
    });
    const formContact = () => {
        let bucket = '';
        for (let i = 0; i < 4; i++) {
            bucket += `<div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <div>
                                <input type="text" name="name[]" class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Nama lengkap" required />
                            </div>
                            <div>
                                <input type="text" name="phone[]" class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="No. HP" required />
                            </div>
                            <div>
                                <select name="school_id[]" style="width: 100%" class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  js-example-input-single" required>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="text" name="class[]" class="bg-white border border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Kelas" required />
                            </div>
                            <div>
                                <input type="text" name="year[]" class="bg-whnumberborder border-gray-300 text-gray-900 text-xs rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Tahun Lulus" required />
                            </div>
                        </div>`
        }
        bucket +=
            `<button
            type="submit"
            class="bg-lp3i-100 hover:bg-lp3i-200 text-white px-5 py-2 rounded-xl text-xs"
        ">
            <i class="fa-solid fa-floppy-disk mr-1"></i>
            <span>Simpan</span>
        </button>`
        $('#form-add-contact').append(bucket);
    }
    formContact();
</script>

<script>
    let phoneInput = document.querySelectorAll('input[name="phone[]"]');
    for (let i = 0; i < phoneInput.length; i++) {
        phoneInput[i].addEventListener('input', function() {
            let phone = this.value;

            if (phone.length > 14) {
                phone = phone.substring(0, 14);
            }

            if (phone.startsWith("62")) {
                if (phone.length === 3 && (phone[2] === "0" || phone[2] !== "8")) {
                    phoneInput.value = '62';
                } else {
                    phoneInput.value = phone;
                }
            } else if (phone.startsWith("0")) {
                phoneInput.value = '62' + phone.substring(1);
            } else {
                phoneInput.value = '62';
            }

            this.value = phone;
        });
    }
</script>
