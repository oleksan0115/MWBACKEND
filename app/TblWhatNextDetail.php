<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblWhatNextDetail extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_whatnext_details';
    protected $fillable = [
        'id',
        'name',
        'cat_id',
        'subcat_id',
        'lat',
        'lon',
        'url',
        'restaurant_id',
        'createdon',
        'status',
        'description',
        'fastpass',
        'event_inst_date',
        'event_day',
        'park_id',
        'ride_location',
        'showtime',
        'no_of_time_added',
        ];


    
    
    
  
}
