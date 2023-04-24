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
use App\TblMwTempCredit;
use App\TblTriviaAppStorePurchase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Alert\AlertController;
use App\Http\Controllers\Alert\RankController;
use App\Http\Controllers\Common\CommonController;


class MobileController extends Controller
{
	/*https://www.mousewait.xyz/mousewaitnew/backend/api/v1/updateCreditByUserId.php?user_id=38&credit=1500&amount=34.99&transaction_id=131232321312&isSandbox=0&apptype=DL&version=7&appname=disneyland */
	
	public function updateCreditByUserId(Request $request)
	{
		$receipt_id = "";
		$user_id_param =0;
		$flage = "0"; 
		$return_value = "0";   // 0 error not done ,  1 successfully done  , 2 not complete data received. data received  , 3 Data enter in temp table.
		$joinstatus_param = 0 ;
		$current_game_name = '';
		$current_game_owner_id = 0;
		$isSandbox = false;   
		$temp_credit_id = 0;
		$CreditBeforeBuy = 0;
		$NewCreditBalance = 0;
		$msg = "";
		$appversion ='11';
		$appname = 'disneyland';
		

		//ye receipt sahi h
/* 		$receipt_id = "eyJzaWduYXR1cmUiID0gIkFoaHEwbmFxaG01ci8wSUNuYk9hVThCeVBLNkRja2ZsanRCMDNnZUh4dk0ybEVjVkdqK2NVM1lnWGZ0RkZCZ2lFYkR1NGdoYXFVWFRqRzlpc25Zeit6VWFhTXRUZDJ6YnNLbFhIMitzYm1ZaC9tY2M2eWt3dVFkaFZsOWZKYkxNaFVXWHNTUlIxVlVjQlE4TkxjVGg5ZHNXOTVTREcxdG9DQk45cWM0L01CZlVBQUFEVnpDQ0ExTXdnZ0k3b0FNQ0FRSUNDQnVwNCtQQWhtL0xNQTBHQ1NxR1NJYjNEUUVCQlFVQU1IOHhDekFKQmdOVkJBWVRBbFZUTVJNd0VRWURWUVFLREFwQmNIQnNaU0JKYm1NdU1TWXdKQVlEVlFRTERCMUJjSEJzWlNCRFpYSjBhV1pwWTJGMGFXOXVJRUYxZEdodmNtbDBlVEV6TURFR0ExVUVBd3dxUVhCd2JHVWdhVlIxYm1WeklGTjBiM0psSUVObGNuUnBabWxqWVhScGIyNGdRWFYwYUc5eWFYUjVNQjRYRFRFME1EWXdOekF3TURJeU1Wb1hEVEUyTURVeE9ERTRNekV6TUZvd1pERWpNQ0VHQTFVRUF3d2FVSFZ5WTJoaGMyVlNaV05sYVhCMFEyVnlkR2xtYVdOaGRHVXhHekFaQmdOVkJBc01Fa0Z3Y0d4bElHbFVkVzVsY3lCVGRHOXlaVEVUTUJFR0ExVUVDZ3dLUVhCd2JHVWdTVzVqTGpFTE1Ba0dBMVVFQmhNQ1ZWTXdnWjh3RFFZSktvWklodmNOQVFFQkJRQURnWTBBTUlHSkFvR0JBTW1URXVMZ2ppbUx3Ukp4eTFvRWYwZXNVTkRWRUllNndEc25uYWwxNGhOQnQxdjE5NVg2bjkzWU83Z2kzb3JQU3V4OUQ1NTRTa01wK1NheWc4NGxUYzM2MlV0bVlMcFduYjM0bnF5R3g5S0JWVHk1T0dWNGxqRTFPd0Mrb1RuUk0rUUxSQ21lTnhNYlBaaFM0N1QrZVp0REVoVkI5dXNrMytKTTJDb2dmd283QWdNQkFBR2pjakJ3TUIwR0ExVWREZ1FXQkJTSmFFZU51cTlEZjZaZk42OEZlK0kydTIyc3NEQU1CZ05WSFJNQkFmOEVBakFBTUI4R0ExVWRJd1FZTUJhQUZEWWQ2T0tkZ3RJQkdMVXlhdzdYUXd1UldFTTZNQTRHQTFVZER3RUIvd1FFQXdJSGdEQVFCZ29xaGtpRzkyTmtCZ1VCQkFJRkFEQU5CZ2txaGtpRzl3MEJBUVVGQUFPQ0FRRUFlYUpWMlU1MXJ4ZmNxQUFlNUMyL2ZFVzhLVWw0aU80bE11dGE3TjZYelAxcFpJejFOa2tDdElJd2V5Tmo1VVJZSEsrSGpSS1NVOVJMZ3VObDBua2Z4cU9iaU1ja3dSdWRLU3E2OU5JbnJaeUNENjZSNEs3N25iOWxNVEFCU1NZbHNLdDhvTnRsaGdSLzFralNTUlFjSGt0c0RjU2lRR0tNZGtTbHA0QXlYZjd2bkhQQmU0eUN3WVYyUHBTTjA0a2JvaUozcEJseHNHd1YvWmxMMjZNMnVlWUhLWUN1WGhkcUZ3eFZnbTUyaDNvZUpPT3Qvdlk0RWNRcTdlcUhtNm0wM1o5YjdQUnpZTTJLR1hIRG1PTWs3dkRwZU1WbExEUFNHWXoxK1Uzc0R4SnplYlNwYmFKbVQ3aW16VUtmZ2dFWTd4eGY0Y3pmSDB5ajV3TnpTR1RPdlE9PSI7ICJwdXJjaGFzZS1pbmZvIiA9ICJld29KSW05eWFXZHBibUZzTFhCMWNtTm9ZWE5sTFdSaGRHVXRjSE4wSWlBOUlDSXlNREUxTFRFeExUSXpJREE0T2pNeU9qSTNJRUZ0WlhKcFkyRXZURzl6WDBGdVoyVnNaWE1pT3dvSkluVnVhWEYxWlMxcFpHVnVkR2xtYVdWeUlpQTlJQ0psTkRjME1qVmtaamRtWWpaaFlqaGpNMk0zWlRVM016QmpNMkUzWldJMVlqWTFOak00TWpOa0lqc0tDU0p2Y21sbmFXNWhiQzEwY21GdWMyRmpkR2x2YmkxcFpDSWdQU0FpTVRBd01EQXdNREU0TVRRNU1qVTFOeUk3Q2draVluWnljeUlnUFNBaU15STdDZ2tpZEhKaGJuTmhZM1JwYjI0dGFXUWlJRDBnSWpFd01EQXdNREF4T0RFME9USTFOVGNpT3dvSkluRjFZVzUwYVhSNUlpQTlJQ0l4SWpzS0NTSnZjbWxuYVc1aGJDMXdkWEpqYUdGelpTMWtZWFJsTFcxeklpQTlJQ0l4TkRRNE1qazJNelEzTVRNNElqc0tDU0oxYm1seGRXVXRkbVZ1Wkc5eUxXbGtaVzUwYVdacFpYSWlJRDBnSWpWRE1qYzFRalZCTFRORk5qWXROREF5TmkwNU5USXpMVGcwTlVJeU1qVTNOVFZHUXlJN0Nna2ljSEp2WkhWamRDMXBaQ0lnUFNBaWNIVnlZMmhoYzJWeUxtTnZibk4xYldGaWJHVkdaV0YwZFhKbElqc0tDU0pwZEdWdExXbGtJaUE5SUNJeE1EWXhOVFUzTkRnMElqc0tDU0ppYVdRaUlEMGdJbU52YlM1bGN5NVFkWEpqYUdGelpYSWlPd29KSW5CMWNtTm9ZWE5sTFdSaGRHVXRiWE1pSUQwZ0lqRTBORGd5T1RZek5EY3hNemdpT3dvSkluQjFjbU5vWVhObExXUmhkR1VpSUQwZ0lqSXdNVFV0TVRFdE1qTWdNVFk2TXpJNk1qY2dSWFJqTDBkTlZDSTdDZ2tpY0hWeVkyaGhjMlV0WkdGMFpTMXdjM1FpSUQwZ0lqSXdNVFV0TVRFdE1qTWdNRGc2TXpJNk1qY2dRVzFsY21sallTOU1iM05mUVc1blpXeGxjeUk3Q2draWIzSnBaMmx1WVd3dGNIVnlZMmhoYzJVdFpHRjBaU0lnUFNBaU1qQXhOUzB4TVMweU15QXhOam96TWpveU55QkZkR012UjAxVUlqc0tmUT09IjsiZW52aXJvbm1lbnQiID0gIlNhbmRib3giOyJwb2QiID0gIjEwMCI7InNpZ25pbmctc3RhdHVzIiA9ICIwIjt9"; */
		
		$ip_address = $_SERVER['REMOTE_ADDR'] ;
		$user_id_param = $request->user_id;
		$credit_param = $request->credit;
		$amount_param = $request->amount;
		$transaction_id_param = $request->transaction_id;
		$receipt_id = $request->transactionReceipt;
		$isSandbox = $request->isSandbox == true ? 'true':'false';
		$appversion = $request->version;
		$apptype = $request->apptype;
		$appname = $request->appname;
		
		
			
		
			
		
		if( $user_id_param < 1 and $credit_param < 1 and  $amount_param < 1 and !empty($transaction_id_param)) 
		{
		//echo $return_value = 2 ; // Incomplete data 
		$msg = "Incompleted data sent to server.";
		$result = array(['message' => $msg]);
		return response()->json(['status' => 201, 'data' =>	$result ]);
		}
		
		
		$userdata =  User::select('*')->where([['user_id', '=', $user_id_param ]])->first();		  
		$CreditBeforeBuy = $userdata->user_credits; 
		$NewCreditBalance = $userdata->user_credits; 
		
		
		
		
		if($user_id_param > 0 and !empty($transaction_id_param) and $receipt_id != null )
		{
					$noofrows_cd = 0;
					
					$user_Res = static::get_user_detail($user_id_param);
					
					$noofrows = count($user_Res); 	
		
					if($noofrows > 0)
					{		
						$user_name = $user_Res[0]['user_name'];  
						$CreditBeforeBuy = $user_Res[0]['user_credits']; 
						$NewCreditBalance = $user_Res[0]['user_credits']; 
					}   
				
					$sql = "select no_of_times from  admin_credits_setting where id= 1 and status = 1 and  (now() between start_date and end_date)";
					$res = DB::select($sql);
					$nRest = count($res);
				 
					if($nRest > 0)
					{
						$no_of_times = $res[0]->no_of_times;
						$credit_param = round(($credit_param * $no_of_times),2); 
					}  
					
					/* $sql = "select * from  tbl_user where user_id = 38";
					$res = DB::select($sql);
					$nRest = count($res);
			
					if($nRest > 0)
					{
						$no_of_times = $res[0]->user_name;
						
					} 
					dd($no_of_times); */
					
					
					$qry_cd =  TblMwCreditDetail::select('*')->where([['user_id', '=', $user_id_param ],['paypal_transaction_id', '=', $transaction_id_param ]])->get();
				
					$noofrows_cd = count($qry_cd); 	
					
					if ($noofrows_cd > 0) {
						
					    $return_value = 1; // Mean Data Already enter in temp table 
						$msg = "This Transaction id already used.";
						$result = array([
						'message' => $msg,
						'status' => $return_value,
						'CreditBeforeBuy' => $CreditBeforeBuy,
						'NewCreditBalance' => $NewCreditBalance,
						'CrieditUserBuy' => $user_id_param
						]);
						return response()->json(['status' => 201, 'data' =>	$result ]);
						
					 } 
					 else
					 {   
						$entry = new TblMwTempCredit;  
						$entry->user_id = $user_id_param;
						$entry->credits = $credit_param;
						$entry->amount = $amount_param;
						$entry->ip_address = $ip_address;
						$entry->status = 1;
						$entry->createdon = NOW();
						$entry->order_from = $apptype;
						$entry->user_name = $user_name;
						$entry->transaction_id = $transaction_id_param;
						$entry->apptype = $apptype;
						$entry->appname = $appname;
						$entry->appversion = $appversion;
						$entry->save();
						
						$temp_credit_id=$entry->id; // last inserted id
						
						
						$return_value = 3; // Mean Data enter in temp table 
						 
						$noofrows_cd = 0;
						
						$mw_credits_detail_id = 0;
						
						$cd_Res2 =  TblMwCreditDetail::select('*')->where([['user_id', '=', $user_id_param ],['paypal_transaction_id', '=', $transaction_id_param ]])->get();
				
						$noofrows_cd = count($cd_Res2); 	
								
						 if ($noofrows_cd == 0) 
						 { 			
							if($temp_credit_id > 0)
							{
								//  1 ;Successfully done   
								 $mw_credits_detail_id = static::UpdateCredits($user_id_param , $credit_param , $amount_param , $transaction_id_param ,  $receipt_id , $temp_credit_id ,$temp_credit_id ,$apptype ,$appversion , $appusername='') ;  
						
								 // $return_value = 1 ; // Error not done 
							}   
							
							if($apptype=='android'){
							$result = array([
							'message' => '',
							'status' => $return_value,
							'CreditBeforeBuy' => $CreditBeforeBuy,
							'NewCreditBalance' => $NewCreditBalance,
							'CrieditUserBuy' => $user_id_param
							]);
							return response()->json(['status' => 201, 'data' =>	$result ]);


							}
							
							else
							{
							$info = static::getReceiptData($mw_credits_detail_id , $user_id_param , $credit_param,$receipt_id , $transaction_id_param , $appversion , $apptype ,$ip_address ,$isSandbox );
							
							
							
						   if($info == 0)
							{
							$msg = "unable to verify receipt, or receipt is not valid";
							}

							else if(sizeof($info) > 0)
							{
							
								$quantity =	$info['quantity'];
								$product_id =	$info['product_id'];
								$transaction_id =	$info['transaction_id'];
								$purchase_date =	$info['purchase_date'];
								$app_item_id =	$info['item_id'];
								$bid =	$info['bid'];
								$bvrs =	$info['bvrs'];
								
						 		$entry = new TblTriviaAppStorePurchase;  
								$entry->quantity = $quantity;
								$entry->product_id = $product_id;
								$entry->transaction_id = $transaction_id;
								$entry->purchase_date = $purchase_date;
								$entry->app_item_id = $app_item_id;
								$entry->bid = $bid;
								$entry->bvrs = $bvrs;
								$entry->receipt_id = $receipt_id;
								$entry->save(); 
								
								$apps_trans_id=$entry->id; // last inserted id
								$msg = "Successs";
						 
							 	
							} 
								$userdata =  User::select('*')->where([['user_id', '=', $user_id_param ]])->first();		  
								$CreditBeforeBuy = $userdata->user_credits; 
								$NewCreditBalance = $userdata->user_credits; 
								$result = array([
								'message' => $msg,
								'status' => 1,
								'CreditBeforeBuy' => $CreditBeforeBuy,
								'NewCreditBalance' => $NewCreditBalance,
								'CrieditUserBuy' => $user_id_param
								]);
								return response()->json(['status' => 201, 'data' =>	$result ]);
							
							
							}
						
							// receipt is valid, now do something with $info
							
						 } 
			
					}  
        }
		
		else
		{
		$msg = "unable to verify receipt, or receipt is not valid";
		$result = array([
		'message' => $msg,
		'status' => 0,
		'CreditBeforeBuy' => $CreditBeforeBuy,
		'NewCreditBalance' => $NewCreditBalance,
		'CrieditUserBuy' => $user_id_param
		]);
		return response()->json(['status' => 201, 'data' =>	$result ]);	
		}
        
		

	
	}
	
	
	
