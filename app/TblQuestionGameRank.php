<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TblQuestionGameRank extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	public $timestamps = false;
	protected $table = 'tbl_question_games_ranks';
    protected $fillable = [
        'id',
        'totalpoints',
        'user_name',
        'user_id',
        'position',
        'rank',
        'rank_status',
        'date_inst',
        'date_upd',
        'level',
        'noofanswered',
        'bounspoints',
        'current_level',
        'iscredit_paid',
        'credits_paid',
        'credits_paindon',
        ];
		

		public function user()
    {
		
        return $this->belongsTo('App\User','user_id','user_id')->select(['user_id','user_name','user_email','image','rank','position','totalpoints','user_status']);
    }
    
    
    
    public function chat()
    {
		
        return $this->belongsTo('App\TblChat','chat_id','chat_id');
    }
    
   
}
