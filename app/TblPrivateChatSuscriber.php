<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblPrivateChatSuscriber extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_private_chat_subscriber';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'user_name',
        'chat_room_id',
        'status',
        'createdon',
        'type',
        ];


	
  
}