	function get_user_detail($user_id_param){
		if($user_id_param > 0)
		{
			$qry_user =  User::select('*')->where([['user_id', '=', $user_id_param ],['user_status', '=', 1 ]])->get();
			 
			if($qry_user)
			{
				return $qry_user;
			}
			else
			{
				return false;	
			}
			
		}
	}
	
	
	function UpdateCredits($user_id_param , $credit_param , $amount_param , $transaction_id_param , $receipt_id ,  $apps_trans_id , $temp_credit_id ,$apptype ,$appname , $appversion ){
	

		$ip_address = $_SERVER['REMOTE_ADDR'] ;
				
				$user_Res = static::get_user_detail($user_id_param);
					
				$noofrows = count($user_Res); 	
				
				
				$noofrows_cd = 0;
	
				$current_balance_atthis_point = $user_Res[0]['user_credits']; 
				$current_rank_atthis_point = $user_Res[0]['rank'];
				
				$cd_Res3 =  TblMwCreditDetail::select('*')->where([['user_id', '=', $user_id_param ],['paypal_transaction_id', '=', $transaction_id_param ]])->get();
				
				$noofrows_cd = count($cd_Res3); 
				 
				 if ($noofrows_cd == 0) 
				 {
				     User::where('user_id', $user_id_param)->update(['user_credits' => \DB::raw('user_credits + '.$credit_param.'')]);				
					
					$description ="Credits updated from Apps";
					// $description ="Credits updated from trivia Apps. tbl_trivia_appstore_purchases table Id is  :".$apps_trans_id;
					
					$entry = new TblMwCreditDetail;  
					$entry->user_id = $user_id_param;
					$entry->credits = $credit_param;
					$entry->type = 'cash';
					$entry->points_used = 0;
					$entry->amount = $amount_param;
					$entry->ip_address = $ip_address;
					$entry->status = 1;
					$entry->createdon = NOW();
					$entry->paypal_transaction_id = $transaction_id_param;
					$entry->appsstore_receipt_id = $receipt_id;
					$entry->paypal_payer_email = '';
					$entry->paypal_receiver_email = '';
					$entry->description = $description;
					$entry->current_rank_atthis_point = $current_rank_atthis_point;
					$entry->current_balance_atthis_point = $current_balance_atthis_point;
					$entry->apptype = $apptype;
					$entry->appname = $appname;
					$entry->appversion = $appversion;
					$entry->save();
					$mw_credits_detail_id=$entry->id; // last inserted id
 								
			
					TblMwTempCredit::where('id', $temp_credit_id)->update(['status' => 2]);	
					return $return_value = $mw_credits_detail_id ; 	// ok Done completely.
				}
				else
				{ 
					 return $msg = "This Transaction id already used.";
				}
				
			 
				
	} 
	
