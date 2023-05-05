<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use App\LoginUserTracking;
use App\TblChat;
use App\Comment;
use App\CommentReply;
use App\TblLike;
use App\ThankYou;
use App\TblLikeComment;
use App\TblReport;
use App\MwProduct;
use App\TblRankPointDetail;
use App\TblMwCreditDetail;
use App\AdminCreditSetting;
use App\TblBanIp;
use App\TblChatAdminSuscriber;
use App\WdwChatSuscriber;
use App\TblUserWaitTime;
use App\TblChatSuscriber;
use App\TblPrivateChatSuscriber;
use App\TblBofDaySuscriber;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alert\AlertController;

class UserController extends APIController
{
	
	
	public function activeUser(Request $request)	
    {
       
		$track_user_detail = LoginUserTracking::select('*')->with('user')->paginate(100);
		
			
			$startdate =date('Y-m-d',strtotime("-30 days"));// for 30 days
			//$startdate =date('Y-m-d'); // for current day
			$enddate = date('Y-m-d');
			$nPost_counts = 0;
			$nComments_Results = 0;
			$nReplies_Results = 0;
			$nLikes_Results = 0;
			$nThanks_counts = 0;
			$nComments_Likes_counts = 0;
			$nActive_Users_counts = 0;
			
			
				$nPost_counts = TblChat::select('*')->whereBetween('chat_time', [$startdate, $enddate])->count();  
				$nComments_Results = Comment::select('*')->whereBetween('chat_reply_date', [$startdate, $enddate])->count();
				$nReplies_Results = CommentReply::select('*')->whereBetween('chat_reply_date', [$startdate, $enddate])->count();
				$nLikes_Results = TblLike::select('*')->whereBetween('createdon', [$startdate, $enddate])->count();
				$nThanks_counts = ThankYou::select('*')->whereBetween('createdon', [$startdate, $enddate])->count();
				$nComments_Likes_counts = TblLikeComment::select('*')->whereBetween('createdon', [$startdate, $enddate])->count();
				$nActive_Users_counts = LoginUserTracking::select('*')->whereBetween('login_datetime', [$startdate, $enddate])->count();
								

			
		
		return view('layouts/activeuser')
		->with('posts', $track_user_detail)
		->with('startdate', $startdate)
		->with('enddate', $enddate)
		->with('getpostcountbyday', $nPost_counts)
	    ->with('getcommentcountbyday', $nComments_Results)
	    ->with('getreplycountbyday', $nReplies_Results)
	     ->with('getlikecountbyday', $nLikes_Results)
	     ->with('getthankyoucountbyday', $nThanks_counts)
	     ->with('getcommentlikecountbyday', $nComments_Likes_counts)
	     ->with('getactiveusercountbyday', $nActive_Users_counts);

    }
    
