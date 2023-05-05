<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblRealtime extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_myrealtime';
    protected $fillable = [
        'id',
        'datetime',
        'prefix',
        'msg',
        'status',
        'createdon',
        'reff_id',
        'entryfrom',
        ];


	
  
}
