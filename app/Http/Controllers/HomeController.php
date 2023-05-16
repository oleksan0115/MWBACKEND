<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use ShortPixel;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\User;
use App\LoginUserTracking;
use App\TblChat;
use App\TblChatRoom;
use App\TblMwEmojiCategory;
use App\TblMwMycollection;
use App\Comment;
use App\Reply;
use App\ThankYou;
use App\TaggedUser;
use App\TextMessage;
use App\TagComposit;
use App\Tag;
use App\MwProduct;
use App\CommentReply;
use App\WdwChat;
use App\WdwChatReply;
use App\TblThankYouEmail;
use App\Concert;
use App\ConcertEntry;
use App\TblLike;
use App\BestOfTheDay;
use App\TblRankPointDetail;
use App\TblMwCreditDetail;
use App\TblQuestionGameRank;
use App\TblFollowSuscriber;
use App\MtUserFriend;
use App\TblUserSuscribeViaEmail;
use App\TblReport;
use App\TblUserRight;
use App\TblChatBlock;
use App\TblBanUser;
use App\TblChatSuscriber;
use App\TblPrivateChatSuscriber;
use App\TblCrowdIndex;
use App\TblEventHour;
use App\TblWhatNextDetail;
use App\TblWheatherForcast;
use App\TblBestOfPostHour;
use App\TblAdminNews;
use App\TblMeetUp;
use App\TblMwCredit;
use App\TblSong;
use App\TblRide;
use App\TblPark;
use App\WdwWhatNextDetail;
use App\TblRestorant;
use App\TblMwProductTradeRequest;
use App\ToDoList;
use App\TblMwMyCollectionHistory;
use App\TblMwOrder;
use App\TblMwOrderProduct;
use App\TblLikeComment;
use App\TblLikeReply;
use App\TblUserSpecialLogo;
use App\TblChatAutoBump;
use App\TblChatSticky;
use App\TblBanner;
use App\TblTopUserLeaderBoard;
use App\AddEmailConfirmation;
use App\WdwChatRoom;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\RankController;
use App\Http\Controllers\Common\CommonController;


class HomeController extends Controller
{
	
    
	public function home(Request $request)
	{  
//echo phpinfo();die;
	/* for search */
	
		$offset = 0;
		$page = $request->page;
		$page = $page - 1;
		$offset = $page * 50; 
	$searchtext = $request->chat_msg;	

// to remove post for particular user not display

	$forsortordefault = $request->sortordefault;
	
	if($forsortordefault == null)
	{
	$time = 'chat_reply_update_time'; 
	}
	else
	{
	$time = 'chat_time';	
	} 

      $chat_room_id = $request->chat_room_id;
	
   
	$user = auth()->user();
	$get_block_chat_by_userid = [];
	$deleted_chat_id = array();
	$permissionArray = ['3', '4'];


	if($user != null ){

		$permissionArray = [];
		$user_id = $user->user_id;
		$get_block_chat_by_userid =  TblChatBlock::where
											([
											 ['user_id', '=', $user_id],
											 ['status', '=', '1'],
											 ['ban_chat_id', '!=', 'null'],
											 ])
											 ->select('ban_chat_id')->get();
	   
		
		foreach($get_block_chat_by_userid as $row)
		{
			$deleted_chat_id[] = $row['ban_chat_id'];
			
		}	
		
		$userpermission = TblUserRight::where([['user_id', '=', $user_id], ['rights_id', '=', '13']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '3';
		}

		$userpermission = TblUserRight::where([['user_id', '=', $user_id], ['rights_id', '=', '14']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '4';
		}
	}
	// else 
		// return response()->json(['status' => 201, 'data' =>	 $users]);	

	
	if($chat_room_id == null)
	{
			 
		$total_list =  TblChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['mapping_url', '!=', ''],
						    ['chat_room_id', '=', 7],
						    ])->
							orWhere([
						    ['chat_room_id', '=', 1],
						    ])
	                       ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('user.getuserlogodetails.speciallogo')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                       ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
	                       ->with('checksticky')
	                       ->with('subscribepost')
	                       ->whereNotIn('chat_id',$deleted_chat_id)
						   ->orderBy($time, 'DESC')
	                        ->offset($offset)
							->take(50)
							->get();
		
	
	}
	
	else if($chat_room_id == 0)
	{
	
		return response()->json(['status' => 201, 'data' =>	 $user]);	

		$total_list =  TblChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['mapping_url', '!=', ''],

						    //['chat_room_id', '=', $chat_room_id],
						    ])
						 /*    
						    ->when($chat_room_id, function ($query) use ($chat_room_id) {
                            return $query->where('chat_room_id', '=', $chat_room_id);
                            })
							 */
	                       ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('user.getuserlogodetails.speciallogo')
						   // ->with('user.allotedmenubyadmin.menuname')
						   // ->with('user.allotedmenubyadmin')
						   // ->with('allotedmenubyadmin',function ($query) {$query->where('user_id','=','38');})
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                       ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
	                       ->with('checksticky')
	                       ->with('subscribepost')
	                       
