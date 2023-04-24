<?php

namespace App\Http\Controllers\Alert;
use App\TblEmailTemplate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\TblChat;
use App\WdwChat;
use App\Comment;
use App\CommentReply;

class AlertController extends Controller
{
    
	
	
	public function sucessRegistartion($user_id,$username,$user_email,$user_password) 
	{
		$message = "";
		$from     = "info@mousewait.com"; 
		$subject  = "Mousewait Registartion";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
				
		if(!empty($user_email))
		{						   
		$to       = $user_email;
		$message = "hello";
		$my_message_orignal = "";
		
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 8)->get();
		
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$my_message_orignal = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
		
		
	
 
		
		$url = "https://www.mousewait.com/backend/api/v1/confirmationMail?uid=$user_id";
		  

		$message = $my_message_orignal;
		$message = str_replace('%USERNAME%', $username, $message);
		$message = str_replace('%URL%', $url, $message);
		$message = str_replace('%USERPASSWORD%', $user_password, $message);
					 



		
		mail($to, $subject, $message, $headers);
		}
		
				
				
			  
		}   
	
	public function resetPassword($user_id,$user_name,$useremail,$resetkey) 
	{
	  
		
		$to = $useremail;
		$subject = 'Mousewait Reset Password';
	   	$from = 'info@mousewait.com';
		 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
	
		
		$my_message = "";
		$my_message_orignal = "";
		
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 9)->get();
		
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$my_message_orignal = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
		
		$url =   "https://www.mousewait.com/disneyland/reset_password.php?uid=".$user_id."&resetkey=".$resetkey; 


		$my_message = $my_message_orignal;
		$my_message = str_replace('%USERNAME%', $user_name, $my_message);
		$my_message = str_replace('%RESETURL%', $url, $my_message);
	
		
	
		mail($to, $subject, $my_message, $headers);
		
	}
	
	
	public function ForgotPasswordEmail($user_name,$user_email,$passwd) 
	{
	  
		
		$to = $user_email;
		$subject = 'Mousewait Forgot Password';
	   	$from = 'info@mousewait.com';
		 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
	// echo($user_name);
	// echo($user_email);
	// dd($passwd);
		
		$my_message = "	Hello, Mousewait user your login details is <br />  Username: ".$user_name." <br />Password: ".$passwd."<br />Email: ".$user_email."<br /><br /><br /><br />Thanks for being a part of the MouseWait Community!<br /><br />Take care,<br /><br />MouseWait.com Support<br />https://mousewait.com";

	
		mail($to, $subject, $my_message, $headers);
		
	}
	
	
	public function sucessThankYou($chat_user_name, $chat_user_email, $chat_msg ,$chatid ,$chatuserid) 
	{
		$to = $chat_user_email;
		$subject = 'Thanked on your post';
		$from = 'info@mousewait.com';
		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
		// Compose a simple HTML email message		
		// $message = "<html><head></head><body>";
		
		$my_message = "";
		$my_message_orignal = "";
		
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 10)->get();
		
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$my_message_orignal = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
		
		//Makeing the keyword base url for comments
		$arrysize = 0;
		$str_keyword_msg = "";
		$ary_keyword_msg = str_word_count(strip_tags($chat_msg), 1);
		$arrysize = sizeof($ary_keyword_msg) ;
		if($arrysize > 8) {$arrysize = 8 ;}
		for($i=0; $i < $arrysize; $i++)
		{
			if($ary_keyword_msg[$i]!='')
			{
				if($str_keyword_msg =='')
				{ $str_keyword_msg .= $ary_keyword_msg[$i]; }
				else
				{
					$str_keyword_msg .= '-'.$ary_keyword_msg[$i];
				}
			}
		}
		 
		if($str_keyword_msg =='')
			{$str_keyword_msg="MouseWait";}
		
		 $str_talk="lands-talk";   
	
		if($str_keyword_msg=='')
		{
			$url = $str_talk.'/'.$chatid.'/MouseWait'; 
		}
		else
		{
			$url = $str_talk.'/'.$chatid.'/'.$str_keyword_msg; 
		} 
 
 
		
		$my_message = $my_message_orignal  ;
		$my_message = str_replace('%USERNAME%' , $chat_user_name ,$my_message);
		$my_message = str_replace('%CHAT_MESSAGE%' , $chat_msg ,$my_message);  
		$my_message = str_replace('%URL%' , $url ,$my_message);
	/* 	$my_message .= "<br>"."Unsubscribe url: https://www.mousewait.com/disneyland/unsubscribe.php?type=tpost&uid=".$chatuserid; */

		mail($to, $subject, $my_message, $headers);
	}
	
    public function emailForReport($chat_id ,$type , $reported_user_id, $ReportedUserName , $reported_id ,$reasion_for_report ,$subject) 
	{
	    
	   $url = env('APP_URL');
	   $url_new = env('APP_URL_NEW');
	  
		$to = 'timejarmail@gmail.com';
		
		$from = 'info@mousewait.com';
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
		
		if($type =='C')
		{ 
				$chat_query =  TblChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','user_id','chat_msg')
									  ->with('user')
					                  ->first();
					                  
			  $chat_username = $chat_query['user']['user_name'];
			  $chat_userimage = $chat_query['user']['image'];
			  $chat_user_id = $chat_query['user_id'];
		}
		elseif($type =='R')
		{
			
				$chat_query =  Comment::where([['chat_reply_id', '=', $chat_id],])
									  ->select('chat_reply_msg as chat_msg','chat_id','reply_user_id')
									  ->with('commentuser')
					                  ->first();
					                  
					               
			 $chat_username = $chat_query['commentuser']['user_name'];
			  $chat_userimage = $chat_query['commentuser']['image'];
			   $chat_user_id = $chat_query['reply_user_id'];
			
		}
		elseif($type =='CR')
		{

			
				$chat_query =  CommentReply::where([['id', '=', $chat_id],])
									  ->select('chat_reply_msg as chat_msg','chat_id','reply_user_id')
									  ->with('replyuser')
					                  ->first();
					                  
			  $chat_username = $chat_query['replyuser']['user_name'];
			  $chat_userimage = $chat_query['replyuser']['image'];
			  $chat_user_id = $chat_query['reply_user_id'];
		}
		
		
	//	dd($chat_query);
	
			  $url_chat_id = $chat_query['chat_id'];
			  $post = $chat_query['chat_msg'];
			 
			 
		
			  $chat_msg = $post;
			  $url_chat_id = $chat_id;
			  $str_keyword_msg=''; 
			
				
			if($type =='R')
				{
					 $getchatid = Comment::where([['chat_reply_id', '=', $chat_id ]])->select('chat_id')->first();
					 $no_of_reports =  TblChat::where([['chat_id', '=', $getchatid->chat_id],])
									  ->select('chat_id','user_id','chat_msg as chatmsg')
					                  ->first();
					 
					
					 $chat_msg = $no_of_reports->chatmsg;					   
					 $url_chat_id = $no_of_reports->chat_id;	
					 $chat_user_id = $no_of_reports->user_id;
					 
				
				
				}
				elseif($type =='CR')
				{
					$getchatid = CommentReply::where([['id', '=', $chat_id ]])->select('chat_id')->first();
					 $no_of_reports =  TblChat::where([['chat_id', '=', $getchatid->chat_id],])
									  ->select('chat_id','user_id','chat_msg as chatmsg')
					                  ->first();
					 
					
					 $chat_msg = $no_of_reports->chatmsg;					   
					 $url_chat_id = $no_of_reports->chat_id;	
					 $chat_user_id = $no_of_reports->user_id;
				} 
				
				
				
		
				
				
				$ary_keyword_msg = str_word_count(strip_tags($chat_msg), 1);
				$arrysize = sizeof($ary_keyword_msg) ;
				if($arrysize > 8) $arrysize = 8 ;
				for($i=0; $i < $arrysize; $i++)
				{
					if($ary_keyword_msg[$i]!='')
					{
						if($str_keyword_msg =='')
						{ 
							$str_keyword_msg .= $ary_keyword_msg[$i]; 
						}
						else
						{
							$str_keyword_msg .= '-'.$ary_keyword_msg[$i];
						}
					}
				} 
				
				if($str_keyword_msg =='')
				{$str_keyword_msg="MouseWait";}
					
				if($str_keyword_msg == '')
				{
					$comment_url=''.$url_new.'/disneyland/lands-talk/'.$url_chat_id.'/MouseWait'; 
				}
				else
				{
					$comment_url=''.$url_new.'/disneyland/lands-talk/'.$url_chat_id.'/'.$str_keyword_msg; 
				} 
				
				$dm_url =  ''.$url_new.'/disneyland/user/'.$chat_user_id.'/txt-me';
				 
	
			

		
		$message = "";	   
			 
		$message .= "Hello Admin, <br /><br />"; 		 
		
		 
		 if($type == 'C')
		{
			
		$message .=  "Following post has be reported by <a href=\"$url_new/disneyland/user/".$reported_user_id."/mypost\" >".$ReportedUserName."</a>  ".'<a href="'.$url_new.'/disneyland/myConversation/'.$reported_user_id.'">DM</a> '.""." , Post content as follow  <br /><br />"; 
		
		$message .=  $post."<br /><br />"; 
		$message .=  '<img src="https://mousewait.com/disneyland/images/thumbs/'.$chat_userimage.'" width="60" height="60" />';
		$message .=  '<a href="'.$url_new.'/disneyland/user/'.$chat_user_id.'/mypost">'.$chat_username.'</a> &nbsp;&nbsp;';
		}
		else
		{
		$message .=  "Following Comment has be reported by <a href=\"$url_new/disneyland/user/".$reported_user_id."/mypost\" >".$ReportedUserName."</a>  ".'<a href="'.$url_new.'/disneyland/myConversation/'.$reported_user_id.'">DM</a> '.""." , Post content as follow  <br /><br />"; 
		
		$message .=  $post."<br /><br />"; 
		
		}
		
		$message .=  "<br />";
		
        
        $message .=	'<a href="'.$url_new.'/backend/api/v1/flagAction?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=deleted">Delete</a> &nbsp;&nbsp;';  
		$message .=  "<br />";
		$message .=	'<a href="'.$url_new.'/backend/api/v1/flagAction?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=remove">Remove</a> &nbsp;&nbsp;'; 
		 
		$message .=  "<br />";
		$message .=	'<a href="'.$url_new.'/backend/api/v1/flagAction?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=restore">Restore</a> '." &nbsp;&nbsp;"; 
		$message .=  "<br />";
		if($type == 'C')
		{ 
			$message .=	'<a href="'.$url_new.'/backend/api/v1/flagAction?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=move">Move to Hub</a> '." &nbsp;&nbsp;";  
		    $message .= '<a href="'.$url_new.'/backend/api/v1/flagAction?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=move-silent">Move to Hub Silent</a> '."&nbsp;&nbsp;";
    
        } 
		

	$message .=  "<br />";
		
		$message .=  "Reasion for Reporting : ".$reasion_for_report." <br /><br />"; 
		$message .=  "Post URL : ".$comment_url." <br /><br />"; 
		
		$message .=  "Thank you ! <br /><br />"; 
		$message .=  "Team MouseWait.com<br /><br />";   
		$message .=  "<br /><br />";  
		//dd($message);
		// echo $to;
		// echo $subject;
		// echo '<pre>'; print_r($message);
		// echo $headers;
		// die;
		
		mail($to, $subject, $message, $headers);
	}
	
	public function emailForReportWdw($chat_id ,$type , $reported_user_id, $ReportedUserName , $reported_id ,$reasion_for_report ,$subject) 
	{
	    
	   $url = env('APP_URL');
	   $url_new = env('APP_URL_NEW');
	  
		$to = 'timejarmail@gmail.com';
		//$to = 'aniljaipur302029@gmail.com';
		$from = 'info@mousewait.com';
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
		
		if($type =='C')
		{ 
				$chat_query =  WdwChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','user_id','chat_msg')
									  ->with('user')
					                  ->first();
					                  
			  $chat_username = $chat_query['user']['user_name'];
			  $chat_userimage = $chat_query['user']['image'];
			  $chat_user_id = $chat_query['user_id'];
		}
		elseif($type =='R')
		{
			
				$chat_query =  WdwChatReply::where([['chat_reply_id', '=', $chat_id],])
									  ->select('chat_reply_msg as chat_msg','chat_id','reply_user_id')
									  ->with('commentuser')
					                  ->first();
					                  
					               
			 $chat_username = $chat_query['commentuser']['user_name'];
			  $chat_userimage = $chat_query['commentuser']['image'];
			   $chat_user_id = $chat_query['reply_user_id'];
			
		}
		elseif($type =='CR')
		{

			
				$chat_query =  WdwChatReplyReply::where([['id', '=', $chat_id],])
									  ->select('chat_reply_msg as chat_msg','chat_id','reply_user_id')
									  ->with('replyuser')
					                  ->first();
					                  
			  $chat_username = $chat_query['replyuser']['user_name'];
			  $chat_userimage = $chat_query['replyuser']['image'];
			  $chat_user_id = $chat_query['reply_user_id'];
		}
		
		
	//	dd($chat_query);
	
			  $url_chat_id = $chat_query['chat_id'];
			  $post = $chat_query['chat_msg'];
			 
			 
		
			  $chat_msg = $post;
			  $url_chat_id = $chat_id;
			  $str_keyword_msg=''; 
			
				
			if($type =='R')
				{
					 $getchatid = WdwChatReply::where([['chat_reply_id', '=', $chat_id ]])->select('chat_id')->first();
					 $no_of_reports =  WdwChat::where([['chat_id', '=', $getchatid->chat_id],])
									  ->select('chat_id','user_id','chat_msg as chatmsg')
					                  ->first();
					 
					
					 $chat_msg = $no_of_reports->chatmsg;					   
					 $url_chat_id = $no_of_reports->chat_id;	
					 $chat_user_id = $no_of_reports->user_id;
					 
				
				
				}
				elseif($type =='CR')
				{
					$getchatid = WdwChatReplyReply::where([['id', '=', $chat_id ]])->select('chat_id')->first();
					 $no_of_reports =  WdwChat::where([['chat_id', '=', $getchatid->chat_id],])
									  ->select('chat_id','user_id','chat_msg as chatmsg')
					                  ->first();
					 
					
					 $chat_msg = $no_of_reports->chatmsg;					   
					 $url_chat_id = $no_of_reports->chat_id;	
					 $chat_user_id = $no_of_reports->user_id;
				} 
				
				
				
		
				
				
				$ary_keyword_msg = str_word_count(strip_tags($chat_msg), 1);
				$arrysize = sizeof($ary_keyword_msg) ;
				if($arrysize > 8) $arrysize = 8 ;
				for($i=0; $i < $arrysize; $i++)
				{
					if($ary_keyword_msg[$i]!='')
					{
						if($str_keyword_msg =='')
						{ 
							$str_keyword_msg .= $ary_keyword_msg[$i]; 
						}
						else
						{
							$str_keyword_msg .= '-'.$ary_keyword_msg[$i];
						}
					}
				} 
				
				if($str_keyword_msg =='')
				{$str_keyword_msg="MouseWait";}
					
				if($str_keyword_msg == '')
				{
					$comment_url=''.$url_new.'/disneyworld/lands-talk/'.$url_chat_id.'/MouseWait'; 
				}
				else
				{
					$comment_url=''.$url_new.'/disneyworld/lands-talk/'.$url_chat_id.'/'.$str_keyword_msg; 
				} 
				
				$dm_url =  ''.$url_new.'/disneyland/user/'.$chat_user_id.'/txt-me';
				 
	
			

		
		$message = "";	   
			 
		$message .= "Hello Admin, <br /><br />"; 		 
		$message .=  "Following post has be reported by <a href=\"$url_new/disneyland/user/".$reported_user_id."/mypost\" >".$ReportedUserName."</a>  ".'<a href="'.$url_new.'/disneyland/myConversation/'.$reported_user_id.'">DM</a> '.""." , Post content as follow  <br /><br />"; 
		
		$message .=  $post."<br /><br />"; 
		 
		$message .=  '<img src="https://mousewait.com/disneyland/images/thumbs/'.$chat_userimage.'" width="60" height="60" />';
		$message .=  '<a href="'.$url_new.'/disneyworld/user/'.$chat_user_id.'/mypost">'.$chat_username.'</a> &nbsp;&nbsp;';
		$message .=  "<br />";

        
        $message .=	'<a href="'.$url_new.'/backend/api/v1/flagActionWdw?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=deleted">Delete</a> &nbsp;&nbsp;';  
		$message .=  "<br />";
		$message .=	'<a href="'.$url_new.'/backend/api/v1/flagActionWdw?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=remove">Remove</a> &nbsp;&nbsp;'; 
		 
		$message .=  "<br />";
		$message .=	'<a href="'.$url_new.'/backend/api/v1/flagActionWdw?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=restore">Restore</a> '." &nbsp;&nbsp;"; 
		$message .=  "<br />";
		if($type == 'C')
		{ 
			$message .=	'<a href="'.$url_new.'/backend/api/v1/flagActionWdw?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=move">Move to Hub</a> '." &nbsp;&nbsp;";  
		    $message .= '<a href="'.$url_new.'/backend/api/v1/flagActionWdw?chatid='.$chat_id.'&type='.$type.'&reported_id='.$reported_id.'&action=move-silent">Move to Hub Silent</a> '."&nbsp;&nbsp;";
    
        } 
		

	$message .=  "<br />";
		
		$message .=  "Reasion for Reporting : ".$reasion_for_report." <br /><br />"; 
		$message .=  "Post URL : ".$comment_url." <br /><br />"; 
		
		$message .=  "Thank you ! <br /><br />"; 
		$message .=  "Team MouseWait.com<br /><br />";   
		$message .=  "<br /><br />";  
		//dd($message);
		// echo $to;
		// echo $subject;
		// echo '<pre>'; print_r($message);
		// echo $headers;
		// die;
		
		mail($to, $subject, $message, $headers);
	}
	
	
	public function sendMail($user_email,$message,$user_name,$subject) 
	{
		
		  //get data nedeed !
            $from     = "support@mousewait.com";
            $to       = "$user_email";
			$my_message = "";	 
			$my_message .= "$message";

		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			

		mail($to, $subject, $my_message, $headers);
	}
	
	
	
	public function passwordChangeEmail($user_name,$user_email,$tbox_new_pass) 
	{
		
		  //get data nedeed !
            $from     = "info@mousewait.com";
            $to       = "$user_email";
            $subject  = "Mousewait Password";
			$message = "";	 
			$message .= "Hi ".$user_name."<br>";
			$message .= "Your password request is received. Here is your password  details.  <br>";		   
			$message .=   "<br>";	 
			$message .=   "User Name:  ". $user_name."<br>";	 	 
			$message .=   "Password : ".$tbox_new_pass."<br>";	 	 
			$message .=  "Thanks <br>";
			$message .=  "Best Regards <br>";
			$message .=  "mousewait support team <br>";
		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			
			// dd($message);
		mail($to, $subject, $message, $headers);
	}
	
	public function sendGiftMail($user_name , $user_email , $product) 
	{
		$subject = "";
      
		$from     = "info@mousewait.com"; 
		 
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		 
		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		 
		// Compose a simple HTML email message		
		// $message = "<html><head></head><body>";
		
		$my_message = "";
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 14)->get();
		
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$my_message = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
		$my_message = str_replace('%USERNAME%', $user_name, $my_message);
		
        $to  =  $user_email;  
		// echo($to);
		// echo($subject);
		// dd($my_message);
	// echo($my_message); die;
		// Sending email
		mail($to, $subject, $my_message, $headers,'-finfo@mousewait.com');
	}
	
	
	public function mailTagUser($user_id,$taged_user_name , $comment_message , $chat_id) 
	{
		$message = "";
		$from     = "info@mousewait.com"; 
		$subject  = "You were tagged in a post in the Lounge";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		
		$chat_message = "";
		$chat_query =  TblChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
    
        if (empty($chat_mapping_url)) {
            //Makeing the keyword base url for comments
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;

		 
		$userdata = User::where([['user_id', '=', $user_id],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				 
				$user_name	  = $userdata->user_name;
				$user_email	  = $userdata->user_email; 
				$isvarified	  = $userdata->isvarified; 
				
				if(!empty($user_email))
				{						   
					$to       = $user_email;			 
					 
					$message .="Hello ".$user_name.", <br><br>"; 		 
					$message .= $taged_user_name ." tagged you in with the following comment :";  
					$message .=  $comment_message;
					
					$message .="You can also see the detail post at the following link.. <br><br>";	
					$message .= $url."<br><br>"; 
				 
					$message .=  "Thanks Have fun! <br><br>"; 
					$message .=  "Team MouseWait  <br><br>"; 
					$message .=  "www.MouseWait.com<br>"; 
					
					// echo $to;
					// echo $subject;
					 //echo $message; die;
				
					mail($to, $subject, $message, $headers);
				}
				
				
				
			  
		}   

	public function emailForChat( $who_get_mail_user_id, $user_text_email , $user_text_message,$user_name , $user_email) 
	{
		//dd($user_email);
		$user = auth('api')->user();
		$sender_user_name = $user->user_name;
		$sender_user_id = $user->user_id;
		$from     = "info@mousewait.com";
		$to       = "$user_email";
		$subject  = "Mousewait Text Message From ".$sender_user_name ;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		$message = "";	  
		$message .= "You have a new message from ".$sender_user_name." \n<br>";					 	 	 
		$message .= "<br>";	
		$message .=   $user_text_message."\n\n <br>";
	 	$message .= "<br>";	
		// $message .=   "PLEASE DO NOT REPLY TO THIS EMAIL - go to this page to respond https://www.mousewait.xyz/mousewaitnew/disneyland/myConversation/".$sender_user_id."\n\n <br>";
		
		$message .=   "PLEASE DO NOT REPLY TO THIS EMAIL - go to this page to respond. \n";  
		$message .= "<br>";	
		$message .=   env('APP_URL_NEW')."/disneyland/notification"; 
		$message .= "\n <br>";	
		$message .=  "Thank you for using MouseWait! \n <br>";
		$message .= "<br>";	
		$message .=  "www.MouseWait.com \n <br>";  
		$message .= "<br>";	
		// $message  = strip_tags($message); 
		
		
				
		
		
		mail($to, $subject, $message, $headers);
				
				
				
				
			  
	}   
	
	public function emailConfirmationMail($userid,$auth_username,$auth_useremail,$type) 
	{
		$url = env('APP_URL');
		$message = "";
		$from     = "support@mousewait.com"; 
		$to       = $auth_useremail;
		$subject  = "Your MouseWait Txt Email Activation!";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		 $message .= "Hello ".$auth_username." <br><br>"; 		 
		 $message .=   "Welcome to MouseWait! To enable your account for posting in the Lounge, please click on the link below to activate. You will receive 3 MouseRank points for activating! <br><br>";
		 // $message .=   "https://www.mousewait.xyz/mousewaitnew/disneyland/confirmationMail?uid=".$userid." <br><br>";
		
		$message .=	'<a href="'.$url.'api/v1/confirmationMail?uid='.$userid.'">Click Here For Confirm</a> &nbsp;&nbsp;'; 

		 
		 $message .= 	"ALSO - please read our Rules-FAQ before you post, this is very important http://mousewait.com/blog/?page_id=405"." <br><br>"; 
		 $message .=  "Thank you for joining the MouseWait Family and have fun! <br><br>"; 
		 $message .=  "Team MouseWait<br><br>";
		// dd($message);
   

		mail($to, $subject, $message, $headers,'-finfo@mousewait.com');
				
				
				
			  
	}   
	
	public function bestOfTheDayEmail($user_name,$user_email,$message) 
	{

		$from     = "info@mousewait.com"; 
		$to       = $user_email;
		$subject  = "Congratulations on earning MouseRank!";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers,'-finfo@mousewait.com'); 
			  
	}   
	
	public function adminPostMailTosubscribeUser($userid,$authname,$friendid,$chat_id) 
	{
		 
		$message = "";
		$from     = "info@mousewait.com"; 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		$chat_message = "";
		$chat_query =  TblChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg','chat_time')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
	    $date = $chat_query->chat_time;
    
        if (empty($chat_mapping_url)) {
            //Makeing the keyword base url for comments
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;
		$urltwo = 'lands-talk/' . $chat_mapping_url;
		 
		$userdata = User::where([['user_id', '=', $friendid],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				
		$user_name	  = $userdata->user_name;
		$user_email	  = $userdata->user_email; 
		$isvarified	  = $userdata->isvarified;		
						   
		
		if(!empty($user_email))
		{						   
		$to = $user_email;
		$my_message_orignal = "";
		
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 2)->get();
		
		
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$my_message_orignal = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
	
	 
		
		$message = $my_message_orignal;
		$message = str_replace('%USERNAME%', $user_name, $message);
		$message = str_replace('%URL%', $urltwo, $message);
		$message = str_replace('%CHAT_MESSAGE%', $url, $message);
		$message = str_replace('%USER_ID%', $userid, $message);
		$message = str_replace('%DATETIME%', $date, $message);
		
		mail($to, $subject, $message, $headers);
		}
		  
	}   
	
	public function mailSubscribFriend($userid,$authname,$friendid,$chat_id) 
	{
		 
		$message = "";
		$from     = "info@mousewait.com"; 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		$chat_message = "";
		$chat_query =  TblChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg','chat_time')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
	    $date = $chat_query->chat_time;
    
        if (empty($chat_mapping_url)) {
            //Makeing the keyword base url for comments
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;
		$urltwo = 'lands-talk/' . $chat_mapping_url;
		 
		$userdata = User::where([['user_id', '=', $friendid],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				
		$user_name	  = $userdata->user_name;
		$user_email	  = $userdata->user_email; 
		$isvarified	  = $userdata->isvarified;		
						   
		
		if(!empty($user_email))
		{						   
		$to = $user_email;
		$my_message_orignal = "";
		
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 7)->get();
		
		
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$my_message_orignal = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
		$subject = str_replace('%USERNAME%', $authname, $subject);
	
		
		$message = $my_message_orignal;
		$message = str_replace('%USERNAME%', $authname, $message);
		$message = str_replace('%URL%', $urltwo, $message);
		$message = str_replace('%CHAT_MESSAGE%', $url, $message);
		$message = str_replace('%USER_ID%', $userid, $message);
		$message = str_replace('%DATETIME%', $date, $message);
		
		mail($to, $subject, $message, $headers);
		}
		  
	}   
	
	/* public function mailSubscribFriend($userid,$username,$friendid,$comment_message,$chat_id) 
	{
		$message = "";
		$from     = "info@mousewait.com"; 
		$subject  = "New Post From : ".$username;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		
		$chat_message = "";
		$chat_query =  TblChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
    
        if (empty($chat_mapping_url)) {
           
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;

		 
		$userdata = User::where([['user_id', '=', $friendid],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				 
				$user_name	  = $userdata->user_name;
				$user_email	  = $userdata->user_email; 
				$isvarified	  = $userdata->isvarified; 
				
				if(!empty($user_email))
				{						   
					$to       = $user_email;			 
					 
					$message .="Hello ".$user_name.", <br><br>"; 		 
					$message .="Here is new post from ".$username.", <br><br>";  
				
					
					$message .="You can also see the detail post at the following link.. <br><br>";	
					$message .= $url."<br><br>"; 
				 
					$message .=  "Thanks Have fun! <br><br>"; 
					$message .=  "Team MouseWait  <br><br>"; 
					$message .=  "www.MouseWait.com<br>"; 
					
	
				
					mail($to, $subject, $message, $headers);
				}
				
				
				
			  
		}  */  
	
	public function mailToPostOwner($userid,$authname,$comment_message,$chat_id) 
	{
		 
		$message = "";
		$from     = "info@mousewait.com"; 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		$chat_message = "";
		$chat_query =  TblChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
    
        if (empty($chat_mapping_url)) {
            //Makeing the keyword base url for comments
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;

		 
		$userdata = User::where([['user_id', '=', $userid],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				
		$user_name	  = $userdata->user_name;
		$user_email	  = $userdata->user_email; 
		$isvarified	  = $userdata->isvarified;		
						   
		
		if(!empty($user_email))
		{						   
		$to = $user_email;
		$my_message_orignal = "";
		
		$template_Sql_Query = TblEmailTemplate::select('id','template_for','subject','template','description')->where('id', 22)->get();
		
		$authuser = auth()->user();
		$auth_user_name = $authuser->user_name;
		$id = $template_Sql_Query[0]['id'];
		$template_for = $template_Sql_Query[0]['template_for'];
		$subject = $template_Sql_Query[0]['subject'];
		$subject = str_replace('%CHAT_USER_NAME%', $auth_user_name, $subject);
		$my_message_orignal = $template_Sql_Query[0]['template'];
		$description = $template_Sql_Query[0]['description'];
		
		
		$message = $my_message_orignal;
		$message = str_replace('%USERNAME%', $user_name, $message);
		$message = str_replace('%POST_COMMENTS%', $comment_message, $message);
		$message = str_replace('%CHAT_MESSAGE%', $url, $message);
		
		mail($to, $subject, $message, $headers);
		}
		  
	}   
	
	public function emailForUpdateUserCredit($user_email, $my_message , $subject) 
	{
	  
		
		$message = "";
		$from     = "info@mousewait.com"; 
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		$to       = $user_email;			 
		$message .=  '"'.$my_message.'"'."<br><br>";
			
		mail($to, $subject, $message, $headers);
						
		
	}
	
	public function mailToPostOwnerWdw($userid,$authname,$comment_message,$chat_id) 
	{
		$message = "";
		$from     = "info@mousewait.com"; 
		$subject  = "New Comment on Your Post By:".$authname;
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		
		$chat_message = "";
		$chat_query =  WdwChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
    
        if (empty($chat_mapping_url)) {
            //Makeing the keyword base url for comments
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;

		 
		$userdata = User::where([['user_id', '=', $userid],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				 
				$user_name	  = $userdata->user_name;
				$user_email	  = $userdata->user_email; 
				$isvarified	  = $userdata->isvarified; 
				
				if(!empty($user_email))
				{						   
					$to       = $user_email;			 
					 
					$message .="Hello ".$user_name.", <br><br>"; 		 
					$message .="The following comment has been posted at your Post: <br><br>"; 
				
					 $message .=  '"'.$comment_message.'"'."<br><br>";
					$message .="You can also see the detail post at the following link.. <br><br>";	
					$message .= $url."<br><br>"; 
				 
					$message .=  "Thanks Have fun! <br><br>"; 
					$message .=  "Team MouseWait  <br><br>"; 
		
					
					/* echo $to;
					echo $subject;
					 echo $message; die;  */
				
					mail($to, $subject, $message, $headers);
				}
				
				
				
			  
		}   
	
	public function mailTagUserWdw($user_id,$taged_user_name , $comment_message , $chat_id) 
	{
		$message = "";
		$from     = "info@mousewait.com"; 
		$subject  = "You were tagged in a post in the Lounge";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		
		$chat_message = "";
		$chat_query =  WdwChat::where([['chat_id', '=', $chat_id],])
									  ->select('chat_id','mapping_url','chat_msg')
					                  ->first();
					                  
	    $chat_message = $chat_query->chat_msg;
	    $chat_mapping_url = $chat_query->mapping_url;
    
        if (empty($chat_mapping_url)) {
            //Makeing the keyword base url for comments
            $ary_keyword_msg = str_word_count($chat_message, 1);
            $str_keyword_msg = '';
    
            for ($i = 0; $i < 8; $i++) {
                if ($ary_keyword_msg[$i] != '') {
                    if ($str_keyword_msg == '') { $str_keyword_msg .= $ary_keyword_msg[$i];
                    } else {
                        $str_keyword_msg .= '-' . $ary_keyword_msg[$i];
                    }
                }
            }
            if ($str_keyword_msg == '') {$str_keyword_msg = "MouseWait";
            }
            
              $chat_mapping_url = addslashes($chat_id."/".$str_keyword_msg);
        }
    
        $url = env('APP_URL_NEW').'/disneyland/lands-talk/' . $chat_mapping_url;

		 
		$userdata = User::where([['user_id', '=', $user_id],])
									  ->select('user_name','user_email','isvarified')
					                  ->first();
				 
				$user_name	  = $userdata->user_name;
				$user_email	  = $userdata->user_email; 
				$isvarified	  = $userdata->isvarified; 
				
				if(!empty($user_email))
				{						   
					$to       = $user_email;			 
					 
					$message .="Hello ".$user_name.", <br><br>"; 		 
					$message .= $taged_user_name ." tagged you in with the following comment :";  
					$message .=  $comment_message;
					
					$message .="You can also see the detail post at the following link.. <br><br>";	
					$message .= $url."<br><br>"; 
				 
					$message .=  "Thanks Have fun! <br><br>"; 
					$message .=  "Team MouseWait  <br><br>"; 
					$message .=  "www.MouseWait.com<br>"; 
					
					// echo $to;
					// echo $subject;
					 //echo $message; die;
				
					mail($to, $subject, $message, $headers);
				}
				
				
				
			  
		}   

	
	
	
	

}
