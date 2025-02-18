<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class ResetPasswordController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request): JsonResponse
    {
        $applicants = Applicant::where('is_register', '1')->get();
        $data = [];
        foreach ($applicants as $applicant) {
            $user = User::where('identity', $applicant->identity)->first();
            if($user){
                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);
                array_push($data, $user);
            }
        }
        return response()->json([
            'message' => 'Berhasil diupdate semuanya!',
            'data' => $data,
        ]);
    }
}
