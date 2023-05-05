<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class MtUserFriend extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'mt_user_friends';
    protected $fillable = [
        'id',
        'user_id',
        'friend_id',
        'user_name',
        'friend_name',
        'status',
        'createdon',
        ];
		

    
   
}
