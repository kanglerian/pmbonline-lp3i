<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.png') }}">
    <title>Cetak Dokumen - Politeknik LP3I Kampus Tasikmalaya</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font-family: 'Roboto Mono', monospace;
            font-size: 13px;
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm;
            margin: 10mm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            position: relative;
            background-image: url('/img/wattermark.svg');
            background-size: 200px;
            background-repeat: no-repeat;
            background-position: center center;
        }


        .subpage {
            padding: 1cm;
            border: 5px red solid;
            height: 257mm;
            outline: 2cm #FFEAEA solid;
        }

        td {
            padding-top: 5px;
        }

        #footer {
            display: none;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
                background-image: url('/img/wattermark.svg');
                background-size: 200px;
                background-repeat: no-repeat;
                background-position: center center;
            }

            #print {
                display: none
            }

            #footer {
                display: block;
                position: fixed;
                bottom: 0;
                left: -20px;
                width: 100%;
                height: 50px;
                background-color: #f2f2f2;
                text-align: center;
                padding-top: 15px;
                font-size: 12px;
            }
        }
    </style>
</head>
@php
    $monthsInIndonesian = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];
@endphp

<body>
    <div class="book">
        <div class="page">
            <div id="api_endpoint_lp3i" style="display: none">{{ env('API_LP3I') }}</div>
            <header style="display: flex; justify-content: start; align-items: start">
                <div>
                    <img src="{{ asset('img/lp3i.png') }}" alt="" width="30%" style="text-align: center">
                    <h2>DAFTAR RIWAYAT HIDUP</h2>
                    <p>Mahasiswa Politeknik LP3I Kampus Tasikmalaya</p>
                    <p>Program Studi {{ $applicant->program == null ? '_______________' : $applicant->program }}</p>
                </div>
                @if ($user->avatar)
                    <img src="https://uploadhub.politekniklp3i-tasikmalaya.ac.id/download?identity={{ $user->identity }}&filename={{ $user->identity }}-{{ $user->avatar }}"
                        alt="Avatar" width="110px">
                @else
                    <div
                        style="border: 1px dotted black; height: 180px; width: 420px;display: flex;justify-content: center;align-items:center">
                        <p>Pas foto 4x3</p>
                    </div>
                @endif
            </header>
            <hr style="margin-top: 10px;">
            <h3>Biodata Mahasiswa</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $applicant->name == null ? '_______________' : $applicant->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $applicant->place_of_birth == null ? '_______________' : $applicant->place_of_birth }}
                        /
                        {{ $applicant->date_of_birth == null ? '_______________' : \Carbon\Carbon::parse($applicant->date_of_birth)->format('d ') . $monthsInIndonesian[\Carbon\Carbon::parse($applicant->date_of_birth)->format('m')] . \Carbon\Carbon::parse($applicant->date_of_birth)->format(' Y') }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Agama</td>
                    <td>:</td>
                    <td>{{ $applicant->religion == null ? '_______________' : $applicant->religion }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Asal SMA / SMK. Sederajat</td>
                    <td>:</td>
                    <td>{{ $applicant->school == null ? '_______________' : $applicant->SchoolApplicant->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. Telepon / HP</td>
                    <td>:</td>
                    <td>{{ $applicant->phone == null ? '_______________' : $applicant->phone }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $applicant->address == null ? '_______________' : $applicant->address }}</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>Biodata Ayah</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $father->name == null ? '_______________' : $father->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $father->place_of_birth == null ? '_______________' : $father->place_of_birth }}
                        /
                        {{ $father->date_of_birth == null ? '_______________' : \Carbon\Carbon::parse($father->date_of_birth)->format('d ') . $monthsInIndonesian[\Carbon\Carbon::parse($father->date_of_birth)->format('m')] . \Carbon\Carbon::parse($father->date_of_birth)->format(' Y') }}
                </tr>
                <tr>
                    <td style="width: 200px;">Pendidikan / Pekerjaan</td>
                    <td>:</td>
                    <td>
                        {{ $father->education == null ? '_______________' : $father->education }}
                        /
                        {{ $father->job == null ? '_______________' : $father->job }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. Telepon / HP</td>
                    <td>:</td>
                    <td>{{ $father->phone == null ? '_______________' : $father->phone }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $father->address == null ? '_______________' : $father->address }}</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>Biodata Ibu</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $mother->name == null ? '_______________' : $mother->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ $mother->place_of_birth == null ? '_______________' : $mother->place_of_birth }}
                        /
                        {{ $mother->date_of_birth == null ? '_______________' : \Carbon\Carbon::parse($mother->date_of_birth)->format('d ') . $monthsInIndonesian[\Carbon\Carbon::parse($mother->date_of_birth)->format('m')] . \Carbon\Carbon::parse($mother->date_of_birth)->format(' Y') }}
                </tr>
                <tr>
                    <td style="width: 200px;">Pendidikan / Pekerjaan</td>
                    <td>:</td>
                    <td>
                        {{ $mother->education == null ? '_______________' : $mother->education }}
                        /
                        {{ $mother->job == null ? '_______________' : $mother->job }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. Telepon / HP</td>
                    <td>:</td>
                    <td>{{ $mother->phone == null ? '_______________' : $mother->phone }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $mother->address == null ? '_______________' : $mother->address }}</td>
                </tr>
            </table>
            <table style="margin-top: 20px">
                <tr>
                    <td style="width: 200px;">Penghasilan Orang Tua</td>
                    <td>:</td>
                    <td>Rp {{ $applicant->income_parent == null ? '_______________' : $applicant->income_parent }}</td>
                </tr>
            </table>
            <footer id="footer" style="margin-top: 25px;font-size:10px;text-align:right"></footer>
        </div>

        <div class="page">
            <header style="display: flex; justify-content: start; align-items: start">
                <div>
                    <img src="{{ asset('img/lp3i.png') }}" alt="" width="30%" style="text-align: center">
                    <h2>SEKILAS TENTANG ANDA</h2>
                    <p>Mahasiswa Politeknik LP3I Kampus Tasikmalaya</p>
                    <p>Program Studi {{ $applicant->program == null ? '_______________' : $applicant->program }}
                        ({{ $applicant->programtype ? $applicant->programtype->name : 'Tidak diketahui' }})</p>
                    <p>
                        <span>Relasi:
                            {{ $applicant->relation == null ? '_______________' : $applicant->relation }}</span> |
                        <span>Sumber:
                            {{ $applicant->source_id == null ? '_______________' : $applicant->SourceSetting->name }}</span>
                    </p>
                </div>
            </header>
            <hr style="margin-top: 10px;">
            <h3>Biodata Mahasiswa</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $applicant->name == null ? '_______________' : $applicant->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>
                        <span>{{ $applicant->place_of_birth == null ? '_______________' : $applicant->place_of_birth }}</span>
                        /
                        <span>{{ $applicant->date_of_birth == null ? '_______________' : \Carbon\Carbon::parse($applicant->date_of_birth)->format('d ') . $monthsInIndonesian[\Carbon\Carbon::parse($applicant->date_of_birth)->format('m')] . \Carbon\Carbon::parse($applicant->date_of_birth)->format(' Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Agama</td>
                    <td>:</td>
                    <td>{{ $applicant->religion == null ? '_______________' : $applicant->religion }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Asal SMA / SMK. Sederajat</td>
                    <td>:</td>
                    <td>
                        <span>{{ $applicant->school == null ? '_______________' : $applicant->SchoolApplicant->name }}</span>
                        (<span>{{ $applicant->year == null ? '_______________' : $applicant->year }}</span>)
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. HP / Email</td>
                    <td>:</td>
                    <td>
                        <span>{{ $applicant->phone == null ? '_______________' : $applicant->phone }}</span>
                        /
                        <span>{{ $applicant->email == null ? '_______________' : $applicant->email }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $applicant->address == null ? '_______________' : $applicant->address }}</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>Biodata Ayah</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $father->name == null ? '_______________' : $father->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pekerjaan Ayah</td>
                    <td>:</td>
                    <td>{{ $father->job == null ? '_______________' : $father->job }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. HP</td>
                    <td>:</td>
                    <td>{{ $father->phone == null ? '_______________' : $father->phone }}</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>Biodata Ibu</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>{{ $mother->name == null ? '_______________' : $mother->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pekerjaan Ibu</td>
                    <td>:</td>
                    <td>{{ $mother->job == null ? '_______________' : $mother->job }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. HP</td>
                    <td>:</td>
                    <td>{{ $mother->phone == null ? '_______________' : $mother->phone }}</td>
                </tr>
            </table>

            <hr style="margin-top: 10px;">
            <div style="display: flex; justify-content:space-between;gap:30px" style="margin-top: 30px">
                <div style="margin-top: 10px">
                    <p>Keterangan:</p>
                    @if ($applicant->note)
                        {{ $applicant->note }}
                    @else
                        <p>__________________________________</p>
                        <p>__________________________________</p>
                        <p>__________________________________</p>
                    @endif
                </div>
                <div style="margin-top: 10px;text-align:center">
                    <p>Tasikmalaya, <span class="signature"></span></p>
                    <p>Panitia Penerima Mahasiswa Baru</p><br /><br />
                    <p>__________________________________</p>
                    <p>Tanda Tangan & Nama Jelas</p>
                </div>
            </div>
        </div>

        <div class="page">
            <header style="display: flex; justify-content: start; align-items: start">
                <div>
                    <img src="{{ asset('img/lp3i.png') }}" alt="" width="30%" style="text-align: center">
                    <h2>FORMULIR PENDAFTARAN<br/>MAHASISWA BARU T.A {{ $applicant->pmb }}/{{ $applicant->pmb + 1 }}</h2>
                    <p>Mahasiswa Politeknik LP3I Kampus Tasikmalaya</p>
                </div>

                @if ($user->avatar)
                    <img src="https://uploadhub.politekniklp3i-tasikmalaya.ac.id/download?identity={{ $user->identity }}&filename={{ $user->identity }}-{{ $user->avatar }}"
                        alt="Avatar" width="110px">
                @else
                    <div
                        style="border: 1px dotted black; height: 180px; width: 420px;display: flex;justify-content: center;align-items:center">
                        <p>Pas foto 4x3</p>
                    </div>
                @endif
            </header>
        
            <hr style="margin-top: 10px;">
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">No. Pendaftaran</td>
                    <td>:</td>
                    <td>____________________________________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Status Aplikan</td>
                    <td>:</td>
                    <td>
                        <span>A {{ $applicant->is_applicant == null ? '[  ]' : ' √ ' }}</span> |
                        <span>D {{ $applicant->is_daftar == null ? '[  ]' : ' √ ' }}</span> |
                        <span>R {{ $applicant->is_register == null ? '[  ]' : ' √ ' }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. Kwitansi Pendaftaran</td>
                    <td>:</td>
                    @if ($enrollment)
                        <td>{{ $enrollment->receipt }}</td>
                    @else
                        <td>________________________</td>
                    @endif
                </tr>
                <tr>
                    <td style="width: 200px;">Program Studi</td>
                    <td>:</td>
                    <td>{{ $applicant->program == null ? '_______________' : $applicant->program }}
                        ({{ $applicant->programtype ? $applicant->programtype->name : 'Tidak diketahui' }})</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>DATA PRIBADI</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">No. KTP</td>
                    <td>:</td>
                    <td>{{ $applicant->nik == null ? '_______________' : $applicant->nik }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">NISN</td>
                    <td>:</td>
                    <td>{{ $applicant->nisn == null ? '_______________' : $applicant->nisn }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Nama Lengkap</td>
                    <td>:</td>
                    <td>
                        <span>{{ $applicant->name == null ? '_______________' : $applicant->name }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Jenis kelamin</td>
                    <td>:</td>
                    <td>
                        <span>
                            @switch($applicant->gender)
                                @case(1)
                                    <span>Laki-laki</span>
                                @break

                                @case(0)
                                    <span>Perempuan</span>
                                @break

                                @default
                                    <span>___</span>
                            @endswitch
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tempat, Tanggal Lahir</td>
                    <td>:</td>
                    <td>
                        <span>{{ $applicant->place_of_birth == null ? '_______________' : $applicant->place_of_birth }}</span>
                        /
                        <span>{{ $applicant->date_of_birth == null ? '_______________' : \Carbon\Carbon::parse($applicant->date_of_birth)->format('d ') . $monthsInIndonesian[\Carbon\Carbon::parse($applicant->date_of_birth)->format('m')] . \Carbon\Carbon::parse($applicant->date_of_birth)->format(' Y') }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. HP / Email</td>
                    <td>:</td>
                    <td>
                        <span>{{ $applicant->phone == null ? '_______________' : $applicant->phone }}</span>
                        /
                        <span>{{ $applicant->email == null ? '_______________' : $applicant->email }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">*Status Pernikahan</td>
                    <td>:</td>
                    <td>Menikah / Belum Menikah</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Agama</td>
                    <td>:</td>
                    <td>{{ $applicant->religion == null ? '_______________' : $applicant->religion }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">*Penanggung Jawab Kuliah</td>
                    <td>:</td>
                    <td>Orang Tua / Wali / Sendiri / Beasiswa</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $applicant->address == null ? '_______________' : $applicant->address }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">*Status Alamat</td>
                    <td>:</td>
                    <td>Rumah Orang Tua / Rumah Keluarga / Kontrak / Kost</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>BIODATA ORANG TUA</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">KTP Orang Tua</td>
                    <td>:</td>
                    <td>______________________________ (Ayah / Ibu)</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Nama Ayah</td>
                    <td>:</td>
                    <td>{{ $father->name == null ? '_______________' : $father->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Nama Ibu</td>
                    <td>:</td>
                    <td>{{ $mother->name == null ? '_______________' : $mother->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. HP Ayah / Ibu</td>
                    <td>:</td>
                    <td>
                        <span>{{ $father->phone == null ? '__________________' : $father->phone }}</span> /
                        <span>{{ $mother->phone == null ? '__________________' : $mother->phone }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat</td>
                    <td>:</td>
                    <td>{{ $father->address == null ? '_______________' : $father->address }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pekerjaan Ayah / Ibu</td>
                    <td>:</td>
                    <td>
                        <span>{{ $father->job == null ? '_______________' : $father->job }}</span> /
                        <span>{{ $mother->job == null ? '_______________' : $mother->job }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px;">Pendidikan Ayah / Ibu</td>
                    <td>:</td>
                    <td>
                        <span>{{ $father->education == null ? '_______________' : $father->education }}</span> /
                        <span>{{ $mother->education == null ? '_______________' : $mother->education }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="page">

            <h3>RIWAYAT PENDIDIKAN</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Asal SMA / SMK. Sederajat</td>
                    <td>:</td>
                    <td>{{ $applicant->school == null ? '_______________' : $applicant->SchoolApplicant->name }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Jurusan</td>
                    <td>:</td>
                    <td>{{ $applicant->major == null ? '_______________' : $applicant->major }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Tahun Lulus</td>
                    <td>:</td>
                    <td>{{ $applicant->year == null ? '_______________' : $applicant->year }}</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat Sekolah</td>
                    <td>:</td>
                    <td>______________________________</td>
                </tr>
            </table>
            <p style="margin-top: 30px">Harap diisi jika mahasiswa pindahan PTS lain</p>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama PTS Asal</td>
                    <td>:</td>
                    <td>______________________________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Program Studi / Akreditasi</td>
                    <td>:</td>
                    <td>______________________________ / ______________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Jenjang Pendidikan</td>
                    <td>:</td>
                    <td>D1 / D2 / D3 / ___</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat PTS</td>
                    <td>:</td>
                    <td>______________________________</td>
                </tr>
            </table>
            <hr style="margin-top: 10px">
            <p>*Harap diisi apabila sudah bekerja</p>
            <h3>DATA PERUSAHAAN TEMPAT BEKERJA</h3>
            <table style="margin-top: 10px">
                <tr>
                    <td style="width: 200px;">Nama Perusahaan</td>
                    <td>:</td>
                    <td>______________________________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Alamat Perusahaan</td>
                    <td>:</td>
                    <td>______________________________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">No. HP / Email</td>
                    <td>:</td>
                    <td>______________________________ / ______________________________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Departemen (Bagian) / Jabatan</td>
                    <td>:</td>
                    <td>______________________________ / ______________________________</td>
                </tr>
                <tr>
                    <td style="width: 200px;">Status Kepegawaian</td>
                    <td>:</td>
                    <td>Tetap / Kontrak / Outsourcing</td>
                </tr>
            </table>
            <hr style="margin-top: 10px;">
            <h3>PENGALAMAN ORGANISASI & PRESTASI</h3>
            <div style="margin-top: 10px" id="identity_val" data-user="{{ $applicant->identity }}">
                <span id="organizations"></span>
                <span id="achievements"></span>
            </div>
        </div>

        <div class="page" id="scholarship_container">
            <h3>HASIL TES BEASISWA</h3>
            <p>Berikut ini adalah hasil tes beasiswa dengan beberapa kategori:</p>
            <div id="scholarship_result"></div>
        </div>

        <div class="page">
            <h3>KELENGKAPAN PERSYARATAN</h3>
            <table style="margin-top: 10px">
                <tbody>
                    <tr>
                        <td style="width: 200px;">Salinan Ijazah Terakhir</td>
                        <td>:</td>
                        <td>[ ] ___________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Salinan Transkip Nilai</td>
                        <td>:</td>
                        <td>[ ] ___________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Salinan Akta Kelahiran</td>
                        <td>:</td>
                        <td>[ ] ___________________________________________________</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Pas Foto Terbaru</td>
                        <td>:</td>
                        <td>[ ] 2x3 / 3x4 / 4x6 (3 lembar)</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Fotokopi KTP</td>
                        <td>:</td>
                        <td>[ ] (3 lembar)</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">SK Kerja</td>
                        <td>:</td>
                        <td>[ ] (Apabila sudah bekerja)</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Fotokopi KK</td>
                        <td>:</td>
                        <td>[ ] (3 lembar)</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Materai Rp10.000</td>
                        <td>:</td>
                        <td>[ ] (3 lembar)</td>
                    </tr>
                    <tr>
                        <td style="width: 200px;">Sertifikat Pendukung</td>
                        <td>:</td>
                        <td>[ ] (Jika ada)</td>
                    </tr>
                </tbody>
            </table>
            <hr style="margin-top: 30px">

            <div style="display: flex; justify-content:space-between">
                <div style="margin-top: 10px;text-align:center">
                    <p>Tasikmalaya, <span class="signature"></span></p>
                    <br />
                    <br />
                    <br />
                    <p>__________________________________</p>
                    <p>Tanda Tangan & Nama Lengkap Pendaftar</p>
                </div>
                <div style="margin-top: 35px;text-align:center">
                    <br />
                    <br />
                    <br />
                    <br />
                    <p>__________________________________</p>
                    <p>Tanda Tangan & Nama Lengkap Leader Presenter</p>
                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script>
        const URL_API_LP3I = document.getElementById('api_endpoint_lp3i').innerText;
    </script>
    <script>
        const isiTimestamp = () => {
            let footer = document.getElementById('footer');
            let dateTimeString = new Date().toLocaleString('id');
            footer.innerText = `Dicetak pada tanggal: ${dateTimeString}`;
        }
        isiTimestamp();

        const signature = () => {
            let signatures = document.getElementsByClassName('signature');
            let dateTime = new Date();
            const monthNames = [
                "Januari", "Februari", "Maret",
                "April", "Mei", "Juni", "Juli",
                "Agustus", "September", "Oktober",
                "November", "Desember"
            ];
            const day = dateTime.getDate();
            const monthIndex = dateTime.getMonth();
            const year = dateTime.getFullYear();
            const formattedDate = `${day} ${monthNames[monthIndex]} ${year}`;

            for (let i = 0; i < signatures.length; i++) {
                signatures[i].innerText = formattedDate;
            }
        }
        signature();

        const printCV = () => {
            window.print();
        }
    </script>
    <script>
        const getOrganizations = async () => {
            let identity = document.getElementById('identity_val').getAttribute('data-user');
            await axios.get(`/organizations/${identity}`)
                .then((response) => {
                    let organizations = response.data.organizations;
                    if (organizations.length > 0) {
                        let bucket = '';
                        organizations.forEach(organization => {
                            bucket += `
                        <li>
                            ${organization.name} (${organization.position}) - ${organization.year}
                        </li>
                        `
                        });
                        document.getElementById('organizations').innerHTML = `
                        <tr>
                            <td style="width: 200px;">Pengalaman Berorganisasi</td>
                            <td>:</td>
                            <td><ul class="space-y-2">${bucket}</ul></td>
                        </tr>`;
                    } else {
                        document.getElementById('organizations').innerHTML =
                            `
                        <tr>
                            <td style="width: 200px;">Pengalaman Berorganisasi</td>
                            <td>:</td>
                            <td>
                                <ul class="space-y-2">
                                    <li>________________________</li>
                                    <li>________________________</li>
                                    <li>________________________</li>
                                    <li>________________________</li>
                                    <li>________________________</li>
                                </ul>
                            </td>
                        </tr>`
                    }
                })
                .catch((error) => {
                    console.log(error.message);
                })
        }
        getOrganizations();
    </script>
    <script>
        const getAchievements = async () => {
            let identity = document.getElementById('identity_val').getAttribute('data-user');
            await axios.get(`/achievements/${identity}`)
                .then((response) => {
                    let achievements = response.data.achievements;
                    if (achievements.length > 0) {
                        let bucket = '';
                        achievements.forEach(achievement => {
                            bucket += `
                        <li>
                            ${achievement.name} (${achievement.result}) - ${achievement.level} ${achievement.year}
                        </li>
                        `
                        });
                        document.getElementById('achievements').innerHTML = `
                        <tr>
                            <td style="width: 200px;">Prestasi</td>
                            <td>:</td>
                            <td><ul class="space-y-2">${bucket}</ul></td>
                        </tr>`;
                    } else {
                        document.getElementById('achievements').innerHTML =
                            `
                        <tr>
                            <td style="width: 200px;">Prestasi</td>
                            <td>:</td>
                            <td>
                                <ul class="space-y-2">
                                    <li>________________________</li>
                                    <li>________________________</li>
                                    <li>________________________</li>
                                    <li>________________________</li>
                                    <li>________________________</li>
                                </ul>
                            </td>
                        </tr>`
                    }
                })
                .catch((error) => {
                    console.log(error.message);
                })
        }
        getAchievements();
    </script>
    <script>
        const getHistories = async () => {
            try {
                let identity = document.getElementById('identity_val').getAttribute('data-user');
                const responseHistories = await axios.get(
                    `${URL_API_LP3I}/scholarship/histories?identity_user=${identity}`
                );
                let histories = responseHistories.data;
                if (histories.length > 0) {
                    const recordPromises = histories.map((history) => getRecords(history));
                    const results = await Promise.all(recordPromises);
                    let bucket = '';
                    let nilai = 0;
                    results.forEach(result => {
                        nilai += parseInt(result.score);
                        bucket += `
                        <div>
                            <h3>${result.category}</h3>
                            <ul>
                                <li>Jumlah Soal: ${result.questions}</li>
                                <li>Jumlah Terjawab: ${result.recordLength}</li>
                                <li>Benar: ${result.trueResult}</li>
                                <li>Salah: ${result.falseResult}</li>
                                <li>Nilai: ${result.score}</li>
                            </ul>
                        </div>
                    `
                    });
                    let resultNilai = nilai / 3;
                    document.getElementById('scholarship_result').innerHTML = `
                        <div>
                            ${bucket}
                            <div>
                                <h3>Nilai Akhir: ${resultNilai.toFixed()}</h3>
                            </div>
                        </div>
                    `;
                } else {
                    document.getElementById('scholarship_container').style.display = 'none';
                    document.getElementById('scholarship_result').innerHTML = `<p>Tidak ada yang dikerjakan</p>`;
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
                    `${URL_API_LP3I}/scholarship/records?identity_user=${history.identity_user}&category=${history.category_id}`
                );
                const responseQuestions = await axios.get(
                    `${URL_API_LP3I}/scholarship/questions?category=${history.category_id}`
                );

                let category = history.category.name;
                let records = responseRecords.data;
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
                }

            } catch (error) {
                document.getElementById('result').innerHTML = `${error.message}`;
            }
        }
    </script>
</body>

</html>
