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
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Alert\AlertController;

class DashboardController extends APIController
{
	
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    
	// public function __construct()
    // {
        // $this->middleware('auth');
    // }


    public function dashboard(Request $request )
    {
       //dd(Session::put('user_id', Auth::user()->user_id));
	// dd('kkk');
      //dd($request);
	// dd('dddd');
       // if (Auth::attempt(['email' => $email, 'password' => $password])) {
    
         // return redirect()->intended('dashboard');
      // }
	 // $data = $this->activeUser();
	  //dd($data);
	    //$nActive_Users_counts = $this->activeUser();
	    //dd($nActive_Users_counts);
	    
	    	
	    	//  dd($request);
	    //dd(Session::get('username'));
	    
	   // $ussername = Session::get('username');
	    //$image = Session::get('image');
	    	
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
								

			
		
		return view('layouts/content')
	
		->with('startdate', $startdate)
		->with('enddate', $enddate)
		->with('getpostcountbyday', $nPost_counts)
	    ->with('getcommentcountbyday', $nComments_Results)
	    ->with('getreplycountbyday', $nReplies_Results)
	     ->with('getlikecountbyday', $nLikes_Results)
	     ->with('getthankyoucountbyday', $nThanks_counts)
	     ->with('getcommentlikecountbyday', $nComments_Likes_counts)
	     ->with('getactiveusercountbyday', $nActive_Users_counts);
	    
	    //return view('layouts/common/header')->with('username', $ussername)->with('image', $image);
	    
	    
	    
	    
	

    }
	
  
    public function reportedComment(Request $request)
    {
        
        	$reported_comment_detail = TblReport::select('id','chat_id','user_id','user_name as repusername','type','createdon','reasion_for_report')
        	                                   
        	                                   ->with('comments')
        	                                   ->with('comments.commentuser')
        	                                   ->where('type','R')
        	                                   ->orderBy('createdon', 'DESC')->paginate(50);
            
          
           
		    return view('layouts/reportedcomment')->with('reports', $reported_comment_detail);

    }
    
    
 
    

	
}
