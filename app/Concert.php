<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Concert extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'concerts';
    protected $fillable = [
        'id',
        'concert_name',
        'description',
        'start_date',
        'end_date',
        'type',
        'user_id',
        'status',
        'createdon',
        'result',
        ];

		public function user()
    {
		
        return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','rank','position']);
    }
	
  
}
