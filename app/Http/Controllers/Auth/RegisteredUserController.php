<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApplicantStatus;
use App\Models\ProgramType;
use App\Models\School;
use App\Models\SourceSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller {
    /**
    * Display the registration view.
    *
    * @return \Illuminate\View\View
    */

    public function create(): RedirectResponse|View {
        try {
            $users = User::where( [ 'status' => '1', 'role' => 'P' ] )->get();
            $sources = SourceSetting::all();
            $statuses = ApplicantStatus::all();
            $programtypes = ProgramType::where( 'status', 1 )->get();
            $schools = School::all();

            return view( 'auth.register' )->with( [
                'statuses' => $statuses,
                'programtypes' => $programtypes,
                'sources' => $sources,
                'users' => $users,
                'schools' => $schools,
            ] );
        } catch ( \Throwable $th ) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with( 'error', $errorMessage );
        }
    }

    /**
    * Handle an incoming registration request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\RedirectResponse
    *
    * @throws \Illuminate\Validation\ValidationException
    */

    public function store( Request $request ) {
        $request->validate(
            [
                'programtype_id' => [ 'required', 'not_in:0' ],
                'program' => [ 'required', 'string', 'not_in:0' ],
                'name' => [ 'required', 'string', 'max:255' ],
                'gender' => [ 'required', 'string', 'not_in:null' ],
                'place_of_birth' => [ 'required' ],
                'date_of_birth' => [ 'required' ],
                'religion' => [ 'required' ],
                'major' => [ 'required' ],
                'year' => [ 'required', 'min:4', 'max:4' ],
                'school' => [ 'required', 'max:100', 'not_in:Pilih Sekolah' ],

                'email' => [ 'required', 'email', 'max:255', 'unique:users,email'],
                'phone' => [ 'required', 'string', 'min:10', 'max:15', 'unique:users,phone',],

                'password' => [ 'required', 'confirmed' ],
            ],
            [
                'programtype_id.required' => 'Oopss, sepertinya kamu lupa memilih Program Kuliah, yuk isi!',
                'programtype_id.not_in' => 'Ayo pilih Program Kuliah yang valid, pasti bisa!',
                'program.required' => 'Program Studi wajib diisi, nih!',
                'program.not_in' => 'Jangan lupa pilih Program Studi yang valid, ya!',
                'name.required' => 'Hei, Nama Lengkap jangan sampai kosong ya!',
                'gender.required' => 'Jenis Kelamin juga penting, lho. Isi dong!',
                'gender.not_in' => 'Jenis Kelamin juga penting, lho. Isi dong!',
                'place_of_birth.required' => 'Tempat Lahir jangan terlupakan ya!',
                'date_of_birth.required' => 'Tanggal Lahir harus diisi, nih!',
                'religion.required' => 'Agama jangan lupa diisi, ya!',
                'major.required' => 'Jurusan wajib diisi, pasti pilihan yang bagus!',
                'year.required' => 'Tahun lulus jangan sampai kosong, ya!',
                'year.min' => 'Tahun harus memiliki setidaknya 4 digit, pastikan benar ya!',
                'school.max' => 'Sekolah tidak boleh lebih dari 100 karakter, pastikan benar ya!',
                'school.required' => 'Sekolah juga jangan terlupakan, lho!',
                'school.not_in' => 'Ayo pilih Sekolah yang valid, pasti oke!',
                'email.required' => 'Email jangan sampai kosong, ya!',
                'email.email' => 'Format email sepertinya kurang benar, cek lagi ya!',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain ya!',
                'phone.required' => 'Nomor Telepon jangan sampai kosong, ya!',
                'phone.string' => 'Nomor Telepon harus berupa string, nih!',
                'phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
                'phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
                'phone.unique' => 'Nomor Telepon sudah terdaftar, butuh bantuan? klik tombol bantuan ya!',
                'password.required' => 'Password jangan sampai kosong, ya!',
                'password.confirmed' => 'Konfirmasi password tidak sesuai, cek lagi ya!',
            ],
        );

        $schoolName = $request->input( 'school' );

        if ( empty( $schoolName ) ) {
            $school = null;
        } else {
            $schoolCheck = School::where( 'id', $schoolName )->first();
            $schoolNameCheck = School::where( 'name', $schoolName )->first();

            if ( $schoolCheck ) {
                $school = $schoolCheck->id;
            } else {
                if ( $schoolNameCheck ) {
                    $school = $schoolNameCheck->id;
                } else {
                    $dataSchool = [
                        'name' => strtoupper( $schoolName ),
                        'region' => 'TIDAK DIKETAHUI',
                    ];
                    $schoolCreate = School::create( $dataSchool );
                    $school = $schoolCreate->id;
                }
            }
        }

        $applicant_exist_by_email = Applicant::where( 'email', $request->input( 'email' ) )->first();
        $applicant_exist_by_phone = Applicant::where( 'phone', $request->input( 'phone' ) )->first();

        $user_exist_by_email_phone = User::where( [ 'phone' => $request->input( 'phone' ), 'email' => $request->input( 'email' ) ] )->first();

        if ( !empty( $user_exist_by_email_phone ) ) {
            dd( 'akun sudah ada' );
        } else {
            if ( !empty( $applicant_exist_by_phone ) ) {
                $data_applicant = [
                    'identity' => $applicant_exist_by_phone->identity,
                    'programtype_id' => $request->input( 'programtype_id' ),
                    'program' => $request->input( 'program' ),
                    'program_second' => $request->input( 'program' ),
                    'name' => ucwords( strtolower( $request->input( 'name' ) ) ),
                    'gender' => $request->input( 'gender' ),
                    'place_of_birth' => $request->input( 'place_of_birth' ),
                    'date_of_birth' => $request->input( 'date_of_birth' ),
                    'religion' => $request->input( 'religion' ),
                    'major' => $request->input( 'major' ),
                    'year' => $request->input( 'year' ),
                    'school' => $school,
                    'class' => $request->input( 'class' ),
                    'email' => $request->input( 'email' ),
                    'pmb' => $request->input( 'pmb' ),
                    'identity_user' => '6281313608558',
                    'source_id' => 8,
                    'source_daftar_id' => 8,
                    'status_id' => 4,
                    'come' => 0,
                    'isread' => '0',
                ];

                $data_user = [
                    'identity' => $applicant_exist_by_phone->identity,
                    'name' => $request->input( 'name' ),
                    'gender' => $request->input( 'gender' ),
                    'email' => $request->input( 'email' ),
                    'phone' => $request->input( 'phone' ),
                    'password' => Hash::make( $request->input( 'password' ) ),
                    'role' => 'S',
                    'status' => '1',
                ];


                $user = User::create( $data_user );
                $applicant_exist_by_phone->update($data_applicant);
                Auth::login( $user );
            } else {
                if ( !empty( $applicant_exist_by_email ) ) {
                    $data_applicant = [
                        'identity' => $applicant_exist_by_email->identity,
                        'programtype_id' => $request->input( 'programtype_id' ),
                        'program' => $request->input( 'program' ),
                        'program_second' => $request->input( 'program' ),
                        'name' => ucwords( strtolower( $request->input( 'name' ) ) ),
                        'gender' => $request->input( 'gender' ),
                        'place_of_birth' => $request->input( 'place_of_birth' ),
                        'date_of_birth' => $request->input( 'date_of_birth' ),
                        'religion' => $request->input( 'religion' ),
                        'major' => $request->input( 'major' ),
                        'year' => $request->input( 'year' ),
                        'school' => $school,
                        'class' => $request->input( 'class' ),
                        'email' => $request->input( 'email' ),
                        'phone' => $request->input( 'phone' ),
                        'pmb' => $request->input( 'pmb' ),
                        'identity_user' => '6281313608558',
                        'source_id' => 8,
                        'source_daftar_id' => 8,
                        'status_id' => 4,
                        'come' => 0,
                        'isread' => '0',
                    ];
    
                    $data_user = [
                        'identity' => $applicant_exist_by_email->identity,
                        'name' => $request->input( 'name' ),
                        'gender' => $request->input( 'gender' ),
                        'email' => $request->input( 'email' ),
                        'phone' => $request->input( 'phone' ),
                        'password' => Hash::make( $request->input( 'password' ) ),
                        'role' => 'S',
                        'status' => '1',
                    ];
    
    
                    $user = User::create( $data_user );
                    $applicant_exist_by_email->update($data_applicant);
                    Auth::login( $user );
                } else {
                    $identity_val = Str::uuid();
                    $data_applicant = [
                        'identity' => $identity_val,
                        'programtype_id' => $request->input( 'programtype_id' ),
                        'program' => $request->input( 'program' ),
                        'program_second' => $request->input( 'program' ),
                        'name' => ucwords( strtolower( $request->input( 'name' ) ) ),
                        'gender' => $request->input( 'gender' ),
                        'place_of_birth' => $request->input( 'place_of_birth' ),
                        'date_of_birth' => $request->input( 'date_of_birth' ),
                        'religion' => $request->input( 'religion' ),
                        'major' => $request->input( 'major' ),
                        'year' => $request->input( 'year' ),
                        'school' => $school,
                        'class' => $request->input( 'class' ),
                        'email' => $request->input( 'email' ),
                        'phone' => $request->input( 'phone' ),
                        'pmb' => $request->input( 'pmb' ),
                        'identity_user' => '6281313608558',
                        'source_id' => 8,
                        'source_daftar_id' => 8,
                        'status_id' => 4,
                        'come' => 0,
                        'isread' => '0',
                    ];

                    $data_user = [
                        'identity' => $identity_val,
                        'name' => $request->input( 'name' ),
                        'gender' => $request->input( 'gender' ),
                        'email' => $request->input( 'email' ),
                        'phone' => $request->input( 'phone' ),
                        'password' => Hash::make( $request->input( 'password' ) ),
                        'role' => 'S',
                        'status' => '1',
                    ];

                    $data_father = [
                        'identity_user' => $identity_val,
                        'gender' => 1,
                    ];
                    $data_mother = [
                        'identity_user' => $identity_val,
                        'gender' => 0,
                    ];

                    $user = User::create( $data_user );
                    Applicant::create( $data_applicant );
                    ApplicantFamily::create( $data_father );
                    ApplicantFamily::create( $data_mother );
                    Auth::login( $user );
                }
            }
        }

        return redirect( RouteServiceProvider::HOME );
    }
}
