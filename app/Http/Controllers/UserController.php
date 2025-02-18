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
use App\Models\UserUpload;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $nameVal = request('name');
        $accountQuery = User::query();
        if ($nameVal) {
            $accountQuery->where('name', 'LIKE', '%' . $nameVal . '%');
        }
        $users = User::count();
        $active = User::where('status', 1)->count();
        $deactive = User::where('status', 0)->count();
        $accounts = $accountQuery->paginate(5);
        return view('pages.user.index')->with([
            'users' => $users,
            'active' => $active,
            'deactive' => $deactive,
            'accounts' => $accounts
        ]);
    }

    public function get_all($role = null, $status = null): JsonResponse
    {
        $usersQuery = User::query();

        if (Auth::user()->role == 'P') {
            $usersQuery->where('role', 'S');
        }

        if ($role !== 'all' && $role !== null) {
            $usersQuery->where('role', $role);
        }

        if ($status !== 'all' && $status !== null) {
            $usersQuery->where('status', $status);
        }

        $users = $usersQuery->orderByDesc('created_at')->get();

        return response()
            ->json([
                'users' => $users,
            ])
            ->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Factory|View
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'not_in:Pilih gender'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'phone' => ['string', 'unique:users', 'max:15'],
            'role' => ['string', 'not_in:Pilih peran'],
            'status' => ['string', 'not_in:Pilih status'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $data = [
            'identity' => $request->input('phone'),
            'name' => ucwords(strtolower($request->input('name'))),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
        ];
        User::create($data);
        return back()->with('message', 'Akun berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): void
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::findOrFail($id);
        $applicant = Applicant::where('identity', $user->identity)->first();
        $schools = School::all();

        if ($user->role == 'S') {
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        }

        $presenters = User::where(['status' => '1', 'role' => 'P'])->get();

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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        $request->validate([
            'gender' => ['required', 'not_in:Pilih gender'],
        ]);

        $rt = $request->input('rt') !== null ? 'RT. ' . $request->input('rt') . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $request->input('rw') . ' ' : null;
        $kel = $request->input('villages') !== null ? 'Desa/Kel. ' . $request->input('villages') . ' ' : null;
        $kec = $request->input('districts') !== null ? 'Kec. ' . $request->input('districts') . ' ' : null;
        $reg = $request->input('regencies') !== null ? 'Kota/Kab. ' . $request->input('regencies') . ' ' : null;
        $prov = $request->input('provinces') !== null ? 'Provinsi ' . $request->input('provinces') . ' ' : null;
        $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;
        $address_applicant = $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $schoolCheck = School::where('id', $request->school)->first();
        $schoolNameCheck = School::where('name', $request->school)->first();

        if ($schoolCheck) {
            $school = $schoolCheck->id;
        } else {
            if ($schoolNameCheck) {
                $school = $schoolNameCheck->id;
            } else {
                $dataSchool = [
                    'name' => strtoupper($request->school),
                    'region' => 'TIDAK DIKETAHUI',
                ];
                $schoolCreate = School::create($dataSchool);
                $school = $schoolCreate->id;
            }
        }

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
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

        $data_user = [
            'gender' => $request->input('gender'),
        ];

        $user->update($data_user);
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
    public function destroy($id): RedirectResponse
    {
        try {
            $account = User::findOrFail($id);
            UserUpload::where('identity_user', $account->identity)->delete();
            $account->delete();
            return back()->with('message', 'Akun berhasil dihapus!');
        } catch (\Exception $e) {
            if($e->getCode() == '23000'){
                return back()->with('error', 'Forbidden to delete!');
            } else {
                return back()->with('error', 'Terjadi kesalahan saat mengubah status: ' . $e->getMessage());
            }
        }
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $data = [
            'status' => $user->status == 0 ? 1 : 0,
        ];
        $user->update($data);
        return back()->with('message', 'Status berhasil diubah!');
    }

    public function reset_password_default($id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($user->phone),
        ]);
        return back()->with('message', 'Password berhasil direset!');
    }
}
