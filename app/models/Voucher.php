<?php

class Voucher extends Model {
    protected $fillable = [
        'issued_to',
        'amount'
    ];
    protected static $rules = [
        'check_id'  => 'required',
        'issued_to' => 'required',
        'amount'    => 'required'
    ];

}