<?php

namespace App\Http\Controllers\Applicant\Status;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use Illuminate\Support\Facades\Date;
use App\Models\StatusApplicantsApplicant;
use Illuminate\Http\Request;

class StatusBeasiswaController extends Controller
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
            'scholarship_date' => ['required'],
            'scholarship_type' => ['required'],
            'achievement' => ['required'],
        ],[
            'scholarship_date.required' => 'Tanggal beasiswa wajib diisi',
            'scholarship_type.required' => 'Jenis beasiswa wajib diisi',
            'achievement.required' => 'Prestasi wajib diisi',
        ]);

        $applicant = Applicant::findOrFail($id);
        $applicant->update([
            'scholarship_date' => $request->input('scholarship_date'),
            'scholarship_type' => $request->input('scholarship_type'),
            'achievement' => $request->input('achievement'),
        ]);

        return back()->with('message', 'Data beasiswa berhasil diupdate');
    }
}
