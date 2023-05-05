<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_tags';
    protected $fillable = [
        'id',
        'tags_name',
        'tags_description',
        'mapping_url',
        'status',
        'lastupdatedon',
        'createdon',
        'page_hits',
        'font_size',
        'ip_address',
        'user_id',
        'meta_titles',
        'meta_description',
        'meta_keywords',
        ];


		public function gettagdata()
    {
		return $this->hasMany('App\TagComposit','tags_id','id')->select(['id','tags_id','chat_id']);
    }
    
    
    
    
  
}
