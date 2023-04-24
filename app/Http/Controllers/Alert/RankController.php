<?php
namespace App\Http\Controllers\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\TblRankReport;

use App\WdwLeaderBoard;
use App\TblLeaderBoard;
use App\TblLeaderBoardDetail;
use App\TblRankPointDetail;


class RankController extends Controller
{
     public function AddorInsertTopUserPoints($user_id ,$points , $type ,$park_name ,$who_is_user_id="", $ip_address="") 
	 {
		
		if($user_id>0)
	{
	
		if($park_name=='WDW')
			{	//WDW Park Leader Board 
		
		$getleaderboard = WdwLeaderBoard::where([
							['user_id', '=', $user_id],
							['date', '=', now()],
							])->count();
					
				if($getleaderboard  > 0 )
					{
					WdwLeaderBoard::where([
							['user_id', '=', $user_id],
							['date', '=', now()],
							])->update(['totalpoints' => \DB::raw('totalpoints + ' . $points . '')]);						
					}
					 else
					 {
						$boardentry = new WdwLeaderBoard;  
						$boardentry->user_id = $user_id;
						$boardentry->totalpoints = $points;
						$boardentry->date = now();
						$boardentry->save();
					 }
			} //WDW Park Leader Board
			else
			{
				
			$getleaderboard = TblLeaderBoard::where([
							['user_id', '=', $user_id],
							['date', '=', now()],
							])->count();
					
				if($getleaderboard  > 0 )
					{
					TblLeaderBoard::where([
							['user_id', '=', $user_id],
							['date', '=', now()],
							])->update(['totalpoints' => \DB::raw('totalpoints + ' . $points . '')]);						
					}
					 else
					 {
						$tblentry = new TblLeaderBoard;  
						$tblentry->user_id = $user_id;
						$tblentry->totalpoints = $points;
						$tblentry->date = now();
						$tblentry->save();
					 }
				 
			}
			
			
			//Insert leaderboards points detail for reporting
			$tblleaderboardentry = new TblLeaderBoardDetail;  
			$clientIP = request()->ip();
			$tblleaderboardentry->user_id = $user_id;
			$tblleaderboardentry->availpoints = $points;
			$tblleaderboardentry->Type = $type;
			$tblleaderboardentry->status = 1;
			$tblleaderboardentry->Park_name = $park_name;
			$tblleaderboardentry->who_is_user_id = $who_is_user_id;
			$tblleaderboardentry->ip_address = $clientIP;
			$tblleaderboardentry->save();
			
			//Insert leaderboards points detail for reporting
			$tblrankentry = new TblRankPointDetail; 
			$clientIP = request()->ip();			
			$tblrankentry->user_id = $user_id;
			$tblrankentry->availpoints = $points;
			$tblrankentry->Type = $type;
			$tblrankentry->status = 1;
			$tblrankentry->Park_name = $park_name;
			$tblrankentry->who_is_user_id = $who_is_user_id;
			$tblrankentry->ip_address = $clientIP;
			$tblrankentry->save();
	
		}
	
	 } 
	
	public function updateUserRank($user_id ,$points , $type ,$park_name ,$who_is_user_id="", $ip_address="") 
	{
	
	TblRankReport::where('user_id', $user_id)->update(['totalpoints' => \DB::raw('totalpoints + ' . $points . '')]);
	
	if($type =='waittime')
	{
		User::where('user_id', $user_id)->update(['totalpoints' => \DB::raw('totalpoints + ' . $points . '')]);
		User::where('user_id', $user_id)->update(['totalpoints' => \DB::raw('totalpoints + ' . $points . ''),'user_waittime_points' => \DB::raw('user_waittime_points + ' . $points . '') ]);
	}
	else
	{
		User::where('user_id', $user_id)->update(['totalpoints' => \DB::raw('totalpoints + ' . $points . '')]);	
		
	}

	$this->AddorInsertTopUserPoints( $user_id ,$points , $type ,$park_name,$who_is_user_id , $ip_address ) ;
	
	
	
	
	TblRankReport::where('user_id', $user_id)->update(['rank' => \DB::raw('round(((totalpoints /300)*10),2 )'),'date_upd' => \DB::raw('NOW()')]);
	User::where('user_id', $user_id)->update(['rank' => \DB::raw('round(((totalpoints /300)*10),2 )'),'date_upd' => \DB::raw('NOW()')]);
	

	
	switch ($type) {  
				case 'comments_likes_web';
				case 'comment_likes_iphone'; 
				case 'likes';
				case 'likes_post';
				case 'comments_likes_WDW';
				case 'web_dl_likes';
				case 'dont_like';
				case 'web_dl_donot_like';
				TblRankReport::where('user_id', $user_id)->update(['likes_points' => \DB::raw('likes_points + ' . $points . '')]);
				User::where('user_id', $user_id)->update(['likes_points' => \DB::raw('likes_points + ' . $points . '')]);	
						 
						
				break;  
				case 'thanks_for_comment_web';
				case 'thanks_for_post_web';
				case 'thanks_for_comment_iphone';
				case 'thanks_for_post_iphone';
				TblRankReport::where('user_id', $user_id)->update(['thanks_points' => \DB::raw('thanks_points + ' . $points . '')]);
				User::where('user_id', $user_id)->update(['thanks_points' => \DB::raw('thanks_points + ' . $points . '')]);
				break;  
			} 
	
		// if($park_name=='WDW')
		// {
			// /* modal ka name change karna h iss table ka model banega */
			// TblRankReport::where('user_id', $user_id)->update(['rank' => \DB::raw('round(((totalpoints /300)*10),2 )'),'date_upd' => \DB::raw('NOW()'),'totalpoints' => \DB::raw('totalpoints + ' . $points . '')]);
		
		// }
	
	}
	
	public function updateUserCredit($user_id ,$credit,$description, $type) 
	{
	
	User::where('user_id', $user_id)->update(['user_credits' => \DB::raw('user_credits + ' . $credit . '')]);	
	
	}
	
	
	
}
