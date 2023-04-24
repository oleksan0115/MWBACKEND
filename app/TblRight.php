<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblRight extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_rights';
    protected $fillable = [
        'id',
        'right_group',
        'rights',
        'status',
        'createdon',
        ];
		

    
    
	
   
}
