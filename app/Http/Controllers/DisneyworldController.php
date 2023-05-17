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
use App\WdwChatReplyReply;
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
use App\WdwChatBlock;
use App\WdwChatBlockDetail;
use App\TblBanUser;
use App\TblChatSuscriber;
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
use App\WdwChatRoom;
use App\WdwLike;
use App\WdwThankYou;
use App\WdwTblThankYouEmail;
use App\WdwChatAutoBump;
use App\TblChatSticky;
use App\WdwReport;
use App\TblBanner;
use App\TblTopUserLeaderBoard;
use App\WdwTblLikeComment;
use App\WdwTblLikeReply;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\RankController;
use App\Http\Controllers\Common\CommonController;


class DisneyworldController extends Controller
{
	
    //disneyworld home page api
	public function disneyworldHome(Request $request)
	{  

	 
	$searchtext = $request->chat_msg;	
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
    // dd($chat_room_id);
	if($chat_room_id == null){
		$chat_room_id = 0;
	}
   
	$user = auth()->user();
	$get_block_chat_by_userid = [];
	$deleted_chat_id = array();
	
	if($user != null ){
	$user_id = $user->user_id;
	$get_block_chat_by_userid =  WdwChatBlock::where
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
	    
	}

	
	
			
		 	if($chat_room_id == null)
			{
			$total_list =  WdwChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							 ['chat_room_id', '=', 1],
							])
							->
							orWhere([
						    ['chat_room_id', '=', 2],
						    ])
						    
						
	                      ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                        ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
						     ->with('checksticky')
	                     	->whereNotIn('chat_id',$deleted_chat_id)
						   ->orderBy($time, 'DESC')
	                       ->paginate(150);
	                       //->get();	
			}
			
			
			else if($chat_room_id == 2)
			{
				$total_list =  WdwChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['chat_room_id', '=', 2],
							])
						    
					
	                      ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                        ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
						     ->with('checksticky')
	                     	->whereNotIn('chat_id',$deleted_chat_id)
						   ->orderBy($time, 'DESC')
	                       ->paginate(50);
	                       //->get();
			} 
			
			else
			{
			$total_list =  WdwChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							])
						    
	                      ->select('chat_id','chat_status','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','mapping_url','chat_reply_update_time','islock')
						    ->with('chatroom')
						   ->with('user')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	                        ->with('tagcomposit.gettagged')
	                        ->with('isbookmark')
	                       ->with('isthankyou')
						     ->with('checksticky')
	                     	->whereNotIn('chat_id',$deleted_chat_id)
						   ->orderBy($time, 'DESC')
	                       ->paginate(50);
	                       //->get();	
			}
						
	
			return response()->json([ 'status' => 201,'data' => $total_list->toArray(),], 201);
	
	
	}
	
	public function hash(Request $request)
	{  

	/* for search */
	$searchtext = $request->hash;	
    $searchtext ='#'.str_replace("-"," ","$searchtext");
  

    // $gettagid =  Tag::where([['tags_name', '=', $tags_name_url],])->select('id')->first();
    // $id = $gettagid->id;

  
	$total_list =  WdwChat::where([
							['chat_status', '=', '0'],
							['chat_msg', 'LIKE', '%'. $searchtext. '%'],
							['mapping_url', '!=', ''],
							
							])
				        
						  // ->whereHas('tagcomposit',  function ($q) use ($id) {
        //                     $q->where('tags_id', $id);
        //                     })
							
	                       ->select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','mapping_url','chat_reply_update_time')
	                     
                            ->with('tagcomposit.gettagged')
						    ->with('chatroom')
						   ->with('user')
						   ->with('topimages')
	                       ->withCount('comments as commentcount')
	        
	                       ->orderBy('chat_time', 'DESC')
	                       ->take(50)
	                       ->get();
	
   
		
			return response()->json([
                'status' => 201,
                'data' => $total_list->toArray(),
                 ], 201);

	}
	
	
	public function sticky(Request $request)
	{  
	$user = auth()->user();

	$get_stick_chat_data =  TblChatSticky::where([['id', '=', 2],['park', '=', 'WDW'],])->select('chat_id')->first();
	
	$stick_chatid	 = $get_stick_chat_data->chat_id;
	
	$total_list = '';
	
	$total_list =  WdwChat::where([['chat_id', '=', $stick_chatid]])
						    
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
	                       // ->with('subscribepost')
	                       ->get();
	
			return response()->json([
                'status' => 201,
                'data' => $total_list,
                 ], 201);
	
	
	}
	
	//disneyworld detail page api
	public function disneyworldPostDetail(Request $request)
	{  

	$chatid = $request->id;
	$postdetail =  WdwChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes')
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
	
	function upload_file($url, $type = 1, $path)
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
	
	public function postWdwLounge(Request $request)
    {             	
	
	$img_up =false ;
	$msg = "Sorry it's not Done.";
	$submit_post = 1 ;
	$isvarified = 0; 
	$iswebcast = 0;
	$ispress = 0; 
	$iseventplanning = 0;
	$iswaittime = 0;
	$ismovepost = 0;
	$istagging = 0; 
	$isfreeze = 0;   
	$p_user_id = 0;
	$username =  '';
	$email = '';
	$mac_add = '';
	$message = '';
	$chat_video = '';
	$rid = 0;
 	$p_isimage = 0;      
    $showonmain=0;        
			  
			  $user = auth()->user();
              $userid = $user->user_id;
              $username = $user->user_name;
                $auth_isverfied = $user->isvarified;
				if($auth_isverfied == 0)
				{			  
					return response()->json(['status' => 201, 'data' =>array('message'=>'Please check your email and hit the verification link, then you’ll be able to post. Check your spam folder if you don’t see it. Thanks!') ]);
				} else {
              $user_status = $user->user_status;
			  
			  $mac_add = $request->mac_add;
			  $message = $request->chat_msg;
			  $rid = $request->chat_room_id; //chat_room_id
			 
			  $ip_address = $_SERVER['REMOTE_ADDR'];
          
		  
		  
		  /*     $auth_isverfied = $user->isvarified;
				if($auth_isverfied == 0)
				{			  
					return response()->json(['status' => 201, 'data' =>array('message'=>'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify after you can make a post and comment') ]);
				}
				
				else
				{
				} */	


					/* 	$res_room = WdwChatRoom::select('showonmain')->where('id',$rid)->first();				
						
						
						if($res_room == null)
						{
						$showonmain=0;	
						}
						else
						{
						$showonmain	  = $res_room->showonmain;	
						} */
						
						$rights = TblUserRight::select('rights_id')->where('user_id',$userid)->get();	
						$rigthcount = count($rights);
						if($rigthcount > 0)
						{
							foreach($rights as $row)
							{
								$rightdata = $row->rights_id;
									 switch ($rightdata ) 
									{
										case '1': 
										   $iswebcast = 1; 
											break;
										case '2': 
											$isprivate_room = 1;
											$ispress = 1; 
											break; 
										case '3': 
										   $isprivate = 1;
											break; 
										case '4': 
										   $iseventplanning = 1; 
											break; 
										case '10': 
										   $isfreeze = 1; 
											break;					 
										  
									}  
								
							}
						}
						
						
					
						
						if($isfreeze == 1)
						{
						return response()->json(['status' => 201, 'data' =>array('error'=>'Inactive User') ]); 		   
						}
					
						
	
							
							$app = realpath(__DIR__ . '/../../../..');
                            $upload_img_dir = $app . '/disneyworld/chat_images/';
							$upload_img_dir_thumb = $app . '/disneyworld/chat_images_thumbnail/';
							$upload_img_dir_medium = $app . '/disneyworld/chat_images_medium/';
                        
                            $lastid = WdwChat::select('chat_id')->orderBy('chat_id','DESC')->first();
                            $lastinsertedid = $lastid->chat_id;
                            
                            $id=DB::select("SHOW TABLE STATUS LIKE 'wdw_chat'");
                            $next_id=$id[0]->Auto_increment;
                            
                            
                        
						
                        
                            
                            if($user_status == 1 && $message !='' && $userid >0){ 
							
							$entry = new WdwChat;  
                            $entry->user_id = $userid;
                            $entry->chat_msg = $message;
							$entry->chat_reply_update_time = NOW();
                            $entry->chat_room_id=$request['chat_room_id'];
							$entry->showonmain = $showonmain;
                            $titlestring = str_replace(" ", "-", $message);
							$small = substr($titlestring, 0, 20);
                            $entry->mapping_url = $next_id.'/'.$small;
                            $entry->chat_video = '';
                            $entry->chat_img = '';
							$entry->mac_address = '';
                            $entry->posted_from = '';
                            $entry->chat_status = 0;
                            
                            $entry->chat_time = NOW();
                            $entry->ip_address = $ip_address;
                            $entry->save();
                            
                            $last_inserted_id = $entry->id;
                            
                       
							
							User::where('user_id', $userid)->update(['no_of_posts' => \DB::raw('no_of_posts + 1'),'ip_address' => $ip_address ]);
							
							/* to update user points on comment partcular chat incresase login user point */
							$myRank = new RankController();
							$rankSetting = $myRank->updateUserRank($userid ,'0.5','apps_post','DL');
                            
                          /*   if ($request['chat_img']) {

                              $file = ''.$last_inserted_id.'_c_img.jpg'; //c stand for Chat image
                              $uploadfile = $upload_img_dir . $file;
                              $path =$upload_img_dir . $file;
                              $uploaddir = "/public_html/disneyworld/chat_images/";

								if($this->upload_file($request['chat_img'],'1',$uploadfile)){
                            
                        
                    
                            WdwChat::where('chat_id', $last_inserted_id)->update(['chat_img' => $file]);
                                return response()->json(['status' => 201, 'data' =>    array('error'=>'in base65') ]);
							}
                            
                        
							else
							{
                            return response()->json(['status' => 201, 'data' =>    array('sucess'=>'Invalid file format') ]);
                            }
                            
                            } */
							
							
							if ($request['chat_img']) {

							 $file = ''.$last_inserted_id.'_c_img.jpg';
							$uploadfile = $upload_img_dir . $file;
							$uploadfilecopy = $upload_img_dir_thumb . $file;
							$uploadfilemedium = $upload_img_dir_medium . $file;
								
							$image_parts = explode(";base64,", $request['chat_img']);
							$image_type_aux = explode("image/", $image_parts[0]);
							$image_type = $image_type_aux[1];
							$image_base64 = base64_decode($image_parts[1]);


							$fname = filter_input(INPUT_POST, "name");
							$encodedImage = filter_input(INPUT_POST, "image");
							$encodedImage = str_replace('data:image/png;base64,', '', $encodedImage);
							$encodedImage = str_replace(' ', '+', $encodedImage);
							$encodedImage = base64_decode($encodedImage);
								
							if(file_put_contents($uploadfile, $image_base64)) {
								/*  OHakDFltn0morEP8s1G4 */
						 	ShortPixel\setKey("VkmJFa5o0QPqcvhFw50D");
							ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
							\File::copy($uploadfile,$uploadfilecopy);
							\File::copy($uploadfile,$uploadfilemedium);
							
							WdwChat::where('chat_id', $last_inserted_id)->update(['chat_img' => $file]);
                            
							// return response()->json(['status' => 201, 'data' =>	'Success' ]);
							}
							
							}
                            
                       
							
                            
                            return response()->json(['status' => 201, 'data' =>    array('sucess'=>'Lounge Post Submit') ]);
                            }
							else
							{
                             return response()->json(['status' => 201, 'data' =>array('error'=>'Lounge Post Did not Submit') ]);  
                            }

				
						
				}        
    

    }
	
	public function myposts(Request $request)
	{ 
	  
	$userid = $request->user_id;
	
	
	$user = auth()->user();
	$get_block_chat_by_userid = [];
	$deleted_chat_id = array();
	
	$get_block_chat_by_userid_two = [];
	$deleted_chat_id_two = array();
	
	if($user != null ){
	$user_id = $user->user_id;
	$get_block_chat_by_userid =  WdwChatBlock::where
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

		
		$get_block_chat_by_userid_two =  WdwChatBlockDetail::where
											([
											 ['user_id', '=', $user_id],
											 ['status', '=', '1'],
											 ['ban_chat_id', '!=', 'null'],
											 ])
											 ->select('ban_chat_id')->get();
	   
		
		foreach($get_block_chat_by_userid_two as $row)
		{
			$deleted_chat_id_two[] = $row['ban_chat_id'];
			
		}	
		
	    
	}
	$userdata = User::where('user_id',$userid)->select('user_id','user_name','user_email','image','rank','position','totalpoints','user_status','creation_date as member_since','default_park as overall_rank')->first();
	$postdata = WdwChat::where('user_id',$userid)
						->select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','mapping_url','islock')
	                    ->with('chatroom')
						->with('topimages')
						->with('isbookmark')
	                    ->with('isthankyou')
	                    ->with('checksticky')
	                    ->withCount('comments as commentcount')
						->whereNotIn('chat_id',$deleted_chat_id)
						->whereNotIn('chat_id',$deleted_chat_id_two)
						->orderBy('chat_id', 'DESC')
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
	
	public function bookMark(Request $request)
	{ 
	$user = auth()->user();
	if($user != null ){
	$userid = $user->user_id;
	$username = $user->user_name;
	$chatdata = WdwChat::where('chat_id',$request['chat_id'])->with('user')->select('chat_id','user_id')->first();
	$chat_user_name = $chatdata['user']['user_name'];
	$chatuserid = $chatdata['user_id'];
	
	// if($chatuserid != $userid)
	// {
	

	$isNotExist = WdwLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->count();
	if($isNotExist == 0)
	{
	/* to save in tbl_like on  bookmark  on partcular chat */	
	$entry = new WdwLike;  
	$clientIP = request()->ip();
	$entry->chat_id = $request['chat_id'];
	$entry->user_id = $userid;
	$entry->user_name = $username;
	$entry->ip_address = $clientIP;
	$entry->save();
	
	$reff_id = $entry->id;// to get last inserted id from bookmark
	

	/* to update like's count on bookmark  on partcular  chat */	
	WdwChat::where('chat_id', $request['chat_id'])->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
	
	


	
	if($userid != $chatuserid){
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'6','web_dl_likes','WDW',$userid, $clientIP);
	}
		
	$bookmarkdata = array(['message' => "Added"]);
	}
	else
	{
	
	// $isExist = WdwLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->firstOrFail();
	// $isExist->delete();
	
	$isExist = WdwLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->first();
	$clientIP = request()->ip();
	
	if($isExist['status'] == 1)
	{
	WdwLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '0','ip_address' => $clientIP]);	
	
	WdwChat::where('chat_id', $request['chat_id'])->update(['no_of_likes' => \DB::raw('no_of_likes - 1')]);
	if($userid != $chatuserid){
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'-6','web_dl_likes','WDW',$userid, $clientIP);
	}
	$bookmarkdata = array(['message' => "Removed"]);
	}
	else
	{
	WdwLike::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '1','ip_address' => $clientIP]);	
	
	WdwChat::where('chat_id', $request['chat_id'])->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
	if($userid != $chatuserid){
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'6','web_dl_likes','WDW',$userid, $clientIP);	
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
	
	public function postComment(Request $request)
	{ 						
							$user = auth()->user();
							$userid = $user->user_id;
							$user_name = $user->user_name;
						
						/* 	$auth_isverfied = $user->isvarified;
							if($auth_isverfied == 0)
							{			  
								return response()->json(['status' => 201, 'data' =>array('error'=>'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify after you can make a post and comment') ]);
							}
							
							else
							{ 
							} */
							
							
					
							
							
		   
// $htmlEle = "<html><body><p data-name='call'>This is ItSolutionStuff.com Example 1</p><p data-name='call2'>This is ItSolutionStuff.com Example 1</p></body></html>";
  

  $domdoc = new \DOMDocument();
$domdoc->loadHTML($request['chat_msg']);
$xpath = new \DOMXpath($domdoc);
  
$query = "//span[@data-id]";
$entries = $xpath->query($query);
  $totag = $entries['DOMNodeList'];
						
						
							if($request['chat_msg'] !='' && $request['chat_id'] !='' && $userid >0 &&  $request['chat_msg'] != 'Add your thoughts')
							{
							$chatroom = WdwChat::where('chat_id',$request['chat_id'])->select('chat_room_id','islock')->first();
							$chat_room_id = $chatroom->chat_room_id;
							$chat_islock = $chatroom->islock;
							$clientIP = request()->ip();
							
							if($chat_islock == 0)
							{
							
						
							
								
							$entry = new WdwChatReply;  
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
							 
							
							WdwChat::where([['chat_id', '=', $request['chat_id']],['isbump', '=', '1'],])->update(['chat_reply_update_time' => NOW() ]);
							
							User::where('user_id', $userid)->update(['no_of_comments' => \DB::raw('no_of_comments + 1'),'ip_address' => $clientIP ]);
							
							/* to update user points on comment partcular chat incresase login user point */
							$myRank = new RankController();
							$rankSetting = $myRank->updateUserRank($userid ,'0.2','dl_room_comments','WDW');
							
							
					
							/* send mail to tag user in a commnet box  */
						/* old version m disneyworld se mail m user ko tag karne per mail nahi ja raha so comment this */
							/* if($totag != null){
							
							 foreach ($entries as $p) {
							 $hdd_user_id =  $p->getAttribute('data-id');
							 $tagentry = new TaggedUser;  
							 $tagentry->user_id = $userid;
							 $tagentry->taged_user_id = $hdd_user_id;
							 $tagentry->chat_id = $request['chat_id'];
							 $tagentry->comment_message = $request['chat_msg'];
							 $tagentry->comment_id = $lastinserid;
							 $tagentry->taged_type = 'CR';
							 $tagentry->save();
							 $myVar = new AlertController();
							 $alertSetting = $myVar->mailTagUserWdw($hdd_user_id ,$user_name,$request['chat_msg'],$request['chat_id']);
							}
							
							} */

							/* send mail to tag user in a commnet box */
							
							/* send mail to owner of the post if any user commnet on his post  */
							$res = WdwChat::where('chat_id',$request['chat_id'])->select('user_id','chat_id')->first();
							
							$post_owner_id = $res->user_id;
						
							if($post_owner_id != $userid){
								
							 $myVar = new AlertController();
							 $alertSetting = $myVar->mailToPostOwnerWdw($post_owner_id,$user_name,$request['chat_msg'],$request['chat_id']);
						
							
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
						
							
							
						   $commentdata=	WdwChatReply::where('chat_id', '=', $request['chat_id'])->with(['commentuser','commentsreply'])->orderBy('chat_reply_date', 'DESC')->get();
							
							

							
							
							return response()->json(['status' => 201, 'data' =>	array('success'=>'Comment Submit','chat_reply_id'=>$entry->id,'commentdata'=>$commentdata) ]);
							}
							else
							{
							   
							return response()->json(['status' => 200, 'data' =>	array('error'=>'Post is Locked by admin','chat_reply_id'=>0) ]);
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
	/* 	$auth_isverfied = $user->isvarified;
		if($auth_isverfied == 0)
		{			  
			return response()->json(['status' => 201, 'data' =>array('error'=>'Your email has not been verified yet. Go to your Profile, then click on the Verify Email link to verify after you can make a post and comment') ]);
		}
		
		else
		{
		} */
		$chatid = $request['chat_id'];
        $message = $request['chat_reply_msg'];
        $commented_id = $request['chat_reply_id'];
		$clientIP = request()->ip();
	
		
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
	
	
	
		$chatroom = WdwChat::where('chat_id',$chatid)->select('islock')->first();
		$chat_islock = $chatroom->islock;
		
		$getcommnetid = WdwChatReply::where('chat_reply_id',$commented_id)->select('reply_user_id')->first();
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
						            	$entry = new WdwChatReplyReply;  
            							$entry->chat_id = $chatid;
            							$entry->chat_reply_id = $commented_id;
            							$entry->reply_user_id = $userid;
            							$entry->chat_reply_msg = $message;
            							$entry->chat_reply_date = NOW();
            							$entry->ip_address = $clientIP;
            							$entry->chat_reply_status = 0;
            							$entry->commented_on_user_id = $commentedon_user_id;
            							$entry->save();
            							
            							$reply_id = $entry->id;
            							
            							WdwChatReply::where([['chat_reply_id', '=',$commented_id]])->update(['iscommnt' => 1 ]);
            							
            							if($isprobition == 0)
                    						{ 
                    						    WdwChatReply::where([['chat_reply_id', '=',$commented_id]])->update(['comment_updatedon' => NOW() ]);
                    						    
                    						    WdwChat::where([['chat_id', '=', $chatid],['isbump', '=', '1'],])->update(['chat_reply_update_time' => NOW() ]);
                    						 
                    							
                    						}
                    					User::where('user_id', $userid)->update(['no_of_reply' => \DB::raw('no_of_reply + 1'),'ip_address' => $clientIP ]);
            						
						               // $replydata=	CommentReply::where('id', '=', $entry->id)->with(['replyuser'])->get();
						                
						              $replydata=	WdwChatReplyReply::where([['chat_id', '=', $chatid],['chat_reply_id', '=', $commented_id],])->with(['replyuser']) ->orderBy('chat_reply_date', 'DESC')->get();
						      
						            
						            
						            
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
					$entry = new WdwChatBlock;  
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
					WdwChat::where('chat_id', $removed_id)->delete();
					WdwChatReply::where('chat_id', $removed_id)->delete();
					WdwChatReplyReply::where('chat_id', $removed_id)->delete();
					return response()->json(['status' => 201, 'data' =>	'Post Deleted']);
					}
					else if($type == 'C') // commnet remove
					{
					WdwChatReply::where('chat_reply_id', $removed_id)->delete();
					return response()->json(['status' => 201, 'data' =>	'Removed']);
					}
					else if($type == 'R') // reply remove
					{
					WdwChatReplyReply::where('id', $removed_id)->delete();
					return response()->json(['status' => 201, 'data' =>	'Removed']);
					}
							


					
	 

	}
	
	public function thankyou(Request $request)
	{  
	$user = auth()->user();
	
	
	if($user != null ){
	$userid = $user->user_id;
	$username = $user->user_name;
    $chatdata = WdwChat::where('chat_id',$request['chat_id'])->with('user')->select('chat_id','user_id','chat_msg','no_of_thanks')->first();
	
	$chat_user_name = $chatdata['user']['user_name'];
	$chat_user_email = $chatdata['user']['user_email'];
	$chatuserid = $chatdata['user_id'];
	$chatid = $chatdata['chat_id'];
	$chat_msg = $chatdata['chat_msg'];
	
	
	
	if($chatuserid != $userid)
	{
	$notExist = WdwThankYou::where([['chat_id', '=', $chatid],['user_id', '=', $userid],])->count();
	if($notExist == 0)
	{
	/* to save thankyou  on partcular chat */	
	$entry = new WdwThankYou;  
	$clientIP = request()->ip();
	$entry->chat_id = $chatid;
	$entry->chat_user_id = $chatuserid;
	$entry->user_id = $userid;
	$entry->user_name = $username;
	$entry->ip_address = $clientIP;
	$entry->save();
	
	$reff_id =$entry->id;// to get last inserted id from thankyou
	

	/* to update thankyou count and time on partcular chat */	
	WdwChat::where('chat_id', $chatid)->update(['no_of_thanks' => \DB::raw('no_of_thanks + 1'),'chat_reply_update_time' => NOW()]);
	
/* 	$from = "thanks from dl web";
	
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
	$concertentry->save(); */
	
	/* to update user points of  partcular chat user */
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'5','thanks_for_post_web','wdw');
	
	
	/* to send email single time on partcular chat */
	$check_chatid = WdwTblThankYouEmail::where('chat_id',$chatid)->count();

	if($check_chatid == 0){
	$myVar = new AlertController();
	$alertSetting = $myVar->sucessThankYou($chat_user_name , $chat_user_email, $chat_msg ,$chatid ,$chatuserid );
	
	$emailentry = new WdwTblThankYouEmail;  
	$clientIP = request()->ip();
	$emailentry->chat_id = $chatid;
	$emailentry->chat_user_id = $chatuserid;
	$emailentry->user_id = $userid;
	$emailentry->user_name = $username;
	$emailentry->ip_address = $clientIP;
	$emailentry->save();
	}
			
		 $thankdetail =  WdwThankYou::select('chat_id','user_id')
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
	
	$isExist = WdwThankYou::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->first();
	$clientIP = request()->ip();
	
	if($isExist['status'] == 1)
	{
	WdwThankYou::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '0','ip_address' => $clientIP]);	
	
	WdwChat::where('chat_id', $request['chat_id'])->update(['no_of_thanks' => \DB::raw('no_of_thanks - 1')]);
	
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'-5','thanks_for_post_web','wdw');
	
	
	 $thankdetail =  WdwThankYou::select('chat_id','user_id')
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
	WdwThankYou::where([['chat_id', '=', $request['chat_id']],['user_id', '=', $userid],])->update(['status' => '1','ip_address' => $clientIP]);	
	
	WdwChat::where('chat_id', $request['chat_id'])->update(['no_of_thanks' => \DB::raw('no_of_thanks + 1')]);
	
	
    $thankdetail =  WdwThankYou::select('chat_id','user_id')
						   ->with('user')
	                       ->where
								 ([
								 ['status', '=', '1'],
								 ['chat_id', '=', $request['chat_id']],
								 ])
	                       ->get();
	
	$myRank = new RankController();
	$rankSetting = $myRank->updateUserRank($chatuserid ,'5','thanks_for_post_web','Wdw');
	
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
					WdwChat::where([['chat_id', '=', $update_chat_id ]])
					->update([
					'chat_reply_update_time' => now(),
					'chat_msg' => $update_msg,
				
					]);
					return response()->json(['status' => 201, 'data' =>	'Post Updated Successfully']);
					}
					else if($type == 'C')
					{
					WdwChat::where([['chat_id', '=', $update_chat_id ]])
					->update([
					'chat_reply_update_time' => now(),
					]);
					
					WdwChatReply::where([['chat_reply_id', '=', $update_id ]])
					->update([
					'chat_reply_msg' => $update_msg,
					]);
					return response()->json(['status' => 201, 'data' =>	'Comment Updated Successfully']);
					}
					else if($type == 'R')
					{
					WdwChatReplyReply::where([['id', '=', $id ]])
					->update([
					'chat_reply_msg' => $update_msg,
					]);
					return response()->json(['status' => 201, 'data' =>	'Reply Updated Successfully']);
					}
							


					
	 

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
			WdwChat::where([
						 ['isbump', '=', 1],
						 ['chat_id', '=', $chatid],
						 ])->update(['chat_reply_update_time' => NOW()]);
			$bump = 'Post has been bumped up';
			}
			else if($type == 'down'){ // post will display 15 posts down
			$getdata = 	WdwChat::select('chat_id','chat_reply_update_time')
						 ->where([
						 ['chat_status', '=', 0],
						 ]) 
						 ->orderBy('chat_reply_update_time', 'DESC')
	                     ->skip(15)->take(15)->first();
						 
						 $chat_reply_update_time = $getdata->chat_reply_update_time;
						 
						 WdwChat::where([
						 ['chat_id', '=', $chatid],
						 ])->update(['chat_reply_update_time' => $chat_reply_update_time]);
						$bump = 'Post has been bumped down';
					
						
			}
			else if($type == 'auto'){
				$getdata = 	WdwChatAutoBump::select('id','chat_id','park','status','createdon')
						 ->where([
						 ['chat_id', '=', $chatid],
						 ]) 
						 ->get();
						 
				WdwChat::where([
						 ['isbump', '=', 1],
						 ['chat_id', '=', $chatid],
						 ])->update(['chat_reply_update_time' => NOW()]);
				 
				$getcount  = count($getdata);
				
				if($getcount == 0)
					{
						$entry = new WdwChatAutoBump;  
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
					WdwChat::where([
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
		
		WdwChat::where([['chat_id', '=', $chatid]])->update(['islock' => $type]);
			   
		$getdata = 	WdwChat::select('*')->where([['chat_id', '=', $chatid]])->first();
		
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
	
	public function advanceEditorGet(Request $request)
	{ 
		$user = auth()->user();
		$userid = $user->user_id;
		if($user != null ){	
		
		$chatid = $request->chat_id;
		// $edit_chat_msg = $request->edit_chat_msg;
		 
		$res =  WdwChat::select('*')->where('chat_id','=', $chatid)->get();						
		// WdwChat::where([['chat_id', '=', $chatid ]])->update(['chat_msg' => $edit_chat_msg,'chat_reply_update_time' => \DB::raw('NOW()')]);							
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
	    WdwChat::where([['chat_id', '=', $chatid ]])->update(['chat_msg' => $edit_chat_msg,'chat_reply_update_time' => NOW()]);							
		return response()->json(['status' => 201, 'data' =>	'Post updated']);
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
			TblChatSticky::where([['id', '=', 2]])->update(['chat_id' => $chatid]);
			$result = 'Post Stick';
			}
			else if($type == 'UnStick'){ 
			TblChatSticky::where([['id', '=', 2]])->update(['chat_id' => 0]);
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
			$showonmain= '( select showonmain from  wdw_chat_rooms where  id='.$chat_room_id.' limit 1) ' ;
		}
		
				WdwChat::where([['chat_id', '=', $chatid]])
				->update(['chat_reply_update_time' => NOW(),'chat_room_id' => $chat_room_id,'showonmain' => $showonmain]);
		
		
		if($userid !='')
			{	
				$comments = '';
				
				if($chat_room_id > 0 )
				{
					$chatroom_query = 	WdwChatRoom::select('chat_room')->where([['id', '=', $chat_room_id]])->first();
					$chat_room = $chatroom_query->chat_room; 
				
				}
				else
				{
					$chat_room = 'The Hub ';
				}
				$comments = 'This post has been moved to '.$chat_room; 
		
				WdwChat::where([['chat_id', '=', $chatid]])
				->update(['comments' => $comments]);
						
				$entry = new WdwChatReply;  
				$entry->chat_id = $chatid;
				$entry->reply_user_id = '122974';
				$entry->chat_reply_msg = $comments;
				$entry->chat_room_id = $chat_room_id;
				$entry->ip_address = $_SERVER['REMOTE_ADDR'];
				$entry->showonmain = $showonmain;
				$entry->comment_updatedon = NOW();
				$entry->save(); 
				
			return response()->json(['status' => 200, 'data' =>	str_replace(" ","-",$chat_room) ]);	
			}
		
	
	return response()->json(['status' => 200, 'data' =>	$move ]);
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$move ]);	
	}
	 

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
							WdwChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '3']);
							}
							else if($type=='R')
							{
							WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '3']); } 
							else if($type=='CR')
							{
							WdwChatReplyReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
							}

							/* to save report  on partcular chat */	
							
							$entry = new WdwReport;  
							$entry->chat_id = $chat_id;
							$entry->user_id = $user_id;
							$entry->user_name = $username;
							$entry->type = $type;
							$entry->reasion_for_report = $reasion_for_report;
							
							$entry->save();
							 
							$new_report_id =$entry->id;
							$subject ="Removed Post after Admin Report"; 
							$myVar = new AlertController();
							$alertSetting = $myVar->emailForReportWdw($chat_id ,$type , $user_id, $username, $new_report_id , $reasion_for_report ,$subject);
						
					 $flagdata[] = array('error'=> "Thank you! A MouseWait Staff Member will look at your feedback shortly.");
						} 
				} 
				elseif($chat_id > 0 and  $user_id > 0 )
			   {  
					$no_of_reports = 0 ;
					$no_of_reports = WdwReport::where([['chat_id', '=', $chat_id],['user_id', '=', $user_id],['type', '=', $type]])->count();
					if($no_of_reports > 0 )
					  { 
					"";
						
						$flagdata[] = array('error'=> "You have already reported this. Thank you! A MouseWait Staff Member will look at your feedback shortly.");
 					  }
					  else
					  { 
							$entry = new WdwReport;  
							$entry->chat_id = $chat_id;
							$entry->user_id = $user_id;
							$entry->user_name = $username;
							$entry->type = $type;
							$entry->reasion_for_report = $reasion_for_report;
							
							$entry->save();
							 
							$new_report_id =$entry->id;
				 
				 $no_of_reports = WdwReport::where([['chat_id', '=', $chat_id],['type', '=', $type]])->count();
							
				  
				  
				  if($no_of_reports > 3 )
				  {					   
					 
						  if($type=='C')
						  {
							WdwChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '3']); 
						  }
						  else if($type=='R')
						  {
							WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
						  } 
						   else if($type=='CR')
						  {
							WdwChatReplyReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
						  }    
					
					 if($chat_id >0 and  $user_id > 0 and $new_report_id > 0 )
						{ 
							$subject ="Removed Post after 4th Report"; 
							$myVar = new AlertController();
							$alertSetting = $myVar->emailForReportWdw($chat_id ,$type , $user_id, $username, $new_report_id , $reasion_for_report ,$subject);
							
							$new_report_id = 0; //Make this zero so do not send  email agian at the bottom.
							
						}  
					
					
				  }
				   
				   if($chat_id >0 and  $user_id > 0 and $new_report_id > 0 )
					{ 
						$subject ="Removed Post after Admin Report"; 
						$myVar = new AlertController();
						$alertSetting = $myVar->emailForReportWdw($chat_id ,$type , $user_id, $username, $new_report_id , $reasion_for_report ,$subject);
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
					   WdwChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '3']); 
						break;
					case 'R': 
					    WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
				
					    $getchatid = WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					 
					    WdwChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
						
						
						
						break; 
					case 'CR': 
						
						WdwChatReplyReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '3']);
					
		                $getchatid = WdwChatReplyReply::where([['id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					    
					    WdwChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
					
						break; 
						
				} 
				
				$TblReport = WdwReport::where('id', $reported_id)->delete();	
		        
		        return Redirect::to(env('APP_URL_NEW').'/disneyworld/lounge');
			   			
				 
			}
			
			elseif ( $admin_action == "deleted"){
	
				switch ($user_verify_type) 
				{
					case 'C': 
					   //change the status of the post to active.
						//Delete All Chate
				
						$tblchat = WdwChat::where('chat_id', $chat_id)->delete();	
						
						
						//Delete all the Comments of this post.
						
						$tblcommnet = WdwChatReply::where('chat_id', $chat_id)->delete();	
						
						
						//Delete all the Comments of this post.
						$tblcommnetreply = WdwChatReplyReply::where('chat_id', $chat_id)->delete();	
					
						
						
						break;
					case 'R': 
						//Delete all the Comments of this post.
						$tblcommnet = WdwChatReply::where('chat_reply_id', $chat_id)->delete();
						break; 
					case 'CR': 
						 
						//Delete all the Comments of this post.
						$tblcommnetreply = WdwChatReplyReply::where('id', $chat_id)->delete(); 
						break; 
						
				} //End switch case..  
				 
				$TblReport = WdwReport::where('id', $reported_id)->delete();
				
				 return Redirect::to(env('APP_URL_NEW').'/disneyworld/lounge');
				 
			} 
			
			elseif ( $admin_action == "restore") {
				switch ($user_verify_type) 
				{
					case 'C': 
					WdwChat::where([['chat_id', '=', $chat_id ]])->update(['chat_status' => '0','chat_reply_update_time' => NOW()]); 
						break;
					case 'R': 
					    
					    WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->update(['chat_reply_status' => '0']);
				
					    $getchatid = WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					    
					    WdwChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
					 
						
						break; 
					case 'CR': 
					    
					    WdwChatReplyReply::where([['id', '=', $chat_id ]])->update(['chat_reply_status' => '0']);
					
		                $getchatid = WdwChatReplyReply::where([['id', '=', $chat_id ]])->select('chat_id')->first(); //  ye  dono query test karni h
					    
					    WdwChat::where([['chat_id', '=', $getchatid->chat_id ]])->update(['chat_reply_update_time' => now() ]);
				
						break; 
						
				} //End switch case..   
				 
				 
				$TblReport = WdwReport::where('id', $reported_id)->delete();
				
			 return Redirect::to(env('APP_URL_NEW').'/disneyworld/lounge');
				 
			}
			
			elseif ( $admin_action == "move") { 
				//This action willmove the post to hub. 
				 WdwChat::where([['chat_id', '=', $chat_id ]])->update(['chat_room_id' => '0','chat_reply_update_time' => NOW()]);
        	
				$comments = 'This post has been moved to The Hub' ; 
				
				WdwChat::where([['chat_id', '=', $chat_id ]])->update(['comments' => $comments]);
			
					$entry = new Comment;  
					$entry->chat_id = $chat_id;
					$entry->reply_user_id = 122974;  // ye id fix h as old code
					$entry->chat_reply_msg = $comments;
					$entry->chat_room_id = 0;
					$entry->ip_address = $ip_address;
					$entry->showonmain = 0;
					$entry->comment_updatedon = NOW();
					$entry->save();
				
				
				$TblReport = WdwReport::where('id', $reported_id)->delete();
				
			// return Redirect::to('https://mousewait.xyz/mousewaitnew/disneyland/lounge');
			 return Redirect::to(env('APP_URL_NEW').'/disneyworld/lounge');
				
				 
			}
            
			elseif ( $admin_action == "move-silent") { 
                //This action willmove the post to hub. 
                 
                WdwChat::where([['chat_id', '=', $chat_id ]])->update(['chat_room_id' => '0','chat_reply_update_time' => NOW()]);
             
                $TblReport = WdwReport::where('id', $reported_id)->delete();    
            
                return Redirect::to(env('APP_URL_NEW').'/disneyworld/lounge');
            }
           
		
		
		} 
	
	 

	}
	
	public function removePostImage(Request $request)
	{	
	$lock =  [];	
	$user = auth()->user();
	
	if($user != null ){	
	$chatid = $request->chat_id;
	WdwChat::where([['chat_id', '=', $chatid]])->update(['chat_img' => '']);
	$app = realpath(__DIR__ . '/../../../..');
    $upload_img_dir = $app . '/disneyworld/chat_images/';
	$file = $upload_img_dir.'/'.$chatid.'_c_img.jpg'; 
	unlink($file);
	
	$upload_img_dir_two = $app . '/disneyworld/chat_images_medium/';
	$filetwo = $upload_img_dir_two.'/'.$chatid.'_c_img.jpg'; 

	unlink($filetwo);
	$lock = 'Post image removed';
	return response()->json(['status' => 200, 'data' =>	$lock ]);
	}
	else
	{
    return response()->json(['status' => 200, 'data' =>	$lock ]);	
	}
	 

	}
	
