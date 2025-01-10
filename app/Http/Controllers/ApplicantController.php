<?php

namespace App\Http\Controllers;

use App\Imports\ApplicantUpdateImport;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;

use App\Models\FollowUp;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicantFamily;
use App\Models\Applicant;
use App\Models\ApplicantStatus;
use App\Models\SourceSetting;
use App\Models\ProgramType;
use App\Models\UserUpload;
use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Database\QueryException;

use App\Exports\ApplicantsExport;
use App\Models\Integration;
use App\Models\Recommendation;
use App\Models\StatusApplicantsApplicant;
use App\Models\Organization;
use App\Models\Achievement;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where(['status' => '1', 'role' => 'P'])->get();
        $sources = SourceSetting::all();
        $statuses = ApplicantStatus::all();
        $schools = School::all();
        $follows = FollowUp::all();
        $nopresenter = Applicant::where('identity_user', '6281313608558')->where('source_id', '!=', '11')->count();

        if (Auth::user()->role == 'A') {
            $total = Applicant::count();
            $nophone = Applicant::where(['phone' => null])->count();
        } else {
            $total = Applicant::where('identity_user', Auth::user()->identity)->count();
            $nophone = Applicant::where(['phone' => null, 'identity_user' => Auth::user()->identity])->count();
        }

        $applicantsQuery = Applicant::query();

        $dateStart = request('datestart', 'all');
        $dateEnd = request('dateend', 'all');
        $yearGrad = request('year', 'all');
        $presenterVal = request('presenter', 'all');
        $schoolVal = request('school', 'all');
        $majorVal = request('major', 'all');
        $birthdayVal = request('dateofbirth', 'all');
        $phoneVal = request('phone', 'all');
        $pmbVal = request('pmb', 'all');
        $followVal = request('follow', 'all');
        $comeVal = request('come', 'all');
        $incomeVal = request('incomeparent', 'all');
        $planVal = request('plan', 'all');
        $sourceVal = request('source', 'all');
        $sourceDaftarVal = request('sourcedaftar', 'all');
        $statusVal = request('status', 'all');
        $achievementVal = request('achievement', 'all');
        $kipVal = request('kip', 'all');
        $relationVal = request('relation', 'all');
        $jobFatherVal = request('jobfather', 'all');
        $jobMotherVal = request('jobmother', 'all');
        $databaseOnline = request('databaseOnline', 'all');
        $statusApplicant = request('applicantstatus', 'all');
        $nameVal = request('name');

        $appends = [];

        if ($nameVal) {
            $applicantsQuery->where('name', 'LIKE', '%' . $nameVal . '%');
        }

        if (Auth::user()->role === 'P') {
            $applicantsQuery->where('identity_user', Auth::user()->identity);
        }

        if ($statusApplicant !== 'all') {
            switch ($statusApplicant) {
                case 'database':
                    $applicantsQuery->where('is_applicant', 0);
                    $applicantsQuery->where('is_daftar', 0);
                    $applicantsQuery->where('is_register', 0);
                    break;
                case 'aplikan':
                    $applicantsQuery->where('is_applicant', 1);
                    break;
                case 'daftar':
                    $applicantsQuery->where('is_daftar', 1);
                    break;
                case 'registrasi':
                    $applicantsQuery->where('is_register', 1);
                    break;
                case 'schoolarship':
                    $applicantsQuery->where('schoolarship', 1);
                    break;
            }
            $appends['statusApplicant'] = $statusApplicant;
        }

        if ($dateStart !== 'all' && $dateEnd !== 'all') {
            $applicantsQuery->whereBetween('created_at', [$dateStart, $dateEnd]);
            $appends['datestart'] = $dateStart;
            $appends['dateend'] = $dateEnd;
        }

        if ($yearGrad !== 'all') {
            $applicantsQuery->where('year', $yearGrad);
            $appends['yearrad'] = $yearGrad;
        }

        if ($presenterVal !== 'all') {
            $applicantsQuery->where('identity_user', $presenterVal);
            $appends['presenter'] = $presenterVal;
        }

        if ($schoolVal !== 'all') {
            $applicantsQuery->where('school', $schoolVal);
            $appends['school'] = $schoolVal;
        }

        if ($majorVal !== 'all') {
            $applicantsQuery->where('major', 'LIKE', '%' . $majorVal . '%');
            $appends['major'] = $majorVal;
        }

        if ($birthdayVal !== 'all') {
            $applicantsQuery->where('date_of_birth', $birthdayVal);
            $appends['dateofbirth'] = $birthdayVal;
        }

        if ($phoneVal !== 'all') {
            if ($phoneVal == '1') {
                $applicantsQuery->whereNotNull('phone');
            } else {
                $applicantsQuery->whereNull('phone');
            }
            $appends['phone'] = $phoneVal;
        }

        function getYearPMB()
        {
            $currentDate = new DateTime();
            $currentYear = $currentDate->format('Y');
            $currentMonth = $currentDate->format('m');
            return $currentMonth >= 10 ? $currentYear + 1 : $currentYear;
        }

        $pmbValue = getYearPMB();

        if ($pmbVal !== 'all') {
            $applicantsQuery->where('pmb', $pmbVal);
            $appends['pmb'] = $pmbVal;
        } else {
            $applicantsQuery->where('pmb', $pmbValue);
            $appends['pmb'] = $pmbValue;
        }

        if ($followVal !== 'all') {
            $applicantsQuery->where('followup_id', $followVal);
            $appends['follow'] = $followVal;
        }
        if ($sourceVal !== 'all') {
            $applicantsQuery->where('source_id', $sourceVal);
            $appends['source'] = $sourceVal;
        }
        if ($sourceDaftarVal !== 'all') {
            $applicantsQuery->where('source_daftar_id', $sourceDaftarVal);
            $appends['sourcedaftar'] = $sourceDaftarVal;
        }
        if ($statusVal !== 'all') {
            $applicantsQuery->where('status_id', $statusVal);
            $appends['status'] = $statusVal;
        }
        if ($comeVal !== 'all') {
            $applicantsQuery->where('come', $comeVal);
            $appends['come'] = $comeVal;
        }
        if ($incomeVal !== 'all') {
            $applicantsQuery->where('income_parent', $incomeVal);
            $appends['incomeparent'] = $incomeVal;
        }
        if ($planVal !== 'all') {
            $applicantsQuery->where('planning', $planVal);
            $appends['plan'] = $planVal;
        }
        if ($databaseOnline !== 'all') {
            $applicantsQuery->where('identity_user', $databaseOnline);
            $appends['databaseOnline'] = $databaseOnline;
        }
        if ($achievementVal !== 'all') {
            $applicantsQuery->where('achievement', 'LIKE', '%' . $achievementVal . '%');
            $appends['achievement'] = $achievementVal;
        }
        if ($relationVal !== 'all') {
            $applicantsQuery->where('relation', 'LIKE', '%' . $relationVal . '%');
            $appends['relation'] = $relationVal;
        }

        if ($kipVal === '1') {
            $applicantsQuery->where('kip', '<>', null);
            $appends['kip'] = $kipVal;
        } elseif ($kipVal === '0') {
            $applicantsQuery->whereNull('kip');
            $appends['kip'] = $kipVal;
        }

        if ($jobFatherVal !== 'all') {
            $applicantsQuery->whereHas('father', function ($query) use ($jobFatherVal) {
                $query->where('job', 'LIKE', '%' . $jobFatherVal . '%');
            });
            $appends['jobfather'] = $jobFatherVal;
        }

        if ($jobMotherVal !== 'all') {
            $applicantsQuery->whereHas('mother', function ($query) use ($jobMotherVal) {
                $query->where('job', 'LIKE', '%' . $jobMotherVal . '%');
            });
            $appends['jobmother'] = $jobMotherVal;
        }

        $applicants = $applicantsQuery
            ->with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])
            ->orderByDesc('created_at')
            ->paginate(5);

        $applicants->appends($appends);

        return view('pages.database.index')->with([
            'total' => $total,
            'sources' => $sources,
            'statuses' => $statuses,
            'schools' => $schools,
            'follows' => $follows,
            'users' => $users,
            'nopresenter' => $nopresenter,
            'nophone' => $nophone,
            'applicants' => $applicants
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_all()
    {
        try {
            $applicantsQuery = Applicant::query();

            $dateStart = request('datestart', 'all');
            $dateEnd = request('dateend', 'all');
            $yearGrad = request('year', 'all');
            $presenterVal = request('presenter', 'all');
            $schoolVal = request('school', 'all');
            $majorVal = request('major', 'all');
            $birthdayVal = request('dateofbirth', 'all');
            $phoneVal = request('phone', 'all');
            $pmbVal = request('pmb', 'all');
            $followVal = request('follow', 'all');
            $comeVal = request('come', 'all');
            $incomeVal = request('incomeparent', 'all');
            $planVal = request('plan', 'all');
            $sourceVal = request('source', 'all');
            $sourceDaftarVal = request('sourcedaftar', 'all');
            $statusVal = request('status', 'all');
            $achievementVal = request('achievement', 'all');
            $kipVal = request('kip', 'all');
            $relationVal = request('relation', 'all');
            $jobFatherVal = request('jobfather', 'all');
            $jobMotherVal = request('jobmother', 'all');
            $databaseOnline = request('databaseOnline', 'all');
            $statusApplicant = request('applicantstatus', 'all');
            $nameVal = request('name');

            if ($nameVal) {
                $applicantsQuery->where('name', 'LIKE', '%' . $nameVal . '%');
            }

            if (Auth::user()->role === 'P') {
                $applicantsQuery->where('identity_user', Auth::user()->identity);
            }

            if ($statusApplicant !== 'all') {
                switch ($statusApplicant) {
                    case 'database':
                        $applicantsQuery->where('is_applicant', 0);
                        $applicantsQuery->where('is_daftar', 0);
                        $applicantsQuery->where('is_register', 0);
                        break;
                    case 'aplikan':
                        $applicantsQuery->where('is_applicant', 1);
                        break;
                    case 'daftar':
                        $applicantsQuery->where('is_daftar', 1);
                        break;
                    case 'registrasi':
                        $applicantsQuery->where('is_register', 1);
                        break;
                    case 'schoolarship':
                        $applicantsQuery->where('schoolarship', 1);
                        break;
                }
            }

            if ($dateStart !== 'all' && $dateEnd !== 'all') {
                $applicantsQuery->whereBetween('created_at', [$dateStart, $dateEnd]);
            }

            if ($yearGrad !== 'all') {
                $applicantsQuery->where('year', $yearGrad);
            }

            if ($presenterVal !== 'all') {
                $applicantsQuery->where('identity_user', $presenterVal);
            }

            if ($schoolVal !== 'all') {
                $applicantsQuery->where('school', $schoolVal);
            }

            if ($majorVal !== 'all') {
                $applicantsQuery->where('major', 'LIKE', '%' . $majorVal . '%');
            }

            if ($birthdayVal !== 'all') {
                $applicantsQuery->where('date_of_birth', $birthdayVal);
            }

            if ($phoneVal !== 'all') {
                if ($phoneVal == '1') {
                    $applicantsQuery->whereNotNull('phone');
                } else {
                    $applicantsQuery->whereNull('phone');
                }
            }

            if ($pmbVal !== 'all') {
                $applicantsQuery->where('pmb', $pmbVal);
            }

            if ($followVal !== 'all') {
                $applicantsQuery->where('followup_id', $followVal);
            }
            if ($sourceVal !== 'all') {
                $applicantsQuery->where('source_id', $sourceVal);
            }
            if ($sourceDaftarVal !== 'all') {
                $applicantsQuery->where('source_daftar_id', $sourceDaftarVal);
            }
            if ($statusVal !== 'all') {
                $applicantsQuery->where('status_id', $statusVal);
            }
            if ($comeVal !== 'all') {
                $applicantsQuery->where('come', $comeVal);
            }
            if ($incomeVal !== 'all') {
                $applicantsQuery->where('income_parent', $incomeVal);
            }
            if ($planVal !== 'all') {
                $applicantsQuery->where('planning', $planVal);
            }
            if ($databaseOnline !== 'all') {
                $applicantsQuery->where('identity_user', $databaseOnline);
            }
            if ($achievementVal !== 'all') {
                $applicantsQuery->where('achievement', 'LIKE', '%' . $achievementVal . '%');
            }
            if ($relationVal !== 'all') {
                $applicantsQuery->where('relation', 'LIKE', '%' . $relationVal . '%');
            }
            if ($kipVal === '1') {
                $applicantsQuery->where('kip', '<>', null);
            } elseif ($kipVal === '0') {
                $applicantsQuery->whereNull('kip');
            }

            if ($jobFatherVal !== 'all') {
                $applicantsQuery->whereHas('father', function ($query) use ($jobFatherVal) {
                    $query->where('job', 'LIKE', '%' . $jobFatherVal . '%');
                });
            }

            if ($jobMotherVal !== 'all') {
                $applicantsQuery->whereHas('mother', function ($query) use ($jobMotherVal) {
                    $query->where('job', 'LIKE', '%' . $jobMotherVal . '%');
                });
            }
            $applicants = $applicantsQuery
                ->with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])
                ->orderByDesc('created_at')
                ->get();

            return response()->json(['applicants' => $applicants]);
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_beasiswa(Request $request)
    {
        $applicantsQuery = Applicant::query();
        $statusApplicant = $request->input('status');

        if ($statusApplicant !== 'all') {
            switch ($statusApplicant) {
                case 'database':
                    $applicantsQuery->where('is_applicant', 0);
                    $applicantsQuery->where('is_daftar', 0);
                    $applicantsQuery->where('is_register', 0);
                    break;
                case 'aplikan':
                    $applicantsQuery->where('is_applicant', 1);
                    break;
                case 'daftar':
                    $applicantsQuery->where('is_daftar', 1);
                    break;
                case 'registrasi':
                    $applicantsQuery->where('is_register', 1);
                    break;
                case 'schoolarship':
                    $applicantsQuery->where('schoolarship', 1);
                    break;
            }
            $applicants = $applicantsQuery->orderByDesc('created_at')->get();
            return response()->json(['applicants' => $applicants]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $users = User::where(['status' => '1', 'role' => 'P'])->get();
            $sources = SourceSetting::all();
            $statuses = ApplicantStatus::all();
            $programtypes = ProgramType::all();
            $schools = School::all();
            $follows = FollowUp::all();

            return view('pages.database.create')->with([
                'statuses' => $statuses,
                'programtypes' => $programtypes,
                'sources' => $sources,
                'users' => $users,
                'schools' => $schools,
                'follows' => $follows,
            ]);
        } catch (\Throwable $th) {
            $errorMessage = 'Terjadi sebuah kesalahan. Perika koneksi anda.';
            return back()->with('error', $errorMessage);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'pmb' => ['required', 'integer'],
                    'programtype_id' => ['required', 'not_in:0'],
                    'program' => ['nullable', 'string', 'not_in:Pilih program'],
                    'program_second' => ['nullable', 'string', 'not_in:Pilih program'],
                    'name' => ['required', 'string', 'max:255'],
                    'gender' => ['required', 'string', 'not_in:null'],
                    'source_id' => ['required', 'not_in:0'],
                    'status_id' => ['required', 'not_in:0'],
                    'followup_id' => ['not_in:null'],
                    'identity_user' => ['required', 'string', 'not_in:0'],
                    'school' => ['required'],
                ],
                [
                    'pmb.required' => 'Kolom PMB tidak boleh kosong, harap isi dengan angka.',
                    'pmb.integer' => 'Kolom PMB harus berupa angka.',
                    'programtype_id.required' => 'Pilih tipe program terlebih dahulu.',
                    'programtype_id.not_in' => 'Pilih tipe program yang valid.',
                    'program.required' => 'Kolom program tidak boleh kosong, harap pilih program yang diinginkan.',
                    'program.string' => 'Kolom program harus berupa teks.',
                    'program.not_in' => 'Pilih program yang valid.',
                    'program_second.string' => 'Kolom program kedua harus berupa teks.',
                    'program_second.not_in' => 'Pilih program kedua yang valid.',
                    'name.required' => 'Kolom nama tidak boleh kosong.',
                    'name.string' => 'Kolom nama harus berupa teks.',
                    'name.max' => 'Panjang nama tidak boleh melebihi 255 karakter.',
                    'gender.required' => 'Pilih jenis kelamin.',
                    'gender.not_in' => 'Pilih jenis kelamin yang valid.',
                    'source_id.required' => 'Pilih sumber informasi Anda.',
                    'source_id.not_in' => 'Pilih sumber informasi yang valid.',
                    'status_id.required' => 'Pilih status Anda.',
                    'status_id.not_in' => 'Pilih status yang valid.',
                    'followup_id.not_in' => 'Pilih opsi tindak lanjut yang valid.',
                    'identity_user.required' => 'Kolom identitas pengguna tidak boleh kosong.',
                    'identity_user.string' => 'Kolom identitas pengguna harus berupa teks.',
                    'identity_user.not_in' => 'Pilih jenis identitas pengguna yang valid.',
                    'school.required' => 'Kolom sekolah tidak boleh kosong.',
                ],
            );

            $identity_val = Str::uuid();

            $schoolCheck = School::where('id', $request->input('school'))->first();
            $schoolNameCheck = School::where('name', $request->input('school'))->first();

            if ($schoolCheck) {
                $school = $schoolCheck->id;
            } else {
                if ($schoolNameCheck) {
                    $school = $schoolNameCheck->id;
                } else {
                    $dataSchool = [
                        'name' => strtoupper($request->input('school')),
                        'region' => 'TIDAK DIKETAHUI',
                    ];
                    $schoolCreate = School::create($dataSchool);
                    $school = $schoolCreate->id;
                }
            }

            $data_applicant = [
                'identity' => $identity_val,
                'pmb' => $request->input('pmb'),
                'name' => ucwords(strtolower($request->input('name'))),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'school' => $school,
                'note' => $request->input('note'),
                'identity_user' => $request->input('identity_user'),
                'program' => $request->input('programtype_id') == 3 ? null : $request->input('program'),
                'program_second' => $request->input('programtype_id') == 3 ? null : $request->input('program_second'),
                'isread' => '0',
                'followup_id' => $request->input('followup_id'),
                'programtype_id' => $request->input('programtype_id') == 3 ? null : $request->input('programtype_id'),
                'source_id' => $request->input('source_id'),
                'status_id' => $request->input('status_id'),
            ];

            $data_father = [
                'identity_user' => $identity_val,
                'gender' => 1,
            ];
            $data_mother = [
                'identity_user' => $identity_val,
                'gender' => 0,
            ];

            $applicant = Applicant::create($data_applicant);
            ApplicantFamily::create($data_father);
            ApplicantFamily::create($data_mother);

            return redirect()->route('database.show', $applicant->identity)->with('message', 'Berhasil menambahkan data ' . $applicant->name);

        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                $errorMessage = 'Terjadi duplikat data, silahkan periksa ke bagian admin.';
                return back()->with('error', $errorMessage);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identity)
    {
        $user = Applicant::with(['SchoolApplicant', 'SourceSetting', 'sourceDaftarSetting'])
            ->where('identity', $identity)
            ->firstOrFail();
        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {
            $father = ApplicantFamily::where(['identity_user' => $identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $identity, 'gender' => 0])->first();

            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            $account = User::where(['email' => $user->email, 'identity' => $user->identity])->count();
            $profile = User::where(['identity' => $user->identity])->first();

            $status_applicant = StatusApplicantsApplicant::where('identity_user', $identity)->first();
            $enrollment = StatusApplicantsEnrollment::where('identity_user', $identity)->first();
            $registration = StatusApplicantsRegistration::where('identity_user', $identity)->first();

            $integration_misil = Integration::where(['identity_user' => $identity, 'platform' => 'misil'])->first();

            return view('pages.database.show.profile')->with([
                'user' => $user,
                'enrollment' => $enrollment,
                'registration' => $registration,
                'status_applicant' => $status_applicant,
                'father' => $father,
                'mother' => $mother,
                'account' => $account,
                'profile' => $profile,
                'integration_misil' => $integration_misil,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function chats($identity)
    {
        $user = Applicant::with(['SchoolApplicant', 'SourceDaftarSetting'])
            ->where('identity', $identity)
            ->firstOrFail();

        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {
            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.chat')->with([
                'user' => $user,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
        return view('pages.database.show.chat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function achievements($identity)
    {
        $user = Applicant::with(['SchoolApplicant', 'SourceDaftarSetting'])
            ->where('identity', $identity)
            ->firstOrFail();

        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {
            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.achievement')->with([
                'user' => $user,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
        return view('pages.database.show.achievement');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function organizations($identity)
    {
        $user = Applicant::with(['SchoolApplicant', 'SourceDaftarSetting'])
            ->where('identity', $identity)
            ->firstOrFail();

        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {
            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.organization')->with([
                'user' => $user,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
        return view('pages.database.show.organization');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function scholarships($identity)
    {
        $user = Applicant::with(['SchoolApplicant', 'SourceDaftarSetting'])
            ->where('identity', $identity)
            ->firstOrFail();

        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A') {
            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.scholarship')->with([
                'user' => $user,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
        return view('pages.database.show.scholarship');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function files($identity)
    {
        $user = Applicant::with(['SchoolApplicant', 'SourceDaftarSetting'])
            ->where('identity', $identity)
            ->firstOrFail();
        if (Auth::user()->identity == $user->identity_user || Auth::user()->role == 'A' || Auth::user()->role == 'P') {
            $userupload = UserUpload::with('fileupload')
                ->where('identity_user', $identity)
                ->get();
            $data = [];
            foreach ($userupload as $upload) {
                $data[] = $upload->fileupload_id;
            }

            $success = FileUpload::whereIn('id', $data)->get();
            $fileupload = FileUpload::whereNotIn('id', $data)->get();

            if (Auth::user()->role == 'P') {
                $user = Applicant::where(['identity' => $identity, 'identity_user' => Auth::user()->identity])->firstOrFail();
            } elseif (Auth::user()->role == 'A') {
                $user = Applicant::where(['identity' => $identity])->firstOrFail();
            }

            return view('pages.database.show.file')->with([
                'user' => $user,
                'userupload' => $userupload,
                'fileupload' => $fileupload,
                'success' => $success,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);
        if (Auth::user()->identity == $applicant->identity_user || Auth::user()->role == 'A') {
            //            $response = Http::get('https://dashboard.politekniklp3i-tasikmalaya.ac.id/api/programs');

            $presenters = User::where(['status' => '1', 'role' => 'P'])->get();
            $sources = SourceSetting::all();
            $statuses = ApplicantStatus::all();
            $programtypes = ProgramType::all();
            $schools = School::all();
            $follows = FollowUp::all();
            $account = User::where('email', $applicant->email)->count();
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();

            //            if ($response->successful()) {
//                $programs = $response->json();
//            } else {
//                $programs = null;
//            }

            $applicant = Applicant::with(['SchoolApplicant', 'SourceSetting', 'sourceDaftarSetting'])->findOrFail($id);
            return view('pages.database.edit')->with([
                'applicant' => $applicant,
                //                'programs' => $programs,
                'presenters' => $presenters,
                'programtypes' => $programtypes,
                'account' => $account,
                'father' => $father,
                'mother' => $mother,
                'sources' => $sources,
                'statuses' => $statuses,
                'schools' => $schools,
                'follows' => $follows,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'pmb' => ['required', 'integer'],
                'programtype_id' => ['not_in:Pilih program'],
                'nik' => ['nullable', 'min:16', 'max:16', Rule::unique('applicants')->ignore($id, 'id')],
                'nisn' => ['nullable', 'min:10', 'max:10', Rule::unique('applicants')->ignore($id, 'id')],
                'kip' => ['nullable', 'min:16', 'max:16', Rule::unique('applicants')->ignore($id, 'id')],
                'name' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'not_in:null'],
                'source_id' => ['required', 'not_in:0'],
                'source_daftar_id' => ['required', 'not_in:0'],
                'status_id' => ['required', 'not_in:0'],
                'followup_id' => ['not_in:null'],
                'program' => ['string'],
                'program_second' => ['string'],
                'identity_user' => ['required', 'string', 'not_in:0'],
            ],
            [
                'pmb.required' => 'Kolom PMB tidak boleh kosong, harap isi dengan angka.',
                'pmb.integer' => 'Kolom PMB harus berupa angka.',
                'programtype_id.not_in' => 'Pilih tipe program yang valid.',
                'nik.unique' => 'Oops, Nomor Induk Kependudukan (NIK) sudah terdaftar nih, coba yang lain!',
                'nik.min' => 'Format NIK nggak bener, harus :min digit ya!',
                'nik.max' => 'Format NIK nggak bener, maksimal :max digit ya!',
                'nisn.unique' => 'Waduh, NISN sudah terdaftar nih, cari yang lain ya!',
                'nisn.min' => 'Format NISN nggak bener, harus :min digit ya!',
                'nisn.max' => 'Format NISN nggak bener, maksimal :max digit ya!',
                'kip.unique' => 'Waduh, Nomor Kartu Indonesia Pintar (KIP) sudah terdaftar nih, cari yang lain ya!',
                'kip.min' => 'Format KIP nggak bener, harus :min digit ya!',
                'kip.max' => 'Format KIP nggak bener, maksimal :max digit ya!',
                'name.required' => 'Kolom nama tidak boleh kosong.',
                'name.string' => 'Kolom nama harus berupa teks.',
                'name.max' => 'Panjang nama tidak boleh melebihi 255 karakter.',
                'gender.required' => 'Pilih jenis kelamin.',
                'gender.not_in' => 'Pilih jenis kelamin yang valid.',
                'source_id.required' => 'Pilih sumber informasi Anda.',
                'source_id.not_in' => 'Pilih sumber informasi yang valid.',
                'source_daftar_id.required' => 'Pilih sumber pendaftaran Anda.',
                'source_daftar_id.not_in' => 'Pilih sumber pendaftaran yang valid.',
                'status_id.required' => 'Pilih status Anda.',
                'status_id.not_in' => 'Pilih status yang valid.',
                'followup_id.not_in' => 'Pilih opsi tindak lanjut yang valid.',
                'program.string' => 'Kolom program harus berupa teks.',
                'program.not_in' => 'Pilih program yang valid.',
                'program_second.string' => 'Kolom program kedua harus berupa teks.',
                'program_second.not_in' => 'Pilih program kedua yang valid.',
                'identity_user.required' => 'Kolom identitas pengguna tidak boleh kosong.',
                'identity_user.string' => 'Kolom identitas pengguna harus berupa teks.',
                'identity_user.not_in' => 'Pilih jenis identitas pengguna yang valid.',
            ],
        );

        $applicant = Applicant::findOrFail($id);
        $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
        $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
        $user_detail = User::where('identity', $applicant->identity)->first();

        if ($user_detail !== null) {
            $data_user = [
                'name' => ucwords(strtolower($request->input('name'))),
                'email' => $request->input('email'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone'),
            ];
            $user = User::findOrFail($user_detail->id);
            $user->update($data_user);
        }

        $rt_digit = strlen($request->input('rt')) < 2 ? '0' . $request->input('rt') : $request->input('rt');
        $rw_digit = strlen($request->input('rw')) < 2 ? '0' . $request->input('rw') : $request->input('rw');

        $place = $request->input('place') !== null ? ucwords(strtolower($request->input('place'))) . ', ' : null;
        $rt = $request->input('rt') !== null ? 'RT. ' . $rt_digit . ' ' : null;
        $rw = $request->input('rw') !== null ? 'RW. ' . $rw_digit . ', ' : null;
        $kel = $request->input('villages') !== null ? 'Desa/Kelurahan ' . ucwords(strtolower($request->input('villages'))) . ', ' : null;
        $kec = $request->input('districts') !== null ? 'Kecamatan ' . ucwords(strtolower($request->input('districts'))) . ', ' : null;
        $reg = $request->input('regencies') !== null ? 'Kota/Kabupaten ' . ucwords(strtolower($request->input('regencies'))) . ', ' : null;
        $prov = $request->input('provinces') !== null ? 'Provinsi ' . ucwords(strtolower($request->input('provinces'))) . ', ' : null;
        $postal = $request->input('postal_code') !== null ? 'Kode Pos ' . $request->input('postal_code') : null;

        $address_applicant = $place . $rt . $rw . $kel . $kec . $reg . $prov . $postal;

        $schoolInput = $request->input('school');

        if (empty($schoolInput)) {
            $school = null;
        } else {
            $schoolCheck = School::where('id', $schoolInput)->first();
            $schoolNameCheck = School::where('name', $schoolInput)->first();
            if ($schoolCheck) {
                $school = $schoolCheck->id;
            } else {
                if ($schoolNameCheck) {
                    $school = $schoolNameCheck->id;
                } else {
                    $dataSchool = [
                        'name' => strtoupper($schoolInput),
                        'region' => 'TIDAK DIKETAHUI',
                    ];
                    $schoolCreate = School::create($dataSchool);
                    $school = $schoolCreate->id;
                }
            }
        }

        $data = [
            'pmb' => $request->input('pmb'),

            'nik' => $request->input('nik'),
            'nisn' => $request->input('nisn'),

            'name' => ucwords(strtolower($request->input('name'))),
            'gender' => $request->input('gender'),
            'place_of_birth' => $request->input('place_of_birth'),
            'date_of_birth' => $request->input('date_of_birth'),
            'religion' => $request->input('religion'),
            'address' => $request->input('address') == null ? $address_applicant : $request->input('address'),
            'social_media' => $request->input('social_media'),

            'email' => $request->input('email'),
            'phone' => $request->input('phone'),

            'school' => $school,
            'major' => $request->input('major'),
            'class' => $request->input('class'),
            'year' => $request->input('year'),
            'achievement' => $request->input('achievement'),
            'kip' => $request->input('kip'),

            'note' => $request->input('note'),
            'relation' => $request->input('relation'),

            'identity_user' => $request->input('identity_user'),
            'program' => $request->input('programtype_id') == 3 ? null : $request->input('program'),
            'program_second' => $request->input('programtype_id') == 3 ? null : $request->input('program_second'),
            'isread' => $request->input('isread'),
            'come' => $request->input('come') == 'null' ? null : $request->input('come'),

            'known' => $request->input('known') == 'null' ? null : $request->input('known'),
            'planning' => $request->input('planning') == 'null' ? null : $request->input('planning'),
            'other_campus' => $request->input('other_campus'),
            'income_parent' => $request->input('income_parent') == 'null' ? null : $request->input('income_parent'),

            'followup_id' => $request->input('followup_id'),
            'programtype_id' => $request->input('programtype_id') == 3 ? null : $request->input('programtype_id'),
            'source_id' => $request->input('source_id'),
            'source_daftar_id' => $request->input('source_daftar_id'),
            'status_id' => $request->input('status_id'),
        ];

        $father_rt_digit = strlen($request->input('father_rt')) < 2 ? '0' . $request->input('father_rt') : $request->input('father_rt');
        $father_rw_digit = strlen($request->input('father_rw')) < 2 ? '0' . $request->input('father_rw') : $request->input('father_rw');

        $father_place = $request->input('father_rt') !== null ? ucwords(strtolower($request->input('father_place'))) . ', ' : null;
        $father_rt = $request->input('father_rt') !== null ? 'RT. ' . $father_rt_digit . ' ' : null;
        $father_rw = $request->input('father_rw') !== null ? 'RW. ' . $father_rw_digit . ', ' : null;
        $father_kel = $request->input('father_villages') !== null ? 'Desa/Kelurahan ' . ucwords(strtolower($request->input('father_villages'))) . ', ' : null;
        $father_kec = $request->input('father_districts') !== null ? 'Kecamatan ' . ucwords(strtolower($request->input('father_districts'))) . ', ' : null;
        $father_reg = $request->input('father_regencies') !== null ? 'Kota/Kabupaten ' . ucwords(strtolower($request->input('father_regencies'))) . ', ' : null;
        $father_prov = $request->input('father_provinces') !== null ? 'Provinsi ' . ucwords(strtolower($request->input('father_provinces'))) . ', ' : null;
        $father_postal = $request->input('father_postal_code') !== null ? 'Kode Pos ' . ucwords(strtolower($request->input('father_postal_code'))) : null;

        $address_father = $father_place . $father_rt . $father_rw . $father_kel . $father_kec . $father_reg . $father_prov . $father_postal;

        $data_father = [
            'name' => ucwords($request->input('father_name')),
            'job' => $request->input('father_job'),
            'place_of_birth' => $request->input('father_place_of_birth'),
            'date_of_birth' => $request->input('father_date_of_birth'),
            'education' => $request->input('father_education'),
            'phone' => strpos($request->input('father_phone'), '0') === 0 ? '62' . substr($request->input('father_phone'), 1) : $request->input('father_phone'),
            'address' => $request->input('father_address') == null ? $address_father : $request->input('father_address'),
        ];

        $mother_rt_digit = strlen($request->input('mother_rt')) < 2 ? '0' . $request->input('mother_rt') : $request->input('mother_rt');
        $mother_rw_digit = strlen($request->input('mother_rw')) < 2 ? '0' . $request->input('mother_rw') : $request->input('mother_rw');

        $mother_place = $request->input('mother_rt') !== null ? ucwords(strtolower($request->input('mother_place'))) . ', ' : null;
        $mother_rt = $request->input('mother_rt') !== null ? 'RT. ' . $mother_rt_digit . ' ' : null;
        $mother_rw = $request->input('mother_rw') !== null ? 'RW. ' . $mother_rw_digit . ', ' : null;
        $mother_kel = $request->input('mother_villages') !== null ? 'Desa/Kelurahan ' . ucwords(strtolower($request->input('mother_villages'))) . ', ' : null;
        $mother_kec = $request->input('mother_districts') !== null ? 'Kecamatan ' . ucwords(strtolower($request->input('mother_districts'))) . ', ' : null;
        $mother_reg = $request->input('mother_regencies') !== null ? 'Kota/Kabupaten ' . ucwords(strtolower($request->input('mother_regencies'))) . ', ' : null;
        $mother_prov = $request->input('mother_provinces') !== null ? 'Provinsi ' . ucwords(strtolower($request->input('mother_provinces'))) . ', ' : null;
        $mother_postal = $request->input('mother_postal_code') !== null ? 'Kode Pos ' . ucwords(strtolower($request->input('mother_postal_code'))) : null;

        $address_father = $mother_place . $mother_rt . $mother_rw . $mother_kel . $mother_kec . $mother_reg . $mother_prov . $mother_postal;

        $data_mother = [
            'name' => ucwords($request->input('mother_name')),
            'job' => $request->input('mother_job'),
            'place_of_birth' => $request->input('mother_place_of_birth'),
            'date_of_birth' => $request->input('mother_date_of_birth'),
            'education' => $request->input('mother_education'),
            'phone' => strpos($request->input('mother_phone'), '0') === 0 ? '62' . substr($request->input('mother_phone'), 1) : $request->input('mother_phone'),
            'address' => $request->input('mother_address') == null ? $address_father : $request->input('mother_address'),
        ];

        $applicant->update($data);
        $father->update($data_father);
        $mother->update($data_mother);

        return back()->with('message', 'Data aplikan berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        if (Auth::user()->identity == $applicant->identity_user || Auth::user()->role == 'A') {
            $family = ApplicantFamily::where('identity_user', $applicant->identity);
            $status_applicant_applicant = StatusApplicantsApplicant::where('identity_user', $applicant->identity);
            $user_upload = UserUpload::where('identity_user', $applicant->identity);
            $organization = Organization::where('identity_user', $applicant->identity);
            $achievement = Achievement::where('identity_user', $applicant->identity);
            $integration = Integration::where('identity_user', $applicant->identity);
            $recommendation = Recommendation::where('identity_user', $applicant->identity);
            $user = User::where('identity', $applicant->identity);
            $user->delete();
            $family->delete();
            $applicant->delete();
            $user_upload->delete();
            $organization->delete();
            $achievement->delete();
            $integration->delete();
            $recommendation->delete();
            $status_applicant_applicant->delete();
            return redirect()->route('database.index')->with('message', 'Data aplikan berhasil dihapus!');
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $applicant = Applicant::with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])
            ->where('identity', $id)
            ->firstOrFail();
        $user = User::where('identity', $id)->firstOrFail();
        $enrollment = StatusApplicantsEnrollment::where('identity_user', $id)->first();
        $registration = StatusApplicantsRegistration::where('identity_user', $id)->first();
        if (Auth::user()->identity == $applicant->identity_user || Auth::user()->role == 'A') {
            $father = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 1])->first();
            $mother = ApplicantFamily::where(['identity_user' => $applicant->identity, 'gender' => 0])->first();
            return view('pages.database.print')->with([
                'applicant' => $applicant,
                'father' => $father,
                'mother' => $mother,
                'user' => $user,
                'enrollment' => $enrollment,
                'registration' => $registration,
            ]);
        } else {
            return back()->with('error', 'Tidak diizinkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($dateStart = null, $dateEnd = null, $yearGrad = null, $schoolVal = null, $birthdayVal = null, $pmbVal = null, $sourceVal = null, $statusVal = null)
    {
        return (new ApplicantsExport($dateStart, $dateEnd, $yearGrad, $schoolVal, $birthdayVal, $pmbVal, $sourceVal, $statusVal))->download('applicants.xlsx');
    }

    public function update_data($student, $applicants, $i, $phone, $school, $gender, $come, $kip, $known, $program, $samePhone = null)
    {
        $scholarship = 0;
        if (!empty($applicants[$i][33])) {
            if ($applicants[$i][33] == 'YA') {
                $scholarship = 1;
            }
        }

        $followup = null;
        if (!empty($applicants[$i][18])) {
            $followupRecord = FollowUp::where('name', $applicants[$i][18])->first();
            $followup = $followupRecord ? $followupRecord->id : null;
        }

        $data_applicant = [
            'pmb' => $applicants[$i][2],
            'name' => !empty($applicants[$i][3]) ? ucwords(strtolower($applicants[$i][3])) : null,
            'phone' => $samePhone == null ? $phone : null,
            'email' => $samePhone == null ? $phone . "@lp3i.ac.id" : null,
            'education' => !empty($applicants[$i][6]) ? $applicants[$i][6] : null,
            'school' => $school,
            'major' => !empty($applicants[$i][8]) ? $applicants[$i][8] : null,
            'year' => !empty($applicants[$i][10]) ? $applicants[$i][10] : null,
            'place_of_birth' => !empty($applicants[$i][11]) ? $applicants[$i][11] : null,
            'date_of_birth' => !empty($applicants[$i][12]) ? date('Y-m-d', strtotime($applicants[$i][12])) : null,
            'gender' => $gender,
            'religion' => !empty($applicants[$i][14]) ? $applicants[$i][14] : null,
            'source_id' => 7,
            'status_id' => !empty($applicants[$i][17]) ? ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($applicants[$i][17])])->value('id') ?? 1 : 1,
            'followup_id' => $followup,
            'come' => $come,
            'achievement' => !empty($applicants[$i][20]) ? $applicants[$i][20] : null,
            'kip' => $kip,
            'relation' => !empty($applicants[$i][27]) ? $applicants[$i][27] : null,
            'known' => $known,
            'planning' => !empty($applicants[$i][29]) ? $applicants[$i][29] : null,
            'program' => $program,
            'other_campus' => !empty($applicants[$i][31]) ? $applicants[$i][31] : null,
            'income_parent' => !empty($applicants[$i][26]) ? $applicants[$i][26] : null,
            'social_media' => !empty($applicants[$i][32]) ? $applicants[$i][32] : null,
            'note' => 'Data berhasil diimport dari file excel',

            /* Scholarship */
            'schoolarship' => $scholarship,
            'is_applicant' => $scholarship == 1 ? 1 : 0,
            'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
        ];

        $data_father = [
            'name' => $applicants[$i][21] ?? null,
            'phone' => strval($applicants[$i][23] ?? ''),
            'job' => $applicants[$i][24] ?? null,
        ];

        $data_mother = [
            'name' => $applicants[$i][22] ?? null,
            'job' => $applicants[$i][25] ?? null,
        ];

        $applicantFather = ApplicantFamily::where(['identity_user' => $student->identity, 'gender' => 1])->first();
        $applicantMother = ApplicantFamily::where(['identity_user' => $student->identity, 'gender' => 0])->first();

        if ($applicantFather) {
            $applicantFather->update($data_father);
        }
        if ($applicantMother) {
            $applicantMother->update($data_mother);
        }
        $student->update($data_applicant);

        if ($scholarship == 1) {
            $account = User::where(['identity' => $student->identity, 'phone' => $student->phone])->count();
            if ($account == 0) {
                User::create([
                    'identity' => $student->identity,
                    'name' => ucwords(strtolower($student->name)),
                    'gender' => $student->gender ? 1 : 0,
                    'email' => $student->phone . "@lp3i.ac.id",
                    'password' => Hash::make($student->phone),
                    'phone' => $student->phone,
                    'role' => 'S',
                    'status' => 1,
                ]);
            }
        }

    }

    public function update_data_duplicate($student, $applicants, $i)
    {
        $scholarship = 0;
        if (!empty($applicants[$i][33])) {
            if ($applicants[$i][33] == 'YA') {
                $scholarship = 1;
            }
        }

        $followup = null;
        if (!empty($applicants[$i][18])) {
            $followupRecord = FollowUp::where('name', $applicants[$i][18])->first();
            $followup = $followupRecord ? $followupRecord->id : null;
        }

        $data_applicant = [
            'pmb' => $applicants[$i][2],
            'email' => $student->phone . "@lp3i.ac.id",
            'year' => !empty($applicants[$i][10]) ? $applicants[$i][10] : null,
            'schoolarship' => $scholarship,
            'is_applicant' => $scholarship == 1 ? 1 : 0,
            'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
            'note' => 'Duplicate entry detected (Error Code: 10621)ww',
            'followup_id' => $followup
        ];

        $student->update($data_applicant);

        if ($scholarship == 1) {
            $account = User::where(['identity' => $student->identity, 'phone' => $student->phone])->count();
            if ($account == 0) {
                User::create([
                    'identity' => $student->identity,
                    'name' => ucwords(strtolower($student->name)),
                    'gender' => $student->gender ? 1 : 0,
                    'email' => $student->phone . "@lp3i.ac.id",
                    'password' => Hash::make($student->phone),
                    'phone' => $student->phone,
                    'role' => 'S',
                    'status' => 1,
                ]);
            }
        }
    }

    public function create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $create_father, $create_mother, $samePhone = null)
    {
        $scholarship = 0;
        if (!empty($applicants[$i][33])) {
            if ($applicants[$i][33] == 'YA') {
                $scholarship = 1;
            }
        }

        $followup = null;
        if (!empty($applicants[$i][18])) {
            $followupRecord = FollowUp::where('name', $applicants[$i][18])->first();
            $followup = $followupRecord ? $followupRecord->id : null;
        }

        $data_applicant = [
            'identity' => $applicants[$i][1],
            'pmb' => $applicants[$i][2],
            'name' => !empty($applicants[$i][3]) ? ucwords(strtolower($applicants[$i][3])) : null,
            'phone' => $samePhone == null ? $phone : null,
            'email' => $samePhone == null ? $phone . "@lp3i.ac.id" : null,
            'education' => !empty($applicants[$i][6]) ? $applicants[$i][6] : null,
            'school' => $school,
            'major' => !empty($applicants[$i][8]) ? $applicants[$i][8] : null,
            'year' => !empty($applicants[$i][10]) ? $applicants[$i][10] : null,
            'place_of_birth' => !empty($applicants[$i][11]) ? $applicants[$i][11] : null,
            'date_of_birth' => !empty($applicants[$i][12]) ? date('Y-m-d', strtotime($applicants[$i][12])) : null,
            'gender' => $gender,
            'religion' => !empty($applicants[$i][14]) ? $applicants[$i][14] : null,
            'identity_user' => $identityUser,
            'source_id' => 7,
            'status_id' => !empty($applicants[$i][17]) ? ApplicantStatus::whereRaw('LOWER(name) = ?', [strtolower($applicants[$i][17])])->value('id') ?? 1 : 1,
            'followup_id' => $followup,
            'come' => $come,
            'achievement' => !empty($applicants[$i][20]) ? $applicants[$i][20] : null,
            'kip' => $kip,
            'relation' => !empty($applicants[$i][27]) ? $applicants[$i][27] : null,
            'known' => $known,
            'planning' => !empty($applicants[$i][29]) ? $applicants[$i][29] : null,
            'program' => $program,
            'other_campus' => !empty($applicants[$i][31]) ? $applicants[$i][31] : null,
            'income_parent' => !empty($applicants[$i][26]) ? $applicants[$i][26] : null,
            'social_media' => !empty($applicants[$i][32]) ? $applicants[$i][32] : null,

            /* Scholarship */
            'schoolarship' => $scholarship,
            'is_applicant' => $scholarship == 1 ? 1 : 0,
            'scholarship_date' => Carbon::now()->setTimezone('Asia/Jakarta'),
        ];

        ApplicantFamily::create($create_father);
        ApplicantFamily::create($create_mother);
        $student = Applicant::create($data_applicant);

        if ($scholarship == 1) {
            $account = User::where(['identity' => $student->identity, 'phone' => $student->phone])->count();
            if ($account == 0) {
                User::create([
                    'identity' => $student->identity,
                    'name' => ucwords(strtolower($student->name)),
                    'gender' => $student->gender ? 1 : 0,
                    'email' => $student->phone . '@lp3i.ac.id',
                    'password' => Hash::make($student->phone),
                    'phone' => $student->phone,
                    'role' => 'S',
                    'status' => 1,
                ]);
            }
        }
    }

    public function studentsHandle($person, $identityUser, $start, $end, $macro)
    {

        $response = Http::get('https://script.google.com/macros/s/' . $macro . '/exec?person=' . $person);

        $applicants = $response->json();

        for ($i = $start; $i < $end; $i++) {
            $phone = null;

            if (!empty($applicants[$i][4]) && strlen($applicants[$i][4]) > 8) {
                if (substr($applicants[$i][4], 0, 1) === '0') {
                    $phone = '62' . substr($applicants[$i][4], 1);
                } else {
                    $phone = '62' . $applicants[$i][4];
                }
            }

            $come = 0;

            if (strcasecmp($applicants[$i][19], 'SUDAH') === 0) {
                $come = 1;
            } elseif (strcasecmp($applicants[$i][19], 'BELUM') === 0) {
                $come = 0;
            }

            $kip = null;

            $known = null;

            if (strcasecmp($applicants[$i][28], 'YA') === 0) {
                $known = 1;
            } elseif (strcasecmp($applicants[$i][28], 'TIDAK') === 0) {
                $known = 0;
            }

            $gender = null;

            if ($applicants[$i][13] === 'WANITA' || $applicants[$i][13] === 'PEREMPUAN') {
                $gender = 0;
            } elseif ($applicants[$i][13] === null) {
                $gender = null;
            } else {
                $gender = 1;
            }

            $schoolName = $applicants[$i][7];

            if (empty($schoolName)) {
                $school = null;
            } else {
                $schoolCheck = School::where('id', $schoolName)->first();
                $schoolNameCheck = School::where('name', $schoolName)->first();

                if ($schoolCheck) {
                    $school = $schoolCheck->id;
                } else {
                    if ($schoolNameCheck) {
                        $school = $schoolNameCheck->id;
                    } else {
                        $dataSchool = [
                            'name' => strtoupper($schoolName),
                            'region' => 'TIDAK DIKETAHUI',
                        ];
                        $schoolCreate = School::create($dataSchool);
                        $school = $schoolCreate->id;
                    }
                }
            }

            $program = null;

            if (!empty($applicants[$i][30])) {
                switch ($applicants[$i][30]) {
                    case 'AB':
                        $program = 'D3 Administrasi Bisnis';
                        break;
                    case 'MI':
                        $program = 'D3 Manajemen Informatika';
                        break;
                    case 'MKP':
                        $program = 'D3 Manajemen Keuangan Perbankan';
                        break;
                    case 'MP':
                        $program = 'D3 Manajemen Pemasaran';
                        break;
                    case 'TO':
                        $program = 'Teknik Otomotif Vokasi 2 Tahun';
                        break;
                    default:
                        $program = null;
                }
            }

            $create_father = [
                'identity_user' => $applicants[$i][1],
                'name' => $applicants[$i][21] ?? null,
                'phone' => strval($applicants[$i][23] ?? ''),
                'gender' => 1,
                'job' => $applicants[$i][24] ?? null,
            ];
            $create_mother = [
                'identity_user' => $applicants[$i][1],
                'name' => $applicants[$i][22] ?? null,
                'gender' => 0,
                'job' => $applicants[$i][25] ?? null,
            ];

            if (!empty($applicants[$i][0]) && !empty($applicants[$i][1]) && !empty($applicants[$i][2]) && !empty($applicants[$i][3])) {
                if ($phone) {
                    $studentDataPhone = Applicant::where(['identity' => $applicants[$i][1], 'phone' => $phone])->first();
                    if ($studentDataPhone) {
                        if ($studentDataPhone->is_applicant == 0) {
                            $this->update_data($studentDataPhone, $applicants, $i, $phone, $school, $gender, $come, $kip, $known, $program);
                        } else if ($studentDataPhone->is_applicant == 1 && $studentDataPhone->schoolarship == 1) {
                            $this->update_data($studentDataPhone, $applicants, $i, $phone, $school, $gender, $come, $kip, $known, $program);
                        }
                    } else {
                        $studentData = Applicant::where('identity', $applicants[$i][1])->first();
                        if ($studentData) {
                            if ($studentData->is_applicant == 0) {
                                $studentPhone = Applicant::where('phone', $phone)->first();
                                if ($studentPhone) {
                                    if ($studentPhone->is_applicant == 0 && $studentPhone->is_daftar == 0 && $studentPhone->is_register == 0 && $studentPhone->schoolarship == 0) {
                                        $samePhone = true;
                                        $this->update_data($studentData, $applicants, $i, $phone, $school, $gender, $come, $kip, $known, $program, $samePhone);
                                    }
                                } else {
                                    $this->update_data($studentData, $applicants, $i, $phone, $school, $gender, $come, $kip, $known, $program, );
                                }
                            }
                        } else {
                            $studentPhoneDup = Applicant::where('phone', $phone)->first();
                            if ($studentPhoneDup) {
                                $samePhone = true;
                                $this->update_data_duplicate($studentPhoneDup, $applicants, $i);
                            } else {
                                $this->create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $create_father, $create_mother);
                            }
                        }
                    }
                } else {
                    $studentData = Applicant::where('identity', $applicants[$i][1])->first();
                    if ($studentData) {
                        $samePhone = true;
                        $this->update_data($studentData, $applicants, $i, $phone, $school, $gender, $come, $kip, $known, $program, $samePhone);
                    } else {
                        $samePhone = true;
                        $this->create_data($applicants, $i, $phone, $school, $gender, $identityUser, $come, $kip, $known, $program, $create_father, $create_mother, $samePhone);
                    }
                }
            }
        }
    }

    public function check_spreadsheet($sheet, $macro)
    {
        try {
            $response = Http::get('https://script.google.com/macros/s/' . $macro . '/exec?person=' . $sheet);
            $applicants = $response->json();
            return response()->json([
                'applicants' => count($applicants)
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function import()
    {
        try {
            if (Auth::user()->role == 'P' && Auth::user()->sheet) {
                $start = request('start', 'all');
                $end = request('end', 'all');
                $macro = request('macro');
                $this->studentsHandle(Auth::user()->sheet, Auth::user()->identity, $start, $end, $macro);

                return response()->json([
                    'message' => 'Data ' . Auth::user()->name . ' berhasil disinkronisasi dari Spreadsheet',
                ]);
            } else {
                return response()->json([
                    'message' => 'Presenter / Sheet tidak ditemukan.',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Terjadi error saat sinkronisasi',
                'error' => $th->getMessage(), // Ini akan memberikan pesan error yang lebih deskriptif
                'trace' => $th->getTraceAsString(), // Ini akan menampilkan jejak stack trace dari error
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function is_applicant(Request $request, $id)
    {

        $request->validate([
            'change_pmb' => ['required'],
            'identity_user' => ['required'],
            'session' => ['required'],
        ]);


        $applicant = Applicant::findOrFail($id);
        $data_applicant = [
            'is_applicant' => 1,
        ];
        $status_applicant = [
            'pmb' => $request->input('change_pmb'),
            'identity_user' => $request->input('identity_user'),
            'session' => $request->input('session'),
            'date' => now()->format('Y-m-d'),
        ];
        $applicant->update($data_applicant);
        StatusApplicantsApplicant::create($status_applicant);
        return back()->with('message', 'Data aplikan berhasil diupdate');
    }

    public function delete_is_applicant($id)
    {
        $applicant = Applicant::findOrFail($id);
        $data_applicant = [
            'is_applicant' => 0,
        ];
        $status_applicant = StatusApplicantsApplicant::where('identity_user', $applicant->identity)->firstOrFail();
        $applicant->update($data_applicant);
        $status_applicant->delete();
        return back()->with('message', 'Data aplikan berhasil dihapus');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function is_schoolarship(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $data = [
            'schoolarship' => $applicant->schoolarship == 1 ? 0 : 1,
            'scholarship_date' => $applicant->schoolarship == 1 ? null : Carbon::now()->setTimezone('Asia/Jakarta'),
        ];
        $applicant->update($data);
        return back()->with('message', 'Data aplikan berhasil diupdate');
    }
}
