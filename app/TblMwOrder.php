<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_orders';
    protected $fillable = [
        'id',
        'order_date',
        'user_id',
        'credites',
        'order_quantity',
        'discount',
        'discount_code',
        'status',
        'createdon',
        'product_id',
        ];
		

   
}
