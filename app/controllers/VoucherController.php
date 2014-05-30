<?php

class VoucherController extends \BaseController {
    public $restful = true;


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$vouchers = Voucher::all();
        $result = $vouchers->toArray();
        return Response::json(['vouchers'=>$result]);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$voucher = new Voucher;
        $voucher->amount = Input::get('amount');
        $voucher->issued_to = Input::get('issued_to');
        $voucher->check_id = 23;

        if($voucher->save()) {
            $result = ['meta' => ['message'=>'success', 'id'=>$voucher->id]];
        } else {
            $result = ['meta'=> ['message'=>'failure']];
        }
        return Response::json($result);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function missingMethod($parameters = array()) {
        echo "Missing";
    }


}
