<?php

namespace App\Http\Controllers\Applicant\Status;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\StatusApplicantsEnrollment;
use Illuminate\Http\RedirectResponse;

class StatusDaftarController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $applicant = Applicant::findOrFail($id);
        $status_daftar = StatusApplicantsEnrollment::where('identity_user', $applicant->identity)->first();

        $data_applicant = [
            'is_daftar' => 0,
        ];

        $applicant->update($data_applicant);
        $status_daftar->delete();

        return back()->with('message', 'Data daftar berhasil dihapus');
    }
}
