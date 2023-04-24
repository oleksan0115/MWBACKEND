<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class VpFavouriteList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $table = 'vp_favorites_list';
    protected $fillable = [
        'id',
        'user_id',
        'park_id',
        'type',
        'reff_id',
        'title',
        'description',
        'latitude',
        'longitude',
        'pushnoti_datetime',
        'min_waittime',
        'status',
        'createdon',
        'is_updated_today',
        'updatedon',
    ];



  
}