	public function user(Request $request)
    {
     
          $id = $request->id;
          $action = $request->action;
		  
		  $search = $request->search;
	
		
          
          if ($action =='delete') { 	User::where([['user_id', '=', $id ]])->update(['user_status' => '2']); }
          if ($action =='moderator') { 	$query = "UPDATE tbl_user SET ismoderator = IF(ismoderator = '1', '0', IF(ismoderator = '0', '1', ismoderator)) WHERE user_id =". $id ; DB::select($query); }
          if ($action =='admin'){ 	    $query = "UPDATE tbl_user SET isadmin = IF(isadmin = '1', '0', IF(isadmin = '0', '1', isadmin)) WHERE user_id =". $id ; DB::select($query); }
          if ($action =='ispress') { 	$query = "UPDATE tbl_user SET ispress = IF(ispress = '1', '0', IF(ispress = '0', '1', ispress)) WHERE user_id =". $id ; DB::select($query); }
          if ($action =='iswebcast') { 	$query = "UPDATE tbl_user SET iswebcast = IF(iswebcast = '1', '0', IF(iswebcast = '0', '1', iswebcast)) WHERE user_id =". $id ; DB::select($query); }
          if ($action =='isprivate') { 	$query = "UPDATE tbl_user SET isprivate = IF(isprivate = '1', '0', IF(isprivate = '0', '1', isprivate)) WHERE user_id =". $id ; DB::select($query); }
          if ($action =='iscomposer') { $query = "UPDATE tbl_user SET iscomposer = IF(iscomposer = '1', '0', IF(iscomposer = '0', '1', iscomposer)) WHERE user_id =". $id ; DB::select($query); }
          if ($action =='Approved') { User::where([['user_id', '=', $id ]])->update(['user_status' => '1']);  }
          if ($action =='disapprove') { User::where([['user_id', '=', $id ]])->update(['user_status' => '2']);  }
          if ($action =='varified') { User::where([['user_id', '=', $id ]])->update(['isvarified' => '1']);  }
         
         
        	$user_detail = User::select('*')->where
								 ([
								 ['user_name', '!=', 'null'],
								 ['user_email', '!=', ''],
								 ['user_name', 'LIKE', '%'. $search. '%'],
								 ])
        	                   ->orderBy('creation_date', 'DESC')->paginate(50);
            
          //dd($user_detail);
           
		    return view('layouts/users')->with('users', $user_detail);

    }
	
	
	public function changeUserDetail(Request $request)
    {
		  $msg="";
	      $action ="";
		  $pumac_address = "";
          $id = $request->uid;
          $action = $request->action;
		  $searchtext = $request->search;
		  $searchornot= '';	
		  $ip_address=$_SERVER['REMOTE_ADDR'];
		  $puser_name = $request->txtuser_name;
          $puser_email = $request->txtuser_email;
		  $pumac_address = $request->txtumac_address;
		  $prtotalpoints = $request->txtrtotalpoints;
		  $prlikes_points = $request->txtlikes_points;
		  $prthanks_points = $request->txtthanks_points;
		  $txtuser_credits = $request->txtuser_credits;
		  // dd($request);
		  
		  $isUserExist = User::select('*')->where([ ['user_id', '=', $id],])->count();	
		  $user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();
		  $rank = $user_detail->rank;
		  $u_mac_address = $user_detail->mac_address;
		  
		  $get_username_by_id = $user_detail->user_name;
		  $get_useremail_by_id = $user_detail->user_email;
		  
		  $login_admin = $request->session()->get('user_id');
		  $hostname = env("APP_URL", "somedefaultvalue"); 
		  $currentpath= Route::getFacadeRoot()->current()->uri();
		  $pagefrom = $hostname . '/'.$currentpath.'&action='.$action;



		$user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();
		  /* for search */
		  $isExist = User::select('*')->where([ ['user_name', 'LIKE', '%'. $searchtext. '%'],])->count();  
		  if($searchtext == '' ||  $isExist == 0)
		  {
		   $searchornot = User::select('*')->where([ ['user_id', '=', $id],])->first();  
		  }
		  else
		  {
			$searchornot = User::select('*')->where([ ['user_name', '!=', 'null'], ['user_name', 'LIKE', '%'. $searchtext. '%'],])->first();  
		  } 
		  /* for search */
		  

			if (isset($request->btnupdatename)) {
			   
				
				//$isExist_username = User::where([['user_name', '=', $puser_name],])->get();
				
				$res = User::where([['user_name', '=', $puser_name]])->exists();
				if($res == true)
				{
				$msg = "UserName Already Exist";
				return view('layouts/change_user_detail')->with('changeuser',$user_detail)
				->with('searchornot',$searchornot)
				->with('message',$msg);	
				}
				else
				{
				User::where([['user_id', '=', $id ]])->update(['user_name' => $puser_name]);
				$user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();
				/* for search */
				$isExist = User::select('*')->where([ ['user_name', 'LIKE', '%'. $searchtext. '%'],])->count();  
				if($searchtext == '' ||  $isExist == 0)
				{
				$searchornot = User::select('*')->where([ ['user_id', '=', $id],])->first();  
				}
				else
				{
				$searchornot = User::select('*')->where([ ['user_name', '!=', 'null'], ['user_name', 'LIKE', '%'. $searchtext. '%'],])->first();  
				} 
			  /* for search */
				$msg = "UserName Updated Successfully";
				return view('layouts/change_user_detail')->with('changeuser',$user_detail)
				->with('searchornot',$searchornot)
				->with('success',$msg);	
				}
			
			}
			
			if (isset($request->btnupdateemail)) {
			   
				
				//$isExist_username = User::where([['user_name', '=', $puser_name],])->get();
				
				$res = User::where([['user_email', '=', $puser_email]])->exists();
				if($res == true)
				{
				$msg = "UserEmail Already Exist";
				return view('layouts/change_user_detail')->with('changeuser',$user_detail)
				->with('searchornot',$searchornot)
				->with('message',$msg);	
				}
				else
				{
				User::where([['user_id', '=', $id ]])->update(['user_email' => $puser_email]);
				$user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();
				/* for search */
				$isExist = User::select('*')->where([ ['user_name', 'LIKE', '%'. $searchtext. '%'],])->count();  
				if($searchtext == '' ||  $isExist == 0)
				{
				$searchornot = User::select('*')->where([ ['user_id', '=', $id],])->first();  
				}
				else
				{
				$searchornot = User::select('*')->where([ ['user_name', '!=', 'null'], ['user_name', 'LIKE', '%'. $searchtext. '%'],])->first();  
				} 
			  /* for search */
				$msg = "UserEmail Updated Successfully";
				return view('layouts/change_user_detail')->with('changeuser',$user_detail)
				->with('searchornot',$searchornot)
				->with('success',$msg);	
				}
			
			}
		   
		   if (isset($request->btnupdatepoints)) { 
		
		   if(empty($prtotalpoints))
			{
				$msg = "User points Can not be empty<br>";				
			}			
			if($msg=="")
			{  
					if($id > 0)
					{		
						 
						
					
						User::where('user_id', $id)->update(['totalpoints' => \DB::raw('totalpoints + ' . $prtotalpoints . ''),'date_upd' => \DB::raw('NOW()')]);
						
						
						
						$tblrankentry = new TblRankPointDetail; 		
						$tblrankentry->user_id = $id;
						$tblrankentry->availpoints = $prtotalpoints;
						$tblrankentry->Type = '';
						$tblrankentry->status = 1;
						$tblrankentry->Park_name = '';
						$tblrankentry->who_is_user_id = 0;
						$tblrankentry->ip_address = $ip_address;
						$tblrankentry->save();
						
						
						
						
						$new_credits = 0;
						$result = 	User::select(DB::raw('round((rank-current_points_atcredits),2) as 		credits'))->where('user_id','=',$id)->first(); 
						
						$new_credits = $result->credits;
				
						User::where('user_id', $id)
							->update([
							'last_updated_credits' => \DB::raw('round((rank-current_points_atcredits),2)'),
							'user_credits' => \DB::raw('round((user_credits+(rank - current_points_atcredits)),2)'),
							'current_points_atcredits' => \DB::raw('round(rank,2)'),
							'credit_updatedon' => NOW()
							]);
						
						
						$tblmwentry = new TblMwCreditDetail; 		
						$tblmwentry->user_id = $id;
						$tblmwentry->credits = $new_credits;
						$tblmwentry->type = 'admin';
						$tblmwentry->points_used = 0;
						$tblmwentry->ip_address = $ip_address;
						$tblmwentry->save();
			
						
						
						$msg ='Points Updated Successfully..! ';
						
						
					}
					else
					{
						$msg ='Invalid User ';
					}
			} 
		}
		   
		   if (isset($request->btnlikes_points)) { 
		
		   if(empty($prlikes_points))
			{
				$msg = "Like points Can not be empty<br>";				
			}			
			if($msg=="")
			{  
					if($id > 0)
					{		
						User::where('user_id', $id)->update(['likes_points' => \DB::raw('likes_points + ' . $prlikes_points . ''),'date_upd' => \DB::raw('NOW()')]);
						
						User::where('user_id', $id)->update(['rank' => \DB::raw('(((totalpoints/300)*10))')]);
						
						
						
						$tblrankentry = new TblRankPointDetail; 		
						$tblrankentry->user_id = $id;
						$tblrankentry->availpoints = $prlikes_points;
						$tblrankentry->Type = '';
						$tblrankentry->status = 1;
						$tblrankentry->Park_name = '';
						$tblrankentry->who_is_user_id = 0;
						$tblrankentry->ip_address = $ip_address;
						$tblrankentry->save();
						
						
						
						
						$new_credits = 0;
						$result = 	User::select(DB::raw('round((rank-current_points_atcredits),2) as 		credits'))->where('user_id','=',$id)->first(); 
						
						$new_credits = $result->credits;
				
						User::where('user_id', $id)
							->update([
							'last_updated_credits' => \DB::raw('round((rank-current_points_atcredits),2)'),
							'user_credits' => \DB::raw('round((user_credits+(rank - current_points_atcredits)),2)'),
							'current_points_atcredits' => \DB::raw('round(rank,2)'),
							'credit_updatedon' => NOW()
							]);
						
						
						$tblmwentry = new TblMwCreditDetail; 		
						$tblmwentry->user_id = $id;
						$tblmwentry->credits = $new_credits;
						$tblmwentry->type = 'admin';
						$tblmwentry->points_used = 0;
						$tblmwentry->ip_address = $ip_address;
						$tblmwentry->save();
			
						
						
						$msg ='Points Updated Successfully..! ';
						
						
					}
					else
					{
						$msg ='Invalid User ';
					}
			} 
		}
		   
		   if (isset($request->btnthanks_points)) { 
		
		   if(empty($prthanks_points))
			{
				$msg = "Thank points Can not be empty<br>";				
			}			
			if($msg=="")
			{  
					if($id > 0)
					{		
						
						User::where('user_id', $id)->update(['thanks_points' => \DB::raw('thanks_points + ' . $prthanks_points . ''),'date_upd' => \DB::raw('NOW()')]);
						
						User::where('user_id', $id)->update(['rank' => \DB::raw('(((totalpoints/300)*10))')]);
						
						
						
						$tblrankentry = new TblRankPointDetail; 		
						$tblrankentry->user_id = $id;
						$tblrankentry->availpoints = $prthanks_points;
						$tblrankentry->Type = '';
						$tblrankentry->status = 1;
						$tblrankentry->Park_name = '';
						$tblrankentry->who_is_user_id = 0;
						$tblrankentry->ip_address = $ip_address;
						$tblrankentry->save();
						
						
						
						
						$new_credits = 0;
						$result = 	User::select(DB::raw('round((rank-current_points_atcredits),2) as 		credits'))->where('user_id','=',$id)->first(); 
						
						$new_credits = $result->credits;
				
						User::where('user_id', $id)
							->update([
							'last_updated_credits' => \DB::raw('round((rank-current_points_atcredits),2)'),
							'user_credits' => \DB::raw('round((user_credits+(rank - current_points_atcredits)),2)'),
							'current_points_atcredits' => \DB::raw('round(rank,2)'),
							'credit_updatedon' => NOW()
							]);
						
						
						$tblmwentry = new TblMwCreditDetail; 		
						$tblmwentry->user_id = $id;
						$tblmwentry->credits = $new_credits;
						$tblmwentry->type = 'admin';
						$tblmwentry->points_used = 0;
						$tblmwentry->ip_address = $ip_address;
						$tblmwentry->save();
			
						
						
						$msg ='Points Updated Successfully..! ';
						
						
					}
					else
					{
						$msg ='Invalid User ';
					}
			} 
		}
		   
		   if (isset($request->btncredits)) { 
		
		   if(empty($txtuser_credits))
			{
				$msg = "credits value can not be empty.<br>";				
			}			
			if($msg=="")
			{  
					if($id > 0)
					{		
						 
						
						User::where('user_id', $id)->update(['user_credits' => \DB::raw('user_credits + ' . $txtuser_credits . ''),'last_updated_credits' => \DB::raw('user_credits + ' . $txtuser_credits . ''),'date_upd' => \DB::raw('NOW()'),'credit_updatedon' => \DB::raw('NOW()')]);
						
						$description = 'Admin give you '.$txtuser_credits.' credits';
						
						$tblmwentry = new TblMwCreditDetail; 		
						$tblmwentry->user_id = $id;
						$tblmwentry->credits = $txtuser_credits;
						$tblmwentry->type = 'admin';
						$tblmwentry->points_used = 0;
						$tblmwentry->ip_address = $ip_address;
						$tblmwentry->description = $description;
						$tblmwentry->current_rank_atthis_point = $rank;
						$tblmwentry->save();
			
						
						$msg ='Successfully Updated..! ';
					}
					else
					{
						$msg ='Invalid User ';
					}
			} 
		}
	   
		   if ($action =='delete') { User::where([['user_id', '=', $id ]])->update(['user_status' => '2']); 
		   $msg ='Delete';
		   }
		   
		   if ($action =='moderator') { 	$query = "UPDATE tbl_user SET ismoderator = IF(ismoderator = '1', '0', IF(ismoderator = '0', '1', ismoderator)) WHERE user_id =". $id ; DB::select($query);  $msg ='Moderator';}
           if ($action =='admin'){ 	    $query = "UPDATE tbl_user SET isadmin = IF(isadmin = '1', '0', IF(isadmin = '0', '1', isadmin)) WHERE user_id =". $id ; DB::select($query); $msg ='Admin';}
           if ($action =='ispress') { 	$query = "UPDATE tbl_user SET ispress = IF(ispress = '1', '0', IF(ispress = '0', '1', ispress)) WHERE user_id =". $id ; DB::select($query); $msg ='Press'; }
           if ($action =='iswebcast') { 	$query = "UPDATE tbl_user SET iswebcast = IF(iswebcast = '1', '0', IF(iswebcast = '0', '1', iswebcast)) WHERE user_id =". $id ; DB::select($query); $msg ='Webcast';}
           if ($action =='isprivate') { 	$query = "UPDATE tbl_user SET isprivate = IF(isprivate = '1', '0', IF(isprivate = '0', '1', isprivate)) WHERE user_id =". $id ; DB::select($query); $msg ='News';}
           if ($action =='iscomposer') { $query = "UPDATE tbl_user SET iscomposer = IF(iscomposer = '1', '0', IF(iscomposer = '0', '1', iscomposer)) WHERE user_id =". $id ; DB::select($query); $msg ='Composer';}
           if ($action =='Approved') { User::where([['user_id', '=', $id ]])->update(['user_status' => '1']); $msg ='Approved'; }
           if ($action =='disapprove') { User::where([['user_id', '=', $id ]])->update(['user_status' => '2']); deleteFromAutoEmails($id);
		   $msg ='Disapprove'; }
		   if ($action =='varified') { User::where([['user_id', '=', $id ]])->update(['isvarified' => '1']); $msg ='Approved'; }
		   if ($action =='bandevice') { 
			$banip = TblBanIp::where ([ ['user_id', '=', $id], ])->select('*')->count();
				if($banip == 0 )
				{
						$entry = new TblBanIp; 
						$adminIP = request()->ip();						
						$entry->ban_add = $u_mac_address;
						$entry->user_id = $id;
						$entry->banby = $login_admin;
						$entry->banby_ip_address = $adminIP;
						$entry->pagefrom = $pagefrom;
						$entry->save();
					
				}	
				
			/*
			On Ban Device Just Block the user to psubmit waittime ,
			I have Added new field of waittime status if 1 the can submit if 0 then can not submit.
			*/
			 User::where([['user_id', '=', $id ]])->update(['waittime_status' => '0']); 
			 TblUserWaitTime::where([['user_id', '=', $id ],['status', '=', '1' ]])->update(['status' => '4','upd_time' => NOW()]); 
			 User::where([['user_id', '=', $id ]])->update(['iscreditsfreez' => '1','freezedon' => now()]); 
			
			static::deleteFromAutoEmails($id);
			 $msg ='Ban User'; 
			 }
          
		   if ($action =='banall') {
					/*
					On Ban All  Just Block the user from Apps , wait time and Lounge ..
					I have Added new field of waittime status if 1 the can submit if 0 then can not submit.
					*/			  
			$banip = TblBanIp::where ([ ['user_id', '=', $id], ])->select('*')->count();
				if($banip == 0 )
				{
						$entry = new TblBanIp; 
						$adminIP = request()->ip();						
						$entry->ban_add = $u_mac_address;
						$entry->user_id = $id;
						$entry->banby = $login_admin;
						$entry->banby_ip_address = $adminIP;
						$entry->pagefrom = $pagefrom;
						$entry->save();
					
				}	
				
			/*
			On Ban Device Just Block the user to psubmit waittime ,
			I have Added new field of waittime status if 1 the can submit if 0 then can not submit.
			*/
			 User::where([['user_id', '=', $id ]])->update(['user_status' => '2','waittime_status' => '0','iscreditsfreez' => '1','freezedon' => now()]); 
			
			 TblUserWaitTime::where([['user_id', '=', $id ],['status', '=', '1' ]])->update(['status' => '3','upd_time' => NOW()]); 
			 
			 User::where([['user_id', '=', $id ]])->update(['iscreditsfreez' => '1','freezedon' => now()]); 
			
			static::deleteFromAutoEmails($id);
			 $msg ='Ban All'; 
			 }
		  
		   if ($action =='unban') {
			/*On UnBan All  Just unBlock the user from Apps , wait time and Lounge ..  */ 			  
			TblBanIp::where('user_id', $id)->delete();
			 User::where([['user_id', '=', $id ]])->update(['user_status' => '1','waittime_status' => '1','iscreditsfreez' => '0','freezedon' => now()]); 
			 $msg ='UnBan All'; 
			 }
		  
		  // $upd_points = "update tbl_user set user_credits = (user_credits+(rank - current_points_atcredits)) ,current_points_atcredits=rank,credit_updatedon=NOW()";
		  // DB::select($upd_points);
		  
		  
		  $user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();
		  /* for search */
		  $isExist = User::select('*')->where([ ['user_name', 'LIKE', '%'. $searchtext. '%'],])->count();  
		  if($searchtext == '' ||  $isExist == 0)
		  {
		   $searchornot = User::select('*')->where([ ['user_id', '=', $id],])->first();  
		  }
		  else
		  {
			$searchornot = User::select('*')->where([ ['user_name', '!=', 'null'], ['user_name', 'LIKE', '%'. $searchtext. '%'],])->first();  
		  } 
		  /* for search */
		  
		  
		
		  return view('layouts/change_user_detail')->with('changeuser',$user_detail)->with('searchornot',$searchornot)->with('success',$msg);

    }
    
