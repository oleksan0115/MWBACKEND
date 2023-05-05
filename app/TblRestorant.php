<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblRestorant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_restaurents';
    protected $fillable = [
        'res_id',
        'res_location_id',
        'res_name',
        'subcat_id',
        'cat_name',
        'res_description',
        'res_image',
        'res_add',
        'res_lat',
        'res_long',
        'res_city',
        'res_state',
        'res_country',
        'res_zipcode',
        'res_phone1',
        'res_phone2',
        'res_rating',
        'res_rating_hits',
        'menu_url',
        'status',
        'createdon',
        'mapping_url',
        'meta_description',
        'meta_keyword',
        'meta_title',
        'res_detail_page_url',
        'isdetail_scraping_done',
        'isscraping_done',
        'res_menu_url',
        'res_opening',
        'res_closing',
        'disney_restaurant_name',
        'park',
        'location',
        'park_id',
        'park_name',
     
        ];
		

   
}
