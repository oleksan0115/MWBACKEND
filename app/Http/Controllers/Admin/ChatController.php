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

class ChatController extends APIController
{
	
	

    
    public function reportedChat(Request $request)
    {
		
		
			$delete_product_id = $request->id;
		$action = $request->action;
		
		if ($action =='restore') { 	 
		TblChat::where('chat_id', $delete_product_id)->update(['chat_status' => 0]);		
		return redirect()->back()->with('message', 'Post Restore Successfully');
		}
		
		if ($action =='delete') { 	 
		TblChat::where('chat_id', $delete_product_id)->update(['chat_status' => 3]);		
		return redirect()->back()->with('message', 'Post Delete Successfully');
		}
		
		
        
        	$reported_chat_detail = TblReport::select('id','chat_id','user_id','user_name as repusername','type','createdon','reasion_for_report')
        	                                   
        	                                   ->with('chat')
        	                                   ->with('chat.user')
        	                                   ->where('type','C')
        	                                   ->orderBy('createdon', 'DESC')->paginate(50);
            
         
		    return view('layouts/reportedchat')->with('reports', $reported_chat_detail);

    }
    
    
   

	
}
