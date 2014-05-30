<?php

class Check extends Model {
    protected static $rules = [
        'amount' => 'required',
        'check_no' => 'required',
        'date_issued' => 'required'
    ];
}