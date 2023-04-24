<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblRankPointDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_ranks_points_details';
    protected $fillable = [
        'id',
        'user_id',
        'availpoints',
        'Type',
        'status',
        'createdon',
        'Park_name',
        'who_is_user_id',
        'ip_address',
        ];

	
	
  
}
