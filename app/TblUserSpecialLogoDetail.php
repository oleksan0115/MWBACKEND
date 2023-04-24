<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblUserSpecialLogoDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_user_special_logos_detail';	
    protected $fillable = [
        'id',
        'user_id',
        'user_special_logos_id',
        'status',
        'createdon',
 
        ];

    // public function user()
    // {
		 // return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','image']);
    // }
	
      public function speciallogo()
    {
		 return $this->hasOne('App\TblUserSpecialLogo','id','user_special_logos_id');
    }
    
    
    
  
}
