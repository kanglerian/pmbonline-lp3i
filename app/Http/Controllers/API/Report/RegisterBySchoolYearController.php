<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\RegisterBySchoolYear;
use Illuminate\Http\JsonResponse;

class RegisterBySchoolYearController extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = RegisterBySchoolYear::query();

        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $wilayahVal = request('wilayahVal', 'all');

        if($roleVal == 'P'){
            $databaseQuery->where('identity_user', $identityVal);
        }

        if ($wilayahVal !== 'all') {
            $databaseQuery->where('wilayah', $wilayahVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
