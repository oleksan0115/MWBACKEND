<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblFollowSuscriber extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_follow_subscriber';
    protected $fillable = [
        'id',
        'user_id',
        'friend_id',
        'friend_name',
        'status',
        'createdon',
        'park',
        ];
		

   
}