	public function userMrHistory(Request $request)
    {
		$parameters = $request->uid;

		$wherecls =" WHERE tld.user_id  ='". $parameters."'  Order by tld.createdon desc";
		
			 
	$qry = "SELECT tld.availpoints, tld.id , tld.user_id  , tld.status  , tld.Type, tld.createdon as tld_date , tld.Park_name, tld.ip_address , tld_uid.user_name as username  , tld_whois.user_name as whois 
FROM  tbl_ranks_points_details as tld  left JOIN tbl_user as tld_uid ON (tld.user_id = tld_uid.user_id)
    left JOIN  tbl_user as tld_whois ON (tld.who_is_user_id = tld_whois.user_id )  ".$wherecls ;
	
	$rowcountsSQL = "select count(*) as rowcounts FROM  tbl_ranks_points_details as tld   ".$wherecls ;
	$res = DB::select($qry);

		  // $searchornot = TblRankPointDetail::select('*')->with('user')->where([ ['user_id', '=', $id],])->first(); 
		  return view('layouts/user_mr_history')->with('result',$res);

    }
    
	public function userIpHistory(Request $request)
    {
		$history_user_id = $request->uid;
		$used_ips[] = array();
											
						$nQuery = " (SELECT  tbl_user_waittime.user_ip as ip_address , 'waittime' as type, wt_cur_time as datetime , tbl_user.user_name , tbl_user.user_id , '' as user_status     FROM `tbl_user_waittime`    INNER JOIN tbl_user ON (tbl_user_waittime.user_id = tbl_user.user_id) 	 where tbl_user_waittime.user_id = ".$history_user_id ." ) " ;
						$nQuery .= "UNION ( SELECT   tbl_chat.ip_address , 'Post' as type,chat_time as datetime, tbl_user.user_name , tbl_user.user_id   , '' as user_status   FROM `tbl_chat`    INNER JOIN tbl_user ON (tbl_chat.user_id = tbl_user.user_id) 	 where tbl_chat.user_id = ".$history_user_id." ) " ;
						
						$nQuery .= "UNION (SELECT   tbl_chat_reply.ip_address , 'Comment' as type,  chat_reply_date as datetime , tbl_user.user_name , tbl_user.user_id  , '' as user_status    FROM `tbl_chat_reply`    INNER JOIN tbl_user ON (tbl_chat_reply.reply_user_id = tbl_user.user_id)  where tbl_chat_reply.reply_user_id = ".$history_user_id." ) " ;  								
						$nQuery .= "UNION (SELECT   tbl_chat_reply_reply.ip_address , 'Reply' as type, chat_reply_date as datetime , tbl_user.user_name , tbl_user.user_id , '' as user_status	    FROM  `tbl_chat_reply_reply`    INNER JOIN tbl_user ON (tbl_chat_reply_reply.reply_user_id = tbl_user.user_id)    where tbl_chat_reply_reply.reply_user_id = ".$history_user_id ." ) " ; 			
						$nQuery .= "UNION (SELECT   ip_address , 'User' as type, creation_date as datetime , user_name , user_id ,user_status  FROM  `tbl_user` where user_id = ".$history_user_id ." ) " ;
						$nQuery .= "UNION (SELECT   signup_ip_address as ip_address  , 'User' as type , creation_date as datetime, user_name , user_id ,user_status   FROM  `tbl_user` where user_id = ".$history_user_id ." ) " ;
						$nQuery .= "UNION ( SELECT   tbl_user_login_tracking.ip_address , 'Tracking' as type ,  createdon as datetime , tbl_user.user_name , tbl_user.user_id , '' as user_status   FROM  `tbl_user_login_tracking`    INNER JOIN tbl_user ON (tbl_user_login_tracking.user_id = tbl_user.user_id) 	 where tbl_user_login_tracking.user_id = ".$history_user_id." ) " ; 	 
					$nQuery .=  " order by 3 desc ";
							$res = DB::select($nQuery);
						
		  
		  return view('layouts/user_ip_history')->with('result',$res);

    }
    
	
	
