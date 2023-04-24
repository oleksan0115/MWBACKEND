<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwChatSuscriber extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_chat_subscriber';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'user_name',
        'status',
        'createdon',
        'type',
        ];


	
  
}
