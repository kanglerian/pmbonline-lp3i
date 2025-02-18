<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\RekapitulasiPerolehanPMB;
use Illuminate\Http\JsonResponse;

class RekapPerolehanPMB extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = RekapitulasiPerolehanPMB::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb_applicant', $pmbVal);
            $databaseQuery->where('pmb_enrollment', $pmbVal);
            $databaseQuery->where('pmb_registration', $pmbVal);
        }

        $databases = $databaseQuery->get();

        return response()->json([
            'databases' => $databases
        ]);
    }
}
