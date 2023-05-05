<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WdwChatRoom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'wdw_chat_rooms';
    protected $fillable = [
        'id',
        'chat_room',
        'createdby',
        'status',
        'createdon',
        'subtitle',
        'ip_address',
        'showonmain',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'type',
        'credits',
        'mapping_url',
        ];


	
  
}
