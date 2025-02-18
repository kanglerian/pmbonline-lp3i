<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index(): void {
        //
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create(): void {
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ): RedirectResponse {
        $request->validate( [
            'identity_user' => [ 'required', 'string', 'max:255' ],
            'name' => [ 'required', 'string', 'max:255' ],
            'position' => [ 'required', 'string' ],
            'year' => [ 'required' ],
        ] );

        $data = [
            'identity_user' => $request->input( 'identity_user' ),
            'name' => $request->input( 'name' ),
            'position' => $request->input( 'position' ),
            'year' => $request->input( 'year' ),
        ];

        Organization::create( $data );

        return back()->with( 'message', 'Data organisasi berhasil ditambahkan!' );
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ): JsonResponse {
        $organizations = Organization::where( 'identity_user', $id )->get();
        return response()->json( [
            'organizations' => $organizations,
        ] );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ): void {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id ): void {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id ): RedirectResponse {
        try {
            $organization = Organization::findOrFail( $id );
            $organization->delete();

            return redirect()->back()->with( 'message', 'Data organisasi berhasil dihapus!' );
        } catch ( \Throwable $th ) {
            return redirect()->back()->with( 'error', 'Terjadi sebuah kesalahan. Periksa koneksi Anda.' );
        }
    }

}
