<?php

namespace App\Http\Controllers\API\Target;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\StatusApplicantsRegistration;
use App\Models\TargetDatabase;
use App\Models\TargetRevenue;
use App\Models\TargetVolume;
use Illuminate\Http\JsonResponse;

class VolumeController extends Controller
{
    public function get_volumes(): JsonResponse
    {
        $registrationQuery = StatusApplicantsRegistration::query();
        $registrationQuery->with('applicant');
        $targetQuery = TargetVolume::query();

        $identityVal = request('identityVal');
        $pmbVal = request('pmbVal', 'all');
        $sessionVal = request('sessionVal', 'all');
        $dateVal = request('dateVal', 'all');

        $targetQuery->where('identity_user', $identityVal);

        $registrationQuery->whereHas('applicant', function ($query) use ($identityVal) {
            $query->where('identity_user', $identityVal);
        });

        if ($pmbVal !== 'all') {
            $targetQuery->where('pmb', $pmbVal);
            $registrationQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $targetQuery->where('session', $sessionVal);
            $registrationQuery->where('session', $sessionVal);
        }

        if ($dateVal !== 'all') {
            $targetQuery->where('date', $dateVal);
            $registrationQuery->where('date', $dateVal);
        }

        $targets = $targetQuery->get();
        $registrations = $registrationQuery->get();
        return response()->json(['targets' => $targets, 'registrations' => $registrations]);
    }

    public function get_revenues()
    {
        $registrationQuery = StatusApplicantsRegistration::query();
        $registrationQuery->with('applicant');
        $targetQuery = TargetRevenue::query();

        $identityVal = request('identityVal');
        $pmbVal = request('pmbVal', 'all');
        $sessionVal = request('sessionVal', 'all');
        $dateVal = request('dateVal', 'all');

        $targetQuery->where('identity_user', $identityVal);

        $registrationQuery->whereHas('applicant', function ($query) use ($identityVal) {
            $query->where('identity_user', $identityVal);
        });

        if ($pmbVal !== 'all') {
            $targetQuery->where('pmb', $pmbVal);
            $registrationQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $targetQuery->where('session', $sessionVal);
            $registrationQuery->where('session', $sessionVal);
        }

        if ($dateVal !== 'all') {
            $targetQuery->where('date', $dateVal);
            $registrationQuery->where('date', $dateVal);
        }

        $targets = $targetQuery->get();
        $registrations = $registrationQuery->get();
        return response()->json(['targets' => $targets, 'registrations' => $registrations]);
    }
    public function get_databases()
    {
        $applicantQuery = Applicant::query();
        $targetQuery = TargetDatabase::query();

        $identityVal = request('identityVal');
        $pmbVal = request('pmbVal', 'all');

        $applicantQuery->where('identity_user', $identityVal);
        $targetQuery->where('identity_user', $identityVal);

        if ($pmbVal !== 'all') {
            $targetQuery->where('pmb', $pmbVal);
            $applicantQuery->where('pmb', $pmbVal);
        }

        $targets = $targetQuery->get();
        $applicants = $applicantQuery->count();
        return response()->json(['targets' => $targets, 'applicants' => $applicants]);
    }
}
