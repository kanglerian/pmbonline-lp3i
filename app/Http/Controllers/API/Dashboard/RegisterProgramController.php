<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\RegisterByProgram;
use Illuminate\Http\JsonResponse;

class RegisterProgramController extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = RegisterByProgram::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        $databases = $databaseQuery->get();

        return response()->json($databases);
    }
}
