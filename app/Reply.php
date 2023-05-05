<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Reply extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_chat_reply_reply';
    protected $fillable = [
        'id',
        'chat_reply_id',
        'chat_id',
        'reply_user_id',
        'chat_reply_msg',
        'chat_reply_date',
        'ip_address',
        'chat_reply_status',
        'no_of_likes',
        'no_of_thanks',
        'commented_on_user_id',
        ];


	
  
}
