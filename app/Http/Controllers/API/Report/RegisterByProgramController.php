<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\RegisterByProgram;
use App\Models\Report\RegisterByProgramAdmin;
use Illuminate\Http\JsonResponse;

class RegisterByProgramController extends Controller
{
    public function get_all(): JsonResponse
    {
        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');

        if($roleVal == 'A'){
            $databaseQuery = RegisterByProgramAdmin::query();
        } else {
            $databaseQuery = RegisterByProgram::query();
        }

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if($roleVal == 'P'){
            $databaseQuery->where('identity_user', $identityVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
