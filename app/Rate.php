<?php
namespace App;


use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'tbl_rate';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'btc', 'btc_qrs', 'eth', 'btc_qrs', 'rate_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}