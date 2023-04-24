<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblBanner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_banners';
    protected $fillable = [
        'id',
        'banner_title',
        'banner_image',
        'banner_desc',
        'banner_url',
        'status',
        'createdon',
        'type',
        'order_no',
        ];
		
  
	
   
}
