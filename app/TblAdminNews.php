<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TblAdminNews extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_admin_news';
    protected $fillable = [
        'id',
        'new_title',
        'news_description',
        'news_description_wdw',
        'status',
        'createdon',
        'user_id',
        'news_description_web',
        'news_description_web_wdw',
        'park',
        'pulse_updated',
        'istoday_news',
        'hyperlink',
        'texttolink',
        'newstype_free',
        'newstype_paid',
        'newstype_normal',
        'updated_on',
        ];


    public function user()
    {
		 return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints','user_status','default_park','isdirect_msg','likes_points','thanks_points','quality_rank as total_likes_points']);
    }
  
}
