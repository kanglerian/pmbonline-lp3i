<?php

namespace App\Http\Controllers\Applicant\Status;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\StatusApplicantsRegistration;
use Illuminate\Http\RedirectResponse;

class StatusRegistrasiController extends Controller
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
        $status_registrasi = StatusApplicantsRegistration::where('identity_user', $applicant->identity)->first();

        $data_applicant = [
            'is_register' => 0,
        ];

        $applicant->update($data_applicant);
        $status_registrasi->delete();

        return back()->with('message', 'Data registrasi berhasil dihapus');
    }
}
