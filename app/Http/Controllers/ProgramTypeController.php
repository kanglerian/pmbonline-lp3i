<?php

namespace App\Http\Controllers;

use App\Models\ProgramType;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ProgramTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $programtypes = ProgramType::paginate(5);
        return view('pages.menu.programtype.index')->with([
            'programtypes' => $programtypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('pages.menu.programtype.create');
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
            'code' => ['required', 'string', 'unique:program_types'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'code' => strtoupper($request->input('code')),
            'status' => 1,
        ];

        ProgramType::create($data);
        return redirect()->route( 'programtype.index' )->with( 'message', 'Program type status add successfully' );
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
        $programtype = ProgramType::findOrFail($id);
        return view('pages.menu.programtype.edit')->with([
            'programtype' => $programtype
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
        $programtype = ProgramType::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
            'code' => ['required', 'string', 'unique:program_types,code,' . $id],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'code' => strtoupper($request->input('code')),
            'status' => 1,
        ];

        $programtype->update($data);
        return redirect()->route( 'programtype.index' )->with( 'message', 'Program type status updated successfully' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $programtype = ProgramType::findOrFail($id);
        $programtype->delete();
        return redirect()->route( 'programtype.index' )->with( 'message', 'Program type status deleted successfully' );
    }

    public function status( $id ): RedirectResponse {
        $programtype = ProgramType::findOrFail( $id );
        $programtype->update(
            [
                'status' => !$programtype->status
            ]
        );
        return redirect()->route( 'programtype.index' )->with( 'message', 'Program type status updated successfully' );
    }
}
