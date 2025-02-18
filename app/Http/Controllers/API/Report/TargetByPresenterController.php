<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\TargetByPresenter;
use Illuminate\Http\JsonResponse;

class TargetByPresenterController extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = TargetByPresenter::query();

        $pmbVal = request('pmbVal', 'all');
        $sessionVal = request('sessionVal', 'all');
        $dateVal = request('dateVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb_volume', $pmbVal);
            $databaseQuery->where('pmb_revenue', $pmbVal);
        }

        if ($sessionVal !== 'all') {
            $databaseQuery->where('session_volume', $sessionVal);
            $databaseQuery->where('session_revenue', $sessionVal);
        }

        if ($dateVal !== 'all') {
            $monthVal = intval(date('m', strtotime($dateVal)));
            $databaseQuery->where('date_volume', $monthVal);
            $databaseQuery->where('date_revenue', $monthVal);
        }

        $databases = $databaseQuery->get();
        return response()->json([
            'databases' => $databases,
        ]);
    }
}
