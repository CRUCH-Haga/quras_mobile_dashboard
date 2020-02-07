<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class WithdrawalHistory extends Model
{
    protected $table = 'tbl_withdrawal_history';

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
        'tx_id',
        'tx_datetime',
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