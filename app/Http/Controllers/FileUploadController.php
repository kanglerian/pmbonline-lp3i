<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $files = FileUpload::paginate(5);
        return view('pages.menu.file.index')->with([
            'files' => $files
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Factory|View
    {
        return view('pages.menu.file.create');
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
            'accept' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'namefile' => strtolower(str_replace(' ','-', ucwords(strtolower($request->input('name'))))),
            'accept' => $request->input('accept'),
        ];

        FileUpload::create($data);
        return back()->with('message', 'Data berkas berhasil ditambahkan!');
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
        $file = FileUpload::findOrFail($id);
        return view('pages.menu.file.edit')->with([
            'file' => $file
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
        $fileupload = FileUpload::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string'],
            'accept' => ['required', 'string'],
        ]);

        $data = [
            'name' => ucwords(strtolower($request->input('name'))),
            'namefile' => strtolower(str_replace(' ','-', ucwords(strtolower($request->input('name'))))),
            'accept' => $request->input('accept'),
        ];

        $fileupload->update($data);
        return back()->with('message', 'Data berkas berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $fileupload = FileUpload::findOrFail($id);
        $fileupload->delete();
        return back()->with('message', 'Data berkas berhasil dihapus!');
    }
}
