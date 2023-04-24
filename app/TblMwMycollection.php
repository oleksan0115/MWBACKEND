<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwMycollection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_mycollections';
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
        'isemojis',
        'emoji_category_id',
        'sorting_order',
        'buy_from',
      
        
    ];

	public function user()
    {
		 return $this->belongsTo('App\User','giftedby_user_id','user_id')->select(['user_id','user_name']);
    }
	
	public function usertrade()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name']);
    }
	
	public function mwproduct()
    {
		 return $this->hasMany('App\MwProduct','id','product_id')->select(['id','product_name','product_description','product_image']);
    }
  
}
