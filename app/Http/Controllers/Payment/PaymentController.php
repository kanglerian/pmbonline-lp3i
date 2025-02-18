<?php

namespace App\Http\Controllers\Payment;

use DateTime;
use App\Http\Controllers\Controller;
use App\Models\StatusApplicantsEnrollment;
use App\Models\StatusApplicantsRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PaymentController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index(): View {
        function getYearPMB() {
            $currentDate = new DateTime();
            $currentYear = $currentDate->format( 'Y' );
            $currentMonth = $currentDate->format( 'm' );
            return $currentMonth >= 10 ? $currentYear + 1 : $currentYear;
        }

        $pmb = request( 'pmb', getYearPMB() );
        $daftar_total_nominal = StatusApplicantsEnrollment::where(
            'pmb',
            $pmb
        )->sum( 'nominal' );
        $daftar_total_debit = StatusApplicantsEnrollment::where(
            'pmb',
            $pmb
        )->sum( 'debit' );
        $cash = $daftar_total_nominal - $daftar_total_debit;
        $total = StatusApplicantsRegistration::where( 'pmb', $pmb )->sum(
            'nominal'
        );
        $turnover = StatusApplicantsRegistration::where( 'pmb', $pmb )->sum(
            'deal'
        );
        return view( 'pages.payment.index' )->with( [
            'total' => $total,
            'turnover' => $turnover,
            'cash' => $cash,
        ] );
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

    public function store( Request $request ): void {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id ): void {
        //
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
            $presenter = StatusApplicantsEnrollment::findOrFail( $id );
            $presenter->delete();

            return redirect()->back()->with( 'message', 'Data pendaftaran berhasil dihapus!' );
        } catch ( \Throwable $th ) {
            return redirect()->back()->with( 'error', 'Terjadi sebuah kesalahan. Periksa koneksi Anda.' );
        }
    }

}
