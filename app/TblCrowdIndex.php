<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblCrowdIndex extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_crowd_index';
    protected $fillable = [
        'id',
        'crowd_index',
        'status',
        'createon',
        'createdon',
        'park_id',
        'lastupdatedon',
        ];


    
    
    
  
}
