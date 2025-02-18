<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\Http\JsonResponse;

class RecommendationController extends Controller
{
    public function get_all(): JsonResponse
    {
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');
        $schoolVal = request('schoolVal', 'all');
        $sourceVal = request('sourceVal', 'all');
        $yearVal = request('yearVal', 'all');
        $referenceVal = request('referenceVal', 'all');

        $recommendationQuery = Recommendation::query();
        if($roleVal == 'A'){
            if($identityVal !== 'all'){
                $recommendationQuery->whereHas('applicant', function ($query) use ($identityVal) {
                    $query->where('identity_user', $identityVal);
                });
            }
        } else {
            $recommendationQuery->whereHas('applicant', function ($query) use ($identityVal) {
                $query->where('identity_user', $identityVal);
            });
        }

        if($schoolVal !== 'all'){
            $recommendationQuery->where('school_id', $schoolVal);
        }

        if($yearVal !== 'all'){
            $recommendationQuery->where('year', $yearVal);
        }

        if($referenceVal !== 'all'){
            $recommendationQuery->where('reference', 'like', '%' . $referenceVal .'%');
        }

        if($sourceVal !== 'all'){
            $recommendationQuery->where('source_id', $sourceVal);
        }

        $recommendations = $recommendationQuery->with(['applicant','schoolapplicant','applicant.presenter','sourcesetting'])->get();
        return response()->json([
            'recommendations' => $recommendations,
        ])->header('Content-Type', 'application/json');
    }
}
