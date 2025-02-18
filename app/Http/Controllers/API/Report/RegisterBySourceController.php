<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\RegisterBySource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterBySourceController extends Controller
{
    public function get_all(): JsonResponse
    {
        $registerQuery = RegisterBySource::query();
        $presenterQuery = User::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $registerQuery->where('pmb', $pmbVal);
        }

        $presenterQuery->where('role', 'P');

        $registers = $registerQuery->get();
        $presenters = $presenterQuery->get();

        return response()->json([
            'registers' => $registers,
            'presenters' => $presenters
        ]);
    }
}
