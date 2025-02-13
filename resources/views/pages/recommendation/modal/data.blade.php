{{-- Modal Status --}}
<div class="fixed inset-0 flex items-center justify-center z-50 hidden" id="statusModal">
    <div class="fixed inset-0 bg-black opacity-50"></div>
    <div class="fixed inset-0 flex items-center justify-center">
        <div class="w-full md:w-1/2 relative bg-white rounded-3xl shadow mx-5">
            <div class="flex items-center justify-between px-6 pt-5 pb-6 md:px-8 md:py-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900" id="title_data">
                    Tambah Status
                </h3>
                <button type="button" onclick="changeStatusModal(this)" data-modal-target="statusModal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('recommendation.store') }}" class="px-6 pt-5 pb-6 md:px-8 md:py-5 md:pb-6"
                method="POST" id="formStatusModal">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                        <input type="text" name="name[]" id="name_data"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Nama lengkap" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">No. Handphone</label>
                        <input type="number" name="phone[]" id="phone_data"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="No. Handphone" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="school_id" class="block mb-2 text-sm font-medium text-gray-900">Sekolah</label>
                        <select id="school_id" name="school_id[]" style="width: 100%"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 js-example-input-single"
                            required>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="class" class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                        <input type="text" name="class[]" id="class_data"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Kelas" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="year" class="block mb-2 text-sm font-medium text-gray-900">Tahun Lulus</label>
                        <input type="text" name="year[]" id="year_data"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Tahun Lulus" required>
                    </div>
                </div>
                <button type="submit" id="formStatusButton"
                    class="text-white inline-flex items-center bg-lp3i-100 hover:bg-lp3i-200 font-medium rounded-xl text-sm px-5 py-2.5 text-center">
                    <i class="fa-solid fa-floppy-disk mr-1"></i>
                    <span>Simpan</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Script Status --}}
<script>
    $(document).ready(function() {
        $('.js-example-input-single').select2({
            tags: true,
        });
    });
    const changeStatusModal = (button) => {
        const modalTarget = button.dataset.modalTarget;
        let status = document.getElementById(modalTarget);
        let url = "{{ route('recommendation.store') }}";
        document.getElementById('title_data').innerText = `Tambah Data Rekomendasi`;
        document.getElementById('name_data').value = '';
        document.getElementById('phone_data').value = '62';
        document.getElementById('class_data').value = '';
        document.getElementById('year_data').value = '';
        document.getElementById('formStatusButton').innerHTML =
            `<i class="fa-solid fa-floppy-disk mr-1"></i> Simpan`;
        document.getElementById('formStatusModal').setAttribute('action', url);

        const elementsToRemove = document.querySelectorAll('[name="_method"]');
        if (elementsToRemove.length > 0) {
            elementsToRemove.forEach((element) => {
                element.remove();
            });
        } else {
            console.log("No elements found with the specified name.");
        }
        status.classList.toggle('hidden');
    }

    const editStatusModal = (button) => {
        const formModal = document.getElementById('formStatusModal');
        const modalTarget = button.dataset.modalTarget;
        const id = button.dataset.id;
        const name = button.dataset.name;
        const phone = button.dataset.phone;
        const school = button.dataset.school;
        const classes = button.dataset.classes;
        const year = button.dataset.year;
        const accept = button.dataset.accept;
        let url = "{{ route('recommendation.update', ':id') }}".replace(':id', id);
        let status = document.getElementById(modalTarget);
        document.getElementById('title_data').innerText = `Edit Data ${name}`;
        document.getElementById('name_data').value = name;
        document.getElementById('phone_data').value = phone;
        document.getElementById('school_id').value = school;
        document.getElementById('class_data').value = classes;
        document.getElementById('year_data').value = year;
        document.getElementById('formStatusButton').innerHTML =
            `<i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Perubahan`;
        document.getElementById('formStatusModal').setAttribute('action', url);
        let csrfToken = document.createElement('input');
        csrfToken.setAttribute('type', 'hidden');
        csrfToken.setAttribute('name', '_token');
        csrfToken.setAttribute('value', '{{ csrf_token() }}');
        formModal.appendChild(csrfToken);

        let methodInput = document.createElement('input');
        methodInput.setAttribute('type', 'hidden');
        methodInput.setAttribute('name', '_method');
        methodInput.setAttribute('value', 'PATCH');
        formModal.appendChild(methodInput);

        status.classList.toggle('hidden');
    }

    const deleteStatus = (item) => {
        let id = item.dataset.id;
        if (confirm('Apakah kamu yakin akan menghapus data?')) {
            $.ajax({
                url: `/applicantstatus/${id}`,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('File upload dipakai, tidak bisa dihapus.');
                }
            })
        }
    }
</script>

<script>
    let phoneInput = document.getElementById('phone_data');
    phoneInput.addEventListener('input', function() {
        let phone = phoneInput.value;

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

        phoneInput.value = phone;
    });
</script>
