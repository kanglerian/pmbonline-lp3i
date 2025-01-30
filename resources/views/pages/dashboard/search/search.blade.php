@if (Auth::user()->role !== 'S' && Auth::user()->role !== 'K')
    <div class="grid grid-cols-1 gap-4" id="quicksearch_container">
        <div class="bg-gray-50 relative overflow-x-auto border border-gray-200 rounded-3xl">
            <section class="grid grid-cols-1 md:grid-cols-2 items-center gap-3 p-6">
                <header class="space-y-2">
                    <h1 class="flex items-center gap-2 font-bold text-gray-800">
                        <span>Quick Search: </span>
                        <span id="count-quicksearch"
                            class="inline-block bg-red-500 px-2 py-1 rounded-lg text-xs text-white">
                            0
                        </span>
                    </h1>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
                        </div>
                        <input type="search" id="quick-search" onchange="quickSearch()"
                            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                            placeholder="Cari calon mahasiswa disini...">
                    </div>
                    <p id="quick-search" class="mt-2 text-xs text-gray-500">Fitur cari cepat data calon
                        mahasiswa.
                        Untuk selengkapnya <a href="{{ route('database.index') }}"
                            class="font-medium text-blue-600 hover:underline">klik disini.</a>
                    </p>
                </header>
            </section>
            <hr class="mb-5">
            <section class="px-5 pb-5">
                <table class="w-full bg-gray-50 text-sm text-left rtl:text-right text-gray-500" id="quickSearchTable">
                    <thead class="text-xs text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                                PMB
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Beasiswa
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Lengkap
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Presenter
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Phone
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Sumber Database
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Asal Sekolah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tahun Lulus
                            </th>
                        </tr>
                    </thead>
                    <tbody id="result-quicksearch">
                        <tr class="border-b border-t">
                            <td colspan="10" class="px-6 py-4 text-center">
                                Silahkan untuk isi kolom pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <hr class="mb-5">
            <div class="px-5 pb-5">
                <p class="text-gray-500 text-xs">Catatan: Silahkan untuk klik nama untuk melihat informasi lebih
                    lanjut.
                </p>
            </div>
        </div>
    </div>
@endif

