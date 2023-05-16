<?php
namespace App\Http\Controllers\Auth;

// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use JWTAuth;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use App\LoginUserTracking;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Alert\AlertController;

class LoginController extends APIController
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
			$username = $request->username;
            $password = $request->password;
            $loginfrom = $request->loginfrom;
     
			if($loginfrom == 'webview')
			{
				$loginfrom = true;
			}
			else
			{
				$loginfrom = false;
			}
	 

            if (!empty($username) and !empty($password))
            {

                 $userdata = User::select('*')->where([
								  ['user_name', '=', $username],
								  ['password', '=', $password],
								  ])->first();
		
		
				
                if ($userdata === null)
                {
                    return response()->json(['status' => 200,'data' => 'Invalid user or password!']);
                }
				else if($userdata->user_status == 2)
                {
                    return response()->json(['status' => 200,'data' => 'Your Account Deleted!']);
                }
                else
                {
					Auth::login($userdata);
								 
					$token = JWTAuth::fromUser($userdata);
					
					/* to track user login every time */
						
						$ip_address =$_SERVER['REMOTE_ADDR'];
			
						$track_user_detail = LoginUserTracking::whereDate('login_datetime', today())
					                         ->where('user_id', $userdata['user_id'])
					                         ->count();
										
						
						
							if($track_user_detail == 0){
							$entry = new LoginUserTracking;  
							$entry->user_name = $userdata['user_name'];
							$entry->user_id = $userdata['user_id'];
							$entry->login_datetime = NOW();
							$entry->ip_address = $ip_address;
							$entry->mac_address = '';
							$entry->login_from = 'web Lounge auto login';
							$entry->no_of_login_from_ip = 1;
							$entry->status = 1;
							$entry->save();
							}
						/* to track user login every time */

                    return response()
                        ->json(['status' => 201,
								'message' => 'Authorized.', 
								'access_token' => $token,
								'token_type' => 'bearer', 
								//'expires_in' => auth()->factory()->getTTL() * 60, // 60 se multiply to get in seconds
								'expires_in' => auth()->factory()->getTTL(),  // to get in minutes for 180 days
								'data' => $userdata,
								'loginfrom' => $loginfrom,

                    ]);
		
                }
            }
           
        

    }



	 public function loginWithUserId(Request $request)
    {
	
		$id = $request->user;
		$page = $request->page;
		$source = $request->source;
		$islogin = $request->islogin;
	 	$loginfrom = $request->loginfrom;
	 	$access = $request->access;
		
		
		if($access == 'app')
		{
			$access = 'app';
		}
		else
		{
			$access = 'browser';
		}
		
		
		
		if($loginfrom == 'webview')
		{
			$loginfrom = 'true';
		}
		else
		{
			$loginfrom = 'false';
		}
	 
		if($islogin == '')
		{
		$userdata = User::where([['user_id', '=', $id ],])->select('*')->first();
		if($userdata->user_status == 1){
		$token = JWTAuth::fromUser($userdata);
		/* to track user login every time */
			
			$ip_address =$_SERVER['REMOTE_ADDR'];

			$track_user_detail = LoginUserTracking::whereDate('login_datetime', today())
								 ->where('user_id', $userdata['user_id'])
								 ->count();
							
			
			
				if($track_user_detail == 0){
				$entry = new LoginUserTracking;  
				$entry->user_name = $userdata['user_name'];
				$entry->user_id = $userdata['user_id'];
				$entry->login_datetime = NOW();
				$entry->ip_address = $ip_address;
				$entry->mac_address = '';
				$entry->login_from = 'web Lounge auto login';
				$entry->no_of_login_from_ip = 1;
				$entry->status = 1;
				$entry->save();
				}
				
				if($page != ''){
				$url = env('APP_URL_NEW')."/disneyland/user/$id/mypost"; 
				
				}
				else if($source == 'wdw')
				{
				$url = env('APP_URL_NEW')."/disneyworld/lounge";    
				}
				else{
				$url = env('APP_URL_NEW')."/disneyland/lounge/";
				}
						
				
				return '<script>
				localStorage.setItem("token","'.$token.'");
				localStorage.setItem("user_id","'.$userdata['user_id'].'");
				localStorage.setItem("user_name","'.$userdata['user_name'].'");
				localStorage.setItem("email","'.$userdata['user_email'].'");
				localStorage.setItem("image","'.$userdata['image'].'");
				localStorage.setItem("user_bio","");
				localStorage.setItem("membership_date","'.$userdata['creation_date'].'");
				localStorage.setItem("user_mw_waittime_points","'.$userdata['user_waittime_points'].'");
				localStorage.setItem("user_mw_waittime_rank","'.$userdata['user_waitrank_rank'].'");
				localStorage.setItem("user_mw_quality_rank","'.$userdata['quality_rank'].'");
				localStorage.setItem("mw_position","'.$userdata['position'].'");
				localStorage.setItem("mw_rank","'.$userdata['rank'].'");
				localStorage.setItem("user_mw_credits","'.$userdata['user_credits'].'");
				localStorage.setItem("loginfrommobile","true");
				localStorage.setItem("loginfrom","'.$loginfrom.'");
				localStorage.setItem("access","'.$access.'");
				location.replace("'.$url.'");
				</script>';
			
        		

		}
		else{
			return response()->json(['status' => 200,'data' => 'Invalid Account or Deleted!']);
		}
	
		}
		
		else if($source == 'wdw' && $islogin != '')
		{
		$url = env('APP_URL_NEW')."/disneyworld/lounge/";
			return '<script>
			localStorage.clear();
			localStorage.setItem("access","'.$access.'");
			location.replace("'.$url.'");
			</script>';	
		}
	
		else
		{
		$url = env('APP_URL_NEW')."/disneyland/lounge/";
			return '<script>
			localStorage.clear();
				localStorage.setItem("access","'.$access.'");
			location.replace("'.$url.'");
			</script>';	
		}
	}
	
}