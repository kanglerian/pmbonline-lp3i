<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Report\SchoolBySourceAll;
use App\Models\School;
use Illuminate\Http\JsonResponse;

class SchoolController extends Controller
{
    public function get_all(): JsonResponse
    {
        $schools = School::all();
        return response()->json(['schools' => $schools]);
    }
    public function get_sources()
    {
        $schoolsQuery = SchoolBySourceAll::query();
        $pmbVal = request('pmbVal', 'all');
        $regionVal = request('regionVal', 'all');

        if ($pmbVal !== 'all') {
            $schoolsQuery->where('pmb', $pmbVal);
        }

        if ($regionVal !== 'all') {
            $schoolsQuery->where('wilayah', $regionVal);
        }

        $schools = $schoolsQuery->get();

        return response()->json(['schools' => $schools]);
    }

}
