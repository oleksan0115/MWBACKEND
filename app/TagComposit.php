<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TagComposit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_tags_chat_composit';
    protected $fillable = [
        'id',
        'tags_id',
        'chat_id',
        'createdon',
        'ip_address',
        'user_id',
        ];


	public function gettagged()
    {
		return $this->hasMany('App\Tag','id','tags_id')->select(['id','tags_name']);
    }
  
}
