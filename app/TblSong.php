<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblSong extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_songs';
    protected $fillable = [
        'id',
        'singer_name',
        'song_url',
        'album_name',
        'rank_to_show',
        'song_name',
        'upload_user_id',
        'song_description',
        'status',
        'createdon',
        'file_size',
        'is_radio',
        ];
		

   
}
