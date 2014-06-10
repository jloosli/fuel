<?php

class Voucher extends Model {

    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function($model) {
            $model->id = uniqid();
        });
    }

    protected $fillable = [
        'issued_to',
        'amount'
    ];
    protected static $rules = [
        'check_id'  => 'required',
        'issued_to' => 'required',
        'amount'    => 'required'
    ];

    public function check() {
        $this->belongsTo('Check');
    }

}