<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FollowUp;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $followups = FollowUp::paginate(5);
        return view('pages.menu.followup.index')->with([
            'followups' => $followups
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Factory|View
    {
        return view('pages.menu.followup.create');
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

        FollowUp::create($data);
        return back()->with('message', 'Data follow up berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $followup = FollowUp::findOrFail($id);
        return view('pages.menu.followup.edit')->with([
            'followup' => $followup
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
        $followup = FollowUp::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
        ];

        $followup->update($data);
        return back()->with('message', 'Data follow up berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $followup = FollowUp::findOrFail($id);
        $followup->delete();
        return back()->with('message', 'Data follow up berhasil dihapus!');
    }
}
