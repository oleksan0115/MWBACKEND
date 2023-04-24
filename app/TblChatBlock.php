<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblChatBlock extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_chat_block';
    protected $fillable = [
        'id',
        'user_id',
        'ban_chat_id',
        'status',
        'createdon',
        'reasion_for_ban',
        'ip_address',
        ];


	
  
}
