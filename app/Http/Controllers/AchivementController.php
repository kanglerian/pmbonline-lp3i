<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AchivementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): void
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): void
    {
        //
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
            'identity_user' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'not_in:Pilih tingkat'],
            'year' => ['required'],
            'result' => ['required'],
        ]);

        $data = [
            'identity_user' => $request->input('identity_user'),
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'year' => $request->input('year'),
            'result' => $request->input('result'),
        ];

        Achievement::create($data);

        return back()->with('message', 'Data prestasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $achievements = Achievement::where('identity_user', $id)->get();
        return response()->json([
            'achievements' => $achievements,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id): RedirectResponse
    {
        try {
            $achievement = Achievement::findOrFail($id);
            $achievement->delete();
    
            return redirect()->back()->with('message', 'Data prestasi berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi sebuah kesalahan. Periksa koneksi Anda.');
        }
    }
    
}