							->whereNotIn('chat_id',$deleted_chat_id)
							->whereNotIn('chat_room_id', $permissionArray)
							// ->whereNotIn('chat_id',$stick_chat)
						   ->orderBy($time, 'DESC')
	                        ->offset($offset)
							->take(50)
							->get();	
		
	}
	
	else
	{
		
	$total_list =  TblChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['mapping_url', '!=', ''],
						    ['chat_room_id', '=', $chat_room_id],
						    ])
	                       ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('user.getuserlogodetails.speciallogo')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                       ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
	                       ->with('checksticky')
	                       ->with('subscribepost')
	                       ->whereNotIn('chat_id',$deleted_chat_id)
						   ->orderBy($time, 'DESC')
	                        ->offset($offset)
							->take(50)
							->get();	
	}
	
	
			return response()->json([
                'status' => 201,
                'data' => $total_list->toArray(),
                 ], 201);
	
	
	}
	
	public function sticky(Request $request)
	{  
	$user = auth()->user();

	$get_stick_chat_data =  TblChatSticky::where([['id', '=', 1],['park', '=', 'DL'],])->select('chat_id')->first();
	
	$stick_chatid	 = $get_stick_chat_data->chat_id;
	
	$total_list = '';
	
	$total_list =  TblChat::where([['chat_id', '=', $stick_chatid]])
						    
	                       ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('user.getuserlogodetail.speciallogo')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                       ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
						    ->with('checksticky')
	                       ->with('subscribepost')
	                       ->get();
	
			return response()->json([
                'status' => 201,
                'data' => $total_list,
                 ], 201);
	
	
	}
	
	public function tag(Request $request)
	{  

	/* for search */
	$searchtext = $request->chat_msg;	

    $tags_name_url = $request->tags_name;	
    $tags_name_url =str_replace("-"," ","$tags_name_url");
	
	$forsortordefault = $request->sortordefault;
	
	if($forsortordefault == null)
	{
	$time = 'chat_reply_update_time'; 
	}
	else
	{
	$time = 'chat_time';	
	}


    $gettagid =  Tag::where([['tags_name', '=', $tags_name_url],])->select('id')->first();
    $id = $gettagid->id;

	$user = auth()->user();
	$permissionArray = ['3', '4'];
  
	if($user != null) {
		$userpermission = TblUserRight::where([['user_id', '=', $user->user_id], ['rights_id', '=', '13']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '3';
		}

		$userpermission = TblUserRight::where([['user_id', '=', $user->user_id], ['rights_id', '=', '14']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '4';
		}
	}
	
	$total_list =  TblChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['mapping_url', '!=', ''],
							
							])
				        
						   ->whereHas('tagcomposit',  function ($q) use ($id) {
                            $q->where('tags_id', $id);
                            })
							
	                       ->select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','mapping_url','chat_reply_update_time')
	                     
                            ->with('tagcomposit.gettagged')
						    ->with('chatroom')
						   ->with('user')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
						   ->whereNotIn('chat_room_id', $permissionArray)	  
	                       ->orderBy($time, 'DESC')
	                       ->take(50)
	                       ->get();
	
   
		
			return response()->json([
                'status' => 201,
                'data' => $total_list->toArray(),
                 ], 201);

	}
	
	public function getAssignMenuByAdmin(Request $request)
	{ 
	$user = auth()->user();
	if($user != null ){
	$menuresult = TblUserRight::select('user_id','rights_id')->with('menuname')->where([['user_id', '=', $user->user_id]])->get();
	return response()->json([ 'status' => 201, 'data' => $menuresult], 201);
	}
	else
	{
	return response()->json([ 'status' => 201, 'data' => [] ], 201);	
	}
	}
	
	public function hash(Request $request)
	{  

	/* for search */
	$searchtext = $request->hash;	
    $searchtext ='#'.str_replace("-"," ","$searchtext");
  

    // $gettagid =  Tag::where([['tags_name', '=', $tags_name_url],])->select('id')->first();
    // $id = $gettagid->id;
	
	$forsortordefault = $request->sortordefault;
	
	if($forsortordefault == null)
	{
	$time = 'chat_reply_update_time'; 
	}
	else
	{
	$time = 'chat_time';	
	}

	$user = auth()->user();
	$permissionArray = [];
  
	if($user != null) {
		$userpermission = TblUserRight::where([['user_id', '=', $user->user_id], ['rights_id', '=', '13']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '3';
		}

		$userpermission = TblUserRight::where([['user_id', '=', $user->user_id], ['rights_id', '=', '14']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '4';
		}
	}
  
	$total_list =  TblChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['mapping_url', '!=', ''],
							])
				        
						  // ->whereHas('tagcomposit',  function ($q) use ($id) {
        //                     $q->where('tags_id', $id);
        //                     })
							
	                       ->select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time')
	                     
                            ->with('tagcomposit.gettagged')
						    ->with('chatroom')
						   ->with('user')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
							->whereNotIn('chat_room_id', $permissionArray)
	                      ->orderBy($time, 'DESC')
	                       ->take(50)
	                       ->get();
	
   
		
			return response()->json([
                'status' => 201,
                'data' => $total_list->toArray(),
                 ], 201);

	}
	
	public function flag(Request $request)
	{  
	$user = auth()->user();
	
	
	if($user != null ){
	$user_id = $user->user_id;
	$username = $user->user_name;
    $result = User::where([['user_id', '=', $user_id],])->select('user_status','isadmin','ismoderator','rank')->first();
	// echo '<pre>'; print_r($result); die;
	$chat_id = $request->chat_id;
	$type = $request->type;
	
	
	$reasion_for_report = $request->reasion_for_report;
	
	if($result['user_status'] == 1)
	{
	
		if( $user_id == 18  or $user_id == 914 or $user_id == 261 or $user_id == 38)
				{
				
						//if users is admin then his report will be conside final and chat will be removed
						if($chat_id > 0 and  $user_id > 0 )
						{     
							  
							if($type=='C')
							{
							TblChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '3']);
							}
							else if($type=='R')
							{
							Comment::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '3']); } 
							else if($type=='CR')
							{
							CommentReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
							}

							/* to save report  on partcular chat */	
							
							$entry = new TblReport;  
							$entry->chat_id = $chat_id;
							$entry->user_id = $user_id;
							$entry->user_name = $username;
							$entry->type = $type;
							$entry->reasion_for_report = $reasion_for_report;
							
							$entry->save();
							 
							$new_report_id =$entry->id;
							$subject ="Removed Post after Admin Report"; 
							$myVar = new AlertController();
							$alertSetting = $myVar->emailForReport($chat_id ,$type , $user_id, $username, $new_report_id , $reasion_for_report ,$subject);
						
					 $flagdata[] = array('error'=> "Thank you! A MouseWait Staff Member will look at your feedback shortly.");
						} 
				} 
				elseif($chat_id > 0 and  $user_id > 0 )
			   {  
					$no_of_reports = 0 ;
					$no_of_reports = TblReport::where([['chat_id', '=', $chat_id],['user_id', '=', $user_id],['type', '=', $type]])->count();
					if($no_of_reports > 0 )
					  { 
					"";
						
						$flagdata[] = array('error'=> "You have already reported this. Thank you! A MouseWait Staff Member will look at your feedback shortly.");
 					  }
					  else
					  { 
							$entry = new TblReport;  
							$entry->chat_id = $chat_id;
							$entry->user_id = $user_id;
							$entry->user_name = $username;
							$entry->type = $type;
							$entry->reasion_for_report = $reasion_for_report;
							
							$entry->save();
							 
							$new_report_id =$entry->id;
				 
				 $no_of_reports = TblReport::where([['chat_id', '=', $chat_id],['type', '=', $type]])->count();
							
				  
				  
				  if($no_of_reports > 3 )
				  {					   
					 
						  if($type=='C')
						  {
							TblChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '3']); 
						  }
						  else if($type=='R')
						  {
							Comment::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
						  } 
						   else if($type=='CR')
						  {
							CommentReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
						  }    
					
					 if($chat_id >0 and  $user_id > 0 and $new_report_id > 0 )
						{ 
							$subject ="Removed Post after 4th Report"; 
							$myVar = new AlertController();
							$alertSetting = $myVar->emailForReport($chat_id ,$type , $user_id, $username, $new_report_id , $reasion_for_report ,$subject);
							
							$new_report_id = 0; //Make this zero so do not send  email agian at the bottom.
							
						}  
					
					
				  }
				   
				   if($chat_id >0 and  $user_id > 0 and $new_report_id > 0 )
					{ 
						$subject ="Removed Post after Admin Report"; 
						$myVar = new AlertController();
						$alertSetting = $myVar->emailForReport($chat_id ,$type , $user_id, $username, $new_report_id , $reasion_for_report ,$subject);
					}  
					
					
					$flagdata[] = array('error'=> "Thank you! A MouseWait Staff Member will look at your feedback shortly.");
					}
			   
			  
			   
			   }  
				 
	
	}
	
	else
	{
	$flagdata[] = array('error'=> "You cann't Report because you are not Active user. Please contact to admin at info@mousewait.xyz , Thanks");

	}
	
	}
	else
	{
  $flagdata[] = array('error'=> "Please Login.");	
	}
	    


	return response()->json(['status' => 201, 'data' =>	$flagdata ]);
	 
	}
	
	public function flagAction(Request $request)
	{  

		$chat_id = $request->chatid;
		$user_verify_type = $request->type;
		$reported_id = $request->reported_id;
		$admin_action = $request->action;
		$ip_address =$_SERVER['REMOTE_ADDR'];
		
		
		if ($chat_id > 0 and !empty($user_verify_type)  and !empty($admin_action)  )
		{
			if ( $admin_action == "remove") {
		
					//this switch case is for private rooms.
				switch ($user_verify_type) 
				{
					case 'C': 
					   TblChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '3']); 
						break;
					case 'R': 
					    Comment::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
				
					    $getchatid = Comment::where([['chat_reply_id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					 
					    TblChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
						
						
						
						break; 
					case 'CR': 
						
						CommentReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
					
		                $getchatid = CommentReply::where([['id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					    
					    TblChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
					
						break; 
						
				} 
				
				$TblReport = TblReport::where('id', $reported_id)->delete();	
		        
		        return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
			   			
				 
			}
			
			elseif ( $admin_action == "deleted"){
	
				switch ($user_verify_type) 
				{
					case 'C': 
					   //change the status of the post to active.
						//Delete All Chate
				
						$tblchat = TblChat::where('chat_id', $chat_id)->delete();	
						
						
						//Delete all the Comments of this post.
						
						$tblcommnet = Comment::where('chat_id', $chat_id)->delete();	
						
						
						//Delete all the Comments of this post.
						$tblcommnetreply = CommentReply::where('chat_id', $chat_id)->delete();	
					
						
						
						break;
					case 'R': 
						//Delete all the Comments of this post.
						$tblcommnet = Comment::where('chat_reply_id', $chat_id)->delete();
						break; 
					case 'CR': 
						 
						//Delete all the Comments of this post.
						$tblcommnetreply = CommentReply::where('id', $chat_id)->delete(); 
						break; 
						
				} //End switch case..  
				 
				$TblReport = TblReport::where('id', $reported_id)->delete();
				
				 return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
				 
			} 
			
			elseif ( $admin_action == "restore") {
				switch ($user_verify_type) 
				{
					case 'C': 
					TblChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '0','chat_reply_update_time' => \DB::raw('NOW()')]); 
						break;
					case 'R': 
					    
					    Comment::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '0']);
				
					    $getchatid = Comment::where([['chat_reply_id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					    
					    TblChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
					 
						
						break; 
					case 'CR': 
					    
					    CommentReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '0']);
					
		                $getchatid = CommentReply::where([['id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					    
					    TblChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
				
						break; 
						
				} //End switch case..   
				 
				 
				$TblReport = TblReport::where('id', $reported_id)->delete();
				
			 return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
				 
			}
			
			elseif ( $admin_action == "move") { 
				//This action willmove the post to hub. 
				 TblChat::where([['chat_id', '=', $chat_id ]])->update(['chat_room_id' => '0','chat_reply_update_time' => \DB::raw('NOW()')]);
        	
				$comments = 'This post has been moved to The Hub' ; 
				
				TblChat::where([['chat_id', '=', $chat_id ]])->update(['comments' => $comments]);
			
					$entry = new Comment;  
					$entry->chat_id = $chat_id;
					$entry->reply_user_id = 122974;  // ye id fix h as old code
					$entry->chat_reply_msg = $comments;
					$entry->chat_room_id = 0;
					$entry->ip_address = $ip_address;
					$entry->showonmain = 0;
					$entry->comment_updatedon = NOW();
					$entry->save();
				
				
				$TblReport = TblReport::where('id', $reported_id)->delete();
				
			// return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/lounge');
			 return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
				
				 
			}
            
			elseif ( $admin_action == "move-silent") { 
                //This action willmove the post to hub. 
                 
                TblChat::where([['chat_id', '=', $chat_id ]])->update(['chat_room_id' => '0','chat_reply_update_time' => \DB::raw('NOW()')]);
             
                $TblReport = TblReport::where('id', $reported_id)->delete();    
            
                return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
            }
           
		
		
		} 
	
	 

	}
	
	public function thankyou(Request $request)
	{  
	$user = auth()->user();
	
	
	if($user != null ){
	$userid = $user->user_id;
	$username = $user->user_name;
    $chatdata = TblChat::where('chat_id',$request['chat_id'])->with('user')->select('chat_id','user_id','chat_msg','no_of_thanks')->first();
	$chat_user_name = $chatdata['user']['user_name'];
	$chat_user_email = $chatdata['user']['user_email'];
	$chatuserid = $chatdata['user_id'];
	$chatid = $chatdata['chat_id'];
	$chat_msg = $chatdata['chat_msg'];
	
	
	
	if($chatuserid != $userid)
	{
	$notExist = ThankYou::where([['chat_id', '=', $chatid],['user_id', '=', $userid],])->count();
	if($notExist == 0)
	{
	/* to save thankyou  on partcular chat */	
	$entry = new ThankYou;  
	$clientIP = request()->ip();
	$entry->chat_id = $chatid;
	$entry->chat_user_id = $chatuserid;
	$entry->user_id = $userid;
	$entry->user_name = $username;
	$entry->ip_address = $clientIP;
	$entry->save();
	
	$reff_id =$entry->id;// to get last inserted id from thankyou
	

	/* to update thankyou count and time on partcular chat */	
	TblChat::where('chat_id', $chatid)->update(['no_of_thanks' => \DB::raw('no_of_thanks + 1'),'chat_reply_update_time' => NOW()]);
	
	$from = "thanks from dl web";
	
	$concertentry = new ConcertEntry;  
	$concertentry->concert_name = '';
	$concertentry->concert_id = '';
	$concertentry->start = '';
	$concertentry->end_date = '';
	$concertentry->user_name = $chat_user_name;
	$concertentry->user_id = $chatuserid;
	$concertentry->from = $from;
	$concertentry->createdon = now();
	$concertentry->reff_id = $reff_id;
	$concertentry->save();
	
	/* to update user points of  partcular chat user */
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'5','thanks_for_post_web','DL');
	
	
	/* to send email single time on partcular chat */
	$check_chatid = TblThankYouEmail::where('chat_id',$chatid)->count();

	if($check_chatid == 0){
	$myVar = new AlertController();
	//$alertSetting = $myVar->sucessThankYou($chat_user_name , $chat_user_email, $chat_msg ,$chatid ,$chatuserid );
	
	$emailentry = new TblThankYouEmail;  
	$clientIP = request()->ip();
	$emailentry->chat_id = $chatid;
	$emailentry->chat_user_id = $chatuserid;
	$emailentry->user_id = $userid;
	$emailentry->user_name = $username;
	$emailentry->ip_address = $clientIP;
	$emailentry->save();
	}
			
		 $thankdetail =  ThankYou::select('chat_id','user_id')
						   ->with('user')
	                       ->where
								 ([
								 ['status', '=', '1'],
								 ['chat_id', '=', $request['chat_id']],
								 ])
	                       ->get();
	
	
	$thankdata = array(['message' => "Added", 'thankdata' =>	$thankdetail->toArray() ]);
	}
	else
	{
	
	$isExist = ThankYou::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->first();
	$clientIP = request()->ip();
	
	if($isExist['status'] == 1)
	{
	ThankYou::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '0','ip_address' => $clientIP]);	
	
	TblChat::where('chat_id', $request['chat_id'])->update(['no_of_thanks' => \DB::raw('no_of_thanks - 1')]);
	
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'-5','thanks_for_post_web','DL');
	
	
	 $thankdetail =  ThankYou::select('chat_id','user_id')
						   ->with('user')
	                       ->where
								 ([
								 ['status', '=', '1'],
								 ['chat_id', '=', $request['chat_id']],
								 ])
	                       ->get();
	
	
	$thankdata = array(['message' => "Removed",'thankdata' => $thankdetail->toArray() ]);
	}
	else
	{
	ThankYou::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '1','ip_address' => $clientIP]);	
	
	TblChat::where('chat_id', $request['chat_id'])->update(['no_of_thanks' => \DB::raw('no_of_thanks + 1')]);
	
	
    $thankdetail =  ThankYou::select('chat_id','user_id')
						   ->with('user')
	                       ->where
								 ([
								 ['status', '=', '1'],
								 ['chat_id', '=', $request['chat_id']],
								 ])
	                       ->get();
	
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'5','thanks_for_post_web','DL');
	
	$thankdata = array(['message' => "Added" ,'thankdata' => $thankdetail->toArray() ]);
	
	
	}
	
		
		
		
	// $thankdata	= "Already thanks";	
	}
	}
	else
	{
	$thankdata[] = array('message'=> "You Cann't Thanks Yourself.");	
	}
	
	}
	else
	{

	$thankdata[] = array('message'=> "Create a FREE MouseWait account and unlock tons of features including your own MyMW page, save your favorite posts, get the ToDo List custom planner, earn Credits, create your own MyFEED Magazine, Notifications, Post to the Lounge, and more! It's easy - just press the Login tab on the left slide out bar, then press New User. OR Login");
	}
	    


	return response()->json(['status' => 201, 'data' =>	$thankdata ]);
	 
	
	}
	
	public function userlist(Request $request)
	{  
	
	$searchtext = $request->user_name;	
	$result = User::where([
						['user_status', '=', '1'],
						['user_name', 'LIKE', '%'. $searchtext. '%'],
						])->select('user_name')->get();
 
	return response()->json([
                'status' => 201,
                'data' => $result,
                
            ], 201);
	
	
	}
	
	public function myfavourites(Request $request)
	{
	 
	 $user = auth()->user();
	if($user != null ){
 
	 $user_id = $user->user_id;
	 
	
	 
	 $total_list =  TblLike::select('id','chat_id','user_id','createdon')->where
								 ([
								 ['user_id', '=', $user_id],
								 ['status', '=', '1'],
								 ])->with('chat.user',function ($query) {
                                    $query->select('user_id','user_name','user_status','user_text_email','user_description','image','default_park','isdirect_msg','totalpoints','position','rank','quality_rank','likes_points','thanks_points')
                                    ->where('user_status','=','1');
                                })
    ->with('chat',function ($query) {
        
        $query->where('chat_status','=','0')->orWhere('isadvertisepost', '=', 1);
        $query->whereNotIn('chat_room_id',[139,140 ,141]);
    })
    ->with('chat.isbookmark')
	->with('chat.isthankyou')
    ->with('chat.chatroom')
    ->with('chat.topimages')
							
	                       ->orderBy('createdon', 'DESC')->take(50)
	                       ->get();
	

	$count_my_fav = count($total_list);
	
	
	    	if($count_my_fav > 0)
			{
		   $myfav =   $total_list->toArray();
			}
			else
			{
			 
			  $myfav[] = array('error'=> "You do not have any Mw Posts.");
			}
	
  
               
                 
                 
	} 
	else {
	    
	    $myfav[] = array('error'=> "Please login to see your Mw Posts.");
	}
	
		return response()->json(['status' => 201, 'data' =>	$myfav ]);
	}
	
	public function postdetail(Request $request)
	{  

	$chatid = $request->id;
	$postdetail =  TblChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes')
							->with('user')
						   ->with('topimages')
	                       ->with('thanks')
						   ->with('thanks.user')
	                       ->with('comments.commentuser')
	                       ->with('comments.commentsreply.replyuser')
	                       ->with('tagcomposit.gettagged')
	                       ->with('isbookmark')
	                       ->with('isthankyou')
						   ->where
								 ([
								 ['chat_status', '=', '0'],
								 ['chat_id', '=', $chatid],
								 ])
	                       ->get();
	
	

	
	
	return response()->json([
                'status' => 201,
                'data' => $postdetail->toArray(),
                
            ], 201);
	
	
	}
	
	public function mystore(Request $request)
	{  
	
	// $user = JWTAuth::parseToken()->authenticate();
	
	$user = auth()->user();
	
	if($user != null ){
	$userid = $user->user_id;
	$userdata = User::select('user_credits','iscreditsfreez')->where('user_id',$userid)->get();
	
	$current_user_credits = $userdata[0]['user_credits'];
	$iscreditsfreez = $userdata[0]['iscreditsfreez'];
	
	
	if($iscreditsfreez == 1)
	{
		$current_user_credits = "Your device has been blocked from MouseWait and your Credits are on hold. Please contact support@mousewait.com for more information.";	
	} 
	
	
	
	}
	
	else
	{
	$current_user_credits = "Please login to see your Credits";		
	}
	
	$current_datetime_on_server = date("Y-m-d H:i");


	
		$store =  MwProduct::select('id','product_name','product_quantity','product_description','product_image','product_price','isauction','active_datetime')
											->where
											([
											 ['status', '=', '1'],
											 ['active_datetime', '!=', '0000-00-00 00:00:00'],
											 ['active_datetime', '<=', $current_datetime_on_server],
											 ])->orderBy('product_quantity', 'DESC')->take(500)->get();

	

	
	$arraydata=array('store'=>$store,'credit_balance'=>$current_user_credits);	
	return response()->json(['status' => 201, 'credit_balance' => $current_user_credits, 'data' =>	$arraydata ]);
	 

	}
	
	public function getcategory(Request $request)
	{ 
	$user = auth()->user();
	
	if($user != null ){
    $categorydata =  TblChatRoom::where('status',1)->select('id','chat_room')->get();
	}
	else
	{
    $categorydata =  TblChatRoom::where('status',1)->select('id','chat_room')->take(8)->get();	
	}
	    
	return response()->json(['status' => 201, 'data' =>	$categorydata ]);
	}
	
	public function getemoji(Request $request)
	{ 
	$user = auth()->user();
	
	if($user != null ){
    $emojidata =  TblMwEmojiCategory::with('getemojidata')->where('status',1)->select('id','emoji_category_name')->get();
	}
	else
	{
    $emojidata =  '';	
	}
	    


	return response()->json(['status' => 201, 'data' =>	$emojidata ]);
	 

	}
	
	function upload_file($url, $type = 1, $path=NULL)
	{
    
    if($type == 1) {        // type 1 tells the media type is image
	
	$image_parts = explode(";base64,", $url);
	$image_type_aux = explode("image/", $image_parts[0]);
	$image_type = $image_type_aux[1];
	$image_base64 = base64_decode($image_parts[1]);


    $fname = filter_input(INPUT_POST, "name");
    $encodedImage = filter_input(INPUT_POST, "image");
    $encodedImage = str_replace('data:image/png;base64,', '', $encodedImage);
    $encodedImage = str_replace(' ', '+', $encodedImage);
    $encodedImage = base64_decode($encodedImage);
        
        // $imageName = $file_name;
       
        //  $file = $folderPath . $imageName;
        // file_put_contents($file, $image_base64);
        // return false;
        
        if(file_put_contents($path, $image_base64)) {
           //  echo 'testtt'; die;
            return true;
        }
        
        else
        {
            // echo 'error'; die;
            return false;
        }
    } else {

    }
    

	}
	
	public function postLounge(Request $request)
    {                   
              $user = auth()->user();
              $userid = $user->user_id;
              $username = $user->user_name;
        
              $auth_isverfied = $user->isvarified;
				if($auth_isverfied == 0)
				{			  
					return response()->json(['status' => 201, 'data' =>array('message'=>'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify after you can make a post and comment') ]);
				}
				
				else
				{ 
							
							
							$app = realpath(__DIR__ . '/../../../..');
                            $upload_img_dir = $app . '/disneyland/chat_images/';
                        
                            $lastid = TblChat::select('chat_id')->orderBy('chat_id','DESC')->first();
                            $lastinsertedid = $lastid->chat_id;
                            
                            $id=DB::select("SHOW TABLE STATUS LIKE 'tbl_chat'");
                            $next_id=$id[0]->Auto_increment;
                            
                            
                        
                            $entry = new TblChat;  
                           
                            
                            if($request['chat_msg'] !='' && $userid >0){ 
                            $clientIP = request()->ip();
                            $entry->user_id = $userid;
                            $entry->chat_msg = $request['chat_msg'];
                            $entry->chat_room_id=$request['chat_room_id'];
                            $titlestring = str_replace(" ", "-", $request['chat_msg']);
                            $small = substr($titlestring, 0, 20);
                            $entry->mapping_url = $next_id.'/'.$small;
                            $entry->chat_video = '';
                            $entry->chat_img = '';
                        
                            $entry->showonmain = '';
                            $entry->mac_address = '';
                            $entry->posted_from = '';
                            $entry->chat_status = '';
                            $entry->chat_reply_update_time = NOW();
                            $entry->chat_time = NOW();
                            $entry->ip_address = $clientIP;
                            $entry->save();
                            
                            $last_inserted_id = $entry->id;
                            
                        
							
							User::where('user_id', $userid)->update(['no_of_posts' => \DB::raw('no_of_posts + 1'),'ip_address' => $clientIP ]);
							
							/* to update user points on comment partcular chat incresase login user point */
							$myRank = new RankController();
							$rankSetting = $myRank->updateUserRank($userid ,'0.5','apps_post','DL');
                            
                            if ($request['chat_img']) {

                              $file = ''.$last_inserted_id.'_c_img.jpg'; //c stand for Chat image
                              $uploadfile = $upload_img_dir . $file;
                              $path =$upload_img_dir . $file;
                              $uploaddir = "/public_html/disneyland/chat_images/";

                        if($this->upload_file($request['chat_img'],'1',$uploadfile)){
                            
							 ShortPixel\setKey("VkmJFa5o0QPqcvhFw50D");
							ShortPixel\fromFile($path)->toFiles($upload_img_dir);  
							
                            TblChat::where('chat_id', $last_inserted_id)->update(['chat_img' => $file]);
                           
                        }
           
                            
                            }
							
							/* mail to suscribed friend(subscribe user from profile) (from mw page) */
							
							//loungeland or club 333 check user have permissoin (loungeland: 13, club: 14)
							if($request['chat_room_id'] == 3 || $request['chat_room_id'] == 4){
								$sql_check =  TblUserSuscribeViaEmail::join('tbl_user_rights', 'tbl_user_rights.user_id', 'tbl_user_subscribe_via_email.subscriber_user_id')
								->where([
									['tbl_user_rights.rights_id', '=', $request['chat_room_id'] + 10],
									['tbl_user_subscribe_via_email.user_id', '=', $userid],
									['tbl_user_subscribe_via_email.status', '=', '1'],])->get();
							}
							 
							else $sql_check =  TblUserSuscribeViaEmail::select('subscriber_user_id')
									->where([
							['user_id', '=', $userid],
							['status', '=', '1'],])->get();
									
								$chk_count = count($sql_check);
					
								if($chk_count > 0){
						
								foreach($sql_check as $row)
								{
								$friendid = $row->subscriber_user_id;
								
								$myVar = new AlertController();
								if($userid == 18)
								{
								$alertSetting = $myVar->adminPostMailTosubscribeUser($userid,$username,$friendid,$last_inserted_id);
								}
								else
								{	
								$alertSetting = $myVar->mailSubscribFriend($userid,$username,$friendid,$last_inserted_id);	
								}
								
								}
								
								}
				
							/* mail to suscribed user from profile */
							
							
							/* mail to suscribed friend subscribr from toggle menu */
							
						/* 	$sql_check =  TblChatSuscriber::select('subscriber_user_id')
										->where([['user_id', '=', $userid ]])->get();
									
								$chk_count = count($sql_check);		
								if($chk_count > 0){
						
								foreach($sql_check as $row)
								{
								$friendid = $row->subscriber_user_id;
								
								$myVar = new AlertController();
								$alertSetting = $myVar->mailSubscribFriend($userid,$username,$friendid,$request['chat_msg'],$last_inserted_id);
								}
								
								} */
				
							/*mail to suscribed friend subscribr from toggle menu*/
							
							
							
							
							
							
							
                            
                            return response()->json(['status' => 201, 'data' =>    array('sucess'=>'Lounge Post Submit') ]);
                            }else{
                             return response()->json(['status' => 201, 'data' =>array('error'=>'Lounge Post Did not Submit') ]);  
                            }

				}
                    
    

    }
	
	public function postComment(Request $request)
	{ 						
							$user = auth()->user();
							$userid = $user->user_id;
							$user_name = $user->user_name;
						
						 	$auth_isverfied = $user->isvarified;
							if($auth_isverfied == 0)
							{
							return response()->json(['status' => 201, 'data' =>	array('message'=>'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify after you can make a post and comment') ]);								
							
							
							}
							
							else
							{ 
						

//   $domdoc = new \DOMDocument();
// $domdoc->loadHTML($request['chat_msg']);
// $xpath = new \DOMXpath($domdoc);
  
// $query = "//*[@data-id]";
// $entries = $xpath->query($query);
// $totag = $entries['DOMNodeList'];

		$matches = array();
		preg_match_all('/@(\w+)\s(.+?)((?=@\w|$))/s', $request['chat_msg'], $matches, PREG_SET_ORDER);
		$words = array();
		foreach ($matches as $match) {
			$word = array(
				'name' => $match[1],
				'text' => trim($match[2])
			);
			$words[] = $word;
		}

		$totag = count($words);


						
						
							if($request['chat_msg'] !='' && $request['chat_id'] !='' && $userid >0 &&  $request['chat_msg'] != 'Add your thoughts')
							{
							$chatroom = TblChat::where('chat_id',$request['chat_id'])->select('chat_room_id','islock')->first();
								
							$chat_room_id = $chatroom->chat_room_id;
							if($chat_room_id == null){$chat_room_id = 7;}
							else{$chat_room_id = $chatroom->chat_room_id;}
							
							$chat_islock = $chatroom->islock;
							$clientIP = request()->ip();
							
							if($chat_islock == 0)
							{
							
						
							
								
							$entry = new Comment;  
							$entry->chat_id = $request['chat_id'];
							$entry->reply_user_id = $userid;
							$entry->chat_reply_msg = $request['chat_msg'];
							$entry->chat_room_id = $chat_room_id;
							$entry->ip_address = $clientIP;
							$entry->showonmain = '';
							$entry->chat_reply_date = NOW();
							$entry->comment_updatedon = NOW();
							$entry->save();
							$lastinserid=$entry->id;
							 
							
							TblChat::where([['chat_id', '=', $request['chat_id']],['isbump', '=', '1'],])->update(['chat_reply_update_time' => NOW() ]);
							
							User::where('user_id', $userid)->update(['no_of_comments' => \DB::raw('no_of_comments + 1'),'ip_address' => $clientIP ]);
							
							/* to update user points on comment partcular chat incresase login user point */
							$myRank = new RankController();
							$rankSetting = $myRank->updateUserRank($userid ,'0.2','dl_room_comments','DL');
							
							
					
							/* send mail to tag user in a commnet box  */
							if($totag != 0){

							 foreach ($words as $p) {
							//  $hdd_user_id =  $p->getAttribute('data-id');

							 $hdd_user_id =  $p['name'];
							 $myVar = new AlertController();
							 $alertSetting = $myVar->mailTagUser($hdd_user_id ,$user_name,$p['text'],$request['chat_id']);

							 $tagentry = new TaggedUser;  
							 $tagentry->user_id = $userid;
							 $tagentry->taged_user_id = $hdd_user_id;
							 $tagentry->chat_id = $request['chat_id'];
							 $tagentry->comment_message = $p['text'];
							 $tagentry->comment_id = $lastinserid;
							 $tagentry->taged_type = 'CR';
							 $tagentry->save();
							 }
							
							 
							}

							/* send mail to tag user in a commnet box */
							
							/* send mail to owner of the post if any user commnet on his post  */
							$res = TblChat::where('chat_id',$request['chat_id'])->select('user_id','chat_id')->first();
							
							$post_owner_id = $res->user_id;
						
							if($post_owner_id != $userid){
								
							 $myVar = new AlertController();
							 $alertSetting = $myVar->mailToPostOwner($post_owner_id,$user_name,$request['chat_msg'],$request['chat_id']);
							
							}
							/* send mail to owner of the post if any user commnet on his post  */
							
							
							//Send Push to Chat posted user. Sending Push of Private lands Post 
					/* 		$res = TblChat::where('chat_id',$request['chat_id'])->select('user_id','chat_id')->first();
							$post_owner_id = $res->user_id;
							$message = $request['chat_msg'];
							$chat_id = $request['chat_id']
                            $pushMessages = ( strlen($message)>100?substr($message, 0,100): $message ); 
							$array = array(
									"serviceid" => "2",
									"user_id" => "$userid",
									"id" => "$chat_id",  
									"category" => "COMMENT_CATEGORY",  
									"service" => "notification",
									);    
							$myVar = new AlertController();
							$alertSetting = $myVar->sendPushNotification($post_owner_id , $pushMessages ,$type="DL" , $array);			 */				
						
							
							
						   $commentdata=	Comment::where('chat_reply_id', '=', $entry->id)->with(['commentuser','commentsreply'])->get();
							
							

							
							
							return response()->json(['status' => 201, 'data' =>	array('success'=>'Comment Submit','chat_reply_id'=>$entry->id,'commentdata'=>$commentdata) ]);
							}
							else
							{
							   
							return response()->json(['status' => 200, 'data' =>	array('error'=>'Post is Locked by admin','chat_reply_id'=>0) ]);
							}
							}
							
							
							} 	

					
	 

	}
	
	public function commentReply(Request $request)
	{ 
		$isprobition = 0;
		$isfreeze = 0; 
		$ispress = 0 ;
		
		$user = auth()->user();
		$userid = $user->user_id;
		$chatid = $request['chat_id'];
        $message = $request['chat_reply_msg'];
        $commented_id = $request['chat_reply_id'];
		$clientIP = request()->ip();
	
		
		$user = auth()->user();
		$userid = $user->user_id;
		$user_name = $user->user_name;

		$matches = array();
		preg_match_all('/@(\w+)\s(.+?)((?=@\w|$))/s', $request['chat_reply_msg'], $matches, PREG_SET_ORDER);
		$words = array();
		foreach ($matches as $match) {
			$word = array(
				'name' => $match[1],
				'text' => trim($match[2])
			);
			$words[] = $word;
		}
		
		$totag = count($words);

		if($userid > 0)
    {   
     	$rightdata =  TblUserRight::select('*')->where([['user_id', '=', $userid]])
         	                      ->where(function($query) {
                                  $query->orWhere('rights_id', '9')
                                 ->orWhere('rights_id', '10');})
                                 ->get();
		
		foreach($rightdata as $row)
		{
		      $rights_id =  $row['rights_id'];  
                 switch ($rights_id) {
                     case '9':
                         $isprobition = 1;
                         break;
                      case '10':
                         $isfreeze = 1;  
                         break; 
                 }
		}
    }
	
	
	
		$chatroom = TblChat::where('chat_id',$chatid)->select('islock')->first();
		$chat_islock = $chatroom->islock;
		
		$getcommnetid = Comment::where('chat_reply_id',$commented_id)->select('reply_user_id')->first();
		$commentedon_user_id = $getcommnetid->reply_user_id;
							
				
							if($chat_islock == 0)
							{
							
							if($userid>0 && $message !='' &&  $commented_id>0)
							{ 
							    $ispress_or_verified =  User::select('ispress','isvarified','user_status')->where([['user_id', '=', $userid]])->first();
							    $ispress = $ispress_or_verified->ispress;
						        $user_isvarified = $ispress_or_verified->isvarified; 
						        $user_status = $ispress_or_verified->user_status; 
					        
					        if($user_status == 1  )
					        {
					            if ($isfreeze == 0 )
						        {
						            	$entry = new CommentReply;  
            							$entry->chat_id = $chatid;
            							$entry->chat_reply_id = $commented_id;
            							$entry->reply_user_id = $userid;
            							$entry->chat_reply_msg = $message;
            							$entry->chat_reply_date = NOW();
            							$entry->ip_address = $clientIP;
            							$entry->chat_reply_status = 0;
            							$entry->commented_on_user_id = $commentedon_user_id;
            							$entry->save();
										$lastinserid=$entry->id;
            							
            							$reply_id = $entry->id;
            							
            							Comment::where([['chat_reply_id', '=',$commented_id]])->update(['iscommnt' => 1 ]);


										/* send mail to tag user in a commnet box  */
										if($totag != 0){
												
											foreach ($words as $p) {

										//  $hdd_user_id =  $p->getAttribute('data-id');
											$hdd_user_id =  $p['name'];
											$myVar = new AlertController();
											$alertSetting = $myVar->mailTagUser($hdd_user_id ,$user_name,$p['text'],$request['chat_id']);
											$tagentry = new TaggedUser;  
											$tagentry->user_id = $userid;
											$tagentry->taged_user_id = $hdd_user_id;
											$tagentry->chat_id = $request['chat_id'];
											$tagentry->comment_message = $p['text'];
											$tagentry->comment_id = $lastinserid;
											$tagentry->taged_type = 'CR';
											$tagentry->save();
											}
										}

							   
										/////////////////update///////////////////
										// $res = TblChat::where('chat_id',$request['chat_id'])->select('user_id','chat_id')->first();
							
										// $post_owner_id = $res->user_id;
									
										// if($post_owner_id != $userid){
											
										// $myVar = new AlertController();
										// $alertSetting = $myVar->mailToPostOwner($post_owner_id,$user_name,$request['chat_reply_msg'],$request['chat_id']);
										
										// }

										/////////////////update///////////////////
            							
            							if($isprobition == 0)
                    						{ 
                    						    Comment::where([['chat_reply_id', '=',$commented_id]])->update(['comment_updatedon' => now() ]);
                    						    
                    						    TblChat::where([['chat_id', '=', $chatid],['isbump', '=', '1'],])->update(['chat_reply_update_time' => NOW() ]);
                    						 
                    							
                    						}
                    					User::where('user_id', $userid)->update(['no_of_reply' => \DB::raw('no_of_reply + 1'),'ip_address' => $clientIP ]);
            						
						               // $replydata=	CommentReply::where('id', '=', $entry->id)->with(['replyuser'])->get();
						                
						              $replydata=	CommentReply::where([['chat_id', '=', $chatid],['chat_reply_id', '=', $commented_id],])->with(['replyuser']) ->orderBy('chat_reply_date', 'DESC')->get();
						      
						            
						            
						            
						        }
					
							
			
							
							return response()->json(['status' => 201, 'data' =>	array('success'=>'Reply Submit' , 'replydata'=>$replydata) ]);
					        }
					        else
					        {
					         	return response()->json(['status' => 200, 'data' =>	'I am sorry but I am unable to post your message at this time. Please send an email to info@mousewait.com with your username and email and we will look into it, thanks!' ]);   
					        }
							}
						
							}
							else
							{
								return response()->json(['status' => 200, 'data' =>	'Post is Locked by admin' ]);
							}
							
							
			
					
	 

	}
	
	public function bookMark(Request $request)
	{ 
	$user = auth()->user();
	if($user != null ){
	$userid = $user->user_id;
	$username = $user->user_name;
	$chatdata = TblChat::where('chat_id',$request['chat_id'])->with('user')->select('chat_id','user_id')->first();
	$chat_user_name = $chatdata['user']['user_name'];
	$chatuserid = $chatdata['user_id'];
	
	// if($chatuserid != $userid)
	// {
	

	$isNotExist = TblLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->count();
	if($isNotExist == 0)
	{
	/* to save in tbl_like on  bookmark  on partcular chat */	
	$entry = new TblLike;  
	$clientIP = request()->ip();
	$entry->chat_id = $request['chat_id'];
	$entry->user_id = $userid;
	$entry->user_name = $username;
	$entry->ip_address = $clientIP;
	$entry->save();
	
	$reff_id = $entry->id;// to get last inserted id from bookmark
	

	/* to update like's count on bookmark  on partcular  chat */	
	TblChat::where('chat_id', $request['chat_id'])->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
	
	
	
	// $from = "Like from dl web";
	// $concertentry = new ConcertEntry;  
	// $concertentry->concert_name = '';
	// $concertentry->concert_id = '';
	// $concertentry->start = '';
	// $concertentry->end_date = '';
	// $concertentry->user_name = $chat_user_name;
	// $concertentry->user_id = $chatuserid;
	// $concertentry->from = $from;
	// $concertentry->createdon = now();
	// $concertentry->reff_id = $reff_id;
	// $concertentry->save();
	
	
	/* to update total points of  partcular chat user */

	
	if($userid != $chatuserid){
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'10','web_dl_likes','DL',$userid, $clientIP);
	}
		
	$bookmarkdata = array(['message' => "Added"]);
	}
	else
	{
	
	// $isExist = TblLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->firstOrFail();
	// $isExist->delete();
	
	$isExist = TblLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->first();
	$clientIP = request()->ip();
	
	if($isExist['status'] == 1)
	{
	TblLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '0','ip_address' => $clientIP]);	
	
	TblChat::where('chat_id', $request['chat_id'])->update(['no_of_likes' => \DB::raw('no_of_likes - 1')]);
	if($userid != $chatuserid){
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'-10','web_dl_likes','DL',$userid, $clientIP);
	}
	$bookmarkdata = array(['message' => "Removed"]);
	}
	else
	{
	TblLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '1','ip_address' => $clientIP]);	
	
	TblChat::where('chat_id', $request['chat_id'])->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
	if($userid != $chatuserid){
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'10','web_dl_likes','DL',$userid, $clientIP);	
	}
	$bookmarkdata = array(['message' => "Added"]);
	
	
	}

	}
	// }//
	// else
	// {
	// $bookmarkdata[] = array('message'=> "You Cann't Bookmark Own post.");	
	// }
	}
	else
	{
	$bookmarkdata[] = array('message'=> "Create a FREE MouseWait account and unlock tons of features including your own MyMW page, save your favorite posts, get the ToDo List custom planner, earn Credits, create your own MyFEED Magazine, Notifications, Post to the Lounge, and more! It's easy - just press the Login tab on the left slide out bar, then press New User. OR Login");
	}
	    
	return response()->json(['status' => 201, 'data' =>	$bookmarkdata ]);
	 
	}
	
	public function bestoftheday(Request $request)
	{ 
		
			$type = $request->type;
        	if($type == 'w'){
			$dayofweek = date('w',  strtotime("-0 HOUR"));
			$weekend = (6-$dayofweek) ;
			$startdate = date('Y-m-d', strtotime("-$dayofweek day") );
			$enddate = date('Y-m-d', strtotime("+$weekend day") ); 	
			}
			else if($type == 'm'){
			$startdate = date('Y-m-d', strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
			$enddate = date('Y-m-d', strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));	
			}
			else
			{
			
			$startdate =date('Y-m-d',strtotime("-1 days")); //date('Y-m-d');
			$enddate = date('Y-m-d'); 			
			}


			
			$bestoftheday = 	TblChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
								->with('user',function ($query) {$query->where('user_status','=','1');})
								->withCount('comments as commentcount')
								->where('chat_status','=','0')
								//->whereDate('chat_time', Carbon::today())
								->havingRaw('chat_total_thank_and_like > 0')
								->whereBetween('chat_time', [$startdate, $enddate])
								->whereNotIn('chat_id',[329864, 402398])
								->orderBy('chat_total_thank_and_like', 'DESC')
								->take(10)
								->get();  
      
      
		 
		return response()->json(['status' => 201, 'data' =>	$bestoftheday ]);      
	
	}
	
	public function myposts(Request $request)
	{ 
	 	$offset = 0;
		$page = $request->page;
		$page = $page - 1;
		$offset = $page * 50; 
	$userid = $request->user_id;
	
	
	$user = auth()->user();
	$get_block_chat_by_userid = [];
	$deleted_chat_id = array();
	if($user != null ){
	$user_id = $user->user_id;
	$get_block_chat_by_userid =  TblChatBlock::where
		([
			['user_id', '=', $user_id],
			['status', '=', '1'],
			['ban_chat_id', '!=', 'null'],
			])
			->select('ban_chat_id')->get();
	   
		
		foreach($get_block_chat_by_userid as $row)
		{
			$deleted_chat_id[] = $row['ban_chat_id'];
			
		}	
		
		$permissionArray = [];
		$userpermission = TblUserRight::where([['user_id', '=', $user_id], ['rights_id', '=', '13']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '3';
		}

		$userpermission = TblUserRight::where([['user_id', '=', $user_id], ['rights_id', '=', '14']])->get();
		if(count($userpermission) == 0) {
			$permissionArray[] = '4';
		}
	}

	$userdata = User::where('user_id',$userid)->select('user_id','user_name','user_email','image','rank','position','totalpoints','user_status','creation_date as member_since','default_park as overall_rank','user_description')
        ->with('getuserlogodetails.speciallogo')->first();


	$postdata = TblChat::where([
								['user_id', '=', $userid],
								['chat_status', '=', 0],])
						->select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','islock')
	                    ->with('chatroom')
						->with('topimages')
						->with('isbookmark')
	                    ->with('isthankyou')
	                    ->with('checksticky')
	                    ->withCount('comments as commentcount')
						->whereNotIn('chat_id',$deleted_chat_id)
						->whereNotIn('chat_room_id', $permissionArray)
						->orderBy('chat_id', 'DESC')
	                    ->offset($offset)
						->take(50)
						->get();
						
						
	$usermoredetail= [];
	 
	$eventsdata = TblRankPointDetail::where('user_id',$userid)->select('Type' , \DB::raw('round( sum( availpoints ) , 2 ) as  points'))->groupBy('Type')->get();
	// dd($eventsdata);
	$noofrows = count($eventsdata);
	
	if($noofrows > 0)
	{
	    
	    $triviaScore_one  =0;
		$triviaScore_two  =0;
		$waittimeScore =0;
		$likesScore    =0;
		$loungeScores  =0;
		$deleteScores  =0;
		$notLikeScores =0;
		$thanksScores  =0;
		
		
		foreach($eventsdata as $row){
		$Type = $row['Type'];
		$points = $row['points'];
		
		switch ($Type) {  
				case 'comments_likes_web';
				case 'comment_likes_iphone'; 
				case 'likes';
				case 'likes_post';
				case 'comments_likes_WDW';
				case 'web_dl_likes';
					$likesScore=$likesScore+$points;
					break;  
				
				case 'waittime';
				case 'fastpass';
				case 'wdw_fastpass';
					$waittimeScore=$waittimeScore+$points;
					break; 
				
				case 'traiva_game';
				case 'traiva_game1';
					$triviaScore_one=$triviaScore_one+$points;
					break;
				case 'traiva_game2'; 
					$triviaScore_two=$triviaScore_two+$points;
					break;
					
				case 'apps_post';
				case 'android_apps_post';
				case 'dl_hub_comments';
				case 'dl_room_comments'; 
				case 'dl_hub_post';
				case 'dl_room_post'; 
				case 'web_dl_room_post';
				case 'hub_post'; 
				case 'room_post'; 
				case 'wdw_hub_comments';
				case 'web_dl_hub_comments'; 
				case 'web_dl_room_comments';
				case 'hub_comments';
				case 'room_comments';
					$loungeScores=$loungeScores+$points;
					break;  
				case 'delete_post';
				case 'delete_comments';
					$deleteScores=$deleteScores+$points;
					break; 
					
				case 'dont_like';
				case 'web_dl_donot_like';
					$notLikeScores=$notLikeScores+$points;
					break;
				case 'thanks_for_comment_web';
				case 'thanks_for_post_web';
				case 'thanks_for_comment_iphone';
				case 'thanks_for_post_iphone';
					$thanksScores++;
					break;
				
						
			}
		}
	    
	    
	    
	    
	    
		/* to get purchase credit */
		$credit_purchase = TblMwCreditDetail::where
											([
											['user_id', '=', $userid],
											['status', '=', '1'],
											['type', '=', 'cash'],
											])
											->select(\DB::raw('sum( credits ) as  credits'))
											->groupBy('Type')
											->get();
		
		$purchase_count = count($credit_purchase);
		
		$creditsPurchased=0; 
		if($purchase_count>0)
		{  	
			$creditsPurchased = $credit_purchase[0]['credits']; 
		} 
		/* to get purchase credit end*/
		
	    /* to get featured in news,bestoftheday,likes,counts */
		
		
		$userno_of_bestoftheday_posts = 0;
		$no_of_posts_news = 0;
		$total_quality_points = 0;
		$quality_point_rank = 0;
		$thank_tp_counts=0;
		$thank_score = 0;
		$lb_30days =0; 
		

		
		
	    $get_no_of_bestoftheday = 	User::select('thanks_points','likes_points','quality_rank','no_of_posts_news','no_of_bestoftheday_posts',DB::raw('(likes_points + thanks_points) as total_likes_points'))
			                            ->where('user_id','=',$userid)
								         ->get();
		
		
		$userno_of_bestoftheday_posts = $get_no_of_bestoftheday[0]->no_of_bestoftheday_posts;
		$no_of_posts_news = $get_no_of_bestoftheday[0]->no_of_posts_news;
		$total_quality_points =  round((($get_no_of_bestoftheday[0]->total_likes_points/300)*10));
		$quality_point_rank = $get_no_of_bestoftheday[0]->quality_rank;

       

		/* to get featured in news,bestoftheday,likes,counts end*/
		 
		 
		 
		 /* Trivia Challenge One and Two start */
		  
			$triviaScore_one ='0';
			$triviaScore_two ='0';
			$triviaScore_one_rank_one=0;
			$triviaScore_two_rank_two=0; 
		    $mouse_gift = 0;
    
			$triviascrore = TblQuestionGameRank::where([['user_id', '=', $userid]])
											        ->select('totalpoints','position','bounspoints as allbounspoints','rank','level','current_level')
											        ->get();
											        
											      // dd($triviascrore);
											        
						//$trivia_count = count($triviascrore);
						
						foreach($triviascrore as $row)
						{
						 if($row['level'] == 1)
						 {
						   	$triviaScore_one = $row->position;
					    	$triviaScore_one_rank_one = $row->rank;  
						 }
						else if($row['level'] == 2)
						 {
						 	$triviaScore_two = $row->position;
						    $triviaScore_two_rank_two = $row->rank;    
						 }
						}
						
				
	
		/* Trivia Challenge One and Two start */
		
		
		
			/* to get thank detail start */
		$res_tp = ThankYou::where([['chat_user_id', '=', $userid]])->select(DB::raw('count(*) as thanksPost'),DB::raw('count(DISTINCT chat_id) as thanksScores'))->get();
		$thank_tp_counts = $res_tp[0]->thanksPost;
		$thank_score = $res_tp[0]->thanksScores;
		 /* to get thank detail end*/
		
		
		
		 /* get waittime score  start */
		$waittimeScore=	round((($waittimeScore /300)*10),2);
	    /* get waittime score end */
	    
	     /* get lounge score  start */
	       if($deleteScores<0){$loungeScores=$loungeScores+$deleteScores; }
		    $loungeScores = round((($loungeScores /300)*10),2);
	    /* get lounge score end */
	    
	    
	    
	     
		  /* to get 30 days mousewait point */
		  $startDate = \Carbon\Carbon::now()->subDays(30);
        $endDate = \Carbon\Carbon::now();
		  
		  $day30mousewaitt = TblRankPointDetail::where([['user_id', '=', $userid]])
											     ->select(\DB::raw('sum( availpoints ) as  tp'))
											      //->whereBetween('createdon', [now()->subdays(30), now()->subday()])
											      ->whereBetween("createdon", [$startDate, $endDate])
											     ->get();
	     $lb_30days = $day30mousewaitt[0]['tp'];
		 /* to get 30 days mousewait point end*/
		 
		 
		 
		 		  /* to get gift card start */
		     
		   
		  if($userid != 18 and $userid != 914 )  {
		  	$mouse_gift = TblMwMycollection::where
											([
											['status', '>', '0'],
											['user_id', '=', $userid],
											])
											->select('id','product_id','owner_only','is_featured','giftedby_user_id','gift_date','status','user_id')
											->with('user')
											->with('mwproduct')
											->take(4)
											->get();
		  }
	         //remember
		 // mouse_gift.status == 1 {'Owner'}
		 // mouse_gift.status == 2 {'Gifted'} mouse_gift.user == "Gift from user_name;
		 // mouse_gift.status == 3 {'Traded'}
		 
		 
		 /* is not auth or auth  always show these in profile my post footer section  
            DM/MY POSTS/MY Comments/Bookmarks/Trade/Gift/cddedddd  ni/Remove All Posts  */
		  /* to get gift card  end*/
		  
		  
		  
		   /*reference disneyland/include/user_profile_description file*/
		  
		  	$existcount = ''; 
			$followcounts = ''; 
			$block = '';
			$user_isdirect_msg = '';
		  	$count_friends='';
		  	$suscribe_or_unsuscribe = 0;
		  
		  	$user = auth()->user();
			if($user != null ){
			$auth_userid = $user->user_id;
			if($auth_userid != $userid)
			{
			 
					
				
					// for UNFOLLOW   if $existcount>0 than unfollow will show (condition apply in front end)
					$existcount = TblFollowSuscriber::where('user_id',$auth_userid)->count(); 
					
					// For FOLLOW
					$followcounts = TblFollowSuscriber::where('friend_id',$userid)->count(); 
					
			    	if($auth_userid == 18 or $auth_userid == 914) 
					{ $followcounts = ''; }	
					
					
				    // For FRIEND COUNT
				    $count_friends = MtUserFriend::where('user_id',$userid)->count(); 
        	
					
					// FOR BLOCK	
					if($auth_userid != '18' and $auth_userid != 914 )  { 
					    $block = 'true'; // true means BLOCK option will show  (condition apply in front end)  
					}
					
					//FOR DM
					$getfollow = User::where('user_id',$userid)->select('user_id','isdirect_msg')->first(); 
					$user_isdirect_msg = $getfollow['isdirect_msg'];  // if 1 than DM option will show else Not   (condition apply in front end)
					
					
					
					// For Get Updates Via Email OR Unsubscribe Via Email   (0 for Get Updates Via Email) and  (1 for Unsubscribe Via Email)
				
					$userpost_subscriber_exist = TblUserSuscribeViaEmail::select('*')->where([ ['user_id', '=', $userid],['subscriber_user_id', '=', $auth_userid],])->get(); 
					$suscribe_or_unsuscribe = count($userpost_subscriber_exist);
				 
					
			}
			
			    
			}
	    
	    
		$usermoredetail = array(['credit_purchase' => $creditsPurchased,
		                          'userno_of_bestoftheday_posts' => $userno_of_bestoftheday_posts,
		                          'no_of_posts_news' => $no_of_posts_news,
		                          'total_quality_points' => $total_quality_points,
		                          'quality_point_rank' => $quality_point_rank,
		                          'thank_tp_counts' => $thank_tp_counts,
		                          'thank_score' => $thank_score,
		                          'triviaScore_one' => $triviaScore_one,
		                          'triviaScore_one_rank_one' => $triviaScore_one_rank_one,
		                          'triviaScore_two' => $triviaScore_two,
		                          'triviaScore_two_rank_two' => $triviaScore_two_rank_two,
		                          'waittimeScore' => $waittimeScore,
		                          'loungeScore' => $loungeScores,
		                          'last30daymousewait' => $lb_30days,
		                          'mouse_gift' => $mouse_gift,
		                          'existcount' => $existcount,
		                          'followcounts' => $followcounts,
		                          'block' => $block,
		                          'dm'=> $user_isdirect_msg,
		                          'count_friend'=> $count_friends,
		                          'suscribe_or_unsuscribe' => $suscribe_or_unsuscribe,
		                      
		                          ]);
	                 
		                          
		                          

		 
	}
	$totaldata = array(['user' => $userdata,'otherdetail' => $usermoredetail, 'posts' => $postdata ]);
	    
	return response()->json(['status' => 201, 'data' =>	$totaldata ]);
	}
	
	public function removeChat(Request $request)
	{ 				
	$user = auth()->user();
					$userid = $user->user_id;
					$clientIP = request()->ip();
					$type = $request['RemoveType'];
					$removed_id = $request['ban_chat_id'];
					// dd($type);	
					if($type == 'P')  //if post remove from the lounge
					{
					$entry = new TblChatBlock;  
					$entry->user_id = $userid;
					$entry->ban_chat_id = $removed_id;
					$entry->status = 1;
					$entry->createdon = NOW();
					$entry->reasion_for_ban = '';
					$entry->ip_address = $clientIP;
					$entry->save();
					return response()->json(['status' => 201, 'data' =>	'Post Removed']);
					}
					else if($type == 'D')  //if post permanantly delete by particular user from his posts
					{
					TblChat::where('chat_id', $removed_id)->delete();
					Comment::where('chat_id', $removed_id)->delete();
					CommentReply::where('chat_id', $removed_id)->delete();
					return response()->json(['status' => 201, 'data' =>	'Post Deleted']);
					}
					else if($type == 'C') // commnet remove
					{
					Comment::where('chat_reply_id', $removed_id)->delete();
					return response()->json(['status' => 201, 'data' =>	'Removed']);
					}
					else if($type == 'R') // reply remove
					{
					CommentReply::where('id', $removed_id)->delete();
					return response()->json(['status' => 201, 'data' =>	'Removed']);
					}
							


					
	 

	}
	
	public function editChat(Request $request)
	{ 
	
	$user = auth()->user();
					$userid = $user->user_id;
					$clientIP = request()->ip();
					$type = $request['type'];
					$update_chat_id = $request['chat_id'];
					$update_id = $request['chat_reply_id'];
					$update_msg = $request['chat_reply_msg'];
					$id = $request['id'];
					
				
				
					
					if($type == 'P')
					{
					TblChat::where([['chat_id', '=', $update_chat_id ]])
					->update([
					'chat_reply_update_time' => now(),
					'chat_msg' => $update_msg,
				
					]);
					return response()->json(['status' => 201, 'data' =>	'Post Updated Successfully']);
					}
					else if($type == 'C')
					{
					TblChat::where([['chat_id', '=', $update_chat_id ]])
					->update([
					'chat_reply_update_time' => now(),
					]);
					
					Comment::where([['chat_reply_id', '=', $update_id ]])
					->update([
					'chat_reply_msg' => $update_msg,
					]);
					return response()->json(['status' => 201, 'data' =>	'Comment Updated Successfully']);
					}
					else if($type == 'R')
					{
					CommentReply::where([['id', '=', $id ]])
					->update([
					'chat_reply_msg' => $update_msg,
					]);
					return response()->json(['status' => 201, 'data' =>	'Reply Updated Successfully']);
					}
							


					
	 

	}
	
	public function notification(Request $request)
	{  
	$user = auth()->user();
	
	if($user != null ){
	$userid = $user->user_id;
	
	

	$notify = array();
	
	
	
	    /*  $ban_user_qry ="select group_concat(ban_user_id) as ban_user_id ,
(select group_concat(user_id) from tbl_ban_users where ban_user_id=".$session_user_id.")  as ban_me_user_id ,
(select group_concat(ban_user_id) as ban_me_user_id from tbl_remove_user_posts where user_id=" . $session_user_id . ")  as remove__user_posts
from tbl_ban_users where user_id=".$session_user_id ; */
	

	
		$bandata = TblBanUser::select(DB::raw('group_concat(ban_user_id) as ban_user_id'))->where('user_id',$userid)->first();
	    $ban_user_id_array = $bandata->ban_user_id;
	
	    //dd($ban_user_id_array);
	

	// to get notification data as
	//type  tagged , conversion, comment, chat
	
	
	    $datatwo = TextMessage::select('sender_user_id as user_id','id  as chat_id','text_message  as chat_msg','createdon  as updatetime',DB::raw('("") as chat_reply_id'),DB::raw('("conversion") as type'),DB::raw('("") as iscommnt'),'createdon',DB::raw('("") as no_of_likes'),DB::raw('("") as no_of_thanks'))
	                                        
	                                        ->where
										    ([
											['status', '=', '1'],
											['receiver_user_id', '=', $userid],
											//])->groupBy('user_id')->orderBy('createdon', 'DESC');
											]);
        
         $datathree = TextMessage::select('receiver_user_id as user_id','id  as chat_id','text_message  as chat_msg','createdon  as updatetime',DB::raw('("") as chat_reply_id'),DB::raw('("conversion") as type'),DB::raw('("") as iscommnt'),'createdon',DB::raw('("") as no_of_likes'),DB::raw('("") as no_of_thanks'))
	                                       
	                                       ->where
										    ([
											['status', '=', '1'],
											['sender_user_id', '=', $userid],
											//])->groupBy('user_id')->orderBy('createdon', 'DESC');
											]);
        
        
    
		$datafour = Comment::select('reply_user_id','chat_id','chat_reply_msg  as chat_msg','comment_updatedon  as updatetime','chat_reply_id',DB::raw('("comment") as type'),'iscommnt','chat_reply_date as createdon','no_of_likes','no_of_thanks')
		                                   
		                                    ->where
											([
											['chat_reply_status', '=', '0'],
											])
											// ->whereNotIn('reply_user_id',[$ban_user_id_array])
											->take(70)->orderBy('updatetime', 'DESC');
	
	$totalquery = TaggedUser::select('user_id','chat_id','comment_message as chat_msg','createdon  as updatetime','comment_id as chat_reply_id',DB::raw('("tagged") as type'),DB::raw('("") as iscommnt'),'createdon',DB::raw('("") as no_of_likes'),DB::raw('("") as no_of_thanks'))
					->with('user',function ($query) { $query->select(['user_id','user_name','image','user_status','user_text_email','default_park','isdirect_msg','rank','position']); })
					->with('chat',function ($query) { $query->select('chat_id','user_id','chat_msg'); })
				    //->with('comments',function ($query) { $query->where('chat_reply_status','0')->whereNotIn('reply_user_id',[$ban_user_id_array])->orderBy('comment_updatedon', 'DESC')->take(30); })
					//->with('comments.commentuser')
	                ->with('comments.commentsreply.replyuser')
	    
					->where('taged_user_id',$userid)->union($datatwo)->union($datathree)->union($datafour)
					->orderBy('updatetime', 'DESC')->take(60)->get();
		//dd($totalquery);	
	
	
	
/* 	foreach($totalquery as $row){
$friend_user_id = $row->user_id;
//echo '<pre>'; print_r($friend_user_id);

	
	
	} */
	
/* 		$conversionData =  TextMessage::select('*')->where
								 ([
								 ['status', '=', '1'],
								 ['receiver_user_id', '=', $userid ],
								 //['sender_user_id', '=', $friend_user_id],
								  ])
								  ->orWhere
								 ([
								//['receiver_user_id', '=', $friend_user_id],
								['sender_user_id', '=', $userid ],
								  ])
							->with('user')	 
							->orderBy('createdon', 'DESC')
						   ->take(50)
	                       ->get(); */


	    
	    	if($totalquery->count() > 0)
			{
			  $notify =   $totalquery;
			}
			else
			{
			  //$notify = "You do not have any Notification.";
			  $notify[] = array('error'=> "You do not have any Notification.");
			}
	              
	}
	
	else
	{
	    
	$notify[] = array('error'=> "Please login to see your Notifications.");
	}
	
	
	

	
		
	return response()->json(['status' => 201, 'data' =>	$notify, 'conversionData' => '']);
	 

	}
	
	public function notificationNew(Request $request)
	{  
	$user = auth()->user();
	
	if($user != null ){
	$userid = $user->user_id;
	
	$notify = array();

	
	/* $bandata = TblBanUser::select(DB::raw('group_concat(ban_user_id) as ban_user_id'))->where('user_id',$userid)->first();
	$ban_user_id_array = $bandata->ban_user_id;
 */


		// c=comment,s=subscriber,n=tagged,m=text-message

	


$sql = "( SELECT  tbl_users_taged.user_id as user_id ,tbl_users_taged.chat_id as chat_id  ,  tbl_users_taged.comment_message as chat_msg ,'' as chat_img ,'' as chat_video 
	, tbl_users_taged.createdon   as updatetime , tbl_user.user_name  , tbl_user.image ,'n' as type  , '' as   user_status,  '' as user_text_email, '' as  default_park, '' as isdirect_msg ,  '' as chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks , tbl_users_taged.comment_id as chat_reply_id  , tbl_users_taged.createdon,'' as reply_msg 
	FROM tbl_users_taged INNER JOIN  tbl_user ON (tbl_users_taged.user_id = tbl_user.user_id) INNER JOIN tbl_chat ON (tbl_users_taged.chat_id = tbl_chat.chat_id)  where tbl_users_taged.taged_user_id=".$userid." LIMIT 0 , 10 )  
	
	UNION (SELECT distinct tm.sender_user_id as user_id ,tm.id  as chat_id,  tm.text_message  as chat_msg, '' as chat_img, '' as chat_video,  tm.createdon  as updatetime , u.user_name, u.image ,'m' as type  , '' as   user_status,  '' as user_text_email, '' as  default_park, '' as isdirect_msg ,  '' as chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks    , '' as chat_reply_id,  tm.createdon ,'' as reply_msg
	 FROM tbl_text_messages as tm INNER JOIN tbl_user as u ON (tm.sender_user_id = u.user_id)  where status=1 and (tm.receiver_user_id=".$userid.")    )  
	UNION	
	(SELECT distinct tm.receiver_user_id as user_id ,tm.id  as chat_id,  tm.text_message  as chat_msg, '' as chat_img, '' as chat_video,  tm.createdon  as updatetime , u.user_name, u.image ,'m' as type  , '' as   user_status,  '' as user_text_email, '' as  default_park, '' as isdirect_msg ,  '' as chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks    , '' as chat_reply_id,  tm.createdon,'' as reply_msg 
	FROM tbl_text_messages as tm INNER JOIN tbl_user as u ON (tm.receiver_user_id = u.user_id)  where status=1 and  ( tm.sender_user_id = ".$userid." )  )  
	

	UNION 
	( SELECT tbl_chat_reply.reply_user_id  ,tbl_chat_reply.chat_id  as chat_id,   tbl_chat_reply.chat_reply_msg as chat_msg,  '' as chat_img , '' as chat_video,   tbl_chat_reply.comment_updatedon  as updatetime , tbl_user.user_name,   tbl_user.image  ,'c' as type ,  tbl_user.user_status ,  '' as user_text_email, '' as  default_park, '' as isdirect_msg ,  '' as chat_room_id  , tbl_chat_reply.iscommnt, tbl_chat_reply.no_of_likes, tbl_chat_reply.no_of_thanks , tbl_chat_reply.chat_reply_id ,   tbl_chat_reply.chat_reply_date  as createdon,'' as reply_msg 
			FROM  tbl_chat_reply Inner Join tbl_user ON tbl_user.user_id = tbl_chat_reply.reply_user_id 
			 INNER JOIN  tbl_chat ON (tbl_chat_reply.chat_id = tbl_chat.chat_id)
			 
			WHERE tbl_user.user_status=1 and  tbl_chat_reply.chat_reply_status = 0 and  tbl_chat.user_id = ".$userid." ORDER BY tbl_chat_reply.comment_updatedon DESC LIMIT 0 , 40 )  ";   

			$sql .= " UNION 
		( select chat.user_id as uid , chat.chat_id as id, chat.chat_msg as chat_msg, chat.chat_img as chat_img,chat.chat_video  as chat_video  , chat.chat_reply_update_time as updatetime ,  	usr.user_name , usr.image,   's' as type , usr.user_status , usr.user_text_email, usr.default_park,usr.isdirect_msg
	, chat.chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks  , '' as chat_reply_id ,chat.chat_time as createdon,'' as reply_msg   
	FROM   tbl_chat_subscriber  INNER JOIN tbl_chat as chat ON (tbl_chat_subscriber.chat_id = chat.chat_id) INNER JOIN tbl_user as usr  ON (chat.user_id = usr.user_id) 
	where usr.user_status =1  and (tbl_chat_subscriber.user_id = ".$userid.")   order by chat.chat_reply_update_time desc  limit 0,10  ) ";  	 
		 


			
	$sql .= " UNION 
		( select chat.user_id as uid , chat.chat_id as id, chat.chat_msg as chat_msg, chat.chat_img as chat_img,chat.chat_video  as chat_video  , chat.chat_reply_update_time as updatetime ,  	usr.user_name , usr.image,   's' as type , usr.user_status , usr.user_text_email, usr.default_park,usr.isdirect_msg
	, chat.chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks  , '' as chat_reply_id ,chat.chat_time as createdon,'' as reply_msg   
	FROM   tbl_chat_subscriber  INNER JOIN tbl_chat as chat ON (tbl_chat_subscriber.chat_id = chat.chat_id) INNER JOIN tbl_user as usr  ON (chat.user_id = usr.user_id) 
	where usr.user_status =1  and (tbl_chat_subscriber.user_id = ".$userid.")   order by chat.chat_reply_update_time desc  limit 0,10  ) ";   
	$sql .= "  order by  6 desc "; 




	$totalquery = DB::select($sql);
	
/* 	
 	foreach($totalquery as $row)
	{
		$user_id = $row->user_id;
		$newsql = " SELECT tm.id, tm.sender_user_id, tm.text_message, tm.createdon, tm.user_text_email
                        , tm.user_name as tm_user_name, tm.sending_datetime , u.user_name, u.image
                    FROM tbl_text_messages as tm INNER JOIN tbl_user as u ON (tm.sender_user_id = u.user_id)  where status=1 and ((tm.receiver_user_id=".$userid." and tm.sender_user_id=".$user_id.") or (tm.receiver_user_id=".$user_id." and tm.sender_user_id=".$userid.") )  order by  tm.createdon desc  limit 10 "; 
					
					$res = 	DB::select($newsql);
				echo '<pre>'; print_r($res);
	}
	
	die; */
	 
	$result = count($totalquery);
	
/* 	foreach($totalquery as $row)
	{
	 
				 $user_id = $row[0]['user_id'];
				 dd($user_id);
	} */

			
				if($result > 0)
				{
				  $notify =   $totalquery;
				}
				else
				{
				  //$notify = "You do not have any Notification.";
				  $notify[] = array('error'=> "You do not have any Notification.");
				}
					  
		}
		
		else
		{
			
		$notify[] = array('error'=> "Please login to see your Notifications.");
		}
		
	
	

	
		
	return response()->json(['status' => 201, 'data' =>	$notify,]);
	 

	}
	
	public function notificationConversionFriend(Request $request)
	{  
	$user = auth()->user();
	
	if($user != null ){
	$userid = $user->user_id;
	// ->groupBy('user_id')
/* 	$notify = TextMessage::select('*')
							->where
							([
							['status', '=', '1'],
							['sender_user_id', '=', $userid],
							])
							->orderBy('createdon', 'DESC')
							->get();
 */
	

	
/* 	foreach($totalquery as $row)
	{
		$user_id = $row->user_id;
		$newsql = " SELECT tm.id, tm.sender_user_id, tm.text_message, tm.createdon, tm.user_text_email
                        , tm.user_name as tm_user_name, tm.sending_datetime , u.user_name, u.image
                    FROM tbl_text_messages as tm INNER JOIN tbl_user as u ON (tm.sender_user_id = u.user_id)  where status=1 and ((tm.receiver_user_id=".$userid." and tm.sender_user_id=".$user_id.") or (tm.receiver_user_id=".$user_id." and tm.sender_user_id=".$userid.") )  order by  tm.createdon desc  limit 10 "; 
					
				$res = 	DB::select($newsql);
				echo '<pre>'; print_r($res);
	}
	
	die;
	 */
	
		$sql = "SELECT distinct tm.sender_user_id as user_id ,tm.id  as chat_id,  tm.text_message  as chat_msg, '' as chat_img, '' as chat_video,  tm.createdon  as updatetime , u.user_name, u.image ,'m' as type  , '' as   user_status,  '' as user_text_email, '' as  default_park, '' as isdirect_msg ,  '' as chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks    , '' as chat_reply_id,  tm.createdon 
	 FROM tbl_text_messages as tm INNER JOIN tbl_user as u ON (tm.sender_user_id = u.user_id)  where status=1 and (tm.receiver_user_id=".$userid." )  
	UNION	
	(SELECT distinct tm.receiver_user_id as user_id ,tm.id  as chat_id,  tm.text_message  as chat_msg, '' as chat_img, '' as chat_video,  tm.createdon  as updatetime , u.user_name, u.image ,'m' as type  , '' as   user_status,  '' as user_text_email, '' as  default_park, '' as isdirect_msg ,  '' as chat_room_id   , '' as iscommnt,  '' as no_of_likes,  '' as  no_of_thanks    , '' as chat_reply_id,  tm.createdon 
	FROM tbl_text_messages as tm INNER JOIN tbl_user as u ON (tm.receiver_user_id = u.user_id)  where status=1 and  ( tm.sender_user_id = ".$userid." ))";

	
	
	$notify = DB::select($sql);
		
	return response()->json(['status' => 201, 'data' =>	$notify,]);
	 
	}
	}
	
	
	public function getProfile(Request $request)
	{
	
        	$user = auth()->user();
			if($user != null ){
			$userdetails  = User::select('*')->where('user_id',$user->user_id)->first();	
			$categorydata =  TblChatRoom::where('status',1)->select('id','chat_room')->take(8)->get();
			$totaldata = array(['user' => $userdetails,'chatroom' => $categorydata ]);
			return response()->json(['status' => 201, 'data' =>	$totaldata ]);
			}
			else
			{
			$totaldata[] =array('error'=> "Please Login To View OR Update profile");
			return response()->json(['status' => 201, 'data' =>		$totaldata ]);	
			}
		
		
	
	}
	
	public function updateProfile(Request $request)
	{
	   $user_name = '';	  
	   $user_email = '';
	   $userid = '';
	   $user_description = '';
	   
	   $app = realpath(__DIR__ . '/../../../..');
	   $upload_img_dir = $app . '/disneyland/images/userimg/';	
	   $upload_img_dir_thumb = $app . '/disneyland/images/thumbs/';
		
	   $user = auth()->user();
	   $userid = $user->user_id;
	   $auth_username = $user->user_name;
	   $auth_useremail = $user->user_email;
	   
	   $user_name = addslashes( strip_tags($request->user_name)) ;	  
	   $user_email = addslashes( strip_tags($request->user_email) );
	   $user_description = addslashes( strip_tags($request->user_description) );
	  

		if ($user_name !=''){
			$isExist_username = User::where('user_name', '=', $user_name)->first();
			if ($isExist_username === null) {
			User::where([['user_id', '=', $userid ]])->update(['user_name' => $user_name]);	 
			
			return response()->json(['status' => 201, 'data' =>	'Your Username updated successfully.','user_name' =>	$user_name ]);
			 }
			 
			 else
			 {
			 return response()->json(['status' => 201, 'data' =>	'This User name is already in use.' ]);
			 }
					 
		}
		
		else if ($user_email !=''){
			$isExist_email = User::where('user_email', '=', $user_email)->first();
			if ($isExist_email === null) {
			User::where([['user_id', '=', $userid ]])->update(['user_email' => $user_email]);	 
			return response()->json(['status' => 201, 'data' =>	'Your Email updated successfully.' ]);
			 }
			 
			 else
			 {
			 return response()->json(['status' => 201, 'data' =>	'This Email already in use.' ]);
			 }
					 
		}
		
		else if ($user_description !=''){
		User::where([['user_id', '=', $userid ]])->update(['user_description' => $user_description]);	 
		return response()->json(['status' => 201, 'data' =>	'Your Profile updated successfully.' ]);
		}
	
		else if ($request['myfile']) {

		$file = ''.$userid.'.jpg'; 
		$uploadfile = $upload_img_dir . $file;
		$uploadfilecopy = $upload_img_dir_thumb . $file;
			
		$image_parts = explode(";base64,", $request['myfile']);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);


		$fname = filter_input(INPUT_POST, "name");
		$encodedImage = filter_input(INPUT_POST, "image");
		$encodedImage = str_replace('data:image/png;base64,', '', $encodedImage);
		$encodedImage = str_replace(' ', '+', $encodedImage);
		$encodedImage = base64_decode($encodedImage);
		
			if(File::exists($uploadfile)){
                unlink($uploadfile);
            }
			 if(File::exists($uploadfilecopy)){
                unlink($uploadfilecopy);
            }
			
		if(file_put_contents($uploadfile, $image_base64)) {
	/* 	ShortPixel\setKey("OHakDFltn0morEP8s1G4");
		ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir); */ 
		\File::copy($uploadfile,$uploadfilecopy);
		User::where('user_id', $userid)->update(['image' => $file]);
	
		}
			return response()->json(['status' => 201, 'data' =>	'Your Profile Picture updated successfully.' ]);
		
		}
		
		
		
	
	}
	
	public function verifyMail(Request $request)
	{
	  
		
		$user = auth()->user();
		$userid = $user->user_id;
		$auth_username = $user->user_name;
		$auth_useremail = $user->user_email;
	   
		$type = $request->verifymail;

		
		 if ($type !=''){
			$result = AddEmailConfirmation::select('*')->where('user_id', '=', $userid)->get();
			$check_result = count($result);
			if ($check_result > 0) {
			AddEmailConfirmation::where([['user_id', '=', $userid ]])->update(['email_date' => NOW()]);	 
			}
			 
			else
			{
			$entry = new AddEmailConfirmation;  
			$entry->user_id = $userid;
			$entry->email_date = NOW();
			$entry->save();
			}
		
			$myVar = new AlertController();
			$alertSetting = $myVar->emailConfirmationMail($userid,$auth_username,$auth_useremail,$type);
							 		 
		}
		return response()->json(['status' => 201, 'data' =>	'Please Check Your Mailbox']);
	
	}

	
	public function resetConfirmationMail(Request $request)
	{  

		$user_id = $request->uid;
		$ip_address =$_SERVER['REMOTE_ADDR'];
		
		$result = AddEmailConfirmation::select('*')->where('user_id', '=', $user_id)->get();
		$user_res = count($result);
	
		 if($user_res > 0)
				{	

					User::where([['user_id', '=', $user_id ]])->update(['password' => '123456', 'user_status' => '1','isvarified' => 1,'istxtemailvarified' => 1,]);	
				
					AddEmailConfirmation::where('user_id', $user_id)->delete();	
					
					return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
					
				} 
		
	}
	
	public function confirmationMail(Request $request)
	{  

		$user_id = $request->uid;
		//$user_verify_type = $request->type;
		$ip_address =$_SERVER['REMOTE_ADDR'];
		
		$result = AddEmailConfirmation::select('*')->where('user_id', '=', $user_id)->get();
		$user_res = count($result);
	
		 if($user_res > 0)
				 {	
		
				 	/* $email_date = strtotime(date('d-m-Y',strtotime($rows['email_date'])). " +7 day");  
					$today = date('d-m-Y') ;  */
				 		 
					User::where([['user_id', '=', $user_id ]])->update(['user_status' => '1','isvarified' => 1,'istxtemailvarified' => 1,]);	
				
					$description = "Credits for email validation by admin!";
					$type = "admin";
					$credit = 100;
					//it giving 100 credits to user not points 
					$myRank = new RankController();
					$rankSetting = $myRank->updateUserCredit($user_id ,$credit,$description, $type);						
				
					AddEmailConfirmation::where('user_id', $user_id)->delete();	
					
					//return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/lounge');	
						return Redirect::to(env('APP_URL_NEW').'/disneyland/lounge');
					
					} 
		
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/getPlatinumDashboardV9 */
	public function getPlatinumDashboardV9(Request $request)
	{
	
			$user_id = 0; 
			$start_date = date('Y-m-d',strtotime("-70 days")); //date('Y-m-d'); //'2015-03-01';
			$end_date = date('Y-m-d');  //date('Y-m-t'); // '2015-03-31'; 
			$last_updatedon = date('Y-m-d H:i:s'); 
			$selectedDate = date('Y-m-d'); 
			$time_2h  = strtotime(date("Y-m-d H:i"));         
			$current_pulse_time =  ltrim(date("Y-m-d h:i a", $time_2h),'0') ;         
			$next_time  = ltrim(date("Y-m-d h:i a", $time_2h + 1 * 3600),'0') ;
			$current_date =  date('Y-m-d');
	        $usermoredetail='';
			$crowd_index='';
			$todo='';
			$event_hours='';
			$EventIn30Min='';
			$Weather='';
			$BestoftheDay='';
			$admin_news='';
			$BestofFoodLand='';
			$RealTimeLand='';
			$topRealtimePost='';
			$news_land='';
			$Upcoming_Events='';
			$mac_address='';
			$os='';
			$appname='';
			$latitude='';
			$longitude='';
			$version='';
			$type='';
			
			
			
			$user_id = $request->user_id;
			$mac_address = $request->mac_address;
			$os = $request->os;
			$appname = $request->appname;
			$latitude = $request->latitude;
			$longitude = $request->longitude;
			$version = $request->version;
			$type = $request->type;
			
			  
		   	if($user_id > 0)
			 {
				 
		$myVar = new CommonController();
		$todo = $myVar->getUserToDo($user_id,$type='',$event_datetime='',$latitude ='',$longitude ='',$reff_id =0);
				if(!empty($mac_address)){
				static::trackUser($user_id,$mac_address,$appname ,$os);
				 }
				
			 }
			
			/* to get Crowd Index */
			$crowd_index =  TblCrowdIndex::select('park_id','crowd_index')
							->where([
							['status', '=', '1'],
							])
	                       ->orderBy('park_id', 'DESC')
	                       ->get();	
			
			// Event and hours and park timing.
						
			if(!empty($start_date) and !empty($end_date))
			{
			$event_hours =  TblEventHour::select('*')
							->where([
							['event_date', '>=', $start_date],
							['event_date', '<=', $end_date],
							])
	                       ->orderBy('event_date', 'ASC')
	                       ->get();
           }
		   
		   //UPNEXT Events in next 60 Mins.
		   	$EventIn30Min =  TblWhatNextDetail::select('*')
							->where([
							['event_inst_date', '=', $start_date],
							])
							->get();

			 // Yahoo Weather 
			$Weather =  TblWheatherForcast::select('*')->get();
			
			
			// BEST OF THE DAY
			$BestoftheDay =  TblBestOfPostHour::select('*')
							->with('chat')
							->with('user')
							->orderBy('order_no', 'ASC')
							->take(5)
							->get();
			//Admin newss
			$is_free = 0;
		
			$admin_news =  TblAdminNews::select('*')
							->with('user')
							->where([
							['status', '=', 1],
							['istoday_news', '=', 1],
						
							
							])
							->orderBy('id', 'DESC')
							->get();
			
			//BEST OF THE Food Land
			
			$BestofFoodLand =  TblChat::select('*')
							   ->with('user',function ($query) {
								$query->select('user_id','user_name','user_status','user_text_email','user_description','image','default_park','isdirect_msg','totalpoints','position','rank','quality_rank','likes_points','thanks_points',DB::raw('("bestoftheday") as type'))
								->where('user_status','=','1');
                                })
								->with('tagcomposit',function ($query) {
								$query->select('*')
								->where('tags_id','=',17);
                                })
					           ->where([ ['chat_status', '=', 0], ])
					           ->orderBy('chat_id', 'DESC')
						       ->take(5)
					           ->get();
			//Real Time LAND 1 first(by time) LATEST POST.
			
	    	$RealTimeLand =  TblChat::select('*')
							   ->with('user',function ($query) {
								$query->select('user_id','user_name','user_status','user_text_email','user_description','image','default_park','isdirect_msg','totalpoints','position','rank','quality_rank','likes_points','thanks_points',DB::raw('("bestoftheday") as type'))
								->where('user_status','=','1');
                                })
					           ->where([ ['chat_status', '=', 0],['chat_room_id', '=', 1] ])
								// ->whereNotIn('user_id',[$ban_user_id_array])
					           ->orderBy('chat_time', 'DESC')
						       ->take(1) 
					           ->get();
			
			//Real Time LAND 0  first(by time) LATEST POST.
			$topRealtimePost =  TblChat::select('*')
							   ->with('user',function ($query) {
								$query->select('user_id','user_name','user_status','user_text_email','user_description','image','default_park','isdirect_msg','totalpoints','position','rank','quality_rank','likes_points','thanks_points',DB::raw('("bestoftheday") as type'))
								->where('user_status','=','1');
                                })
					           ->where([ ['chat_status', '=', 0],['chat_room_id', '=', 0] ])
								// ->whereNotIn('user_id',[$ban_user_id_array])
					           ->orderBy('chat_time', 'DESC')
						       ->take(1) 
					           ->get();
			
			//NEWS LAND 5 LATEST POST.
				$news_land =  TblChat::select('*')
							   ->with('user',function ($query) {
								$query->select('user_id','user_name','user_status','user_text_email','user_description','image','default_park','isdirect_msg','totalpoints','position','rank','quality_rank','likes_points','thanks_points',DB::raw('("bestoftheday") as type'))
								->where('user_status','=','1');
                                })
					           ->where([ ['chat_status', '=', 0],['chat_room_id', '=', 137] ])
								// ->whereNotIn('user_id',[$ban_user_id_array])
					           ->orderBy('chat_time', 'DESC')
						       ->take(5) 
					           ->get();
					
				//Upcoming Events from MW Events (Meetup Events.)	
				$Upcoming_Events =  TblMeetUp::select('*')
							   ->with('user')
					           ->where([ ['status', '=', 1],['event_date', '>=', $current_date] ])
							   ->take(5) 
					           ->get();
			
				$totaldetail = array([
	    	                   'todo'  => $todo,
	    	                   'crowd_index'  => $crowd_index,
	    	                   'event_hours'  => $event_hours,
	    	                   'EventIn30Min' => $EventIn30Min,
	    	                   'Weather' 	  => $Weather,
	    	                   'BestoftheDay' => $BestoftheDay,
	    	                   'admin_news'   => $admin_news,
	    	                   'BestofFoodLand'   => $BestofFoodLand,
	    	                   'RealTimeLand'   => $RealTimeLand,
	    	                   'topRealtimePost'   => $topRealtimePost,
	    	                   'news_land'   => $news_land,
	    	                   'Upcoming_Events'   => $Upcoming_Events,
		                         
		                       ]);
       
     	return response()->json(['status' => 201, 'data' =>	 $totaldetail]);	
		
		
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/radioJson */
	public function radioJson(Request $request)
	{
		$radioJson =  TblSong::select('id','singer_name as artist','album_name as album','song_name as title',DB::raw('("https://picsum.photos/id/1038/200/300") as artwork'),DB::raw('("123") as duration'),'song_url as url')
							->where([ ['status', '=', '1'], ])
							->orderBy('id', 'DESC')
	                       ->get();	
			
     	return response()->json(['status' => 201, 'data' =>	 $radioJson]);	
		
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/userSongsJson */
	public function userSongsJson(Request $request)
	{
		
		// $user = auth()->user();
		// if($user != null ){
		// $userid = $user->user_id;
	
		// }
		// else
		// {
		// return response()->json(['status' => 201, 'data' =>	 'please login']);		
		// }
		
		$userSongsJson =  TblSong::select('*')
					->where([ ['status', '=', '1'], ])
					->orderBy('id', 'DESC')
				   ->get();	
			
     	return response()->json(['status' => 201, 'data' =>	 $userSongsJson]);
		
	
	}
	
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/getWhatNext?lat=21.2333&long=81.6333&appname=DL&in_active=1&version=11.0&type=DL&user_id=38 
	*/
	public function getWhatNext(Request $request)
	{
		$user_id = 0;
        $get_request_count = count($request->all());
        $event_inst_date = date('Y-m-d');
		$whatnext_cat_id = 1;
		$sub_cat_id = 0;
		$appname = 'DL';
		$attractions = '';
		$events = '';
		$restrooms = '';
        $iPhone_charging_stations='';
        $upnext='';
		
		if($get_request_count > 0)
        {
            $mac_address = '';
	    	$os = 0;
	    //	$mac_address = request()->ip();
            $start_date = date('Y-m-d');
          	$latitude = $request->lat;
			$longitude  = $request->long;
			$in_active = $request->in_active;
	
			
			$appname = $request->appname;
			$version = $request->version;
			$type = $request->type;
			if(isset($request->mac_address)){$mac_address =  $request->mac_address;}
			if(isset($request->os)){$os =  $request->os;}
			$user_id = $request->user_id; 

			$attractions =  TblRide::select('rides_id','rides_location',DB::raw("(round( ((ACOS(SIN($latitude * PI() / 180) * SIN(lat * PI() / 180) + COS($latitude * PI() / 180) * COS(lat * PI() / 180) * COS(($longitude - lon) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000*3.28), 2)) as distance"),'avg_upd_time  as lastupdate','lat','lon as long1','fastpass','is_fastpass','isfood','rides_status','last_updated_wt_user_id','last_updated_wt_user_name','last_updated_fp_user_id','last_updated_fp_user_name','is_show_username_wt','wt_postedon','fp_postedon','is_show_username_fp','park_id',DB::raw("(IF(park_id = 1 ,'Disneyland Park','Disney California Adventure')) as park_name"),DB::raw("(IF(avg_time = 0 ,'CL',avg_time)) as avg_time"),DB::raw("(REPLACE(rides_name, 'amp;', '')) as rides_name"))
							   ->with('park')
								->where([ ['lat', '<>', ''],['islock', '=', 0],['rides_status', '=', 1], ])
					           ->orderBy('distance', 'ASC')
						     
					           ->get();
			
				$events = static::getWhatUpNext($latitude, $longitude , 'DL','1');
				$restrooms = static::getWhatUpNext($latitude, $longitude , 'DL','3');
				$iPhone_charging_stations = static::getWhatUpNext($latitude, $longitude , 'DL','4');
         
			
			
			$upnext =  TblWhatNextDetail::select('id','name','description','event_inst_date','event_day','showtime',			'park_id')
						->where([['event_inst_date', '=',  $event_inst_date], ])
					   ->get();
					   
		   $Restaurants =  TblRestorant::select('res_id','res_name','res_description','res_image','park_id','res_add',			DB::raw("round( ((ACOS(SIN($latitude * PI() / 180) * SIN(res_lat * PI() / 180) + COS($latitude * PI() / 180) * COS(res_lat * PI() / 180) * COS(($latitude - res_long) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000*3.28), 2) as distance"),'res_lat','res_long','res_rating','subcat_id','cat_name','status','res_rating_hits','menu_url','park')
			->where([['status', '=',  1],['park', '=',  $appname] ])
			->orderBy('distance', 'ASC')
		   ->get();
		   
		   
		   	if($user_id > 0 and !empty($mac_address))
			 {
			 static::trackUser($user_id,$mac_address,$appname,$os);
				
			 }
				
			$getWhatNext = array([
						   'attractions'  => $attractions,
						   'events'  => $events,
						   'restrooms' => $restrooms,
						   'iPhone_charging_stations' 	  => $iPhone_charging_stations,
						   'Restaurants' => $Restaurants,
						   'upnext'   => $upnext,
					
							 
						   ]);	
				
		 }

		

			
		
        
        else
        {
           $getWhatNext = 'invalid json'; 
        }
     	return response()->json(['status' => 201, 'data' =>	 $getWhatNext]);	
		
		
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/getRechargeCredit */
	public function getRechargeCredit(Request $request)
	{
	$user = auth()->user();
	$current_user_credits = [];
	$get_recharge_credit = [];
	if($user != ''){
	$user_id = $user->user_id; 
	$userdata = User::select('user_credits','iscreditsfreez')->where('user_id',$user_id)->get();
	
	$current_user_credits = $userdata[0]['user_credits'];
	$iscreditsfreez = $userdata[0]['iscreditsfreez'];
	if($iscreditsfreez == 1)
	{
		$current_user_credits = "Your device has been blocked from MouseWait and your Credits are on hold. Please contact support@mousewait.com for more information.";	
	}
	$get_recharge_credit =  TblMwCredit::select('id','amount','credits')
							->where([ ['status', '=', '1'], ])
	                       ->get();		
	}
	
	else
	{
	$current_user_credits[] = "Please Login To View Recharge Credits";
	}
	
	
	
	$arraydata=array('store'=>$get_recharge_credit,'credit_balance'=>$current_user_credits);	
    return response()->json(['status' => 201, 'data' =>	 $arraydata]);	
		
		
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/getMyTradeRequest?user_id=38&version=11 */
	public function getMyTradeRequest(Request $request)
	{
		$user = auth()->user();
		if($user != ''){
		$user_id = $user->user_id; 
		$version = ''; 
		$version = $request->version; 
		$user_data =  User::select('user_credits','iscreditsfreez')
							->where([ ['user_id', '=', $user_id], ])
	                       ->first();	
		
		$get_trade_request =  TblMwProductTradeRequest::select('*')
							->with('user')
							->with('mycollection')
							->where([ ['user_id', '=', $user_id],['status', '=', 1] ])
						   ->get();
		
		$get_trade_my_request =  TblMwProductTradeRequest::select('*')
							->with('user')
							->with('mycollection')
							->where([ ['trade_request_user_id', '=', $user_id],['status', '=', 1] ])
						   ->get();
		
		$totaldetail = array([
					   'user_data'  => $user_data,
					   'get_trade_request'  => $get_trade_request,
					   'get_trade_my_request'  => $get_trade_my_request,
					   ]);
		
		}
		
		else
		{
			 
		$totaldetail[] =array('error'=> "Please Login To View Your Trade Request");
		}
     	return response()->json(['status' => 201, 'data' =>	 $totaldetail]);	
		
		
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/getMyCollection*/
	public function getMyCollection(Request $request)
	{
		$searchtext = $request->name;
		
		
		$offset = 0;
		$page = $request->page;
		$page = $page - 1;
		$offset = $page * 200;
		
		$current_user_credits = [];
		$get_all_product = [];
		$user = auth()->user();
		if($user != ''){
		$user_id = $user->user_id; 
		$version = ''; 
		$version = $request->version; 
		$userdata = User::select('user_credits','iscreditsfreez')->where('user_id',$user_id)->get();
	
		$current_user_credits = $userdata[0]['user_credits'];
		$iscreditsfreez = $userdata[0]['iscreditsfreez'];
		if($iscreditsfreez == 1)
		{
			$current_user_credits = "Your device has been blocked from MouseWait and your Credits are on hold. Please contact support@mousewait.com for more information.";	
		}
		$get_all_product =  TblMwMycollection::where
											([
											['status', '>', '0'],
											['user_id', '=', $user_id],
											])
											->select('*')
											->with('user')
											->with('mwproduct')
											->orderBy('createdon', 'DESC')
											->offset($offset)
											->take(200)
											->get();
							
		

		$total_list =  User::where([['user_name', 'LIKE', '%'. $searchtext. '%'],])->select('user_name')->take(30)->get();
		
		}
		else
		{
			 
		$current_user_credits = "Please Login To View Your Collections";
		}
		$arraydata=array('store'=>$get_all_product,'credit_balance'=>$current_user_credits,'userlist'=>$total_list);
     	return response()->json(['status' => 201, 'data' =>	 $arraydata]);	
		
		
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/getMyHistory*/
	public function getMyHistory(Request $request)
	{	
	    $offset = 0;
		$page = $request->page;
		$page = $page - 1;
		$offset = $page * 50;
	    
		$user = auth()->user();
		if($user != ''){
		$user_id = $user->user_id;
		// $user_id = $request->user_id; 
		$version = ''; 
		$version = $request->version; 
		
		$mw_collection =  	TblMwMycollection::select('product_name','product_description as description',
							'product_credits as debits',DB::raw('("0") as credts'),'status','createdon',DB::raw('("c") as record'),'trans_description')
						    ->where('user_id',$user_id);
		
		$mw_credit =  		TblMwCreditDetail::select(DB::raw('("Credits") as product_name'),'type as description',
												DB::raw('("0") as debits'),'credits as credts','status','createdon',DB::raw('("d") as record'),DB::raw('(points_used + amount) as trans_description'))
											->where('user_id',$user_id)->union($mw_collection) ->orderBy('createdon', 'DESC')->offset($offset)
											->take(50)
											->get();
		
		
		}
		else
		{
			 
		$mw_credit[] =array('error'=> "Please Login To View Your History");
		}
		
     	return response()->json(['status' => 201, 'data' =>	 $mw_credit]);	
		
		
		/* 1 = Owner, 2 = Gifted, 3 = Traded, 0 = Given */
		
	
	}
	
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/giftThisProduct */
	/* parameters user_name,hdd_coll_id,token */
	
	public function giftThisProduct(Request $request)
	{ 

	$who_take_gift_username = $request->user_name;
	$giftid = $request->hdd_coll_id;
	
			$user = auth()->user();
			if(($user != null) and !empty($who_take_gift_username) and  $giftid>0)
			{
			$userid = $user->user_id;
			
			$userdata = User::where
						([
						['user_status', '=', '1'],
						['user_name', '=', $who_take_gift_username],
						])->select('*')->get();
			
			$countuserdata = count($userdata);
	
			$gifted_user_id = $userdata[0]['user_id'];
			$gifted_user_name = $userdata[0]['user_name'];
			$gifted_user_email = $userdata[0]['user_email'];
							
							
						if($countuserdata > 0)
						{
						$get_all_product =  TblMwMycollection::where([['id', '=', $giftid],])->select('*')->first();
							
							$owner_only=  $get_all_product->owner_only;  
							$gift_id=  $get_all_product->id;  
							$gift_user_id=  $get_all_product->user_id; 
							$gift_product_id = $get_all_product->product_id; 						
							$gift_product_image = $get_all_product->product_image; 						
							if($owner_only==0)
							{
							$trans_description="gifted by your friend user id : ".$gift_user_id." on ".date("y-m-d H:i:s").' tbl_mw_mycollections.id = '.$gift_id;	
							$entry = new TblMwMycollection;  
							$entry->product_id = $get_all_product->product_id;
							$entry->product_name = $get_all_product->product_name;
							$entry->user_id = $gifted_user_id;
							$entry->product_credits = 0;
							$entry->product_quantity = $get_all_product->product_quantity;
							$entry->product_image = $get_all_product->product_image;
							$entry->product_description = $get_all_product->product_description;
							$entry->status = 2;
							$entry->createdon = now();
							$entry->giftedby_user_id = $gift_user_id;
							$entry->gift_date = now();
							$entry->trans_description = $trans_description;
							$entry->owner_only = $owner_only;
							$entry->isemojis = $get_all_product->isemojis;
							$entry->emoji_category_id = $get_all_product->emoji_category_id;
							$entry->save();
							
							$inserted_id=$entry->id;
							$trans_description= "Gifted to a friend user id :".$gifted_user_id." and User name =".$gifted_user_name." on ".date("y-m-d H:i:s").' tbl_mw_mycollections.id = '.$inserted_id." from mwdl apps.";
							
							
							TblMwMycollection::where([['id', '=', $giftid ]])->update(['status' => '0','trans_description' => $trans_description]);
							
							
							$myVar = new AlertController();
							$alertSetting = $myVar->sendGiftMail($gifted_user_name,$gifted_user_email,  $gift_product_image);
							 
							
							return response()->json(['status' => 200, 'data' =>	array('message'=>"You successfully sent a gift to ".$gifted_user_name) ]);	
							}	
							else
							{
							return response()->json(['status' => 200, 'data' =>	array('error'=>'You can not gift this item.') ]);
							}	
								
							
						
						}
						else
						{
						return response()->json(['status' => 200, 'data' =>	array('error'=>'User is not active.') ]);
						}
			}
			else
			{
			return response()->json(['status' => 200, 'data' =>	array('error'=>'Nothing') ]);
			}
		}
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/tradeRequestAccept */
	 public function tradeRequestAccept(Request $request)
	{ 
			$trade_req_id = $request->tid;
		
			if($trade_req_id > 0)
			{
			$get_all_product =  TblMwProductTradeRequest::where
									([
									['status', '=', '1'],
									['id', '=', $trade_req_id],
									])->select('*')->first();

			$mycollection_id =  $get_all_product->mycollection_id;
			$mycol_user_id =  $get_all_product->user_id;
			$trade_request_collection_id =  $get_all_product->trade_request_collection_id;  
			$trade_request_user_id =  $get_all_product->trade_request_user_id;
			
			$get_collection =  TblMwMycollection::where([['id', '=', $mycollection_id],])->with('usertrade')->select('*')->first();
			
			$gift_id =  $get_collection->id;
			$gift_product_id =  $get_collection->product_id;
			$gift_product_name =  $get_collection->product_name; 
			$gift_product_credits = $get_collection->product_credits;
			$gift_product_quantity =  $get_collection->product_quantity;
			$gift_product_image =  $get_collection->product_image;
			$gift_product_description =  $get_collection->product_description;
			$gift_status =  $get_collection->status;  
			$owner_only=  $get_collection->owner_only;  
			$gift_user_name =  $get_collection->user_name;  
			$isemojis=  $get_collection->isemojis;
			$emoji_category_id=  $get_collection->emoji_category_id;
			
			$trans_description="You have Trade with your friend user id : ".$mycol_user_id." and his name is ".$gift_user_name." on ".date("y-m-d H:i:s")." With his collection id ".$mycollection_id.' tbl_mw_mycollections.id = '.$gift_id;
				
							$entry = new TblMwMycollection;  
							$entry->product_id = $gift_product_id;
							$entry->product_name = $gift_product_name;
							$entry->user_id = $trade_request_user_id;
							$entry->product_credits = 0;
							$entry->product_quantity = $gift_product_quantity;
							$entry->product_image = $gift_product_image;
							$entry->product_description = $gift_product_description;
							$entry->status = 2;
							$entry->createdon = now();
							$entry->giftedby_user_id = $mycol_user_id;
							$entry->gift_date = now();
							$entry->trans_description = $trans_description;
							$entry->owner_only = $owner_only;
							$entry->isemojis = $isemojis;
							$entry->emoji_category_id = $emoji_category_id;
							$entry->save();
							
							$inserted_id=$entry->id;
							
							// $trans_description= "Requested for Trade with friend user id :".$gifted_user_id." and User name =".$gifted_user_name." on ".date("y-m-d H:i:s").' tbl_mw_mycollections.id = '.$inserted_id;
							
							//isko uncoment karna h
							$trans_description= 'Requested for Trade with friend user id :"" and User name ="" on '.date("y-m-d H:i:s").' tbl_mw_mycollections.id = '.$inserted_id;
							
							
							TblMwMycollection::where([['id', '=', $mycollection_id ]])->update(['status' => '0','trans_description' => $trans_description]);
							
							$trans_description="You have Trade with your friend user id : ".$trade_request_user_id." and his name is ".$gift_user_name." on ".date("y-m-d H:i:s")." With his collection id ".$trade_request_collection_id ;
							
							$entry = new TblMwMyCollectionHistory;  
							$entry->product_id = $gift_product_id;
							$entry->product_name = $gift_product_name;
							$entry->user_id = $mycol_user_id;
							$entry->product_credits = $gift_product_credits;
							$entry->product_quantity = 1;
							$entry->product_image = $gift_product_image;
							$entry->product_description = $gift_product_description;
							$entry->status = 3;
							$entry->createdon = now();
							$entry->gift_date = now();
							$entry->trans_description = $trans_description;
							$entry->owner_only = 0;
							$entry->is_featured = 0;
						
							$entry->save();
							
							
		$get_collection =  TblMwMycollection::where([['id', '=', $trade_request_collection_id],])->with('usertrade')->select('*')->first();
		
		
						$gift_id =  $get_collection->id;
						$gift_product_id =  $get_collection->product_id;
						$gift_product_name =  $get_collection->product_name; 
						$gift_product_credits = $get_collection->product_credits;
						$gift_product_quantity =  $get_collection->product_quantity;
						$gift_product_image =  $get_collection->product_image;
						$gift_product_description =  $get_collection->product_description;
						$gift_status =  $get_collection->status;  
						$owner_only=  $get_collection->owner_only;  
						$gift_user_name =  $get_collection->user_name;  
						$isemojis=  $get_collection->isemojis;
						$emoji_category_id=  $get_collection->emoji_category_id;
					
					$trans_description="You have Trade with your friend user id : ".$mycol_user_id." and his name is ".$gift_user_name." on ".date("y-m-d H:i:s")." With his collection id ".$trade_request_collection_id .' tbl_mw_mycollections.id = '.$gift_id;
					
							$entry = new TblMwMycollection;  
							$entry->product_id = $gift_product_id;
							$entry->product_name = $gift_product_name;
							$entry->user_id = $mycol_user_id;
							$entry->product_credits = 0;
							$entry->product_quantity = $gift_product_quantity;
							$entry->product_image = $gift_product_image;
							$entry->product_description = $gift_product_description;
							$entry->status = 2;
							$entry->createdon = now();
							$entry->giftedby_user_id = $trade_request_user_id;
							$entry->gift_date = now();
							$entry->trans_description = $trans_description;
							$entry->owner_only = $owner_only;
							$entry->isemojis = $isemojis;
							$entry->emoji_category_id = $emoji_category_id;
							$entry->save();
							
							$inserted_id=$entry->id;
							 // $trans_description= "Requested for Trade with friend user id :".$gifted_user_id." and User name =".$gifted_user_name." on ".date("y-m-d H:i:s").' tbl_mw_mycollections.id = '.$inserted_id; 
							 
							  //isko uncommment karna h
						$trans_description= 'Requested for Trade with friend user id :"" and User name ="" on '.date("y-m-d H:i:s").' tbl_mw_mycollections.id = '.$inserted_id;
							 
						
							TblMwMycollection::where([['id', '=', $trade_request_collection_id ]])->update(['status' => '0','trans_description' => $trans_description]);
			
			$trans_description="You have Trade with your friend user id : ".$trade_request_user_id." and his name is ".$gift_user_name." on ".date("y-m-d H:i:s")." With his collection id ".$trade_request_collection_id ;
						
						
							$entry = new TblMwMyCollectionHistory;  
							$entry->product_id = $gift_product_id;
							$entry->product_name = $gift_product_name;
							$entry->user_id = $mycol_user_id;
							$entry->product_credits = $gift_product_credits;
							$entry->product_quantity = 1;
							$entry->product_image = $gift_product_image;
							$entry->product_description = $gift_product_description;
							$entry->status = 3;
							$entry->createdon = now();
							$entry->gift_date = now();
							$entry->trans_description = $trans_description;
							$entry->owner_only = 0;
							$entry->is_featured = 0;
						
							$entry->save();
							
			TblMwProductTradeRequest::where('id', $trade_req_id)->delete();
			
			return response()->json(['status' => 200, 'data' =>	array('error'=>'OK Done.') ]);
			}
			else
			{
			return response()->json(['status' => 200, 'data' =>	array('error'=>'Invalid trade') ]);
			}
	} 
	/* http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/tradeRequestReject */
	public function tradeRequestReject(Request $request)
	{ 
	
			$trade_req_id = $request->tid;
			
			if($trade_req_id > 0)
			{
			$get_all_product =  TblMwProductTradeRequest::where
									([
									['id', '=', $trade_req_id],
									])->select('*')->first();

			$trade_mycollection_id =  $get_all_product->mycollection_id;
			$trade_request_collection_id =  $get_all_product->trade_request_collection_id;  
			
			TblMwProductTradeRequest::where('id', $trade_req_id)->delete();
			
			TblMwMycollection::where([['id', '=', $trade_request_collection_id ]])->update(['status' => '1','trans_description' => '']);
			
			
			return response()->json(['status' => 200, 'data' =>	array('error'=>'OK Donee.') ]);
			}
			else
			{
			return response()->json(['status' => 200, 'data' =>	array('error'=>'Invalid trade') ]);
			}
	}
	
	public function getWhatUpNext($lat,$lon,$appname,$cat_id)
	{
	   
         if( !empty($lat) and !empty($lon))
        {
            $current_date = date('Y-m-d');
            
			switch ($appname) {
                case 'DL':
					
					
					if($cat_id==1)
					{
					$ev_date = $current_date;
					}
					else
					{
					$ev_date = '';	
					}
					
					$QueryString =  TblWhatNextDetail::select('id','name',DB::raw("(round( ((ACOS(SIN($lat * PI() / 180) * SIN(lat * PI() / 180) + COS($lat * PI() / 180) * COS(lat * PI() / 180) * COS(($lon - lon) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000*3.28), 2)) as distance"),'url','lat','lon as long1','description','showtime','event_inst_date','subcat_id','park_id')
							   
					->where([['status', '=', 1],['cat_id', '=', $cat_id],['event_inst_date', '=', $ev_date] ])
				    ->orderBy('distance', 'ASC');
					
					
                    // $QueryString = "  SELECT id,name , round( ((ACOS(SIN($lat * PI() / 180) * SIN(lat * PI() / 180) + COS($lat * PI() / 180) * COS(lat * PI() / 180) * COS(($lon - lon) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000*3.28), 2) AS distance 
                    // ,url,lat,lon as long1, description ,showtime ,event_inst_date ,subcat_id ,park_id  
                    // FROM  tbl_whatnext_details
                    // where status = 1 and  cat_id = ".$cat_id.$ev_date." order by distance asc   "; 
      
                    break;
                
               case 'WDW':
                    // $QueryString = "  SELECT id,name , round( ((ACOS(SIN($lat * PI() / 180) * SIN(lat * PI() / 180) + COS($lat * PI() / 180) * COS(lat * PI() / 180) * COS(($lon - lon) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000*3.28), 2) AS distance ,url,lat,lon as long1, description ,showtime ,event_inst_date ,subcat_id   
                    // FROM  wdw_whatnext_details
                    // where status = 1 and  cat_id = ".$cat_id." AND event_inst_date ='".$current_date."' order by distance asc   "; 
					
					$QueryString =  WdwWhatNextDetail::select('id','name',DB::raw("(round( ((ACOS(SIN($lat * PI() / 180) * SIN(lat * PI() / 180) + COS($lat * PI() / 180) * COS(lat * PI() / 180) * COS(($lon - lon) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000*3.28), 2)) as distance"),'url','lat','lon as long1','description')
							   
					->where([['status', '=', 1],['cat_id', '=', $cat_id],['event_inst_date', '=', $current_date] ])
				    ->orderBy('distance', 'ASC');
					
                    break;   
            }
    
    
			$getWhatUpNext =  $QueryString->get();
			
			         
        }
        else 
		{
            $getWhatUpNext = 'Latitude or Longitude can not be empty' ;
        }


			
		
       
     	//return response()->json(['status' => 201, 'data' =>	 $getWhatUpNext]);	
		return json_decode(json_encode($getWhatUpNext), true);
		
		
	
	}
	
	public function trackUser($user_id,$mac_address,$appname,$os_type)
	{
	 
		//Tracking the user visit
				$ip_address = $_SERVER['REMOTE_ADDR'];
				if($appname == ''){ $app_name = "DL mobile APPS";}else{$app_name = $appname;}
				if($os_type == ''){ $os = "IOS";}else{$os = $os_type;}
		
				$userdata =  User::select('*')
							->where([['user_status', '=',  1],['user_id', '=',  $user_id] ])
						   ->first();
				User::where([['user_id', '=', $user_id ]])->update(['mac_address' => $mac_address]);
				
				$track_user_detail = LoginUserTracking::whereDate('login_datetime', today())
									->where([['user_id', '=',  $userdata['user_id']],['login_from', '=', $app_name] ])
									->count();
										
						
						
				if($track_user_detail == 0){
				$entry = new LoginUserTracking;  
				$entry->user_name = $userdata['user_name'];
				$entry->user_email = $userdata['user_email'];
				$entry->user_id = $userdata['user_id'];
				$entry->login_datetime = NOW();
				$entry->ip_address = $ip_address;
				$entry->mac_address = $mac_address;
				$entry->login_from = $app_name;
				$entry->os = $os;
				$entry->no_of_login_from_ip = 1;
				$entry->status = 1;
				$entry->save();
				}
		
		
	}
	
	public function getUserDataViaToken(Request $request)
	{
		$user = auth('api')->user();
		// dd($user);
     	return response()->json(['status' => 201, 'data' =>	 $user]);	
		
		
		
	
	}
	
	public function mWStoreBuy(Request $request)
	{ 
	
	$user = auth()->user();
	
	$userid = $user->user_id;
	$product_id = $request->id;
	$userdata = User::select('user_credits','iscreditsfreez')->where('user_id',$userid)->get();
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$user_credits = 0;
	$user_credits = $userdata[0]['user_credits'];
	$iscreditsfreez = $userdata[0]['iscreditsfreez'];
	
	
	if($iscreditsfreez == 1)
	{
		$result = "Your device has been blocked from MouseWait and your Credits are on hold. Please contact support@mousewait.com for more information.";	
		// return response()->json(['status' => 200, 'data' =>	array('error'=>$current_user_credits) ]);
		return response()->json(['status' => 200, 'data' =>	$result ]);
	}
	
	$store =  MwProduct::select('*')->where('id',$product_id)->first();
	
	// $qry = "SELECT * from tbl_mw_products where id=194"; 
	// $res = DB::select($qry);

	$product_id_l = $store->id;
	$product_price = $store->product_price;
	$product_quantity = $store->product_quantity;
	$product_price = $store->product_price;
	$product_name = $store->product_name;
	$isemojis = $store->isemojis;
	$product_image = $store->product_image;
	$product_description = $store->product_description;
	$owner_only = $store->owner_only;
	$emoji_category_id = $store->emoji_category_id;
	
	
	 if($user_credits >= $product_price)
	{
		if($product_quantity >= 1)
		{
				$entry = new TblMwOrder;  
				$entry->order_date = now();
				$entry->user_id = $userid;
				$entry->credites = $product_price;
				$entry->order_quantity = 1;
				$entry->discount = 0;
				$entry->discount_code = '';
				$entry->status = 1;
				$entry->createdon = now();
				$entry->product_id = $product_id_l;
				$entry->save();
				
				$order_id=$entry->id;
				
				$entryorder = new TblMwOrderProduct;  
				$entryorder->order_id = $order_id;
				$entryorder->product_id = $product_id;
				$entryorder->product_name = $product_name;
				$entryorder->product_quantity = 1;
				$entryorder->credites = $product_price;
				$entryorder->discount = 0;
				$entryorder->status = 1;
				$entryorder->createdon = now();
				$entryorder->isemojis = $isemojis;
				$entryorder->user_id = $userid;
				$entryorder->save();
				
				MwProduct::where('id', $product_id)->update(['product_quantity' => \DB::raw('product_quantity - 1')]);
				
				$entrycollection = new TblMwMycollection;  
				$entrycollection->product_id = $product_id;
				$entrycollection->product_name = $product_name;
				$entrycollection->user_id = $userid;
				$entrycollection->product_image = $product_image;
				$entrycollection->product_description = $product_description;
				$entrycollection->product_credits = $product_price;
				$entrycollection->product_quantity = 1;
				$entrycollection->owner_only = $owner_only;
				$entrycollection->isemojis = $isemojis;
				$entrycollection->emoji_category_id = $emoji_category_id;
				$entrycollection->sorting_order = 1;
				$entrycollection->buy_from = 'web lounge';
				$entrycollection->save();
				
				$description = "buy a prodcut ".$product_name ;
				
				
				$entrycredit = new TblMwCreditDetail;  
				$entrycredit->user_id = $userid;
				$entrycredit->credits = 0;
				$entrycredit->debit = $product_price;
				$entrycredit->current_credits = $user_credits;
				$entrycredit->type = 'credits';
				$entrycredit->ip_address = $ip_address;
				$entrycredit->status = 4;
				$entrycredit->createdon = now();
				$entrycredit->description = $description;
				$entrycredit->save();
				
				User::where('user_id', $userid)->update(['user_credits' => \DB::raw("user_credits - ".$product_price."")]);

				return response()->json(['status' => 200, 'data' =>	'This item has been added to your Collection.' ]);
		}
		else
		{
		return response()->json(['status' => 200, 'data' =>	'We are sorry no more product availaible.' ]);	
		}
	
	}
	
	}


	public function likeCommentAndReply(Request $request)
	{
		$user = auth('api')->user();
		$auth_userid = $user->user_id;
		$auth_username = $user->user_name;
		
		
		$chat_id = $request->chat_id;
		$comment_id = $request->comment_id;
		$reply_id = $request->reply_id;
		$commnet_userid = $request->commnet_userid;
		$type = $request->type;
		
	if($type == 'C'){
		if($commnet_userid!=$auth_userid) {
			$isExist = TblLikeComment::select('*')->where([
							['user_id', '=', $auth_userid],
							['comment_id', '=', $comment_id],
						    ])->count();
			
			if($isExist == 0){
				$entry = new TblLikeComment;  
				$entry->comment_id = $comment_id;
				$entry->chat_id = $chat_id;
				$entry->user_id = $auth_userid;
				$entry->user_name = $auth_username;
				$entry->save();
				
			Comment::where('chat_reply_id', $comment_id)->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
				
			$getcommnet = Comment::select('reply_user_id')->where([
							['chat_reply_id', '=', $comment_id],
						    ])->first();
							
			$rk_user_id = $getcommnet->reply_user_id;
				if($auth_userid  != $rk_user_id)
				{  //update User points and top of the week 
					//This function will update or insert the Total point for Top Of the  day ,week ,month 
					//to update user points of  partcular chat user
					$myRank = new RankController();
					$rankSetting = $myRank->updateUserRank($rk_user_id ,'1.5','comments_likes_web','DL');
				 } 
				
		    return response()->json(['status' => 201, 'data' =>	 'Like registered']);	
			
			}
			else
			{
			return response()->json(['status' => 201, 'data' =>	 'Already Added' ]);	
			}
		}
		else{
		return response()->json(['status' => 201, 'data' =>	 'You can not like your own comment']);
		}
		
	}
	else if($type == 'R'){
		if($commnet_userid!=$auth_userid) {
			$isExist = TblLikeReply::select('*')->where([
							['user_id', '=', $auth_userid],
							['comment_id', '=', $reply_id],
						    ])->count();
			
			if($isExist == 0){
				$entry = new TblLikeReply;  
				$entry->comment_id = $reply_id;
				// $entry->reply_id = $reply_id;
				$entry->user_id = $auth_userid;
				$entry->user_name = $auth_username;
				$entry->save();
				
			CommentReply::where('id', $reply_id)->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
			
				if($auth_userid  != $commnet_userid)
				{  
					$myRank = new RankController();
					$rankSetting = $myRank->updateUserRank($commnet_userid ,'1.5','reply_likes_web','DL');
				 } 
				
		    return response()->json(['status' => 201, 'data' =>	 'Like registered']);	
			
			}
			else
			{
			return response()->json(['status' => 201, 'data' =>	 'Already Added']);	
			}
		}
		else{
		return response()->json(['status' => 201, 'data' =>	 'You can not like your own reply']);
		}
		
	}
	
	}
	
	public function getLike(Request $request)
	{
		$comment_id = $request->id; 
		$getlikes = TblLikeComment::select('*')
									->where([
									['comment_id', '=', $comment_id],
									])->with('user')->get();
		
	return response()->json(['status' => 201, 'data' =>	 $getlikes]);	
	}
	
	
	public function getUser(Request $request)
	{ 
		$searchtext = $request->name;
		$searchtext=str_replace("@","",$searchtext);
		$searchtext=str_replace(" ","%",$searchtext);
		$total_list =  User::where([['user_name', 'LIKE', $searchtext. '%'],])->select('user_id as id','user_name as value','image')->take(30)->get();
		return response()->json(['status' => 200, 'data' =>	$total_list ]);
			
	}
	

	public function deleteAccount(Request $request)
	{ 	
	$user = auth()->user();
    $userid = $user->user_id;
	User::where([['user_id', '=', $userid ]])->update([ 'user_status' => 2]);
	return response()->json(['status' => 201, 'data' =>	'User Deleted Successfully']);
	 
	}
	
	public function userData(Request $request)
	{ 	
	$user = auth()->user();
    $userid = $user->user_id;
	$userdetail =  User::select('*')->where([['user_id', '=', $userid ]])->get();
	return response()->json(['status' => 201, 'data' =>	$userdetail]);
	 
	}
	private $x;
	public function tagList(Request $request)
	{ 	
	$searchtext = $request->keytag;
	$chatid = $request->chat_id;
	$this->x =$chatid;

	$res =  Tag::select('id','tags_name')
				->with('gettagdata',function ($query) {
				$query->select('*');
				$query->where('chat_id','=', $this->x);
                 })->where([['tags_name', 'LIKE', '%'. $searchtext. '%']])->orderBy('tags_name')->get();						
								
	return response()->json(['status' => 201, 'data' =>	$res]);

	 }
	
	public function assignTagToPost(Request $request)
	{
	 $user = auth()->user();
	 
	
		 if($user != null){
		 $tags_name =  '';
		 $chat_user_id = 0;
		 $chat_id = $request->chatId;
		 $tags_id = $request->checkedId;
		 $postdata =  TblChat::select('*')->where([['chat_id', '=', $chat_id ]])->first();
		 $chat_user_id = $postdata->chat_id;
		 $user_id = $user->user_id;
		 $clientIP = request()->ip();
		 
		$tblchat = TagComposit::where('chat_id', $chat_id)->delete();
		
		
		$res =  TagComposit::select('*')->where([['chat_id', '=', $chat_id ]])->count();

		if($res == 0){
			foreach ($tags_id as $p) {
			
			$entry = new TagComposit;  
			$entry->tags_id = $p;
			$entry->chat_id = $chat_id;
			$entry->user_id = $user_id;
			$entry->ip_address = $clientIP;
			$entry->save();
			TblChat::where([['chat_id', '=', $chat_id ]])->update(['last_taged_on' => \DB::raw('NOW()'),'chat_reply_update_time' => \DB::raw('NOW()')]);
			Tag::where([['id', '=', $p ]])->update(['lastupdatedon' => \DB::raw('NOW()')]);
			}
		
		}
		/* to update user points of  partcular chat user */
		$myRank = new RankController();
		$rankSetting = $myRank->updateUserRank($chat_user_id  ,'20','dl_taged_user','DL');		
		
		return response()->json(['status' => 201, 'data' =>	'Added']);
		}
		else
		{
		return response()->json(['status' => 201, 'data' =>	'please login']);	
		}
	}
	
	public function chatMessage(Request $request)
	{ 	
	
		$user = auth('api')->user();
		$sender_user_id = $user->user_id;
		$sender_user_name = $user->user_name;
		$sender_user_email = $user->user_email;
		//$sender_user_text_email = $user->user_text_email;
		$sender_user_rank = $user->rank;
		
		$clientIP = request()->ip();
		
		$chat_id = $request->chat_id;
		$receiver_user_id = $request->user_id;
	    $user_text_message = $request->user_text_message;
		$user_name = $request->tbox_name;
		
		$res =  User::select('user_name','user_email','mac_address','user_text_email','isvarified','istxtemailvarified')->where([['user_id', '=', $receiver_user_id ]])->first();
		
		$user_res =  User::where([['user_id', '=', $receiver_user_id ]])->count();
		
				//if($sender_user_id == 38){   echo $qry;}
		
				if($user_res > 0)
				{
				$user_name = $res->user_name;
				$user_email = $res->user_email; 
				$mac_address = $res->mac_address; 
				$user_text_email = $res->user_text_email; 
				$istxtemailvarified = $res->istxtemailvarified;
				$isvarified = $res->isvarified;
				// if($istxtemailvarified<1 and $isvarified>0 )
				// {
				// $user_text_email=$user_email;
				  
				// }
				  
				}
				
				
		   if( $istxtemailvarified == 1 or  $isvarified > 0)
		{	   
			if($sender_user_rank > 9 and  $sender_user_id > 0 )
			{ 
			
				$entry = new TextMessage;  
				$entry->sender_user_id = $sender_user_id;
				$entry->receiver_user_id = $receiver_user_id;
				$entry->user_text_email = $user_email;
				$entry->text_message = $user_text_message;
				$entry->ip_address = $clientIP;
				$entry->user_name = $user_name;
				$entry->createdon = Now();
				$entry->status = 1;
				$entry->sending_datetime = Now();
				$entry->save(); 
							
					 
		 	 //$user_res = mysql_query($qry); 
							 //Send Pushnotification.
							$pushMessages = ( strlen($user_text_message)>100?substr($user_text_message, 0,100): $user_text_message );  
                            $array = array(
                                    "serviceid" => "2",
                                    "user_id" => "$receiver_user_id", 
                                    );   
                             //SendPushNotifications($receiver_user_id , $pushMessages ,$type="DL" , $array );  */ 
                  
				  
				// $myRank = new RankController();
				// $rankSetting = $myRank->SendPushNotifications($receiver_user_id , $pushMessages ,$type="DL" , $array);
				  
				
				$myVar = new AlertController();
				$alertSetting = $myVar->emailForChat($receiver_user_id, $user_text_email , $user_text_message , $user_name , $user_email);			
				
							 
				// $redirecturl="https://www.mousewait.xyz/mousewaitnew/disneyland/myConversation?friend_user_id=".$receiver_user_id;
				
				// header("location: ".$redirecturl);
				// exit(0);
								 
							
						
				 return response()->json(['status' => 201, 'data' =>	'Your Message sent successfully. From :'.$sender_user_name]);
						 
				  
				// return Redirect::to("https://www.mousewait.xyz/mousewaitnew/disneyland/myConversation?friend_user_id=".$receiver_user_id);
				
				
			
				// $url = "https://www.mousewait.xyz/mousewaitnew/disneyland/myConversation?friend_user_id=".$receiver_user_id;
				
					
				
				// return '<script>location.replace("'.$url.'");</script>';
			
			}
			else
			{
				return response()->json(['status' => 201, 'data' =>	"You cann't send message because your rank is less then 10. Thanks"]);
				
			}
		}
		else
			{
				return response()->json(['status' => 201, 'data' =>	"You cann't send message because user not varified his text message email. Thanks"]);
				
			} 
	


	 }
	 
	public function myConversation(Request $request)
	{ 	

		$friend_user_id = $request->friend_user_id;
		$user = auth()->user();
	//dd($friend_user_id);
		
		if($user != null ){
		$auth_userid = $user->user_id;
		 $res =  TextMessage::select('*')->where
								 ([
								 ['status', '=', '1'],
								 ['receiver_user_id', '=', $auth_userid],
								 ['sender_user_id', '=', $friend_user_id],
								  ])
								  ->orWhere
								 ([
								 ['receiver_user_id', '=', $friend_user_id],
								 ['sender_user_id', '=', $auth_userid],
								  ])
							->with('user')	 
							->orderBy('createdon', 'DESC')
						   ->take(50)
	                       ->get();
		return response()->json(['status' => 201, 'data' =>	$res]);
		}
		else
		{
			//return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/login');
			return Redirect::to(env('APP_URL_NEW').'/disneyland/login');
		}
	}
	 
	public function conversationRemove(Request $request)
	{ 	
	$user = auth()->user();
    $userid = $user->user_id;
    $msg_id = $request->msg_id;
	if($user != null ){
	TextMessage::where([['id', '=', $msg_id ]])->update([ 'status' => 2]);
	return response()->json(['status' => 201, 'data' =>	'Message Deleted']);
	}
	}
	
	public function conversationReply(Request $request)
	{ 	
	
				$user = auth('api')->user();
				$sender_user_id = $user->user_id;
				$sender_user_name = $user->user_name;
				$sender_user_email = $user->user_email;
				$sender_user_rank = $user->rank;
				
				$clientIP = request()->ip();
				

				$receiver_user_id = $request->user_id;
				$user_text_message = $request->user_text_message;
				
				
				
				
				$user_right =  TblUserRight::select('*')->where
											([
											 ['rights_id', '=', 10],
											 ['user_id', '=', $sender_user_id],
											])->get();
				$check_isverifi_or_not = count($user_right);
				
				
				if($check_isverifi_or_not > 0)
				{   	 
					$isfreeze = 1; 
					 
				}
				else
				{
					$isfreeze = 0; 
				}
						
				
				
				$res =  User::select('user_name','user_email','mac_address','user_text_email','isvarified','istxtemailvarified')->where([['user_id', '=', $receiver_user_id ]])->first();
				
				$user_res =  User::where([['user_id', '=', $receiver_user_id ]])->count();
				//if($sender_user_id == 38){   echo $qry;}
		
				if($user_res > 0)
				{
				$receiver_user_name = $res->user_name;
				$receiver_user_email = $res->user_email; 
				$receiver_mac_address = $res->mac_address; 
				$receiver_user_text_email = $res->user_text_email; 
				$receiver_istxtemailvarified = $res->istxtemailvarified;
				$receiver_isvarified = $res->isvarified;  
				}
				
			   
				if($sender_user_rank > 9 and  $sender_user_id > 0 )
				{ 
				
					if ($user_text_message!='' and $isfreeze == 0 )
					{
					$entry = new TextMessage;  
					$entry->sender_user_id = $sender_user_id;
					$entry->receiver_user_id = $receiver_user_id;
					$entry->user_text_email = $receiver_user_email;
					$entry->text_message = $user_text_message;
					$entry->ip_address = $clientIP;
					$entry->user_name = $receiver_user_name;
					$entry->createdon = Now();
					$entry->status = 1;
					$entry->sending_datetime = Now();
					$entry->save(); 
								
						 
		 
			/* 		Send Pushnotification.
			        $pushMessages = ( strlen($user_text_message)>100?substr($user_text_message, 0,100): $user_text_message );  
                    $array = array(
                            "serviceid" => "0",
                            "user_id" => "$receiver_user_id",
                            "id" => "$receiver_user_id",  
                            );   
                    SendPushNotifications($receiver_user_id , $pushMessages ,$type="DL" , $array );   
					$myRank = new RankController();
					$rankSetting = $myRank->SendPushNotifications($receiver_user_id , $pushMessages ,$type="DL" , $array);
					   */
					  
					$myVar = new AlertController();
					$alertSetting = $myVar->emailForChat($receiver_user_id, $receiver_user_text_email , $user_text_message , $receiver_user_name , $receiver_user_email);			
					 
								
							
					 return response()->json(['status' => 201, 'data' =>	'Your Message sent successfully. From :'.$sender_user_name]);
							 
					}
					else
					{
					return response()->json(['status' => 201, 'data' =>	"You have no right's for reply..<br />"]);
				
					} 
			
				}
				else
				{
				return response()->json(['status' => 201, 'data' =>	"You cann't send message because your rank is less then 10. Thanks"]);
				
				}
		
	


	 }
	
	public function myConversationPost(Request $request)
	{ 	
	
				$user = auth('api')->user();
				$sender_user_id = $user->user_id;
				$sender_user_name = $user->user_name;
				$sender_user_email = $user->user_email;
				$sender_user_rank = $user->rank;
				
				$clientIP = request()->ip();
				

				$receiver_user_id = $request->user_id;
				$user_text_message = $request->user_text_message;
				
				
				$res =  User::select('user_name','user_email','mac_address','user_text_email','isvarified','istxtemailvarified')->where([['user_id', '=', $receiver_user_id ]])->first();
				
				$user_res =  User::where([['user_id', '=', $receiver_user_id ]])->count();
			
		
				if($user_res > 0)
				{
				$receiver_user_name = $res->user_name;
				$receiver_user_email = $res->user_email; 
				$receiver_mac_address = $res->mac_address; 
				$receiver_user_text_email = $res->user_text_email; 
				$receiver_istxtemailvarified = $res->istxtemailvarified;
				$receiver_isvarified = $res->isvarified;  
				}
				
				
		
			   
				if($sender_user_rank >= 25 and  $sender_user_id > 0 )
				{ 
				
					$entry = new TextMessage;  
					$entry->sender_user_id = $sender_user_id;
					$entry->receiver_user_id = $receiver_user_id;
					$entry->user_text_email = $receiver_user_email;
					$entry->text_message = $user_text_message;
					$entry->ip_address = $clientIP;
					$entry->user_name = $receiver_user_name;
					$entry->createdon = Now();
					$entry->status = 1;
					$entry->sending_datetime = Now();
					$entry->save(); 
								
					// $myVar = new AlertController();
					// $alertSetting = $myVar->emailForChat($sender_user_id, $receiver_user_text_email , $user_text_message , $receiver_user_name , $sender_user_email);			
					 
								
							
					 return response()->json(['status' => 201, 'data' =>	'Your Message sent successfully. From :'.$sender_user_name]);
							 
					
			
				}
				else
				{
				return response()->json(['status' => 201, 'data' =>	"You cann't send message because your rank is less then 25. Thanks"]);
				
				}
		
	


	 }
	 
	 
	public function advanceEditorGet(Request $request)
	{ 
		$user = auth()->user();
		$userid = $user->user_id;
		if($user != null ){	
		
		$chatid = $request->chat_id;
		// $edit_chat_msg = $request->edit_chat_msg;
		 
		$res =  TblChat::select('*')->where('chat_id','=', $chatid)->get();						
		// TblChat::where([['chat_id', '=', $chatid ]])->update(['chat_msg' => $edit_chat_msg,'chat_reply_update_time' => \DB::raw('NOW()')]);							
		return response()->json(['status' => 201, 'data' =>	$res]);
		}
	}
	
	  
	public function advanceEditorPost(Request $request)
	{ 
		$user = auth()->user();
		$userid = $user->user_id;
		if($user != null ){	
		
		$chatid = $request->chat_id;
		$edit_chat_msg = $request->edit_chat_msg;					
	    TblChat::where([['chat_id', '=', $chatid ]])->update(['chat_msg' => $edit_chat_msg,'chat_reply_update_time' => \DB::raw('NOW()')]);							
		return response()->json(['status' => 201, 'data' =>	'Post updated']);
		}
	}
	
	public function getAllUserList(Request $request)
	{ 
		$searchtext = $request->term;
		$total_list =  User::where([['user_name', 'LIKE', '%'. $searchtext. '%'],])->select('user_name')->take(30)->get();
		return response()->json(['status' => 200, 'data' =>	$total_list ]);
			
	}
	
	
	public function postBump(Request $request)
	{	
	$bump =  [];	
	$user = auth()->user();
	
	if($user != null ){	
	$userid = $user->user_id;
		if($userid == 18 || $userid == 38 || $userid == 914 || $userid == 46770  ){
		$chatid = $request->chat_id;
		$type = $request->type;
		
			if($type == 'up'){ // post will display at top
			TblChat::where([
						 ['isbump', '=', 1],
						 ['chat_id', '=', $chatid],
						 ])->update(['chat_reply_update_time' => \DB::raw('NOW()')]);
			$bump = 'Post has been bumped up';
			}
			else if($type == 'down'){ // post will display 15 posts down
			$getdata = 	TblChat::select('chat_id','chat_reply_update_time')
						 ->where([
						 ['chat_status', '=', 0],
						 ]) 
						 ->orderBy('chat_reply_update_time', 'DESC')
	                     ->skip(15)->take(15)->first();
						 
						 $chat_reply_update_time = $getdata->chat_reply_update_time;
						 
						 TblChat::where([
						 ['chat_id', '=', $chatid],
						 ])->update(['chat_reply_update_time' => $chat_reply_update_time]);
						$bump = 'Post has been bumped down';
					
						
			}
			else if($type == 'auto'){
				$getdata = 	TblChatAutoBump::select('id','chat_id','park','status','createdon')
						 ->where([
						 ['chat_id', '=', $chatid],
						 ]) 
						 ->get();
						 
				TblChat::where([
						 ['isbump', '=', 1],
						 ['chat_id', '=', $chatid],
						 ])->update(['chat_reply_update_time' => \DB::raw('NOW()')]);
				 
				$getcount  = count($getdata);
				
				if($getcount == 0)
					{
						$entry = new TblChatAutoBump;  
						$entry->chat_id = $chatid;
						$entry->park = 'DL';
						$entry->status = 1;
						$entry->createdon = NOW();
						$entry->save(); 
						 
						return response()->json(['status' => 200, 'data' =>	"Added Successfully." ]);
						
					}
					else
					{
						return response()->json(['status' => 200, 'data' =>	"Already added." ]);
					
					}
			}
			else if($type == 'never'){ // post will never bump like up and down
					TblChat::where([
						 ['chat_id', '=', $chatid],
						 ])->update(['isbump' => 0]);
			$bump = "It's Marked as Never bump.";	
		
			}
		return response()->json(['status' => 200, 'data' =>	$bump ]);
		  		
		}
		else
		{
		return response()->json(['status' => 200, 'data' =>	$bump ]);
		}
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$bump ]);	
	}
	    


	return response()->json(['status' => 201, 'data' =>	$bump ]);
	 

	}
	
	public function postLock(Request $request)
	{	
	$lock =  [];	
	$user = auth()->user();
	
	if($user != null ){	
	$userid = $user->user_id;

		$chatid = $request->chat_id;
		$type = $request->type;
		
		if($type == 'Lock')
		{
		$type = 1;
		}
		else
		{
		$type = 0;	
		}
		
		TblChat::where([['chat_id', '=', $chatid]])->update(['islock' => $type]);
			   
		$getdata = 	TblChat::select('*')->where([['chat_id', '=', $chatid]])->first();
		
			if($getdata->islock == 0)
			{
		    $lock = 'Post Unlocked';		
			}
			else
			{
			$lock = 'Post Locked';		
			}
		
		return response()->json(['status' => 200, 'data' =>	$lock ]);
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$lock ]);	
	}
	 

	}
	
	
	public function removePostImage(Request $request)
	{	
	$lock =  [];	
	$user = auth()->user();
	
	if($user != null ){	
	$chatid = $request->chat_id;
	TblChat::where([['chat_id', '=', $chatid]])->update(['chat_img' => '']);
	$app = realpath(__DIR__ . '/../../../..');
    $upload_img_dir = $app . '/disneyland/chat_images/';
	$file = $upload_img_dir.'/'.$chatid.'_c_img.jpg'; 
	unlink($file);
	$lock = 'Post image removed';
	return response()->json(['status' => 200, 'data' =>	$lock ]);
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$lock ]);	
	}
	 

	}
	
	public function movePost(Request $request)
	{	
	$move =  [];	
	$user = auth()->user();
	
	if($user != null ){
	$userid = $user->user_id;		
	$chatid = $request->chat_id;
	$chat_room_id = $request->roomid;
	
		if($chat_room_id==0)
		{
			$showonmain=0;
		}
		else
		{
			$showonmain= '( select showonmain from  tbl_chat_rooms where  id='.$chat_room_id.' limit 1) ' ;
		}
		
				TblChat::where([['chat_id', '=', $chatid]])
				->update(['chat_reply_update_time' => NOW(),'chat_room_id' => $chat_room_id,'showonmain' => $showonmain]);
		
		
		if($userid !='')
			{	
				$comments = '';
				
				if($chat_room_id > 0 )
				{
					$chatroom_query = 	TblChatRoom::select('chat_room')->where([['id', '=', $chat_room_id]])->first();
					$chat_room = $chatroom_query->chat_room; 
				
				}
				else
				{
					$chat_room = 'The Hub ';
				}
	//dd('https://mousewait.xyz/mousewaitnew/disneyland/lands/'.$chat_room_id.'/'.str_replace(" ","-",$chat_room).'/');
				$comments = 'This post has been moved to '.$chat_room; 
		
				TblChat::where([['chat_id', '=', $chatid]])
				->update(['comments' => $comments]);
						
				$entry = new Comment;  
				$entry->chat_id = $chatid;
				$entry->reply_user_id = '122974';
				$entry->chat_reply_msg = $comments;
				$entry->chat_room_id = $chat_room_id;
				$entry->ip_address = $_SERVER['REMOTE_ADDR'];
				$entry->showonmain = $showonmain;
				$entry->comment_updatedon = NOW();
				$entry->save(); 
				  // return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/mystore');
			// return \Redirect::to('https://bla.com/?yken=KuQxIVTNRctA69VAL6lYMRo0');
				// return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/lands/'.$chat_room_id.'/'.str_replace(" ","-",$chat_room).'/');
				// return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/lands/'.$chat_room_id.'/'.str_replace(" ","-",$chat_room).'/');
				// "<script>
				// window.location.replace('https://mousewait.xyz/mousewaitnew/disneyland/lands/'.$chat_room_id.'/'.str_replace(" ","-",$chat_room).'/');
				// </script>";
		
			return response()->json(['status' => 200, 'data' =>	str_replace(" ","-",$chat_room) ]);	
			}
		
		// return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/lands/'.$chat_room_id.'/'.str_replace(" ","-",$chat_room).'/');
	return response()->json(['status' => 200, 'data' =>	$move ]);
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$move ]);	
	}
	 

	}
	
	public function postStickOrUnstick(Request $request)
	{	
	$result =  [];	
	$user = auth()->user();
	
	if($user != null ){	
	$userid = $user->user_id;
		if($userid == 18 || $userid == 38 || $userid == 914 || $userid == 46770  ){
		$chatid = $request->chat_id;
		$type = $request->type;
		
			if($type == 'Stick'){ 
			TblChatSticky::where([['id', '=', 1]])->update(['chat_id' => $chatid]);
			$result = 'Post Stick';
			}
			else if($type == 'UnStick'){ 
			TblChatSticky::where([['id', '=', 1]])->update(['chat_id' => 0]);
			$result = 'Post UnStick';
			}
			
			return response()->json(['status' => 200, 'data' =>	$result ]);
		  		
		}
		
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$result ]);	
	}
	    
	}
	
	public function rightBar(Request $request)
	{
	// for tag 		
	$tagsdata =  Tag::select('tags_name','id')->get();
	// for best of the day
	$d_startdate = date('Y-m-d',strtotime("-1 days")); //date('Y-m-d'); 
	$d_enddate =  date('Y-m-d');
	$bestoftheday = [];		
	$bestoftheday = 	TblChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
						->with('user',function ($query) {$query->where('user_status','=','1');})
						// ->withCount('comments as commentcount')
						->where('chat_status','=','0')
						//->whereDate('chat_time', Carbon::today())
						->havingRaw('chat_total_thank_and_like > 0')
						->whereBetween('chat_time', [$d_startdate, $d_enddate])
						->whereNotIn('chat_id',[329864, 402398])
						->orderBy('chat_total_thank_and_like', 'DESC')
						->take(10)
						->get();
						
	// for best of the week
	$dayofweek = date('w',  strtotime("-0 HOUR"));
	$weekend = (6-$dayofweek) ;
	$w_startdate = date('Y-m-d', strtotime("-$dayofweek day") );
	$w_enddate =   date('Y-m-d', strtotime("+$weekend day") );
	$bestoftheweek = [];		
	$bestoftheweek = 	TblChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
						->with('user',function ($query) {$query->where('user_status','=','1');})
						// ->withCount('comments as commentcount')
						->where('chat_status','=','0')
						//->whereDate('chat_time', Carbon::today())
						->havingRaw('chat_total_thank_and_like > 0')
						->whereBetween('chat_time', [$w_startdate, $w_enddate])
						->whereNotIn('chat_id',[329864, 402398])
						->whereNotIn('chat_room_id',[139,140,141])
						->orderBy('chat_total_thank_and_like', 'DESC')
						->take(5)
						->get();
						
	// for best of the week
	$dayofweek = date('w',  strtotime("-0 HOUR"));
	$weekend = (6-$dayofweek) ;
	$m_startdate = date('Y-m-d', strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	$m_enddate =   date('Y-m-d', strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')))); 
	$bestofthemonth = [];		
	$bestofthemonth = 	TblChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
						->with('user',function ($query) {$query->where('user_status','=','1');})
						// ->withCount('comments as commentcount')
						->where('chat_status','=','0')
						//->whereDate('chat_time', Carbon::today())
						->havingRaw('chat_total_thank_and_like > 0')
						->whereBetween('chat_time', [$m_startdate, $m_enddate])
						->whereNotIn('chat_id',[329864, 402398])
						->whereNotIn('chat_room_id',[139,140,141])
						->orderBy('chat_total_thank_and_like', 'DESC')
						->take(5)
						->get();
						
						
	$banner = [];		
	$banner = 	TblBanner::select('*')
						->where('type','=','HR')
						->orderBy('order_no', 'ASC')
						->get();	


	$topmw = [];		
	$topmw = 	TblTopUserLeaderBoard::select('*')
						->where('default_park','=','DL')
						->orderBy('counter', 'ASC')
						->take(10)
						->get();
						
						
						
	
	
	$result = array([
					'tagdata' => $tagsdata,
				    'bestoftheday' => $bestoftheday,
				    'bestoftheweek' => $bestoftheweek,
				    'bestofthemonth' => $bestofthemonth,
				    'banner' => $banner,
				    'topmw' => $topmw,
					]);
	
	
	return response()->json(['status' => 200, 'data' =>	$result ]);
	
	    
	}
	
	public function topMwByQualityPost(Request $request)
	{
	
	$result = 	User::select('quality_rank as pos','rank','position','user_id','user_name','image','default_park',	'user_status',DB::raw('(likes_points + thanks_points) as total_likes_points'),DB::raw('round((((likes_points + thanks_points) /300)*10)) as net_total_likes_points'))
							->where([
							['user_status', '=', '1'],
							['user_id', '!=', '18'],
							['default_park', '=', 'DL'],])
							->orderBy('total_likes_points', 'DESC')
							->take(100)
							->get();
	return response()->json(['status' => 200, 'data' =>	$result ]);
	
	    
	}
	
	
	public function topMousewaiter(Request $request)
	{
	$type = $request->type;
	$result = [];
	if($type =='TR') //Top Ranks
	{
	$result = 	User::select('totalpoints','rank','user_id','user_name','image','default_park',	'user_status')
				->where([
				['user_status', '=', '1'],
				['user_id', '!=', '18'],
				['default_park', '=', 'DL'],])
				->orderBy('totalpoints', 'DESC')
				->take(100)
				->get();
	}
	else if($type =='MR') //Monthly Rank
	{
/* 	$result = 	TblTopUserLeaderBoard::select('counter as  counter','weekly_rank as rank','user_id','default_park') 
					->with('user',function ($query) {
							$query->select('user_id','user_name','image','totalpoints as overallpoints','position','rank as overallrank');})
					->where([
					['default_park', '=', 'MR'],])
					->orderBy('counter', 'ASC')
					->take(100)
					->get(); */	
					
					 $qry = " SELECT lb.`counter` as  counter  ,lb.`weekly_rank` as rank ,lb.`user_id`,     
					urs.user_name,urs.image, urs.totalpoints as overallpoints  , urs.position  , urs.rank as overallrank  FROM `tbl_top_user_leaderboard` as lb INNER JOIN tbl_user urs ON (lb.user_id = urs.user_id) WHERE  lb.`default_park` = 'MR' order by `counter` asc  limit 0 ,100 "; 
					
					$result = DB::select($qry);
	}
	else if($type =='MWR') //Monthly Rank
	{
		/* $result = 	TblTopUserLeaderBoard::select('*')
					->with('user',function ($query) {
							$query->select('user_id','user_name','image','totalpoints as overallpoints','position','rank as overallrank');})
				->where([
				['default_park', '=', 'MWR'],])
				->orderBy('counter', 'ASC')
				->take(100)
				->get(); */	
				
						 $qry = " SELECT lb.`counter` as  counter  ,lb.`weekly_rank` as rank ,lb.`user_id`,     
					urs.user_name,urs.image, urs.totalpoints as overallpoints  ,  urs.position  , urs.rank as overallrank  FROM `tbl_top_user_leaderboard` as lb INNER JOIN tbl_user urs ON (lb.user_id = urs.user_id) WHERE  lb.`default_park` = 'MWR'  order by `counter` asc  limit 0 ,100 "; 
					$result = DB::select($qry);
	}
	
	
	return response()->json(['status' => 200, 'data' =>	$result ]);
	
	    
	}
	
	public function topNewsFeatured(Request $request)
	{
	$result = 	User::select('totalpoints','rank','user_id','user_name','image','no_of_posts_news','user_status')
						->where([
						['user_status', '=', '1'],
						['no_of_posts_news', '>', '0'],
						['user_id', '!=', '18'],])
						->orderBy('no_of_posts_news', 'DESC')
						->take(50)
						->get();


	return response()->json(['status' => 200, 'data' =>	$result ]);
	
	    
	}
	
	 public function suscribeOrUnsuscribePost(Request $request) // from user profile page in old mousewait.com mw page
	{
			$user = auth()->user();
			if($user != null ){
			$auth_userid = $user->user_id;
			$auth_username = $user->user_name;
			$auth_isverfied = $user->isvarified;
			
			$friend_userid = $request->friendId;
			$friend_username = $request->friendName;
			$type = $request->suscribeUnsuscribe;
			
			if($auth_isverfied == 0)
			 {			 
				return response()->json(['status' => 201, 'data' =>	'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify (and earn MouseRank points for verifying!' ]);
			 }
			
			else
			{  
			  if($type == 0){
			  	$sql_check =  TblUserSuscribeViaEmail::select('*')
							->where([
							['user_id', '=', $friend_userid],
							['subscriber_user_id', '=', $auth_userid ],])->get();
				
				  $norwos = count($sql_check);
				  
					if($norwos == 0)
					  {	 						
							$entry = new TblUserSuscribeViaEmail;  
							$entry->user_id = $friend_userid;
							$entry->user_name = $friend_username;
							$entry->subscriber_user_id = $auth_userid;
							$entry->subscriber_user_name = $auth_username;
							$entry->status = 1;
							$entry->save();
						
						 	return response()->json(['status' => 201, 'data' =>	'Successfully Subscribed.' ]);
					  }
					  else
					  {
						return response()->json(['status' => 201, 'data' =>	'Already Added ' ]);
					  } 
				 	
			  }	 
			  else if($type == 1)
			  {
				TblUserSuscribeViaEmail::where([['user_id', '=', $friend_userid],['subscriber_user_id', '=', $auth_userid ],])->delete(); 
			return response()->json(['status' => 201, 'data' =>	'Subscribed Removed.' ]);				
			  }
			}
			
			}
			
	    
	}
	 
	
	public function postSuscribeUnsuscribe(Request $request) // from toggle menu
	{
			$user = auth()->user();
			if($user != null ){
			$auth_userid = $user->user_id;
			$auth_username = $user->user_name;
			$auth_isverfied = $user->isvarified;
			
			$chatid = $request->chat_id;
		
			$type = $request->suscribeUnsuscribe;
			
			if($auth_isverfied == 0)
			 {			 
				return response()->json(['status' => 201, 'data' =>	'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify (and earn MouseRank points for verifying!' ]);
			 }
			
			else
			{  
			  if($type == true){
			  	$sql_check =  TblChatSuscriber::select('*')
							->where([
							['user_id', '=', $auth_userid],
							['chat_id', '=', $chatid ],])->get();
				
				  $norwos = count($sql_check);
				  
					if($norwos == 0)
					  {
						 	$check_room =  TblChat::select('chat_id','chat_room_id')
							->where([['chat_id', '=', $chatid ],])->first();
							
							$chat_room_id = $check_room->chat_room_id;
							
							 if($chat_room_id == 139 or $chat_room_id == 140  or $chat_room_id == 141 )
							 {
								$entry = new TblPrivateChatSuscriber;  
								$entry->chat_id = $chatid;
								$entry->user_id = $auth_userid;
								$entry->user_name = $auth_username;
								$entry->chat_room_id = $chat_room_id;
								$entry->save(); 
							 }
							 else
							 {
								$entry = new TblChatSuscriber;  
								$entry->chat_id = $chatid;
								$entry->user_id = $auth_userid;
								$entry->user_name = $auth_username;
								$entry->save(); 
								
						/* 		$lastinsertedid = $entry->id;
								$entrynew = new TblUserSuscribeViaEmail;  
								$entrynew->id = $lastinsertedid;
								$entrynew->user_id = '18';
								$entrynew->user_name = 'Admin';
								$entrynew->subscriber_user_id = $auth_userid;
								$entrynew->subscriber_user_name = $auth_username;
								$entrynew->status = 1;
								$entrynew->save(); */
					 
							 }
						  
							
						
						 	return response()->json(['status' => 201, 'data' =>	'You have subscribed to this post, watch your email for notifications and make sure you have added info@mousewait.com to your contacts list, thanks!' ]);
					  }
					  else
					  {
						return response()->json(['status' => 201, 'data' =>	'Already Added ' ]);
					  } 
				 	
			  }	 
			  elseif($type == false)
			  {
				TblChatSuscriber::where([['user_id', '=', $auth_userid],['chat_id', '=', $chatid ],])->delete(); 
				return response()->json(['status' => 201, 'data' =>	'Removed' ]);				
			  }
			}
			
			}
			
	    
	}
	
	
	public function PostLiveApi(Request $request) // from toggle menu
	{
		// User data to send using HTTP POST method in curl
$data = array('id'=>'03','msg'=>'best things to do at disneyland?');

// Data should be passed as json format
$data_json = json_encode($data);

// API URL to send data
$url = 'https://loungeland.org/ProcessChat';

// curl initiate
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// SET Method as a POST
curl_setopt($ch, CURLOPT_POST, 1);

// Pass user data in POST command
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute curl and assign returned data
$response  = curl_exec($ch);

// Close curl
curl_close($ch);

// See response if data is posted successfully or any error
print_r ($response);	
	    
	}
	
 	

	
	
	
}


	


// DB::raw('("conversion") as type')
    // DB::raw('("") as iscommnt')
	//REGEXP_SUBSTR(column_name, 'https?:\/\/.*?(?=\s)') AS url
	