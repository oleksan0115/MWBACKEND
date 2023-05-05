<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwMyCollectionHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_mycollections_history';
    protected $fillable = [
        'id',
        'product_id',
        'product_name',
        'user_id',
        'product_credits',
        'product_quantity',
        'product_image',
        'product_description',
        'status',
        'createdon',
        'giftedby_user_id',
        'gift_date',
        'trans_description',
        'owner_only',
        'is_featured',
 
      
        
    ];

	
  
}
