<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwChatAutoBump extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_chat_autobumps';
    protected $fillable = [
        'id',
        'chat_id',
        'park',
        'status',
        'createdon',
        'chat_room_id',
       
       
        
    ];
	
	
  
}
