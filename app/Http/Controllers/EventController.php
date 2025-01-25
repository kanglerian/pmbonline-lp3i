<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantFamily;
use App\Models\StatusApplicantsApplicant;
use DateTime;
use Carbon\Carbon;
use App\Models\Event;
use Illuminate\Support\Str;
use App\Models\EventDetail;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Contracts\View\View
    */

    public function index(): \Illuminate\Contracts\View\View {
        $event_query = Event::query();

        function getYearPMB() {
            $currentDate = new DateTime();
            $currentYear = $currentDate->format( 'Y' );
            $currentMonth = $currentDate->format( 'm' );
            return $currentMonth >= 10 ? $currentYear + 1 : $currentYear;
        }

        $titleVal = request( 'title' );
        $pmb = request( 'pmb', getYearPMB() );

        $appends = [];

        if ( $titleVal ) {
            $event_query->where( 'title', 'like', '%' . $titleVal . '%' );
            $appends[ 'title' ] = $titleVal;
        }

        if ( $pmb ) {
            $event_query->where( 'pmb', $pmb );
            $appends[ 'pmb' ] = $pmb;
        }

        $events = $event_query->paginate( 10 );
        return view( 'pages.menu.event.index', compact( 'events' ) );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'pages.menu.event.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store_event( Request $request ): \Illuminate\Http\JsonResponse {
        try {
            $request->validate( [
                'name' => [ 'required', 'string', 'max:255' ],
                'phone' => [ 'required', 'string', 'min:10', 'max:13' ],
                'school' => [ 'required', 'max:100', 'not_in:Pilih Sekolah' ],
                'major' => [ 'required' ],
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
            ] );

            function getYearPMB() {
                $currentDate = new DateTime();
                $currentYear = $currentDate->format( 'Y' );
                $currentMonth = $currentDate->format( 'm' );
                return $currentMonth >= 10 ? $currentYear + 1 : $currentYear;
            }

            $schoolInput = $request->input( 'school' );

            if ( empty( $schoolInput ) ) {
                $school = null;
            } else {
                $schoolCheck = School::where( 'id', $schoolInput )->first();
                $schoolNameCheck = School::where( 'name', $schoolInput )->first();
                if ( $schoolCheck ) {
                    $school = $schoolCheck->id;
                } else {
                    if ( $schoolNameCheck ) {
                        $school = $schoolNameCheck->id;
                    } else {
                        $dataSchool = [
                            'name' => strtoupper( $schoolInput ),
                            'region' => 'TIDAK DIKETAHUI',
                        ];
                        $schoolCreate = School::create( $dataSchool );
                        $school = $schoolCreate->id;
                    }
                }
            }

            $event = Event::where( 'id', $request->input( 'event_id' ) )->first();

            if ( $event->is_scholarship ) {
                $rt_digit = strlen( $request->input( 'rt' ) ) < 2 ? '0' . $request->input( 'rt' ) : $request->input( 'rt' );
                $rw_digit = strlen( $request->input( 'rw' ) ) < 2 ? '0' . $request->input( 'rw' ) : $request->input( 'rw' );

                $place = $request->input( 'place' ) !== null ? ucwords( strtolower( $request->input( 'place' ) ) ) . ', ' : null;
                $rt = $request->input( 'rt' ) !== null ? 'RT. ' . $rt_digit . ' ' : null;
                $rw = $request->input( 'rw' ) !== null ? 'RW. ' . $rw_digit . ', ' : null;
                $kel = $request->input( 'villages' ) !== null ? 'Desa/Kelurahan ' . ucwords( strtolower( $request->input( 'villages' ) ) ) . ', ' : null;
                $kec = $request->input( 'districts' ) !== null ? 'Kecamatan ' . ucwords( strtolower( $request->input( 'districts' ) ) ) . ', ' : null;
                $reg = $request->input( 'regencies' ) !== null ? 'Kota/Kabupaten ' . ucwords( strtolower( $request->input( 'regencies' ) ) ) . ', ' : null;
                $prov = $request->input( 'provinces' ) !== null ? 'Provinsi ' . ucwords( strtolower( $request->input( 'provinces' ) ) ) . ', ' : null;
                $postal = $request->input( 'postal_code' ) !== null ? 'Kode Pos ' . $request->input( 'postal_code' ) : null;

                $address_applicant = $place . $rt . $rw . $kel . $kec . $reg . $prov . $postal;

                $currentDate = Carbon::now()->setTimezone( 'Asia/Jakarta' );
                $currentMonth = ( int ) $currentDate->format( 'm' );

                $session = 6;

                if ( $currentMonth >= 1 && $currentMonth <= 3 ) {
                    $session = 2;
                } elseif ( $currentMonth >= 4 && $currentMonth <= 6 ) {
                    $session = 3;
                } elseif ( $currentMonth >= 7 && $currentMonth <= 9 ) {
                    $session = 4;
                } elseif ( $currentMonth >= 10 && $currentMonth <= 12 ) {
                    $session = 1;
                }

                $identity_val = Str::uuid();

                $data_applicant = [
                    'event_id' => $request->input( 'event_id' ),
                    'identity' => $identity_val,
                    'pmb' => getYearPMB(),
                    'name' => ucwords( strtolower( $request->input( 'name' ) ) ),
                    'school' => $school,
                    'phone' => $request->input( 'phone' ),
                    'major' => $request->input( 'major' ),
                    'address' => $address_applicant,
                    'identity_user' => $request->input( 'information' ),

                    /* Scholarship */
                    'schoolarship' => $event->is_scholarship,
                    'is_applicant' => $event->is_scholarship,
                    'scholarship_date' => $event->is_scholarship ?: Carbon::now()->setTimezone( 'Asia/Jakarta' ),
                    'scholarship_type' => $request->input( 'scholarship_type' ),
                    'achievement' => $request->input( 'achievement' ),

                    'source_id' => 10,
                    'source_daftar_id' => 10,
                    'status_id' => 4,
                    'come' => 0,
                    'isread' => '0',
                ];

                $applicant = Applicant::create( $data_applicant );

                $data_status_applicant = [
                    'pmb' => $applicant->pmb,
                    'identity_user' => $identity_val,
                    'date' => $currentDate,
                    'session' => $session,
                ];

                $create_mother = [
                    'identity_user' => $identity_val,
                    'name' => $request->input( 'parent_gender' ) == 0 ? $request->input( 'name' ) : null,
                    'gender' => 0, // Gender untuk mother
                    'phone' => $request->input( 'parent_gender' ) == 0 ? $request->input( 'phone' ) : null,
                ];

                $create_father = [
                    'identity_user' => $identity_val,
                    'name' => $request->input( 'parent_gender' ) == 1 ? $request->input( 'name' ) : null,
                    'gender' => 1, // Gender untuk father
                    'phone' => $request->input( 'parent_gender' ) == 1 ? $request->input( 'phone' ) : null,
                ];

                $data_event_detail = [
                    'event_id' => $request->input( 'event_id' ),
                    'identity_user' => $identity_val,
                ];

                StatusApplicantsApplicant::create( $data_status_applicant );
                ApplicantFamily::create( $create_mother );
                ApplicantFamily::create( $create_father );
                EventDetail::create( $data_event_detail );

                return response()->json( [
                    'message' => 'Data berhasil disimpan',
                ] );

            } else {
                $data_applicant = [
                    'event_id' => $request->input( 'event_id' ),
                    'pmb' => getYearPMB(),
                    'name' => ucwords( strtolower( $request->input( 'name' ) ) ),
                    'school' => $school,
                    'phone' => $request->input( 'phone' ),
                    'major' => $request->input( 'major' ),
                    'identity_user' => $request->input( 'information' ),
                ];
            }

            return response()->json( $data_applicant, 200 );

        } catch ( \Illuminate\Validation\ValidationException $e ) {
            // Mengambil pesan error dari exception
            return response()->json( [
                'error' => 'Validation failed',
                'messages' => $e->errors() // Memberikan error per field
            ], 422 );
        } catch ( \Throwable $th ) {
            return response()->json( [ 'error' => $th->getMessage() ], 400 );
        }
    }

    public function store( Request $request ): \Illuminate\Http\RedirectResponse {
        $request->validate( [
            'pmb' => [ 'required', 'integer' ],
            'code' => [ 'required', 'max:10', 'min:3', 'unique:events' ],
            'title' => [ 'required', 'string', 'max:255' ],
            'description' => [ 'required', 'string' ],
        ], [
            'pmb.required' => 'PMB is required',
            'code.required' => 'Code is required',
            'code.max' => 'Code is too long',
            'code.min' => 'Code is too short',
            'code.unique' => 'Code is already taken',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ] );

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
            Event::create( $data );
            return redirect()->route( 'event.index' )->with( 'message', 'Event created successfully' );
        } catch ( \Throwable $th ) {
            return redirect()->route( 'event.index' )->with( 'error', $th->getMessage() );

        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $code ): \Illuminate\Contracts\View\View {
        $event = Event::where( [
            'code' => $code,
            'is_status' => true
        ] )->firstOrFail();
        $schools = School::all();
        $informations = User::where( [
            'role' => 'P',
            'status' => true
        ] )->get();
        return view( 'pages.menu.event.show', compact( 'event', 'schools', 'informations' ) );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Contracts\View\View
    */

    public function edit( $id ): \Illuminate\Contracts\View\View {
        $event = Event::findOrFail( $id );
        return view( 'pages.menu.event.edit', compact( 'event' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ): \Illuminate\Http\RedirectResponse {

        $request->validate( [
            'pmb' => [ 'required', 'integer' ],
            'code' => [ 'required', 'max:10', 'min:3', 'unique:events,code,' . $id ],
            'title' => [ 'required', 'string', 'max:255' ],
            'description' => [ 'required', 'string' ],
        ], [
            'pmb.required' => 'PMB is required',
            'code.required' => 'Code is required',
            'code.max' => 'Code is too long',
            'code.min' => 'Code is too short',
            'code.unique' => 'Code is already taken',
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ] );

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
            $event = Event::findOrFail( $id );
            $event->update( $data );
            return redirect()->route( 'event.index' )->with( 'message', 'Event updated successfully' );
        } catch ( \Throwable $th ) {
            return redirect()->route( 'event.index' )->with( 'error', $th->getMessage() );

        }
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ): \Illuminate\Http\RedirectResponse {
        try {
            $event = Event::findOrFail( $id );
            $event->delete();
            return redirect()->route( 'event.index' )->with( 'message', 'Event deleted successfully' );
        } catch ( \Throwable $th ) {
            return redirect()->route( 'event.index' )->with( 'error', $th->getMessage() );

        }
    }

    public function scholarship( $id ): \Illuminate\Http\RedirectResponse {
        $event = Event::findOrFail( $id );
        $event->update(
            [
                'is_scholarship' => !$event->is_scholarship
            ]
        );
        return redirect()->route( 'event.index' )->with( 'message', 'Event scholarship updated successfully' );
    }

    public function files( $id ): \Illuminate\Http\RedirectResponse {
        $event = Event::findOrFail( $id );
        $event->update(
            [
                'is_files' => !$event->is_files
            ]
        );
        return redirect()->route( 'event.index' )->with( 'message', 'Event files updated successfully' );
    }

    public function status( $id ): \Illuminate\Http\RedirectResponse {
        $event = Event::findOrFail( $id );
        $event->update(
            [
                'is_status' => !$event->is_status
            ]
        );
        return redirect()->route( 'event.index' )->with( 'message', 'Event status updated successfully' );
    }
}
