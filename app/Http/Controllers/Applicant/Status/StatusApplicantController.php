<?php

namespace App\Http\Controllers\Applicant\Status;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Support\Facades\Date;
use App\Models\StatusApplicantsApplicant;
use Illuminate\Http\Request;

class StatusApplicantController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'is_applicant_pmb' => ['required','length:4','year'],
            'is_applicant_date' => ['required'],
            'is_applicant_session' => ['required'],
        ], [
            'is_applicant_session.required' => 'Kolom Gelombang tidak boleh kosong, harap isi dengan angka.',
            'is_applicant_date.required' => 'Kolom Tanggal tidak boleh kosong, harap isi dengan tanggal.',
            'is_applicant_pmb.required' => 'Kolom Tahun PMB tidak boleh kosong, harap isi dengan tahun.',
            'is_applicant_pmb.length' => 'Kolom Tahun PMB harus berisi 4 digit angka.',
            'is_applicant_pmb.year' => 'Kolom Tahun PMB harus berisi angka tahun.',
        ]);



        $applicant = Applicant::findOrFail($id);
        $status_applicant = StatusApplicantsApplicant::where('identity_user', $applicant->identity)->first();

        $data = [
            'session' => $request->input('is_applicant_session'),
            'date' => $request->input('is_applicant_date'),
            'pmb' => $request->input('is_applicant_pmb'),
        ];

        $status_applicant->update($data);

        return back()->with('message', 'Data aplikan berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        $status_applicant = StatusApplicantsApplicant::where('identity_user', $applicant->identity)->first();
        $data_applicant = [
            'is_applicant' => 0,
        ];

        $applicant->update($data_applicant);
        $status_applicant->delete();

        return back()->with('message', 'Data aplikan berhasil dihapus');
    }
}
