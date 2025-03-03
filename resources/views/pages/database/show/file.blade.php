<x-app-layout>
    <x-slot name="header">
        @include('pages.database.components.navigation')
    </x-slot>

    <main>
        @if (session('error'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('error') }}
                </div>
            </div>
        @endif
        @if (session('message'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-emerald-400 text-white rounded-lg" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <div class="ml-3 text-sm font-reguler">
                    {{ session('message') }}
                </div>
            </div>
        @endif
        @if ($errors->first('berkas'))
            <div id="alert" class="flex items-center p-4 mb-4 bg-red-500 text-red-50 rounded-xl" role="alert">
                <i class="fa-solid fa-circle-xmark"></i>
                <div class="ml-3 text-sm font-medium">
                    {{ $errors->first('berkas') }}
                </div>
            </div>
        @endif
        <section id="content" class="flex flex-col md:flex-row gap-5">
            <div class="w-full mx-auto space-y-5">
                <div class="p-8 sm:p-8 bg-gray-50 border border-gray-200 rounded-3xl">
                    <header>
                        <h2 class="text-lg font-bold text-gray-900">
                            Berkas {{ $user->name }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Tabel di bawah ini berisi berkas yang diunggah oleh pemilik akun.
                        </p>
                        <hr class="my-3">
                        <div class="relative h-[535px] overflow-y-auto overflow-x-auto rounded-3xl">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr class="flex justify-between items-center">
                                        <th scope="col" class="px-6 py-3">
                                            Nama Berkas
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Aksi
                                        </th>
                                </thead>
                                <tbody>
                                    @foreach ($userupload as $suc)
                                        <tr class="bg-gray-50 border-b flex justify-between items-center">
                                            <td class="px-6 py-4">{{ $suc->fileupload->name }}</td>
                                            <td class="px-6 py-4">
                                                <button
                                                    class="inline-block bg-green-500 hover:bg-green-600 px-3 py-1 rounded-md text-xs text-white"><i
                                                        class="fa-solid fa-circle-check"></i></button>
                                                <a href="https://uploadhub.politekniklp3i-tasikmalaya.ac.id/download?identity={{ $suc->identity_user }}&filename={{ $suc->identity_user }}-{{ $suc->fileupload->namefile }}.{{ $suc->typefile }}"
                                                    class="bg-sky-500 px-3 py-1 rounded-md text-xs text-white""><i
                                                        class="fa-solid fa-download"></i></a>
                                                <button
                                                    onclick="event.preventDefault(); deleteBerkas('{{ $suc->id }}','{{ $suc->fileupload->namefile }}', '{{ $suc->typefile }}', '{{ $suc->identity_user }}')"
                                                    class="inline-block bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach ($fileupload as $upload)
                                        <tr class="bg-gray-50 border-b flex justify-between items-center">
                                            <td class="px-6 py-4">{{ $upload->name }}</td>
                                            <td class="loading-form px-6 py-4" colspan="2"
                                                id="loading-form-{{ $upload->namefile }}">
                                                <form action="javascript:void(0)" enctype="multipart/form-data"
                                                    class="inline-block" id="form-{{ $upload->namefile }}"
                                                    method="POST">
                                                    @csrf
                                                    <div>
                                                        <input type="hidden" name="fileupload_id"
                                                            value="{{ $upload->id }}">
                                                        <input type="hidden" name="namefile"
                                                            value="{{ $upload->namefile }}">
                                                        <input type="file" name="berkas"
                                                            onchange="notifButton('{{ $upload->namefile }}')"
                                                            id="berkas-{{ $upload->namefile }}" class="text-sm"
                                                            accept="{{ $upload->accept }}">
                                                        <button id="button-{{ $upload->namefile }}"
                                                            onclick="uploadBerkas('{{ $upload->id }}','{{ $upload->namefile }}','{{ $user->identity }}')"
                                                            class="hidden inline-block bg-sky-500 hover:bg-sky-600 px-3 py-1 rounded-md text-xs text-white">
                                                            <i class="fa-solid fa-upload"></i>
                                                        </button>
                                                    </div>
                                                    <small>Maks: 1MB</small>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </header>
                </div>
            </div>
        </section>
    </main>

    <section id="forbidden" class="hidden flex flex-col items-center gap-5">
        <div class="w-full flex flex-col items-center justify-center">
            <lottie-player src="{{ asset('animations/underconstruct.json') }}" background="Transparent" speed="1"
                style="width: 250px; height: 250px" direction="1" mode="normal" loop autoplay></lottie-player>
        </div>
        <div class="text-center space-y-1 px-5">
            <h2 class="font-bold text-xl">Oops! Sesuatu Tidak Beres... 🚧</h2>
            <p class="text-gray-700">Maaf, server kami sedang mengalami masalah dan tidak dapat memproses permintaan
                Anda saat ini. Kami sedang bekerja keras untuk memperbaikinya. Silakan coba lagi dalam beberapa menit.
                Terima kasih atas kesabaran Anda!</p>
        </div>
    </section>

    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script>
        const notifButton = (namefile) => {
            console.log(namefile);

            let inputElement = document.getElementById(`berkas-${namefile}`);
            let buttonElement = document.getElementById(`button-${namefile}`);

            if (inputElement.files.length > 0) {
                buttonElement.classList.remove('hidden');
            } else {
                buttonElement.classList.add('hidden');
            }
        }
        const uploadBerkas = (id, namefile, identity) => {
            let inputElement = document.getElementById(`berkas-${namefile}`);
            let buttonElement = document.getElementById(`button-${namefile}`);

            inputElement.addEventListener('change', function() {
                if (inputElement.files.length > 0) {
                    buttonElement.classList.remove('hidden');
                } else {
                    newButton.classList.add('hidden');
                }
            });

            let uploadForm = document.getElementById(`form-${namefile}`);
            let loadingForm = document.getElementById(`loading-form-${namefile}`);
            let loadingElement = document.createElement('div');
            loadingElement.innerHTML = `
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        `;

            uploadForm.style.display = 'none';
            loadingForm.appendChild(loadingElement);

            let berkas = inputElement.files[0];

            if (berkas) {
                const reader = new FileReader();
                reader.onload = async (event) => {
                    let data = {
                        identity: identity,
                        image: event.target.result.split(';base64,').pop(),
                        namefile: namefile,
                        typefile: berkas.name.split('.').pop(),
                    }

                    let status = {
                        fileupload_id: id,
                        identity: identity,
                        typefile: berkas.name.split('.').pop(),
                    }

                    await axios.post(`https://uploadhub.politekniklp3i-tasikmalaya.ac.id/upload`, data, {
                            headers: {
                                'lp3i-api-key': 'cdbdb5ea29b98565'
                            }
                        })
                        .then((res) => {
                            alert('Berhasil diupload!');
                            loadingForm.removeChild(loadingElement);
                            uploadForm.style.display = 'block';
                            $.ajax({
                                url: `/userupload`,
                                type: 'POST',
                                data: {
                                    data: status,
                                    '_token': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.status == 'success') {
                                        location.reload();
                                    } else {
                                        console.log('Ada kesalahan dalam permintaan.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    location.reload();
                                    console.log(error);
                                    
                                }
                            })
                            console.log(res.data);
                        })
                        .catch((err) => {
                            let bucket =
                                `<i class="fa-solid fa-circle-exclamation"></i>
                        <div class="ml-3 text-sm font-medium">
                            Maaf, server sedang tidak berfungsi saat ini. Harap hubungi administrator untuk informasi lebih lanjut.
                        </div>`
                            let info = document.getElementById('info');
                            info.classList.remove('hidden');
                            info.innerHTML = bucket;
                        });
                };

                reader.readAsDataURL(berkas);
            }
        }

        const deleteBerkas = async (id, namefile, typefile, identity) => {
            if (confirm(`Apakah kamu yakin akan menghapus data?`)) {
                var data = {
                    identity: identity,
                    namefile: namefile,
                    typefile: typefile,
                }
                await axios.delete(`https://uploadhub.politekniklp3i-tasikmalaya.ac.id/delete`, {
                        headers: {
                            'lp3i-api-key': 'cdbdb5ea29b98565'
                        },
                        params: data
                    })
                    .then((res) => {
                        alert('Berhasil dihapus!');
                        $.ajax({
                            url: `/userupload/${id}`,
                            type: 'POST',
                            data: {
                                '_method': 'DELETE',
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status == 'success') {
                                    location.reload();
                                } else {
                                    console.log('Ada kesalahan dalam permintaan.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }
                        })
                    })
                    .catch((err) => {
                        let bucket =
                            `<i class="fa-solid fa-circle-exclamation"></i>
                        <div class="ml-3 text-sm font-medium">
                            Maaf, server sedang tidak berfungsi saat ini. Harap hubungi administrator untuk informasi lebih lanjut.
                        </div>`
                        let info = document.getElementById('info');
                        info.classList.remove('hidden');
                        info.innerHTML = bucket;
                    });

            }
        }
    </script>
</x-app-layout>

@push('scripts')
    <script>
        const checkServer = async () => {
            await axios.get(`https://uploadhub.politekniklp3i-tasikmalaya.ac.id`)
                .then((response) => {
                    if (response.status == 200) {
                        $('#content').show();
                        $('#forbidden').hide();
                    }
                })
                .catch((error) => {
                    $('#content').hide();
                    $('#forbidden').show();
                });
        }
        checkServer();
    </script>
@endpush
