<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\ReportStudentsAdmission;
use Illuminate\Http\JsonResponse;

class ReportStudentsAdmissionController extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = ReportStudentsAdmission::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $programTypeVal = request('programTypeVal', 'all');
        $monthVal = request('monthVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($monthVal !== 'all') {
            $databaseQuery->where('month_number', $monthVal);
        }

        if ($roleVal === 'P') {
            $databaseQuery->where('identity_user', $identityVal);
        }

        if ($programTypeVal !== 'all') {
            $databaseQuery->where('programtype_id', $programTypeVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