	function getReceiptData(  $mw_credits_detail_id , $user_id_param ,$credit_param,$receipt_id , $transaction_id_param , $appversion , $apptype ,$ip_address ,$isSandbox ) {
	
		
		$receipt  = $receipt_id ;
		
		
        // determine which endpoint to use for verifying the receipt
        if ($isSandbox) {
		
            $endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt';
        }
        else {
            $endpoint = 'https://buy.itunes.apple.com/verifyReceipt';
        }
		

        // build the post data
        $postData = json_encode(
            array('receipt-data' => $receipt)
        );
 
//echo 'Post Data :<br> ';
 //print_r($postData);
// echo '<br> <br> ';
 
        // create the cURL request
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
 
        // execute the cURL request and fetch response data
        $response = curl_exec($ch);
        $errno    = curl_errno($ch);
        $errmsg   = curl_error($ch);
        curl_close($ch);
 
        // ensure the request succeeded
        if ($errno != 0) {
            throw new Exception($errmsg, $errno);
        }
 
        // parse the response data
        $data = json_decode($response);
		
	// ensure response data was a valid JSON string
        if (!is_object($data)) {
            throw new Exception('Invalid response data');
        }
		
 
  /*  echo 'Return Data :<br> ';	
	print_r($data);
 exit; */
        // ensure the expected data is present
        if (!isset($data->status) || $data->status != 0) { 
			
		
			
			User::where('user_id', $user_id_param)->update(['user_credits' => \DB::raw('user_credits - '.$credit_param.'')]);
			
			TblMwCreditDetail::where([['id', '=', $mw_credits_detail_id]])->delete();

			$my_message  = "Hi Admin";
			$my_message .= " New Pament from apps store has be denied here is the detail"."<br><br>";
			$my_message .= " Mw Credits detail id : ".$mw_credits_detail_id."<br><br>";
			$my_message .= " Update Credits : ".$credit_param."<br><br>";
			$my_message .= " User id  :  ".$user_id_param."<br><br>";
			$my_message .= " Transaction id : ".$transaction_id_param."<br><br>";
			$my_message .= " Apps Type  : ".$apptype."<br><br>";
			$my_message .= " Version  : ".$appversion."<br><br>";
			$my_message .= " IP Address  : ".$ip_address."<br><br><br>";
			// $my_message .= " Encrypted Receipt Id  : ".$receipt."<br><br>";  
		 	
		 	$subject  = "Unvarified AppsStore Trans id for Credits ";
		 	$user_email ="bagra.manish@gmail.com";
			// $myVar = new AlertController();
			// $alertSetting = $myVar->emailForUpdateUserCredit($user_email, $my_message , $subject);
			
		
			 	return 0;	
             // throw new Exception('Invalid receipt');
        } 
      
        // build the response array with the returned data
			return array(
            'quantity'       =>  $data->receipt->quantity,
            'product_id'     =>  $data->receipt->product_id,
            'transaction_id' =>  $data->receipt->transaction_id,
            'purchase_date'  =>  $data->receipt->purchase_date,
            'item_id'   	 =>  $data->receipt->item_id,
            'bid'            =>  $data->receipt->bid,
            'bvrs'           =>  $data->receipt->bvrs
        ); 
    } 
	
}


	
