<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblUserSpecialLogo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_user_special_logos';
    protected $fillable = [
        'id',
        'image_name',
        'image_desc',
        'image',
        'status',
        'createdon',
 
        ];


	
    
    
    
    
  
}
