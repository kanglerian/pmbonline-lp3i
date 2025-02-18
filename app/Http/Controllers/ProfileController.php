<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'not_in:Pilih gender'],
                'email' => ['required', 'email', 'unique:users', 'max:255'],
                'phone' => ['required', 'string', 'unique:users', 'max:15'],
            ]);

            $data = [
                'identity' => $request->input('identity'),
                'name' => ucwords(strtolower($request->input('name'))),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('phone')),
                'phone' => $request->input('phone'),
                'role' => 'S',
                'status' => 1,
            ];

            $data_applicant = [
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
            ];
            $applicant = Applicant::where('identity', $request->input('identity'))->first();
            User::create($data);
            $applicant->update($data_applicant);
            return back()->with('message', 'Akun berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): RedirectResponse|View
    {
        $user = User::findOrFail($id);

        if ($user->id == Auth::user()->id || Auth::user()->role == 'A') {
            $applicant = Applicant::where('identity', $user->identity)->first();

            if ($user->role == 'S') {
                $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
                $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
            }

            $presenters = User::where(['status' => '1', 'role' => 'P'])->get();
            $schools = School::all();

            if ($user->role == 'S') {
                $data = [
                    'user' => $user,
                    'applicant' => $applicant,
                    'presenters' => $presenters,
                    'father' => $father,
                    'mother' => $mother,
                    'schools' => $schools,
                ];
            } else {
                $data = [
                    'user' => $user,
                ];
            }
            return view('pages.profile.edit')->with($data);
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user_detail = Applicant::where('identity', $user->identity)->first();
        $applicant = Applicant::findOrFail($user_detail->id);

        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();

        $request->validate(
            [
                'nik' => ['required', 'min:16', 'max:16', Rule::unique('applicants')->ignore($user->identity, 'identity')],
                'nisn' => ['required', 'min:10', 'max:10', Rule::unique('applicants')->ignore($user->identity, 'identity')],
                'kip' => ['nullable', 'min:16', 'max:16', Rule::unique('applicants')->ignore($id, 'id')],
                'name' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'not_in:null'],
                'religion' => ['required', 'string'],
                'major' => ['required'],
                'year' => ['required', 'min:4', 'max:4'],
                'school' => ['required', 'max:100', 'not_in:Pilih Sekolah'],

                'father_phone' => ['nullable', 'min:10', 'max:15'],
                'mother_phone' => ['nullable', 'min:10', 'max:15'],
            ],
            [
                'nik.required' => 'Ups, sepertinya NIK belum diisi ya!',
                'nik.unique' => 'Oops, Nomor Induk Kependudukan (NIK) sudah terdaftar nih, coba yang lain!',
                'nik.min' => 'Format NIK nggak bener, harus :min digit ya!',
                'nik.max' => 'Format NIK nggak bener, maksimal :max digit ya!',

                'nisn.required' => 'Ups, sepertinya NISN belum diisi ya!',
                'nisn.unique' => 'Waduh, NISN sudah terdaftar nih, cari yang lain ya!',
                'nisn.min' => 'Format NISN nggak bener, harus :min digit ya!',
                'nisn.max' => 'Format NISN nggak bener, maksimal :max digit ya!',

                'kip.unique' => 'Waduh, Nomor Kartu Indonesia Pintar (KIP) sudah terdaftar nih, cari yang lain ya!',
                'kip.min' => 'Format KIP nggak bener, harus :min digit ya!',
                'kip.max' => 'Format KIP nggak bener, maksimal :max digit ya!',

                'name.required' => 'Nama Lengkap wajib diisi, nih!',
                'gender.required' => 'Jenis Kelamin wajib diisi, jangan terlewat!',
                'religion.required' => 'Agama wajib diisi, pastikan benar ya!',
                'education.required' => 'Pendidikan wajib diisi, jangan sampai terlewatkan!',
                'major.required' => 'Jurusan wajib diisi, pastikan benar ya!',
                'year.required' => 'Tahun lulus wajib diisi, nih!',
                'year.min' => 'Tahun harus memiliki setidaknya 4 digit, pastikan benar ya!',
                'year.max' => 'Tahun harus memiliki setidaknya 4 digit, pastikan benar ya!',

                'school.required' => 'Pilih Sekolah wajib diisi, jangan sampai terlewat!',
                'school.max' => 'Sekolah tidak boleh lebih dari 100 karakter, pastikan benar ya!',

                'father_phone.string' => 'Nomor Telepon harus berupa string, nih!',
                'father_phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
                'father_phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
                'mother_phone.string' => 'Nomor Telepon harus berupa string, nih!',
                'mother_phone.min' => 'Nomor Telepon harus memiliki setidaknya 10 digit, pastikan benar ya!',
                'mother_phone.max' => 'Nomor Telepon tidak boleh lebih dari 15 digit, pastikan benar ya!',
            ],
        );

        $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
        $kel = $request->input('villages') !== null ? 'Desa/Kel. ' . $request->input('villages') . ' ' : null;
        $kec = $request->input('districts') !== null ? 'Kec. ' . $request->input('districts') . ' ' : null;
        $reg = $request->input('regencies') !== null ? 'Kota/Kab. ' . $request->input('regencies') . ' ' : null;
        $prov = $request->input('provinces') !== null ? 'Provinsi ' . $request->input('provinces') . ' ' : null;
        $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;
        $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $schoolCheck = School::where('id', $request->input('school'))->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            $dataSchool = [
                'name' => strtoupper($request->input('school')),
                'region' => 'TIDAK DIKETAHUI',
            ];
            $school = School::create($dataSchool);
            $school = $school->id;
        }

        $data = [
            'nik' => $request->input('nik'),
            'nisn' => $request->input('nisn'),
            'name' => ucwords(strtolower($request->input('name'))),
            'education' => $request->input('education'),
            'major' => $request->input('major'),
            'year' => $request->input('year'),
            'school' => $school,
            'class' => $request->input('class'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender' => $request->input('gender'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address') == null ? $address_applicant : $request->input('address'),
        ];

        $father_rt = $request->input('father_rt') !== null ? 'RT. ' . $request->input('father_rt') . ' ' : null;
        $father_rw = $request->input('father_rw') !== null ? 'RW. ' . $request->input('father_rw') . ' ' : null;
        $father_kel = $request->input('father_villages') !== null ? 'Desa/Kel. ' . $request->input('father_villages') . ' ' : null;
        $father_kec = $request->input('father_districts') !== null ? 'Kec. ' . $request->input('father_districts') . ' ' : null;
        $father_reg = $request->input('father_regencies') !== null ? 'Kota/Kab. ' . $request->input('father_regencies') . ' ' : null;
        $father_prov = $request->input('father_provinces') !== null ? 'Provinsi ' . $request->input('father_provinces') . ' ' : null;
        $father_postal = $request->input('father_postal_code') !== null ? 'Kode Pos ' . $request->input('father_postal_code') : null;
        $address_father = $father_rt . $father_rw . $father_kel . $father_kec . $father_reg . $father_prov . $father_postal;

        $data_father = [
            'name' => ucwords($request->input('father_name')),
            'job' => $request->input('father_job'),
            'place_of_birth' => $request->input('father_place_of_birth'),
            'date_of_birth' => $request->input('father_date_of_birth'),
            'education' => $request->input('father_education'),
            'phone' => $request->input('father_phone'),
            'address' => $request->input('father_address') == null ? $address_father : $request->input('father_address'),
        ];

        $mother_rt = $request->input('mother_rt') !== null ? 'RT. ' . $request->input('mother_rt') . ' ' : null;
        $mother_rw = $request->input('mother_rw') !== null ? 'RW. ' . $request->input('mother_rw') . ' ' : null;
        $mother_kel = $request->input('mother_villages') !== null ? 'Desa/Kel. ' . $request->input('mother_villages') . ' ' : null;
        $mother_kec = $request->input('mother_districts') !== null ? 'Kec. ' . $request->input('mother_districts') . ' ' : null;
        $mother_reg = $request->input('mother_regencies') !== null ? 'Kota/Kab. ' . $request->input('mother_regencies') . ' ' : null;
        $mother_prov = $request->input('mother_provinces') !== null ? 'Provinsi ' . $request->input('mother_provinces') . ' ' : null;
        $mother_postal = $request->input('mother_postal_code') !== null ? 'Kode Pos ' . $request->input('mother_postal_code') : null;
        $address_father = $mother_rt . $mother_rw . $mother_kel . $mother_kec . $mother_reg . $mother_prov . $mother_postal;

        $data_mother = [
            'name' => ucwords($request->input('mother_name')),
            'job' => $request->input('mother_job'),
            'place_of_birth' => $request->input('mother_place_of_birth'),
            'date_of_birth' => $request->input('mother_date_of_birth'),
            'education' => $request->input('mother_education'),
            'phone' => $request->input('mother_phone'),
            'address' => $request->input('mother_address') == null ? $address_father : $request->input('mother_address'),
        ];

        $dataUser = [
            'name' => ucwords(strtolower($request->input('name'))),
            'gender' => $request->input('gender'),
        ];

        $user->update($dataUser);
        $applicant->update($data);
        $father->update($data_father);
        $mother->update($data_mother);

        return back()->with('message', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_account(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user_detail = Applicant::where('identity', $user->identity)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id), 'max:255'],
            'phone' => ['string', Rule::unique('users')->ignore($id), 'max:15'],
        ]);

        $data = [
            'code' => $request->input('code'),
            'name' => ucwords(strtolower($request->input('name'))),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];

        if ($user_detail !== null) {
            $applicant = Applicant::findOrFail($user_detail->id);
            $applicant->update($data);
        }

        $user->update($data);
        return back()->with('message', 'Data berhasil diubah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request, $id): RedirectResponse
    {
        $account = User::findOrFail($id);
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $data = [
            'password' => Hash::make($request->input('password')),
        ];
        $account->update($data);
        return back()->with('message', 'Password berhasil diubah!');
    }
}
