<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SourceSetting;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = SourceSetting::paginate(5);
        return view('pages.menu.source.index')->with([
            'sources' => $sources
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.menu.source.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
        ];

        SourceSetting::create($data);
        return back()->with('message', 'Data sumber database berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $source = SourceSetting::findOrFail($id);
        return view('pages.menu.source.edit')->with([
            'source' => $source
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $source = SourceSetting::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
        ];

        $source->update($data);
        return back()->with('message', 'Data sumber database berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $source = SourceSetting::findOrFail($id);
        $source->delete();
        return back()->with('message', 'Data sumber database berhasil dihapus!');
    }
}
