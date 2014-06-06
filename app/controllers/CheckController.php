<?php

class CheckController extends \BaseController {

    const INSUFFICIENT_FUNDS = 1;
    protected $stdVoucherAmt = 10;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $checks = Check::all();
        $result = $checks->toArray();

        return Response::json( [
            'meta'   => [ 'message' => 'success', 'code' => 200 ],
            'checks' => $result
        ] );


    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $check            = new Check;
        $check->amount    = Input::get( 'amount' );
        $check->check_no = Input::get( 'check_no' );
        $check->date_issued  = Input::get( 'date_issued' );

        if ( $check->save() ) {
            $result = [ 'meta' => [ 'message' => 'success', 'code' => 200, 'id' => $check->id ] ];
        } else {
            $result = [ 'meta' => [ 'message' => 'failure', 'code' => 1, 'errors' => $check->getErrors() ] ];
        }

        return Response::json( $result );
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show( $id ) {
        $check  = Check::findOrFail( $id );
        $result = $check->toArray();

        return Response::json( [
            'meta'   => [ 'message' => 'success', 'code' => 200 ],
            'checks' => $result
        ] );
    }

    public function getVouchers($id) {
        $check = Check::findOrFail($id);
        $vouchers = $check->vouchers();

        return Response::json( [
            'meta' => ['message' => 'success', 'code' => 200],
            'vouchers' => $vouchers
        ]);
    }

    public function createVouchers($id) {
        $check = Check::findOrFail($id);
        $totalVouchers = (int) Input::get( 'vouchers' );
        $toIssue = $totalVouchers * $this->stdVoucherAmt;
        if(($check->amount - $check->total_issued) < $toIssue ) {
            throw new \Jloosli\Fuel\FuelError("Not enough funds available on this check", static::INSUFFICIENT_FUNDS);
        }
        $vouchers = [];

        for($i=0; $i< $totalVouchers; $i++) {
            $voucher = new Voucher;
            $voucher->check_id = $id;
            $voucher->issued_to = Input::get('issued_to');
            $voucher->redeemed = 0;
            $voucher->amount = $this->stdVoucherAmt;
            $voucher->save();
            $vouchers[] = $voucher;
        }
        $check->total_issued += $toIssue;
        $check->save();
        // @todo Generate PDF
        return Response::json(['meta'=>['message'=>'success', 'code'=>200]]);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit( $id ) {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @throws Exception
     * @return Response
     */
    public function update( $id ) {
        $check            = Check::findOrFail($id);
        if ($check->redeemed === 1) {
            throw new \Exception('Check has already had vouchers created against it.', static::CHECK_USED);
        }
        $check->amount    = Input::get( 'amount' );
        $check->issued_to = Input::get( 'issued_to' );
        $check->check_id  = Input::get( 'check_id' );

        if ( $check->save() ) {
            $result = [ 'meta' => [ 'message' => 'success', 'code' => 200, 'id' => $check->id ] ];
        } else {
            $result = [ 'meta' => [ 'message' => 'failure', 'code' => 1, 'errors' => $check->getErrors() ] ];
        }

        return Response::json( $result );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @throws Exception
     * @return Response
     */
    public function destroy( $id ) {
        $check            = Check::findOrFail($id);
        if ($check->redeemed === 1) {
            throw new \Exception('Check has already had vouchers created', static::CHECK_USED);
        }
        $check->delete();
        return Response::json( ['meta'=>['message'=> 'success', 'code' => 200]] );
    }


}
