<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TextMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_text_messages';
    protected $fillable = [
        'id',
        'sender_user_id',
        'receiver_user_id',
        'text_message',
        'createdon',
        'status',
        'ip_address',
        'sending_datetime',
        'user_text_email',
        'user_name',
        ];

	public function usersender()
    {
		
        return $this->belongsTo('App\User','sender_user_id','user_id');
    }
    
    	public function userreceiver()
    {
		
        return $this->belongsTo('App\User','receiver_user_id','user_id');
    }
	
	
		public function user()
    {
		
        return $this->belongsTo('App\User','sender_user_id','user_id');
    }
		
	
  
}
