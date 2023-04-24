<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblChatRoom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_chat_rooms';
    protected $fillable = [
        'id',
        'chat_room',
        'createdby',
        'status',
        'showthis',
        'createdon',
        'subtitle',
        'ip_address',
        'showonmain',
        'ride_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'type',
        'credits',
        'mapping_url',
        ];


	
  
}
