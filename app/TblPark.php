<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblPark extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_park';
    protected $fillable = [
        'park_id',
        'park_name',
        '0_on_off',
        '1_on_off',
        '2_on_off',
        '3_on_off',
        '4_on_off',
        '5_on_off',
        '6_on_off',
        'status',
        'park_desc',
        'override_openingtime',
        'override_closingtime',
        ];
		

   
}
