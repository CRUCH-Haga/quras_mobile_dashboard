<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 9/10/2019
 * Time: 3:29 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'tbl_step';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'step', 'from_date', 'to_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
}