<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblAdvertisePost extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_advertise_post';
    protected $fillable = [
        'id',
        'chat_id',
        'user_id',
        'status',
        'username',
        'username_link',
        'user_image',
        'show_after_noof_post',
        'ip_address',
        'isreplaced',
        'ispriority',
        'lounge',
        
    ];
	
	
    
    public function chat()
    {
		return $this->belongsTo('App\TblChat','chat_id','chat_id');
 
    } 

  
}
