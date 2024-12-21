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

        <section id="content" class="w-full mx-auto">
            <div class="grid grid-cols-2 mx-auto text-center gap-3" id="score_container">
                <span id="total_true" class="hidden p-6 bg-sky-500 text-sm text-white rounded-lg"></span>
                <span id="average_score" class="hidden p-6 bg-emerald-500 text-sm text-white rounded-lg"></span>
            </div>

            <div class="w-full mx-auto space-y-5 px-5" id="result"></div>
        </section>
    </main>

    <input type="hidden" value="{{ $user->identity }}" id="identity_val">

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

    @push('scripts')
        <script>
            const checkServer = async () => {
                await axios.get(`${URL_API_LP3I}`)
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

            const getHistories = async () => {
                try {
                    let identity = document.getElementById('identity_val').value;
                    const responseHistories = await axios.get(
                        `https://sbpmb-backend.politekniklp3i-tasikmalaya.ac.id/histories?identity_user=${identity}`, {
                            headers: {
                                'lp3i-api-key': '5070de3b8c238dc6'
                            }
                        }
                    );

                    const responseCategories = await axios.get(
                        `https://sbpmb-backend.politekniklp3i-tasikmalaya.ac.id/categories`, {
                            headers: {
                                'lp3i-api-key': '5070de3b8c238dc6'
                            }
                        }
                    );
                    let histories = responseHistories.data;
                    let categories = responseCategories.data;
                    if (histories.length > 0) {
                        const recordPromises = histories.map((history) => getRecords(history));
                        const results = await Promise.all(recordPromises);
                        let bucket = '';
                        let count = categories.length;
                        let totalTrue = results.filter((result) => result.trueResult).reduce((acc, result) => acc +
                            result.trueResult, 0);
                        let totalScore = results
                            .map((result) => parseInt(result.score))
                            .reduce((acc, score) => acc + score, 0);
                        let averageScore = parseInt(count > 0 ? totalScore / count : 0);
                        results.forEach(result => {
                            console.log(result);
                            let score = parseInt(result.score);
                            let scoreResult = score.toFixed();
                            bucket += `
                        <div class="relative p-6 bg-white shadow rounded-xl">
                            <h2 class="text-lg font-bold">${result.category}</h2>
                            <ul class="text-sm space-y-1 mt-2">
                                <li>
                                    <i class="fa-solid fa-scroll text-gray-400"></i>
                                    Jumlah Soal: ${result.questions}
                                </li>
                                <li>
                                    <i class="fa-solid fa-inbox text-gray-400"></i>
                                    Jumlah Terjawab: ${result.recordLength}</li>
                                <li>
                                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                    Benar: ${result.trueResult}
                                </li>
                                <li>
                                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                                    Salah: ${result.falseResult}
                                </li>
                                <li>
                                    <i class="fa-solid fa-star text-amber-400"></i>
                                    Nilai: ${scoreResult}
                                </li>
                            </ul>
                            <button type="button" onclick="resetRecord('${result.identityUser}','${result.idCategory}')" class="absolute bottom-3 right-3 bg-sky-500 hover:bg-sky-600 h-10 w-10 rounded-full text-white"><i class="fa-solid fa-rotate-left"></i></button>
                        </div>
                    `
                        });
                        document.getElementById('result').innerHTML = `
                        <div class="grid grid-cols-1 md:grid-cols-3 mx-auto gap-3">
                            ${bucket}
                        </div>
                    `;
                        document.getElementById('total_true').innerText = `Total Benar: ${totalTrue}`;
                        document.getElementById('average_score').innerText = `Nilai Akhir: ${averageScore}`;
                        document.getElementById('total_true').style.display = `block`;
                        document.getElementById('average_score').style.display = `block`;
                    } else {
                        document.getElementById('score_container').style.display = 'none';
                        document.getElementById('result').innerHTML =
                            `<p class="text-sm text-center text-gray-600">Tidak ada yang dikerjakan.</p>`;
                    }

                } catch (error) {
                    console.log(error.message);
                }
            }
            getHistories();
        </script>
        <script>
            const getRecords = async (history) => {
                try {
                    const responseRecords = await axios.get(
                        `https://sbpmb-backend.politekniklp3i-tasikmalaya.ac.id/records?identity_user=${history.identity_user}&category=${history.category_id}`, {
                            headers: {
                                'lp3i-api-key': '5070de3b8c238dc6'
                            }
                        }
                    );
                    const responseQuestions = await axios.get(
                        `https://sbpmb-backend.politekniklp3i-tasikmalaya.ac.id/questions?category=${history.category_id}`, {
                            headers: {
                                'lp3i-api-key': '5070de3b8c238dc6'
                            }
                        }
                    );

                    let category = history.category.name;
                    let records = responseRecords.data;

                    let idCategory = history.category.id;
                    let identityUser = history.identity_user;

                    let recordLength = records.length;
                    let trueResult = records.filter((record) => record.answer.correct == true).length;
                    let falseResult = records.filter((record) => record.answer.correct == false).length;

                    let questions = responseQuestions.data.length;

                    let nilai = (trueResult / questions) * 100;
                    let score = nilai.toFixed();

                    return {
                        recordLength,
                        trueResult,
                        falseResult,
                        questions,
                        score,
                        category,
                        idCategory,
                        identityUser
                    }

                } catch (error) {
                    document.getElementById('result').innerHTML = `${error.message}`;
                }
            }
        </script>
        <script>
            const resetRecord = async (identityUser, idCategory) => {
                const message = confirm('Apakah anda yakin akan mereset?');
                if (message) {
                    const input = prompt(`Silahkan ketik: ${identityUser}`)
                    if (input == identityUser) {
                        await axios.delete(
                                `https://sbpmb-backend.politekniklp3i-tasikmalaya.ac.id/histories/${identityUser}/${idCategory}`, {
                                    headers: {
                                        'lp3i-api-key': '5070de3b8c238dc6'
                                    }
                                }
                            )
                            .then((response) => {
                                alert(response.data.message);
                                location.reload();
                            })
                            .catch((error) => {
                                console.log(error);
                            })
                    } else {
                        alert('Kode tidak tepat!');
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
