<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\ProgramType;
use App\Models\StatusApplicantsApplicant;
use DateTime;
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\EventDetail;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function index(): \Illuminate\Contracts\View\View
    {
        $event_query = Event::query();

        function getYearPMB()
        {
            $currentDate = new DateTime();
            $currentYear = $currentDate->format('Y');
            $currentMonth = $currentDate->format('m');
            return $currentMonth >= 10 ? $currentYear + 1 : $currentYear;
        }

        $titleVal = request('title');
        $pmb = request('pmb', getYearPMB());

        $appends = [];

        if ($titleVal) {
            $event_query->where('title', 'like', '%' . $titleVal . '%');
            $appends['title'] = $titleVal;
        }

        if ($pmb) {
            $event_query->where('pmb', $pmb);
            $appends['pmb'] = $pmb;
        }

        $events = $event_query->paginate(10);
        $program_types = ProgramType::where('status', 1)->get();
        return view('pages.menu.event.index', compact('events', 'program_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('pages.menu.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store_event(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'min:10', 'max:13'],
                'school' => ['required', 'max:100', 'not_in:Pilih Sekolah'],
                'major' => ['required'],
                'information' => ['required'],
            ], [
                'name.required' => 'Nama Lengkap harus diisi',
                'name.max' => 'Nama Lengkap maksimal 255 karakter',
                'phone.required' => 'Nomor Telepon harus diisi',
                'phone.min' => 'Nomor Telepon minimal 10 karakter',
                'phone.max' => 'Nomor Telepon maksimal 13 karakter',
                'school.required' => 'Sekolah harus diisi',
                'school.max' => 'Sekolah maksimal 100 karakter',
                'school.not_in' => 'Sekolah harus dipilih',
                'major.required' => 'Jurusan harus diisi',
                'information.required' => 'Informasi harus diisi',
            ]);

            function getYearPMB()
            {
                $currentDate = new DateTime();
                $currentYear = $currentDate->format('Y');
                $currentMonth = $currentDate->format('m');
                return $currentMonth >= 10 ? $currentYear + 1 : $currentYear;
            }

            $schoolInput = $request->input('school');

            $phone = null;

            if (!empty($request->input('phone')) && strlen($request->input('phone')) > 8) {
                $phone = $request->input('phone');

                // Jika nomor dimulai dengan '0', ubah ke format '62'
                if (substr($phone, 0, 1) === '0') {
                    $phone = '62' . substr($phone, 1);
                }

                // Jika nomor sudah diawali dengan '62', biarkan saja
                elseif (substr($phone, 0, 2) !== '62') {
                    $phone = '62' . $phone;
                }
            }

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

            $identity_val = Str::uuid();

            $data_applicant = [
                'identity' => $identity_val,
                'pmb' => getYearPMB(),
                'name' => ucwords(strtolower($request->input('name'))),
                'school' => $school,
                'phone' => $phone,
                'major' => $request->input('major'),
                'identity_user' => $request->input('information'),
                'source_id' => 1,
                'source_daftar_id' => 1,
                'status_id' => 1,
                'come' => 0,
                'isread' => '0',
            ];

            $data_account = [
                'identity' => $identity_val,
                'name' => ucwords(strtolower($request->input('name'))),
                'gender' => 1,
                'email' => $phone . '@lp3i.ac.id',
                'password' => Hash::make($phone),
                'phone' => $phone,
                'role' => 'S',
                'status' => 1,
            ];

            $create_mother = [
                'identity_user' => $identity_val,
                'gender' => 0,
            ];

            $create_father = [
                'identity_user' => $identity_val,
                'gender' => 1,
            ];

            $data_event_detail = [
                'event_id' => $request->input('event_id'),
                'identity_user' => $identity_val,
            ];

            $event = Event::where('id', $request->input('event_id'))->first();

            $currentDate = Carbon::now()->setTimezone('Asia/Jakarta');
            $currentMonth = (int) $currentDate->format('m');

            $session = 6;

            if ($currentMonth >= 1 && $currentMonth <= 3) {
                $session = 2;
            } elseif ($currentMonth >= 4 && $currentMonth <= 6) {
                $session = 3;
            } elseif ($currentMonth >= 7 && $currentMonth <= 9) {
                $session = 4;
            } elseif ($currentMonth >= 10 && $currentMonth <= 12) {
                $session = 1;
            }

            $data_status_applicant = [
                'pmb' => getYearPMB(),
                'identity_user' => $identity_val,
                'date' => $currentDate,
                'session' => $session,
            ];

            $check_applicant = Applicant::where('phone', $phone)->first();

            if ($check_applicant) {
                if ($check_applicant->is_register || $check_applicant->is_daftar) {
                    return response()->json([
                        'status' => 403,
                        'error' => 'Forbidden',
                        'message' => 'Data sudah tidak bisa terdaftar!',
                    ], 403);
                } else {
                    $data_applicant['identity'] = $check_applicant->identity;
                    $data_applicant['identity_user'] = $check_applicant->identity_user;

                    $data_status_applicant['pmb'] = $check_applicant->pmb;
                    $data_status_applicant['identity_user'] = $check_applicant->identity;

                    $data_event_detail['identity_user'] = $check_applicant->identity;

                    if ($event->is_program) {
                        $programtype = ProgramType::where('code', $request->input('code'))->first();

                        $data_applicant['programtype_id'] = $programtype ? $programtype->id : null;
                        $data_applicant['program'] = $programtype ? $request->input('program') : null;
                        $data_applicant['program_second'] = $programtype ? $request->input('program') : null;
                    }

                    if ($event->is_scholarship) {
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
                        $data_applicant['address'] = $address_applicant;

                        $data_applicant['email'] = $check_applicant->email ?? $phone . '@lp3i.ac.id';
                        $data_applicant['schoolarship'] = 1;
                        $data_applicant['scholarship_date'] = $check_applicant->scholarship_date ?? Carbon::now()->setTimezone('Asia/Jakarta');
                        $data_applicant['scholarship_type'] = $request->input('scholarship_type');
                        $data_applicant['achievement'] = $request->input('achievement');
                        $data_applicant['is_applicant'] = 1;

                        $data_applicant['source_id'] = 10;
                        $data_applicant['source_daftar_id'] = 10;
                        $data_applicant['status_id'] = 4;

                        $data_account['identity'] = $check_applicant->identity;
                        $data_account['email'] = $check_applicant->email ?? $check_applicant->phone . '@lp3i.ac.id';

                        $parent = ApplicantFamily::where([
                            'identity_user' => $check_applicant->identity,
                            'gender' => $request->input('parent_gender')
                        ])->first();

                        $parent->update([
                            'name' => $request->input('parent_name'),
                            'phone' => $request->input('parent_phone')
                        ]);
                    }

                    if ($event->is_employee) {
                        $data_applicant['year'] = $request->input('year');
                        $data_applicant['class'] = $request->input('class');
                        $data_applicant['place_of_working'] = $request->input('place_of_working');
                    }

                    $check_applicant->update($data_applicant);
                }
            } else {
                if ($event->is_program) {
                    $programtype = ProgramType::where('code', $request->input('code'))->first();

                    $data_applicant['programtype_id'] = $programtype ? $programtype->id : null;
                    $data_applicant['program'] = $programtype ? $request->input('program') : null;
                    $data_applicant['program_second'] = $programtype ? $request->input('program') : null;
                }

                if ($event->is_scholarship) {
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
                    $data_applicant['address'] = $address_applicant;

                    $data_applicant['email'] = $phone . '@lp3i.ac.id';
                    $data_applicant['schoolarship'] = 1;
                    $data_applicant['scholarship_date'] = Carbon::now()->setTimezone('Asia/Jakarta');
                    $data_applicant['scholarship_type'] = $request->input('scholarship_type');
                    $data_applicant['achievement'] = $request->input('achievement');
                    $data_applicant['is_applicant'] = 1;

                    $data_applicant['source_id'] = 10;
                    $data_applicant['source_daftar_id'] = 10;
                    $data_applicant['status_id'] = 4;
                    $data_applicant['come'] = 0;
                    $data_applicant['isread'] = '0';

                    if ($request->input('parent_gender') == 1) {
                        $create_father['name'] = $request->input('parent_name');
                        $create_father['phone'] = $request->input('parent_phone');
                    } else {
                        $create_mother['name'] = $request->input('parent_name');
                        $create_mother['phone'] = $request->input('parent_phone');
                    }
                }

                if ($event->is_employee) {
                    $data_applicant['year'] = $request->input('year');
                    $data_applicant['class'] = $request->input('class');
                    $data_applicant['place_of_working'] = $request->input('place_of_working');
                }

                $applicant = Applicant::create($data_applicant);
                ApplicantFamily::create($create_mother);
                ApplicantFamily::create($create_father);

                $data_status_applicant['pmb'] = $applicant->pmb;
                $data_status_applicant['identity_user'] = $applicant->identity;

                $data_account['identity'] = $applicant->identity;
                $data_account['email'] = $applicant->email ?? $applicant->phone . '@lp3i.ac.id';

                $data_event_detail['identity_user'] = $applicant->identity;
            }

            if ($event->is_scholarship) {
                $status_applicant = StatusApplicantsApplicant::where('identity_user', $data_status_applicant['identity_user'])->first();
                if ($status_applicant) {
                    $status_applicant->update($data_status_applicant);
                } else {
                    StatusApplicantsApplicant::create($data_status_applicant);
                }
            }

            if($event->is_scholarship) {
                $account = User::where('phone', $phone)->first();
                if ($account) {
                    $account->update($data_account);
                } else {
                    User::create($data_account);
                }
            }

            $event_applicant = EventDetail::where([
                'event_id' => $data_event_detail['event_id'],
                'identity_user' => $data_event_detail['identity_user']
            ])->first();

            if ($event_applicant) {
                $event_applicant->update($data_event_detail);
            } else {
                EventDetail::create($data_event_detail);
            }

            return response()->json([
                'data' => $data_applicant,
                'event' => $event,
                'message' => 'Data berhasil disimpan',
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Mengambil pesan error dari exception
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors() // Memberikan error per field
            ], 422);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'pmb' => ['required', 'integer'],
            'code' => ['required', 'max:10', 'min:3', 'unique:events'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            'pmb.required' => 'PMB is required',
            'code.required' => 'Code is required',
            'code.max' => 'Code is too long',
            'code.min' => 'Code is too short',
            'code.unique' => 'Code is already taken',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ]);

        $data = [
            'pmb' => $request->pmb,
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'is_scholarship' => false,
            'is_files' => false,
            'is_status' => true,
        ];

        try {
            Event::create($data);
            return redirect()->route('event.index')->with('message', 'Event created successfully');
        } catch (\Throwable $th) {
            return redirect()->route('event.index')->with('error', $th->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id): \Illuminate\Contracts\View\View
    {
        $event = Event::findOrFail($id);

        $nameVal = request('name');

        $applicant_query = EventDetail::query();

        $appends = [];

        if ($nameVal) {
            $applicant_query->whereHas('applicant', function ($query) use ($nameVal) {
                $query->where('name', 'like', "%$nameVal%");
            });

            $appends['name'] = $nameVal;
        }

        $applicants = $applicant_query
            ->with(['event', 'applicant', 'applicant.SourceSetting', 'applicant.SourceDaftarSetting', 'applicant.ApplicantStatus', 'applicant.ProgramType', 'applicant.SchoolApplicant', 'applicant.FollowUp', 'applicant.father', 'applicant.mother', 'applicant.presenter'])
            ->where('event_id', $id)
            ->orderByDesc('created_at')
            ->paginate(5);

        $total = EventDetail::where('event_id', $id)->count();
        return view('pages.menu.event.show', compact('event', 'applicants', 'total'));
    }

    public function participant($code): \Illuminate\Contracts\View\View
    {
        $event = Event::where([
            'code' => $code,
            'is_status' => true
        ])->firstOrFail();
        $schools = School::all();
        $informations = User::where([
            'role' => 'P',
            'status' => true
        ])->get();
        return view('pages.menu.event.participant', compact('event', 'schools', 'informations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */

    public function edit($id): \Illuminate\Contracts\View\View
    {
        $event = Event::findOrFail($id);
        return view('pages.menu.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'pmb' => ['required', 'integer'],
            'code' => ['required', 'max:10', 'min:3', 'unique:events,code,' . $id],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ], [
            'pmb.required' => 'PMB is required',
            'code.required' => 'Code is required',
            'code.max' => 'Code is too long',
            'code.min' => 'Code is too short',
            'code.unique' => 'Code is already taken',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ]);

        $data = [
            'pmb' => $request->pmb,
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'is_scholarship' => false,
            'is_files' => false,
            'is_status' => true,
        ];

        try {
            $event = Event::findOrFail($id);
            $event->update($data);
            return redirect()->route('event.index')->with('message', 'Event updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('event.index')->with('error', $th->getMessage());

        }
    }

    public function update_event(Request $request, $id): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required'],
        ], [
            'rating.required' => 'Rating is required',
            'rating.integer' => 'Rating must be a number',
            'rating.min' => 'Rating must be at least 1',
            'rating.max' => 'Rating must be at most 5',
            'comment.required' => 'Comment is required',
        ]);

        $data = [
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ];

        try {
            $event_detail = EventDetail::findOrFail($id);
            $event_detail->update($data);
            return redirect()->route('dashboard.index')->with('message', 'Rating has been added successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.index')->with('error', $th->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        try {
            $event = Event::findOrFail($id);
            EventDetail::where('event_id', $id)->delete();
            $event->delete();
            return redirect()->route('event.index')->with('message', 'Event deleted successfully');
        } catch (\Throwable $th) {
            return redirect()->route('event.index')->with('error', $th->getMessage());

        }
    }

    public function scholarship($id): \Illuminate\Http\RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_scholarship' => !$event->is_scholarship
            ]
        );
        return redirect()->route('event.index')->with('message', 'Event scholarship updated successfully');
    }

    public function files($id): \Illuminate\Http\RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_files' => !$event->is_files
            ]
        );
        return redirect()->route('event.index')->with('message', 'Event files updated successfully');
    }

    public function employee($id): \Illuminate\Http\RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_employee' => !$event->is_employee
            ]
        );
        return redirect()->route('event.index')->with('message', 'Event employee updated successfully');
    }

    public function program($id): \Illuminate\Http\RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_program' => !$event->is_program
            ]
        );
        return redirect()->route('event.index')->with('message', 'Event program updated successfully');
    }

    public function programstatus(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'program' => $request->input('program'),
            ]
        );
        return redirect()->route('event.index')->with('message', 'Event program status updated successfully');
    }

    public function status($id): \Illuminate\Http\RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->update(
            [
                'is_status' => !$event->is_status
            ]
        );
        return redirect()->route('event.index')->with('message', 'Event status updated successfully');
    }
}
