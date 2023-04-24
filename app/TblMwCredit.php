<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwCredit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_credits';
    protected $fillable = [
        'id',
        'amount',
        'credits',
        'type',
        'status',
        'createdon',
        'app_store_product_ids',
        ];
		

   
}
