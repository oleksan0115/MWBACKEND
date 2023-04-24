<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ToDoList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_todo_list';
    protected $fillable = [
        'id',
        'name',
        'reff_id',
        'type',
        'createdon',
        'status',
        'user_id',
        'order_no',
        'latitude',
        'longitude',
        'event_datetime',
        'parent_id',
        'image',
        'lastupdatedon',
        'title',
        'texttolink',
        'hyperlink',
        'eventtime',
        'min_waittime',
        'park_id',
        'pushnoti_datetime',
        ];


    	public function ridebyid()
    {
		 return $this->hasMany('App\TblRide','rides_id','reff_id')->where([
							['rides_status', '=', '1'],
							]);
    }
    
    
    public function getrestorant()
    {
		 return $this->hasMany('App\TblRestorant','res_id','reff_id');
    }
     
	 public function getshowtime()
    {
		 return $this->hasMany('App\TblWhatNextDetail','name','name')->where([
							['cat_id', '=', '1'],
							]);
    }
    
	
  
}