	public function deleteFromAutoEmails($userid)
	{

		//Deleteing user from all auto emails
	
		TblChatAdminSuscriber::where('user_id', $userid)->delete();
		WdwChatSuscriber::where('user_id', $userid)->delete();
		TblChatSuscriber::where('user_id', $userid)->delete();
		TblPrivateChatSuscriber::where('user_id', $userid)->delete();
		TblBofDaySuscriber::where('user_id', $userid)->delete();
		
		
	}
	
	
	public function changeUserPassword(Request $request)
	{
	$msg="";
	$id = $request->uid;
	$user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();	
	
	
	if (isset($request->btnupdate)) {
	 $puser_name =      $request->txtuser_name;
	 $puser_email =     $request->txtuser_email;
	 $puser_password =  $request->txtuser_password;
	 $puser_cpassword = $request->txtuser_cpassword;
	// dd($puser_name);
			if($puser_name == null)
			{
				$msg = "User Name Can not be empty.<br>";				
			}
			else if($puser_email == null)
			{
				$msg = "User Email Can not be empty.<br>";				
			}
		    else if($puser_password == null && $puser_cpassword == null)
			{
				$msg ="Password and confirm Password Can not be empty.<br>";
			}
			else if($puser_password != $puser_cpassword)
		   	{		
				$msg = "Password and confirm Password Not Match.<br>";
			}
			
			else if(!empty($puser_name) && !empty($puser_email) && !empty($puser_password) && !empty($puser_cpassword))
					{		
						
					
					 User::where([['user_id', '=', $id ]])->update(['user_name' => $puser_name,'user_email' => $puser_email,'password' => $puser_password]); 
						
					$msg ='Successfully Updated..! ';
					}
				
					
			
			
	}
		
	
	
	
	
	return view('layouts/change_user_password')->with('users', $user_detail)->with('success',$msg);	
		
	}
	
