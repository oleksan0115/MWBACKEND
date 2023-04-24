<?php
namespace App\Http\Controllers\Auth;

// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use JWTAuth;
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

    public function login()
    {
       

        $requested = json_decode(file_get_contents('php://input') , true);
        if (count($requested) > 0)
        {

            $username = $requested['username'];
            $password = $requested['password'];
     

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
                else
                {
					 $user = User::where([
								  ['user_name', '=', $userdata['user_name']],
								  ['password', '=', $userdata['password']],
								  ])
								  ->first();
								 
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

                    ]);
		
                }
            }
           
        }
        else
        {
            return response()->json(['status' => 200,'data' => 'Required information missing']);

        }

    }



	 public function loginWithUserId(Request $request)
    {
		
		$id = $request->user;
		$page = $request->page;
       	$userdata = User::where([['user_id', '=', $id ],])->select('user_id','user_email','password','user_name','image')->first();
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
				
				if($page == ''){
				$url = "https://mousewait.xyz/mousewaitnew/disneyland/lounge/";
				}
				else
				{
				$url = "https://mousewait.xyz/mousewaitnew/disneyland/user/$id/mypost";    
				}
						
				
				 return '<script>
		localStorage.setItem("token","'.$token.'");
        localStorage.setItem("user_id","'.$userdata['user_id'].'");
        localStorage.setItem("user_name","'.$userdata['user_name'].'");
        localStorage.setItem("email","'.$userdata['user_email'].'");
        localStorage.setItem("image","'.$userdata['image'].'");
        localStorage.setItem("loginfrommobile","true");
		location.replace("'.$url.'");
		</script>';
			
        

    }


	
}