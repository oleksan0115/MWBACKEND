<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblChatSticky extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_chat_sticky';
    protected $fillable = [
        'id',
        'chat_id',
        'park',
        'status',
        'createdon',
        ];


	
  
}