/* 	private $x;
	public function tagList(Request $request)
	{ 	
	
	$chatid = $request->chat_id;
	$this->x =$chatid;

	$res =  Tag::select('id','tags_name')
				->with('gettagdata',function ($query) {
				$query->select('*');
				$query->where('chat_id','=', $this->x);
                 })->get();						
								
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

		$myRank = new RankController();
		$rankSetting = $myRank->updateUserRank($chat_user_id  ,'20','dl_taged_user','DL');		
		
		return response()->json(['status' => 201, 'data' =>	'Added']);
		}
		else
		{
		return response()->json(['status' => 201, 'data' =>	'please login']);	
		}
	}
	 */

	public function mostViewedChatjson(Request $request)
	{
	$mv_startdate ='';
	$mv_enddate='';		
	$p_view='';
	$p_str='a';
			if(isset($request->view))
			{   
				 $p_view = $request->view;	 		 
				 setcookie("view", $p_view); 
			} 
			else
			{ 
				 $p_view = 'json';
				  
				
			}  
			if(isset($request->type))
			{   
				 $p_str = $request->type;			
				setcookie("type", $p_str); 
			} 
			else
			{		
				  $p_str = $_COOKIE['type'];					
			}
			
		

        	
			$today = date('d-m-Y',  strtotime("-0 HOUR"));
			
			if($p_str== 'w')
			{
				$dayofweek = date('w',  strtotime("-0 HOUR"));
				$weekend = (6-$dayofweek) ;
				$mv_startdate = date('Y-m-d', strtotime("-$dayofweek day") );
				$mv_enddate= date('Y-m-d', strtotime("+$weekend day") );
			}
			else if($p_str== 'm')
			{
				$todaymonth = date('m',  strtotime("-0 HOUR"));  	 		
				$mv_startdate = date('Y-m-d', strtotime(date('m').'/01/'.date('Y').' 00:00:00')); 
				$mv_enddate  =  date('Y-m-d', strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));		
			}
			else if($p_str== 'y')
			{
				$todaymonth = date('m',  strtotime("-0 HOUR"));  
				$time_2h  = strtotime(date("Y-m-d H:i", strtotime(date('Y-m-d H:i') )) . "-1 year"); 
				$mv_startdate = date('Y-m-d', $time_2h);  
				$mv_enddate = date('Y-m-d');  
				
			}
			else 
			{
				$mv_startdate = date('Y-m-d',strtotime("-1 days")); //date('Y-m-d',  strtotime("-0 HOUR"));
				$mv_enddate= date('Y-m-d');;
			} 
			

			
			
			
			$most_viewed_chat = 	WdwChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as totalcounts'))
								->with('user',function ($query) {$query->where('user_status','=','1');})
								->withCount('comments as commentcount')
								->where('chat_status','=','0')
								//->whereDate('chat_time', Carbon::today())
								->havingRaw('totalcounts > 0')
								->whereBetween('chat_time', [$mv_startdate, $mv_enddate])
								->whereNotIn('chat_room_id',[139,140 ,141])
								->whereNotIn('chat_id',[329864, 402398])
								->groupBy('chat_id')
								->orderBy('totalcounts', 'DESC')
								->take(20)
								->get();  
      
		$result = array([
					'most_viewed_chat' => $most_viewed_chat,
					]);
	
		 
		return response()->json(['status' => 201, 'data' =>	$result ]);      
	
	}
	
	public function rightBar(Request $request)
	{
	// for best of the day
	$d_startdate = date('Y-m-d',strtotime("-1 days")); //date('Y-m-d'); 
	$d_enddate =  date('Y-m-d');
	$bestoftheday = [];		
	$bestoftheday = 	WdwChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
						->with('user',function ($query) {$query->where('user_status','=','1');})
						->where('chat_status','=','0')
						->havingRaw('chat_total_thank_and_like > 0')
						->whereBetween('chat_time', [$d_startdate, $d_enddate])
						->whereNotIn('chat_id',[329864, 402398])
						->groupBy('chat_id')
						->orderBy('chat_total_thank_and_like', 'DESC')
						->take(5)
						->get();
						
	// for best of the week
	$dayofweek = date('w',  strtotime("-0 HOUR"));
	$weekend = (6-$dayofweek) ;
	$w_startdate = date('Y-m-d', strtotime("-$dayofweek day") );
	$w_enddate =   date('Y-m-d', strtotime("+$weekend day") );
	$bestoftheweek = [];		
	$bestoftheweek = 	WdwChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
						->with('user',function ($query) {$query->where('user_status','=','1');})
						// ->withCount('comments as commentcount')
						->where('chat_status','=','0')
						//->whereDate('chat_time', Carbon::today())
						->havingRaw('chat_total_thank_and_like > 0')
						->whereBetween('chat_time', [$w_startdate, $w_enddate])
						->whereNotIn('chat_id',[329864, 402398])
						->whereNotIn('chat_room_id',[139,140,141])
						->groupBy('chat_id')
						->orderBy('chat_total_thank_and_like', 'DESC')
						->take(5)
						->get();
						
	// for best of the month
	$m_startdate = date('Y-m-d', strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	$m_enddate =   date('Y-m-d', strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00')))); 
	$bestofthemonth = [];		
	$bestofthemonth = 	WdwChat::select('chat_id','user_id','chat_msg','chat_img','chat_video','chat_room_id','chat_time','no_of_likes as likecount','no_of_thanks as thankcount','iswatermark','mapping_url','chat_status',DB::raw('(no_of_likes + no_of_thanks) as chat_total_thank_and_like'))
						->with('user',function ($query) {$query->where('user_status','=','1');})
						// ->withCount('comments as commentcount')
						->where('chat_status','=','0')
						//->whereDate('chat_time', Carbon::today())
						->havingRaw('chat_total_thank_and_like > 0')
						->whereBetween('chat_time', [$m_startdate, $m_enddate])
						->whereNotIn('chat_id',[329864, 402398])
						->whereNotIn('chat_room_id',[139,140,141])
						->groupBy('chat_id')
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
						->where('default_park','=','WDW')
						->orderBy('counter', 'ASC')
						->take(5)
						->get();
						
						
						
	
	
	$result = array([
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
							['default_park', '=', 'WDW'],])
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
				['default_park', '=', 'WDW'],])
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
					urs.user_name,urs.image, urs.totalpoints as overallpoints  , urs.position  , urs.rank as overallrank  FROM `tbl_top_user_leaderboard` as lb INNER JOIN tbl_user urs ON (lb.user_id = urs.user_id) WHERE  lb.`default_park` = 'MR' order by `counter` asc  limit 0 ,100  "; 
					
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
					urs.user_name,urs.image, urs.totalpoints as overallpoints  ,  urs.position  , urs.rank as overallrank  FROM `tbl_top_user_leaderboard` as lb INNER JOIN tbl_user urs ON (lb.user_id = urs.user_id) WHERE  lb.`default_park` = 'MWR'  order by `counter` asc  limit 0 ,100  "; 
					$result = DB::select($qry);
	}
	
	
	return response()->json(['status' => 200, 'data' =>	$result ]);
	
	    
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
			$isExist = WdwTblLikeComment::select('*')->where([
							['user_id', '=', $auth_userid],
							['comment_id', '=', $comment_id],
						    ])->count();
			
			if($isExist == 0){
				$entry = new WdwTblLikeComment;  
				$entry->comment_id = $comment_id;
				$entry->chat_id = $chat_id;
				$entry->user_id = $auth_userid;
				$entry->user_name = $auth_username;
				$entry->save();
				
			WdwChatReply::where('chat_reply_id', $comment_id)->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
				
			$getcommnet = WdwChatReply::select('reply_user_id')->where([
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
			$isExist = WdwTblLikeReply::select('*')->where([
							['user_id', '=', $auth_userid],
							['comment_id', '=', $reply_id],
						    ])->count();
			
			if($isExist == 0){
				$entry = new WdwTblLikeReply;  
				$entry->comment_id = $reply_id;
				// $entry->reply_id = $reply_id;
				$entry->user_id = $auth_userid;
				$entry->user_name = $auth_username;
				$entry->save();
				
			WdwChatReplyReply::where('id', $reply_id)->update(['no_of_likes' => \DB::raw('no_of_likes + 1')]);
			
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
	
}

