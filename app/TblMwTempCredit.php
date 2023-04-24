<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwTempCredit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_temp_credits';
    protected $fillable = [
        'id',
        'user_id',
        'amount',
        'credits',
        'createdon',
        'status',
        'ip_address',
        'order_from',
        'user_name',
        'transaction_id',
        'apptype',
        'appname',
        'appversion',
        'os',
    
        ];

    
    
    
  
}
