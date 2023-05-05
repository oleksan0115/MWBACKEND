<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwOrderProduct extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_order_products';
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'product_quantity',
        'credites',
        'discount',
        'status',
        'createdon',
        'isemojis',
        'user_id',
        ];
		

   
}
