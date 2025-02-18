<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\RegisterBySchool;
use Illuminate\Http\JsonResponse;

class RegisterBySchoolController extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = RegisterBySchool::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $statusVal = request('statusVal', 'all');
        $wilayahVal = request('wilayahVal', 'all');
        $tipeVal = request('tipeVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if($roleVal == 'P'){
            $databaseQuery->where('identity_user', $identityVal);
        }

        if ($wilayahVal !== 'all') {
            $databaseQuery->where('wilayah', $wilayahVal);
        }

        if ($tipeVal !== 'all') {
            $databaseQuery->where('tipe', $tipeVal);
        }

        if ($statusVal !== 'all') {
            $databaseQuery->where('status', $statusVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
