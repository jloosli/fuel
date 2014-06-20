<?php

class VoucherController extends \BaseController {
    public $restful = true;


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $vouchers = Voucher::all();
        $result   = $vouchers->toArray();

        return Response::make( [
            'meta'     => [ 'message' => 'success', 'code' => 200 ],
            'vouchers' => $result
        ] );

    }


    /**
     * Create new voucher
     *
     * @return Response
     */
    public function create( $amount, $check_id, $issued_to ) {
        $voucher            = new Voucher;
        $voucher->amount    = $amount;
        $voucher->issued_to = $check_id;
        $voucher->check_id  = $issued_to;

        if ( $voucher->save() ) {
            return $voucher;
        }

        return false;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $voucher = $this->create( Input::get( 'amount' ), Input::get( 'check_id' ), Input::get( 'issued_to' ) );
        if ( $voucher !== false ) {
            $result = [ 'meta' => [ 'message' => 'success', 'code' => 200, 'id' => $voucher->id ] ];
        } else {
            $result = [ 'meta' => [ 'message' => 'failure', 'code' => 1, 'errors' => $voucher->getErrors() ] ];
        }

        return Response::make( $result );
    }


    /**
     * Shows whether a voucher is valid.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show( $id ) {
        $voucher = Voucher::find( $id );

        $messages = [ 'valid', 'used', 'invalid' ];
        $status   = $messages[ array_rand( $messages ) ];
        if ( $voucher ) {
            if ( $voucher->redeemed === "1" ) {
                $status = 'used';
            } else {
                $status = 'valid';
            }
        } else {
            $status = 'invalid';
        }
        switch ( $status ) {
            case 'valid':
                $data = [
                    'message'   => 'Voucher is Valid',
                    'issued_to' => $voucher->issued_to,
                    'amount'    => (float) $voucher->amount,
                    ''
                ];
                break;
            case 'used':
                $data = [
                    'message'   => 'Voucher has already been used',
                    'issued_to' => "",
                    'amount'    => 0
                ];
                break;
            case 'invalid':
                $data = [
                    'message'   => 'Voucher is Invalid',
                    'issued_to' => "",
                    'amount'    => 0
                ];
                break;
        }
        $data['status'] = $status;

        return View::make( 'voucher-valid', $data );

        return Response::make( [
            'meta'     => [ 'message' => 'success', 'code' => 200, 'used' => $result['redeemed'] === "1" ],
            'vouchers' => $result
        ] );


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @throws Exception
     * @return Response
     */
    public function edit( $id ) {

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
        $voucher = Voucher::findOrFail( $id );
        if ( $voucher->redeemed === 1 ) {
            throw new \Exception( 'Voucher has already been redeemed', static::VOUCHER_REDEEMED );
        }
        $voucher->amount    = Input::get( 'amount' );
        $voucher->issued_to = Input::get( 'issued_to' );
        $voucher->check_id  = Input::get( 'check_id' );

        if ( $voucher->save() ) {
            $result = [ 'meta' => [ 'message' => 'success', 'code' => 200, 'id' => $voucher->id ] ];
        } else {
            $result = [ 'meta' => [ 'message' => 'failure', 'code' => 1, 'errors' => $voucher->getErrors() ] ];
        }

        return Response::make( $result );

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
        $voucher = Voucher::findOrFail( $id );
        if ( $voucher->redeemed === 1 ) {
            throw new \Jloosli\Fuel\FuelError( 'Voucher has already been redeemed', static::VOUCHER_REDEEMED );
        }
        $voucher->delete();

        return Response::json( [ 'meta' => [ 'message' => 'success', 'code' => 200 ] ] );
    }

    public function print_vouchers( $voucher_ids = "", $pdf = true ) {
        $nf       = new NumberFormatter( 'en-US', NumberFormatter::SPELLOUT );
        $v        = Voucher::select( '*' )->whereIn( 'id', explode( ",", $voucher_ids ) )->get();
        $vouchers = $v->each( function ( $voucher ) use ( $nf ) {
            $url = route( 'getVoucher', [ 'id' => $voucher->id ] );
            ob_start();
            \PHPQRCode\QRcode::png( $url );
            $qrImg = base64_encode( ob_get_contents() );
            ob_end_clean();
            $voucher->qr          = sprintf( "<img src='data:image/png;base64,%s' />", $qrImg );
            $voucher->amount_text = sprintf( "%s dollars ($%0.2f) of GAS only ", ucfirst( $nf->format( 10 ) ), 10 );
            $voucher->issued_date = date( "M j, Y", strtotime( $voucher->created_at ) );

            return $voucher;
        } );
        $data     = [ 'data' => $vouchers ];
        $view     = View::make( 'vouchers' )->nest( 'child', 'child.voucher', $data );
        if ( $pdf === "0" ) {
            return $view;
        }
        $rendered = $view->render();
        $options  = [ 'page-size' => 'Letter'];
        if (isset($_ENV['WKHTMLTOPDF'])) {
            $options['binPath'] = $_ENV['WKHTMLTOPDF'];
        }
        $pdfFile  = new WkHtmlToPdf( $options );
        $pdfFile->addPage( $rendered );

        if(!$pdfFile->send()) {
            echo $pdfFile->getError();
        }
    }

    public function redeem() {
        $url    = Input::get( 'url' );
        $parts  = explode( '/', $url );
        $id     = end( $parts );
        $result = Voucher::where( 'id', $id )->where( 'redeemed', 0 )->get();
        if ( count( $result ) === 1 ) {
            $voucher           = $result[0];
            $voucher->redeemed = 1;
            $check             = $voucher->check;
            $check->total_redeemed += $voucher->amount;
            $voucher->save();
            $check->save();

            return $voucher;
        }

        return "Already Redeemed";

    }

}