@push('scripts')
    <script>
        let dataTableInitialized = false;
        let dataTableInstance;
        const quickSearch = async () => {
            try {
                let nameSearch = document.getElementById('quick-search').value;
                if (nameSearch != '') {
                    let result = document.getElementById('result-quicksearch');
                    let identity = document.getElementById('identity_val').value;
                    const response = await axios.get(`quicksearch/${nameSearch}`);
                    const data = response.data.applicants;
                    document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                        'id-ID');

                    const manualColumns = [{
                        data: 'id',
                        render: (data, type, row, meta) => {
                            return meta.row + 1;
                        }
                    }, {
                        data: 'pmb',
                        render: (data, type, row, meta) => {
                            return data;
                        }
                    }, {
                        data: 'scholarship_date',
                        render: (data, type, row, meta) => {
                            return data || '<i class="fa-solid fa-xmark text-red-500"></i>';
                        }
                    }, {
                        data: {
                            name: 'name',
                            identity: 'identity',
                            identity_user: 'identity_user'
                        },
                        render: (data, type, row, meta) => {
                            let editUrl = "{{ route('database.show', ':identity') }}".replace(
                                ':identity',
                                data.identity);
                            if (data.identity_user == identity || identity == '6281313608558') {
                                return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                            } else {
                                return `<span>${data.name}</span>`;
                            }
                        }
                    }, {
                        data: 'presenter',
                        render: (data) => {
                            return data && typeof data === 'object' && data.name ? data.name : 'Tidak diketahui';
                        }
                    }, {
                        data: 'email',
                        render: (data) => {
                            return data ? data : 'Tidak diketahui';
                        }
                    }, {
                        data: 'phone',
                        render: (data) => {
                            return data ? data : 'Tidak diketahui';
                        }
                    }, {
                        data: 'source_setting',
                        render: (data, type, row) => {
                            return data.name;
                        }
                    }, {
                        data: 'school_applicant',
                        render: (data) => {
                            return data == null ? 'Tidak diketahui' : data.name;
                        }
                    }, {
                        data: 'year',
                        render: (data, row) => {
                            return data != null ? data : 'Tidak diketahui';
                        }
                    }];

                    const dataTableConfig = {
                        columns: manualColumns,
                        data: data,
                        rowCallback: function(row, data, index) {
                            if (index % 2 != 0) {
                                $(row).css('background-color', '#f9fafb');
                            }
                        },
                    }

                    if (dataTableInitialized) {
                        dataTableInstance.destroy();
                    }

                    dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

                    dataTableInitialized = true;
                }
            } catch (error) {
                console.log(error);
            }
        }
    </script>
    <script>
        const quickSearchStatus = async (status) => {
            try {
                let pmbVal = document.getElementById('change_pmb').value || 'all';
                let identity = document.getElementById('identity_val').value;
                let result = document.getElementById('result-quicksearch');
                const response = await axios.get(`quicksearchstatus?statusApplicant=${status}&pmbVal=${pmbVal}`);
                const data = response.data.applicants;
                document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                    'id-ID');

                const manualColumns = [{
                    data: 'id',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                }, {
                    data: 'pmb',
                    render: (data, type, row, meta) => {
                        return data;
                    }
                }, {
                    data: 'scholarship_date',
                    render: (data, type, row, meta) => {
                        return data || '<i class="fa-solid fa-xmark text-red-500"></i>';
                    }
                }, {
                    data: {
                        name: 'name',
                        identity: 'identity',
                        identity_user: 'identity_user'
                    },
                    render: (data, type, row, meta) => {
                        let editUrl = "{{ route('database.show', ':identity') }}".replace(':identity',
                            data.identity);
                        if (data.identity_user == identity || identity == '6281313608558') {
                            return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                        } else {
                            return `<span>${data.name}</span>`;
                        }
                    }
                }, {
                    data: 'presenter',
                    render: (data) => {
                        return data && typeof data === 'object' && data.name ? data.name : 'Tidak diketahui';
                    }
                }, {
                    data: 'email',
                    render: (data) => {
                        return data ? data : 'Tidak diketahui';
                    }
                }, {
                    data: 'phone',
                    render: (data) => {
                        return data ? data : 'Tidak diketahui';
                    }
                }, {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                }, {
                    data: 'school_applicant',
                    render: (data) => {
                        return data == null ? 'Tidak diketahui' : data.name;
                    }
                }, {
                    data: 'year',
                    render: (data, row) => {
                        return data != null ? data : 'Tidak diketahui';
                    }
                }];

                const dataTableConfig = {
                    columns: manualColumns,
                    data: data,
                }

                if (dataTableInitialized) {
                    dataTableInstance.destroy();
                }

                dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

                dataTableInitialized = true;
            } catch (error) {
                console.log(error);
            }
        }
    </script>
    <script>
        const quickSearchSource = async (source) => {
            try {
                let pmbVal = document.getElementById('change_pmb').value || 'all';
                let result = document.getElementById('result-quicksearch');
                const response = await axios.get(`quicksearchsource?source=${source}&pmbVal=${pmbVal}`);
                const data = response.data.applicants;

                document.getElementById('count-quicksearch').innerText = parseInt(data.length).toLocaleString(
                    'id-ID');
                const manualColumns = [{
                    data: 'id',
                    render: (data, type, row, meta) => {
                        return meta.row + 1;
                    }
                }, {
                    data: 'pmb',
                    render: (data, type, row, meta) => {
                        return data;
                    }
                }, {
                    data: {
                        name: 'name',
                        identity: 'identity',
                        identity_user: 'identity_user'
                    },
                    render: (data, type, row, meta) => {
                        let editUrl = "{{ route('database.show', ':identity') }}".replace(
                            ':identity',
                            data.identity);
                        if (data.identity_user == identity || identity == '6281313608558') {
                            return `<a href="${editUrl}" class="font-bold underline">${data.name}</a>`
                        } else {
                            return `<span>${data.name}</span>`;
                        }

                    }
                }, {
                    data: 'presenter',
                    render: (data) => {
                        return data && typeof data === 'object' && data.name ? data.name : 'Tidak diketahui';
                    }
                }, {
                    data: 'source_setting',
                    render: (data, type, row) => {
                        return data.name;
                    }
                }, {
                    data: 'school_applicant',
                    render: (data) => {
                        return data == null ? 'Tidak diketahui' : data.name;
                    }
                }, {
                    data: 'year',
                    render: (data, row) => {
                        return data != null ? data : 'Tidak diketahui';
                    }
                }];

                const dataTableConfig = {
                    columns: manualColumns,
                    data: data,
                }

                if (dataTableInitialized) {
                    dataTableInstance.destroy();
                }

                dataTableInstance = new DataTable('#quickSearchTable', dataTableConfig);

                dataTableInitialized = true;
            } catch (error) {
                console.log(error);
            }
        }
    </script>
@endpush
