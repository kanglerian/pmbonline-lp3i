<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserUpload;
use App\Models\FileUpload;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class UserUploadController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index(): void {
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

    public function store( Request $request ): JsonResponse {

        $berkas = $request->all();

        if ( Auth::user()->role == 'S' ) {
            $data = [
                'identity_user' => Auth::user()->identity,
                'fileupload_id' => $berkas[ 'data' ][ 'fileupload_id' ],
                'typefile' => $berkas[ 'data' ][ 'typefile' ],
            ];
        } else {
            $data = [
                'identity_user' => $berkas[ 'data' ][ 'identity' ],
                'fileupload_id' => $berkas[ 'data' ][ 'fileupload_id' ],
                'typefile' => $berkas[ 'data' ][ 'typefile' ],
            ];
        }

        $userupload = UserUpload::where( [
            'identity_user' => $berkas[ 'data' ][ 'identity' ],
            'fileupload_id' => $berkas[ 'data' ][ 'fileupload_id' ],
            'typefile' => $berkas[ 'data' ][ 'typefile' ],
        ] )->first();

        if ( $userupload ) {
            if ( $data[ 'fileupload_id' ] == 1 ) {
                $file = FileUpload::findOrFail( $data[ 'fileupload_id' ] );
                $dataku = [
                    'avatar' => $file->namefile . '.' . $data[ 'typefile' ],
                ];
                if ( Auth::user()->role == 'S' ) {
                    $user = User::findOrFail( Auth::user()->id );
                } else {
                    $user = User::where( 'identity', $data[ 'identity_user' ] );
                }
                $user->update( $dataku );
            }
            $userupload->update( $data );

            return response()->json( [
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
            ] );
        } else {
            if ( $data[ 'fileupload_id' ] == 1 ) {
                $file = FileUpload::findOrFail( $data[ 'fileupload_id' ] );
                $dataku = [
                    'avatar' => $file->namefile . '.' . $data[ 'typefile' ],
                ];
                if ( Auth::user()->role == 'S' ) {
                    $user = User::findOrFail( Auth::user()->id );
                } else {
                    $user = User::where( 'identity', $data[ 'identity_user' ] );
                }
                $user->update( $dataku );
            }

            UserUpload::create( $data );
            return response()->json( [
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ] );
        }

    }

    public function store_event( Request $request ): JsonResponse {

        $berkas = $request->all();
        
        $data = [
            'identity_user' => $berkas[ 'identity' ],
            'fileupload_id' => $berkas[ 'fileupload_id' ],
            'typefile' => $berkas[ 'typefile' ],
        ];

        $userupload = UserUpload::where( [
            'identity_user' => $berkas[ 'identity' ],
            'fileupload_id' => $berkas[ 'fileupload_id' ],
            'typefile' => $berkas[ 'typefile' ],
        ] )->first();

        if ( $userupload ) {
            if ( $data[ 'fileupload_id' ] == 1 ) {
                $file = FileUpload::findOrFail( $data[ 'fileupload_id' ] );
                $dataku = [
                    'avatar' => $file->namefile . '.' . $data[ 'typefile' ],
                ];

                $user = User::where( 'identity', $data[ 'identity_user' ] );
                $user->update( $dataku );
            }
            $userupload->update( $data );

            return response()->json( [
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
            ] );
        } else {
            if ( $data[ 'fileupload_id' ] == 1 ) {
                $file = FileUpload::findOrFail( $data[ 'fileupload_id' ] );
                $dataku = [
                    'avatar' => $file->namefile . '.' . $data[ 'typefile' ],
                ];
                
                $user = User::where( 'identity', $data[ 'identity_user' ] );
                $user->update( $dataku );
            }

            UserUpload::create( $data );
            return response()->json( [
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ] );
        }

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ): void {
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $identity ): RedirectResponse|View {
        $userupload = UserUpload::with( 'fileupload' )->where( 'identity_user', $identity )->get();
        if ( Auth::user()->identity == $identity ) {
            $data = [];
            foreach ( $userupload as $upload ) {
                $data[] = $upload->fileupload_id;
            }
            $applicant = Applicant::where( 'identity', $identity )->first();
            $success = FileUpload::whereIn( 'id', $data )->get();
            $fileupload = FileUpload::whereNotIn( 'id', $data )->get();
            return view( 'pages.userupload.index' )->with( [
                'identity' => $identity,
                'userupload' => $userupload,
                'fileupload' => $fileupload,
                'success' => $success,
                'applicant' => $applicant,
            ] );
        } else {
            return back();
        }

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

    public function destroy( $id ): JsonResponse {
        $user_upload = UserUpload::with( 'fileupload' )->findOrFail( $id );

        if ( $user_upload->fileupload->namefile == 'foto' ) {
            $dataku = [
                'avatar' => null,
            ];
            $user = User::where( 'identity', $user_upload->identity_user );
            $user->update( $dataku );
        }

        $user_upload->delete();
        return response()->json( [ 'status' => 'success' ] );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
}