	public function sendUserMail(Request $request)
	{
	$msg='';
	$id = $request->uid;
	$user_detail = User::select('*')->where([ ['user_id', '=', $id],])->first();

	if($request->btnsubmit)
	{ 

		$message= strip_tags($request->tboxmessage );
		$subject=$request->tboxsubject;
		
		$user_detail_count = User::select('*')->where([ ['user_id', '=', $id],])->count();
			if($user_detail_count > 0)
			 {
				$user_name = $user_detail->user_name;
				$user_email = $user_detail->user_email;
				$myVar = new AlertController();
				$alertSetting = $myVar->sendMail($user_email,$message,$user_name,$subject);
				$msg ="Email Sent.!"; 
			}
		  	
	} 

	
	return view('layouts/send_user_email')->with('users', $user_detail)->with('success',$msg);	
		
	}
	
	
	
    public function approvedUser(Request $request)
    {
          $id = $request->id;
          $action = $request->action;
          
          if ($action =='disapprove') { 	User::where([['user_id', '=', $id ]])->update(['user_status' => '2']);  TblChat::where('user_id', $id)->delete(); }
          if ($action =='verifyemail') { 	User::where([['user_id', '=', $id ]])->update(['isvarified' => '1']); }
          
          
          $approved_user_detail = User::select('*')->where ([  ['user_status', '=', 1],['user_name', '!=', 'null'],['user_email', '!=', '']])->orderBy('creation_date', 'DESC')->paginate(50);
            
          //dd($approved_user_detail);
           
		    return view('layouts/approved_user')->with('approvedusers', $approved_user_detail);

    }


