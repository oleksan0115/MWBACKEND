<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ConcertEntry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'concert_entries';
    protected $fillable = [
        'id',
        'concert_name',
        'concert_id',
        'start',
        'end_date',
        'user_name',
        'user_id',
        'from',
        'createdon',
        'reff_id',
        ];

		public function user()
    {
		
        return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','rank','position']);
    }
	
  
}
