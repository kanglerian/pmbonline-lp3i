<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Models\Report\SourceDatabaseByPresenter;
use Illuminate\Http\JsonResponse;

class SourceDatabaseByPresenterController extends Controller
{
    public function get_all(): JsonResponse
    {
        $databaseQuery = SourceDatabaseByPresenter::query();

        $pmbVal = request('pmbVal', 'all');
        $identityVal = request('identityVal', 'all');
        $roleVal = request('roleVal', 'all');

        if ($pmbVal !== 'all') {
            $databaseQuery->where('pmb', $pmbVal);
        }

        if ($roleVal === 'P') {
            $databaseQuery->where('identity_user', $identityVal);
        }

        $databases = $databaseQuery->get();
        return response()->json([
            'databases' => $databases
        ]);
    }
}
