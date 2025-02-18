<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    public function getAll()
    {
        $applicants = Applicant::all();
        return response()->json([
            'applicants' => $applicants,
        ])->header('Content-Type', 'application/json');
    }

    public function get_scholarship()
    {
        $applicantsQuery = Applicant::query();

        $pmbVal = request('pmbVal', 'all');
        $dateStart = request('dateStart', 'all');
        $dateEnd = request('dateEnd', 'all');

        if ($pmbVal !== 'all') {
            $applicantsQuery->where('pmb', $pmbVal);
        }

        if ($dateStart !== 'all' && $dateEnd !== 'all') {
            $applicantsQuery->whereBetween('scholarship_date', [$dateStart, $dateEnd]);
        }

        $applicants = $applicantsQuery
            ->with(['SchoolApplicant', 'Presenter'])
            ->where('schoolarship', 1)
            ->select('identity', 'identity_user', 'pmb', 'name', 'phone', 'school', 'major', 'year', 'scholarship_date', 'program')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($applicants);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($identity)
    {
        $user = Applicant::with(['SourceSetting', 'SourceDaftarSetting', 'ApplicantStatus', 'ProgramType', 'SchoolApplicant', 'FollowUp', 'father', 'mother', 'presenter'])->where('identity', $identity)->first();
        $enrollment = StatusApplicantsEnrollment::where('identity_user', $identity)->first();
        $registration = StatusApplicantsRegistration::where('identity_user', $identity)->first();

        return response()->json([
            'user' => $user,
            'enrollment' => $enrollment,
            'registration' => $registration,
        ]);
    }
}
