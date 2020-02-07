<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 9/9/2019
 * Time: 4:02 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class BackOffice extends Model
{
    protected $table = 'tbl_backoffice';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'email',
        'wallet',
        'amount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}