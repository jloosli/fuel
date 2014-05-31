<?php

class CheckController extends \BaseController {

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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $check            = new Check;
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
