<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwProductTradeRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_product_trade_request';
    protected $fillable = [
        'id',
        'product_id',
        'mycollection_id',
        'product_name',
        'product_credits',
        'product_image',
        'product_description',
        'user_id',
        'trade_request_user_id',
        'trade_request_collection_id',
        'status',
        'createdon',
        ];
		

	public function user()
    {
		
        return $this->belongsTo('App\User','trade_request_user_id','user_id')->select('user_id','user_name as requested_prod_username');
    }
	
		public function slefuser()
    {
		
        return $this->belongsTo('App\User','user_id','user_id')->select('user_id','user_name as requested_prod_username');
    }
    
    public function mycollection()
    {
		
        return $this->belongsTo('App\TblMwMycollection','trade_request_collection_id','id')->select('id','product_name as requested_prod_name','product_image as requested_prod_image');
    }
    
    
  
    
   
}
