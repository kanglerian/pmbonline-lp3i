<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\StatusApplicantsApplicant;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use App\Models\UserUpload;
use Illuminate\Http\JsonResponse;

class ReportAplikanController extends Controller
{
    public function aplikan(): JsonResponse
    {
        $databaseQuery = StatusApplicantsApplicant::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $sessionVal = request('sessionVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $databaseQuery->where('session', $sessionVal);
        }

        $databaseQuery->with(['applicant', 'applicant.sourcesetting', 'applicant.schoolapplicant', 'applicant.father', 'applicant.mother', 'applicant.programtype']);

        $databaseQuery->whereHas('applicant', function ($query) use ($identityVal) {
            $query->where('identity_user', $identityVal);
        });

        $databases = $databaseQuery->get();

        return response()->json([
            'databases' => $databases,
        ]);
    }

    public function daftar()
    {
        $databaseQuery = StatusApplicantsEnrollment::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $sessionVal = request('sessionVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $databaseQuery->where('session', $sessionVal);
        }

        $databaseQuery->with(['applicant', 'applicant.sourcesetting', 'applicant.schoolapplicant', 'applicant.father', 'applicant.mother', 'applicant.programtype']);

        $databaseQuery->whereHas('applicant', function ($query) use ($identityVal) {
            $query->where('identity_user', $identityVal);
        });

        $databases = $databaseQuery->get();
        return response()->json([
            'databases' => $databases,
        ]);
    }

    public function registrasi()
    {
        $databaseQuery = StatusApplicantsRegistration::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $sessionVal = request('sessionVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $databaseQuery->where('session', $sessionVal);
        }
        $databaseQuery->with(['applicant', 'applicant.sourcesetting', 'applicant.schoolapplicant', 'applicant.father', 'applicant.mother', 'applicant.programtype']);

        $databaseQuery->whereHas('applicant', function ($query) use ($identityVal) {
            $query->where('identity_user', $identityVal);
        });

        $databases = $databaseQuery->get();

        return response()->json([
            'databases' => $databases,
        ]);
    }

    public function files()
    {
        $fileUploadsQuery = FileUpload::query();
        $usersUploadQuery = UserUpload::query();

        $usersUploadQuery->with(['userupload', 'applicant']);

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');

        if ($pmbVal !== 'all') {
            $usersUploadQuery->whereHas('applicant', function ($query) use ($pmbVal) {
                $query->where('pmb', $pmbVal);
            });
        }

        if ($roleVal === 'P') {
            $usersUploadQuery->whereHas('applicant', function ($query) use ($identityVal) {
                $query->where('identity_user', $identityVal);
            });
        }

        $file_uploads = $fileUploadsQuery->get();
        $users_upload = $usersUploadQuery->get();

        return response()->json([
            'file_uploads' => $file_uploads,
            'users_upload' => $users_upload,
        ]);
    }
}
