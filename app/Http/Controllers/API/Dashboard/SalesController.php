<?php

namespace App\Http\Controllers\API\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\Database;
use App\Models\Dashboard\SalesRevenue;
use App\Models\Dashboard\SalesVolume;
use Illuminate\Http\JsonResponse;

class SalesController extends Controller
{
    public function get_all(): JsonResponse
    {
        $sales_volume_query = SalesVolume::query();
        $sales_revenue_query = SalesRevenue::query();
        $database_query = Database::query();

        $pmbVal = request('pmbVal', 'all');

        if ($pmbVal !== 'all') {
            $sales_volume_query->where('pmb', $pmbVal);
            $sales_revenue_query->where('pmb', $pmbVal);
            $database_query->where('pmb', $pmbVal);
        }

        $sales_volume = $sales_volume_query->get();
        $sales_revenue = $sales_revenue_query->get();
        $database = $database_query->get();

        return response()->json([
            'sales_volume' => $sales_volume,
            'sales_revenue' => $sales_revenue,
            'database' => $database,
        ]);
    }
}
