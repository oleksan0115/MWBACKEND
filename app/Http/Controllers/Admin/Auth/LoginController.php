<?php
namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\APIController;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Alert\AlertController;
use Closure;
use Session;
class LoginController extends APIController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;
  
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	
	
   
    public function adminLogin(Request $request)
    {   
	$user = User::where([
					  ['user_name', '=', $request['user_name']],
					  ['password', '=', $request['password']],
					  ])
					  ->first();
		
	

		
	if($user != null)
		{
			Auth::login($user);
			
			if (auth()->user()->isadmin == 1) {
			    $token = JWTAuth::fromUser($user);
                //Session::flash('success','Welcome '.Auth::user()->name);
            
            	//return view('dashboard')->with('start', 'kkk');
	
                //return redirect()->route('dashboard');
                
                $username = $user['user_name'];
                $image = $user['image'];
                $userid = $user['user_id'];
                Session::put('username', $username);
                Session::put('image', $image);
              Session::put('user_id', $userid);
                return \Redirect::route('dashboard');
			
            }
			else{
               return redirect()->back()->with('error',"You Don't Have Admin Access.");
			 }
		}
		else
		{
		 return redirect()->back()->with('error','Username And Password Not Exist.');
		}
	
	
          
    }
	
	
	public function adminLoginPage(Request $request)
    {   
        return view('layouts.auth.login');   
    }
	
    
    	public function logout(Request $request)
    {   
        
        Session::flush();
       return redirect()->route('adminLogin')->with('success',"Logout Successfully.");  
    }
	
	
	 
}
