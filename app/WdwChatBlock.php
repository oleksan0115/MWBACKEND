<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwChatBlock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_chat_block';
    protected $fillable = [
        'id',
        'user_id',
        'ban_chat_id',
        'status',
		'ip_address',
        'createdon',
        'reasion_for_ban',
        ];


	
  
}