	public function userCreditSetting(Request $request)
    {
		
	// $id = 1 ;
	$tbox_no_of_time =  $request['tbox_no_of_time'];
    $from_datetime =  $request['from_datetime'];
    $end_datetime =   $request['end_datetime'];
    $id = $request['hidden_id'];
	
    if (!empty($request['chk_status'])){ $status = 	 $request['chk_status']; } else { $status = 0; }
    


    if (!empty($tbox_no_of_time)) 
    {
        if ($id > 0) {
	
			AdminCreditSetting::where('id', $id)
			->update([
			'no_of_times' => $tbox_no_of_time,
			'start_date' => $from_datetime,
			'end_date' => $end_datetime,
			'status' => $status,
			]);
            
			$all_credit =   AdminCreditSetting::select('*')->get();
		
			return view('layouts.creditSaleControl.user_credit_setting')->with('allcredit', $all_credit)->with('message', 'Added Successfully.');
    
           
        } 
		
		 else { 
		
		// $admin_credit = AdminCreditSetting::select('*')->where('id',$id)->first();
		$type = 'no of time credits added';
		$entry = new AdminCreditSetting;  
		$entry->no_of_times = $tbox_no_of_time;
		$entry->start_date = $from_datetime;
		$entry->end_date = $end_datetime;
		$entry->status = $status;
		$entry->type = $type;
		$entry->save();
		
		$all_credit =   AdminCreditSetting::select('*')->get();
		
		return view('layouts.creditSaleControl.user_credit_setting')->with('allcredit', $all_credit)->with('message', 'Added Successfully.');

        } 
      
    } 
	
	else {  return redirect()->back()->with('message', 'Required fields are missing.');  } 
	

    }
    
	public function userCreditSettingEdit(Request $request)
    {

	$edit_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='edit') { 	 
	
	$admin_credit = AdminCreditSetting::select('*')->where([['id', '=', $edit_product_id],])->first();

	 return view('layouts.creditSaleControl.edit_user_credit_setting')->with('credit', $admin_credit);
	}
							
	}
	
	public function getuserCreditSetting(Request $request)
    {
		
	$msg = '';
	$delete_product_id = $request->id;
	
	if ($delete_product_id != '') { 
	AdminCreditSetting::where('id', $delete_product_id)->delete(); 
	return redirect()->back()->with('message', 'Delete Successfully');
		
	}  
	$all_credit =   AdminCreditSetting::select('*')->get();
	return view('layouts.creditSaleControl.user_credit_setting')->with('allcredit', $all_credit);
		
		
	

    }
    
}

