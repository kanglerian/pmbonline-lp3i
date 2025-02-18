<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ApplicantStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $applicant_statuses = ApplicantStatus::paginate(5);
        return view('pages.menu.applicantstatus.index')->with([
            'applicant_statuses' => $applicant_statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('pages.menu.applicantstatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
        ];

        ApplicantStatus::create($data);
        return back()->with('message', 'Data status berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): void
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $applicant_status = ApplicantStatus::findOrFail($id);
        return view('pages.menu.applicantstatus.edit')->with([
            'applicant_status' => $applicant_status
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $status = ApplicantStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
        ];

        $status->update($data);
        return back()->with('message', 'Data status berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $status = ApplicantStatus::findOrFail($id);
        $status->delete();
        return back()->with('message', 'Data status berhasil dihapus!');
    }
}
