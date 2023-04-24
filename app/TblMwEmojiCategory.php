<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblMwEmojiCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_mw_emoji_categories';
    protected $fillable = [
        'id',
        'emoji_category_name',
        'description',
        'enoji_image',
        'status',
        'createdon',
        ];
        
     

    public function getemojidata() {
        $user = auth()->user();
        $userid = $user->user_id;
    return $this->hasMany('App\TblMwMycollection','emoji_category_id','id')->where
								 ([
								 ['isemojis', '=', '1'],
								 ['status', '>', '0'],
								 ['user_id', '=', $userid],
								 ])->select(['id','product_id','product_image','emoji_category_id'])->orderBy('id', 'ASC')->groupBy('product_id');
   }
	
  
}
