<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\APIController;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use App\UserBackup;
use App\VpFavouriteList;
use App\AddEmailConfirmation;
use App\TblEmailTemplate;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Twilio\Rest\Client;
use App\Http\Controllers\Alert\AlertController;

class RegisterController extends APIController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
	
	
		 /* 
     * Json return 
     * 
     * Service valling url
     * http://144.208.70.141/~mouse/mousewaitnew/backend/api/v1/auth/register
     * 
     * check these parameters for register get Json data
	 * @username         (Required)
     * @email         	 (Required)
     * @password      l  (Required)   
     * @appname      l  (Required)   
     * @type      l  	Type   
     * @version      l  Version 
     * @park      l  Park   
     * Return  rrror , message  
     * */ 
	 
	public function register(Request $request)
    {
		 
        $validator = Validator::make($request->all() , [

        // 'username' => 'required|regex:/^[a-zA-Z0-9]+$/u|max:255',  
		'email' => 'required|string|email|max:255', 
		// 'password' => 'required|string|min:6', 
		
		]);
		
		
        if ($validator->fails())
        {
            return $this->responseUnprocessable($validator->errors());
        }

					
		$requested = json_decode(file_get_contents('php://input'), true);
		$countarray = count($requested);
		
		 if($countarray > 0)
       {

			
			$username = $requested['username'];
			$user_email = $requested['email'];
			$user_password = $requested['password'];
			$user_park = $requested['park'];
			$appname = $requested['appname'];
			$version = $requested['version'];
			$type = $requested['type'];
			
		
			

			
			
	
		   if(!empty($username) and !empty($user_email) and !empty($user_password))
		   {			
				
	           
							$entry = new User;  //insert user  entry
							$username_check = $this->is_user_name_exist($username);
							if($username_check ==  'false')
							{
							return response()->json(['status' => 200, 'data' => 'User name already exist']);
							}
							
							$useremail_check = $this->is_user_email_exist($user_email);
							if($useremail_check ==  'false')
							{
							return response()->json(['status' => 200, 'data' => 'Email already exist']);
							}
							
						
								
							$datetime = date("Y-m-d H:i:s");
							$timestamp = strtotime($datetime);
							$time = $timestamp + (6* 60 * 60) - (30 * 60) + 600; //60 sec * 10 min  to add the otp duration
							$datetime = date("Y-m-d H:i:s", $time);
							
							
							
							
							$clientIP = request()->ip();
							$entry->user_name = $request['username'];
							$entry->user_email = $request['email'];
							$entry->password = request('password');
							$entry->user_status = 1;
							$entry->default_park = 'DL';
							$entry->ip_address = $clientIP;
							$entry->signup_ip_address = $clientIP;
							$entry->user_registerby = $appname;
							
							$entry->save();
							
							$lastinsertedId = $entry->user_id;

							
							
							$detail =  User::select('*')->where('user_id', $lastinsertedId)->first();
							
							$token = JWTAuth::fromUser($detail);
						
							
							$user_id = 0;
							$park_id = $this->get_vp_selected_park_by_user_id($user_id);
						
							if($park_id ==0){$park_id = 3;}
							
							
							$entryemail = new AddEmailConfirmation; //insert email entry
							$email_date = date('Y-m-d H:i');
							$entryemail->user_id = $lastinsertedId;
							$entryemail->email_date	 = $email_date;
							$entryemail->save();
							
							$entrybackup = new UserBackup;      //insert user backup entry
							$entrybackup->user_id = $lastinsertedId;
							$entrybackup->user_name = $request['username'];
							$entrybackup->user_email = $request['email'];
							$entrybackup->password = request('password');
							$entrybackup->user_status = 1;
							$entrybackup->default_park = 'DL';
							$entrybackup->ip_address = $clientIP;
							$entrybackup->signup_ip_address = $clientIP;
							$entrybackup->user_registerby = $appname;
							
							$entrybackup->save();
							
							
							$myVar = new AlertController();
							$alertSetting = $myVar->sucessRegistartion($lastinsertedId,$username,$user_email,$user_password);
							
							return response()
							->json(['status' => 201,
							'message' => 'Authorized.',  
							'data' => $detail,
							'access_token' => $token,
							'token_type' => 'bearer', 
							'expires_in' => auth()->factory()->getTTL(), 
							'park_id' => $park_id]);
							
							
				
							
				
	      			  
		    }
	        
	   }
	
		
    }



	public function is_user_name_exist($username)
    {

		$user_name_check = User::where('user_name', '=', $username)->first();
			if ($user_name_check === null) { return  'true'; } else { return 'false'; }
	}
	
	public function is_user_email_exist($user_email)
    {

		$user_email_check = User::where('user_email', '=', $user_email)->first();
			if ($user_email_check === null) { return  'true'; } else { return 'false'; }
	}
	
	public function get_vp_selected_park_by_user_id($user_id = 0)
    {
	
		$park_id = VpFavouriteList::select('park_id')->where('user_id', $user_id)->get();
		if ($park_id === null) { return  0; } else { return 0; }
	
	}
    

}