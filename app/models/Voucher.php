<?php

class Voucher extends Model {
    protected static $rules = [
        'check_id' => 'required',
        'issued_to' => 'required',
        'amount' => 'required'
    ];

}