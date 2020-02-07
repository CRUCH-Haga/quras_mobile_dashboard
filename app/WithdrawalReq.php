<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class WithdrawalReq extends Model
{
    protected $table = 'tbl_withdrawal_req';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'wallet',
        'amount',
        'verify_code',
        'verify_state',
        'send_flag',
        'register_date',
        'update_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}