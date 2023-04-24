<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Alert\AlertController;
class ResetPasswordController extends APIController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /* Forget password Work Start */

    /* Forget password Work end */

    // public function __construct()
    // {
        // $this->middleware('guest');
    // }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

   
	

	
    public function reset(Request $request){
		
		 $useremail  = $request['email'];
		 $user_email = User::where('user_email', $useremail)->exists();
	
	
		 if ($user_email)
        {
		 $detail     = User::select('user_id','user_name')->where('user_email', $useremail)->get();
		 $user_id = $detail[0]['user_id'];
		 $user_name = $detail[0]['user_name'];
		 $resetkey = str_random(30);
			
		$updateDetails = [ 'reset_password_key' => $resetkey ];
			
		\DB::table('tbl_user')->where('user_email', $useremail)->update($updateDetails);
		
		$finalarray = array();
		$rawarray = array();
		$rawarray['user_id'] = $user_id;
		$rawarray['resetkey'] = $resetkey;
		$rawarray['message'] = 'A reset password link has been sent to your email.<br />Please check your email and click on link to reset password from info@mousewait.com.';
		
		$finalarray[] = $rawarray;
		
		$myVar = new AlertController();
		
		//$alertSetting = $myVar->resetPassword($user_id,$user_name,$useremail,$resetkey);
		
		
		
		
		return response()->json(['status' => 201,'data' => $finalarray]);					
        }
		
		else
		{
	    return response()->json(['status' => 200,'data' => 'Invalid Email Address.']);
		
		}
		
			


    }
	
	public function passwordResetconfirm(Request $request) {
		
		 $user_id  = $request['user_id'];
		 $resetkey  = $request['resetkey'];
		 $password  = $request['password'];
		 $confirmpassword  = $request['confirmpassword'];
		 
		 
		 if($password == $confirmpassword)
		 {
			
		 
		
		if(!empty($resetkey))
        {
		// $decodePass = base64_decode($password);
		// $hashpassword = Hash::make($decodePass);
		$datetime = date("Y-m-d H:i:s");
		$timestamp = strtotime($datetime);
		$time = $timestamp + (6* 60 * 60) - (30 * 60) + 600; //60 sec * 10 min  to add the otp duration
		$datetime = date("Y-m-d H:i:s", $time);
		$updateDetails = [ 'password' => $password , 'reset_password_key' => '', 'date_upd' =>  $datetime];
			
		\DB::table('tbl_user')->where('user_id', $user_id)->update($updateDetails);
		 return response()->json(['status' => 201,'data' => 'Your password updated succesfully.<br />Please login to mousewait from your updated password.<br />']);					
        }
		
		else
		{
		return response()->json(['status' => 200,'data' => 'your password already updated from this url.<br />  please send email from reset password form to again reset password. <br />']);		
		}
		
		}
		else 
		{
		return response()->json(['status' => 200,'data' => 'passowrd and confirm password not Match']);		
		}

    }

	public function changePassword(Request $request) { 	
			$user = auth()->user();
			if($user != null ){
			$user_id = $user->user_id;
			$tbox_curr_pass = $request['password_old'];	 
			$tbox_new_pass = $request['password_new'];	  
			$ip_address =  request()->ip();
			
				if ($tbox_curr_pass !='' && $tbox_new_pass!='' )
				{
				$get_user_data = User::where([ ['user_id', '=', $user_id], ])->select('*')->first();
				$passwd = $get_user_data->password;
				$user_name = $get_user_data->user_name;
				$user_email = $get_user_data->user_email;
						if($passwd == $tbox_curr_pass)
						 {
						 User::where([['user_id', '=', $user_id ]])->update(['password' => $tbox_new_pass]);
						 $myVar = new AlertController();
						 $alertSetting = $myVar->passwordChangeEmail($user_name,$user_email,$tbox_new_pass);
						 return response()->json(['status' => 200, 'data' =>	'Password Updated !' ]);							 
						 } 
						 else
						 {
							return response()->json(['status' => 200, 'data' =>	'Incorrect Current Password' ]);
						 }
				
				 }
				 else
				{
				return response()->json(['status' => 200, 'data' =>	'Current and New Passwords Are Required.' ]);	
				}
			
			}	
				
			
			else
			{
			return response()->json(['status' => 200, 'data' =>	'Please Login' ]);	
			}
			
			

					
	 

	}

	public function forgotPassword(Request $request) { 	
	$email = $request['email'];	  
	$get_user_data = User::where([ ['user_email', '=', $email], ])->select('*')->first();
	if($get_user_data != null)
	{
	$passwd = $get_user_data->password;
	$user_name = $get_user_data->user_name;
	$user_email = $get_user_data->user_email;
	$myVar = new AlertController();
	$alertSetting = $myVar->ForgotPasswordEmail($user_name,$user_email,$passwd);
	return response()->json(['status' => 200, 'data' =>'Ok Done !' ]);
	} 
	else
	{
	return response()->json(['status' => 200, 'data' =>	'Email Not Exist' ]);
	}
}




}


