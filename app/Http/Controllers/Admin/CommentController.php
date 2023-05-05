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

class CommentController extends APIController
{
	
	
    public function reportedComment(Request $request)
    {
		
		
		$delete_product_id = $request->id;
		$action = $request->action;
		
		if ($action =='restore') { 	 
		Comment::where('chat_reply_id', $delete_product_id)->update(['chat_reply_status' => 0]);		
		return redirect()->back()->with('message', 'Comment Restore Successfully');
		}
		
		if ($action =='delete') { 	 
		Comment::where('chat_reply_id', $delete_product_id)->update(['chat_reply_status' => 2]);		
		return redirect()->back()->with('message', 'Comment Delete Successfully');
		}
        
        	$reported_comment_detail = TblReport::select('id','chat_id','user_id','user_name as repusername','type','createdon','reasion_for_report')
        	                                   
        	                                   ->with('comments')
        	                                   ->with('comments.commentuser')
        	                                   ->where('type','R')
        	                                   ->orderBy('createdon', 'DESC')->paginate(50);
            
          
           
		    return view('layouts/reportedcomment')->with('reports', $reported_comment_detail);

    }
    
  

	
}
