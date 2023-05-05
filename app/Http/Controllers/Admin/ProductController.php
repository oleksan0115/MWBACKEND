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
use ShortPixel;
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
use App\TblMwEmojiCategory;
use App\Tag;
use App\TblUserSpecialLogo;
use App\TblUserSpecialLogoDetail;
use App\TblLeaderBoard;
use App\TblLeaderBoardDetail;
use App\TblUserRight;
use App\TblRight;
use App\TblAdvertisePost;
use App\TblSong;
use App\TblRankReport;
use App\TblAdminNews;
use App\TblRealtime;
use App\TblBofDaySuscriber;
use App\TblEmailTemplate;

use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Alert\AlertController;

class ProductController extends APIController
{
	
    //sticker product
    public function getProduct(Request $request)
    {
       	
	$delete_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='delete') { 	 
	MwProduct::where('id', $delete_product_id)->delete();  
	return redirect()->back()->with('message', 'Delete Successfully');
	}
	
	$product_detail = MwProduct::select('*')->where ([  ['status', '!=', 3],])->orderBy('id', 'DESC')->paginate(50);
	
	return view('layouts/product')->with('products', $product_detail);

    }
	
	public function getEmoji(Request $request)
    {
			$emoji_category = TblMwEmojiCategory::select('*')->get();
       
		    return view('layouts/add_product')->with('emoji', $emoji_category);

    }
	
    public function addProduct(Request $request)
    {
		
	$app = realpath(__DIR__ . '/../../../../..');
	$upload_img_dir = $app . '/disneyland/images/products_fullsize';
	$upload_img_dir_two = $app . '/disneyland/images/products_thumbnail';
    
	$msg = '';
    $owner_only = 0;
    $product_status = 0;
    $product_id_e = 0;
    $product_name = '';
    $product_desc = '';
    $product_qty = 0;
    $product_price = 0;
    $edit_product_id = 0;
	

    
	$product_start_auction_date = date("Y-m-d H:i");
    $product_end_auction_date = date("Y-m-d H:i");
    $current_datetime_on_server = date("Y-m-d H:i");
	
	
	
    
    $product_name =  $request['tboxproductName'];
    $product_desc =  $request['tAreaproductDesc'];
    $product_qty =   $request['tboxProductQty'];
    $product_price = $request['tboxproductPrice'];
	
	if (!empty($request['chkowner'])) { $chkowner = 	 $request['chkowner']; } else { $chkowner = ''; }
	if (!empty($request['chkstatus'])){ $chkstatus = 	 $request['chkstatus']; } else { $chkstatus = ''; }
	if (!empty($request['chkemojis'])) { $chkemojis = 	 $request['chkemojis']; } else { $chkemojis = ''; }
	if (!empty($request['chkisauction'])) { $chkisauction = 	 $request['chkisauction']; } else { $chkisauction = ''; }
	if (!empty($request['tboxstartdate'])) { $product_startdate = 	 $request['tboxstartdate']; } else { $product_startdate = ''; }
	if (!empty($request['tboxenddate'])) { $product_enddate = 	 $request['tboxenddate']; } else { $product_enddate = ''; }
	if (!empty($request['tboxinitialcredits'])) { $product_initialcredits = 	 $request['tboxinitialcredits']; } else { $product_initialcredits = ''; }
	if (!empty($request['tbox_active_datetime'])) { $product_active_datetime = 	 $request['tbox_active_datetime']; } else { $product_active_datetime = ''; }
	
	$ddlemojicategory = $request['ddlemojicategory'];
	
	
	$edit_product_id = $request->id;
    $action = $request->action;

	/* 	if ($action =='quantity') {
		 $product_qty = $request->update_point;
		 dd($product_qty);
	       MwProduct::where('id', $edit_product_id)
					->update(['product_quantity' => $product_qty,]);
							
		} */
	
	if(empty($product_name))
	{
		return redirect()->back()->with('message', 'Please Fill Product Name');
	}
	if(empty($ddlemojicategory))
	{
		return redirect()->back()->with('message', 'Please Select the Emoji Category!');
	}
   
							if(!empty($product_name)  and  empty($msg)){ 
							    
	 
							 
							if ($edit_product_id > 0) {
							
							MwProduct::where('id', $edit_product_id)
							->update([
							'product_name' => $product_name,
							'product_description' => $product_desc,
							'product_quantity' => $product_qty,
							'product_price' => $product_price,
							'owner_only' => $chkowner,
							'status' => $chkstatus,
							'isemojis' => $chkemojis,
							'emoji_category_id' => $ddlemojicategory,
							'isauction' => $chkisauction,
							'start_auction_date' => $product_startdate,
							'end_auction_date' => $product_enddate,
							'initial_bid' => $product_initialcredits,
							'active_datetime' => $product_active_datetime,
							]);
									
							$msg = "Upadetd Successfully";
							$product_detail = MwProduct::select('*')->where ([  ['status', '!=', 3],])->orderBy('id', 'DESC')->paginate(50);
							return redirect()->route('backend.add_product')->with('products', $product_detail)->with('successMsgdd',"Sticker Updated Successfully.");
			                // return view('layouts.product')->with('products', $product_detail)->with('successMsg',"Sticker Updated Successfully.");
							
							     
							 } else {
								
							$product_detail = MwProduct::select('*')->where ([  ['status', '!=', 3],])->orderBy('id', 'DESC')->paginate(50);
							$isNotExist = MwProduct::where([['product_name', '=', $product_name]])->select('product_name','product_description')->count();
							
			                if($isNotExist == 0){
			               
							$entry = new MwProduct;  
							$clientIP = request()->ip();
							$entry->product_name = $product_name;
							$entry->product_description = $product_desc;
						    $entry->product_quantity = $product_qty;
							$entry->product_price = $product_price;
							$entry->product_image = '';
							$entry->status = $chkstatus;
							$entry->owner_only = $chkowner;
							$entry->isemojis = $chkemojis;
							$entry->emoji_category_id = $ddlemojicategory;
							$entry->isauction = $chkisauction;
							$entry->start_auction_date = $product_startdate;
							$entry->end_auction_date = $product_enddate;
							$entry->initial_bid = $product_initialcredits;
							$entry->active_datetime = $product_active_datetime;
							$entry->save();
						   
					
							$product_id = $entry->id;
							
							if ($request->hasFile('myfile')) {
							$image = $request->file('myfile');
							// $type = $image->getClientOriginalExtension()
							$name = 'product_' . $product_id . '.' .$image->getClientOriginalExtension();
							$image->move($upload_img_dir, $name);
							MwProduct::where('id', $product_id)->update(['product_image' => $name]);
							}
							
						
							
							if ($request->hasFile('myfile_thumbnail')) {
							$image = $request->file('myfile_thumbnail');
							// $type = $image->getClientOriginalExtension()
							$name = 'product_' . $product_id . '.' .$image->getClientOriginalExtension();
							$image->move($upload_img_dir_two, $name); 
							}
							
							
							
							
							
				            $msg = "Added Successfully";
			                $product_detail = MwProduct::select('*')->where ([  ['status', '!=', 3],])->orderBy('id', 'DESC')->paginate(50);
			                return view('layouts/product')->with('products', $product_detail)->with('successMsg',"Sticker Added Successfully.");
			         

							

							
			                } 
			                else 
			                { 
			                return view('layouts/product')->with('products', $product_detail)->with('successMsg',"Already Exist.");
			                 
			                }   
                    

			
		

		                 } 
							    
							
					}
					
						


    }
    
    public function editProduct(Request $request)
    {
	
	$edit_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='edit') { 	 
	
	$get_product_detail = MwProduct::select('id','product_name','product_description','product_quantity','product_price','owner_only','status','isemojis','emoji_category_id','isauction','start_auction_date', 	'end_auction_date', 'initial_bid','active_datetime' ,'active_end_datetime')
					->where([['id', '=', $edit_product_id],])->first();
					
	$emoji_category = TblMwEmojiCategory::select('*')->get();
       
	
	
	 return view('layouts/edit_product')->with('products', $get_product_detail)->with('emoji', $emoji_category);
	}
	
		                    
							     
							
							    
							
	}
	
	
	//sticker category
	public function getProductCategory(Request $request)
    {
	$delete_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='delete') { 	 
	TblMwEmojiCategory::where('id', $delete_product_id)->delete();  
	return redirect()->back()->with('message', 'Delete Successfully');
	}
	
	$product_detail = TblMwEmojiCategory::select('*')->get();
	
	return view('layouts.productCategory.product_category')->with('products', $product_detail);

    }
	
	public function addProductCategory(Request $request)
    {

	$app = realpath(__DIR__ . '/../../../../..');
	$upload_img_dir = $app . '/disneyland/images/products_fullsize/';
	$upload_img_dir_two = $app . '/disneyland/images/products_thumbnail/';
    
	$product_name =  $request['txt_cat_name'];
    $product_desc =  $request['txt_cat_desc'];
    $hid_id =  $request['hdd_product_id'];

	if(empty($product_name))
	{
		return redirect()->back()->with('message', 'Please Fill Category Name');
	}

    
							if (!empty($hid_id)) {
							
							TblMwEmojiCategory::where('id', $hid_id)
							->update([
							'emoji_category_name' => $product_name,
							'description' => $product_desc,
							 ]);
							
					 		if ($request->hasFile('myfile')) {
							$image = $request->file('myfile');
							
							$name = 'product_cat_' . $hid_id . '.' .$image->getClientOriginalExtension();
							$uploadfile = $upload_img_dir . $name;
							$uploadfilecopy = $upload_img_dir_two . $name;
							
							ShortPixel\setKey("OHakDFltn0morEP8s1G4");
                            $image->move($upload_img_dir, $name);
                            
                            ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
							\File::copy($uploadfile,$uploadfilecopy);
							TblMwEmojiCategory::where('id', $hid_id)->update(['enoji_image' => $name]);
							}  
							
							$product_detail = TblMwEmojiCategory::select('*')->get();
							// return redirect()->route('backend.add_product_category')->with('products', $product_detail)->with('successMsgdd',"Sticker Category Updated Successfully.");
			                return view('layouts.productCategory.product_category')->with('products', $product_detail)->with('successMsg',"Sticker Category Updated Successfully.");
							
							     
							 } else {
							$product_detail = TblMwEmojiCategory::select('*')->get();	
							$isNotExist = count(TblMwEmojiCategory::select('*')->where([['emoji_category_name', '=', $product_name],])->get());
						
							if($isNotExist == 0){
							$entry = new TblMwEmojiCategory;  
							$clientIP = request()->ip();
							$entry->emoji_category_name = $product_name;
							$entry->description = $product_desc;
	
							$entry->save();
						   
					
					 		$product_id = $entry->id;
							
							if ($request->hasFile('myfile')) {
							$image = $request->file('myfile');
							
							$name = 'product_cat_' . $product_id . '.' .$image->getClientOriginalExtension();
							$uploadfile = $upload_img_dir . $name;
							$uploadfilecopy = $upload_img_dir_two . $name;
							ShortPixel\setKey("OHakDFltn0morEP8s1G4");
                            $image->move($upload_img_dir, $name);
                            
                            ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
							\File::copy($uploadfile,$uploadfilecopy);
							
							
							// if(!empty($name))
								// {
									// static::Create_tumbnail($name ,$name );		
								// }
							TblMwEmojiCategory::where('id', $product_id)->update(['enoji_image' => $name]);
							} 
							
			                $product_detail = TblMwEmojiCategory::select('*')->get();
			                return view('layouts.productCategory.product_category')->with('products', $product_detail)->with('successMsg',"Category Added Successfully.");
			         

							

							
			                } 
			                else 
			                { 
			                return view('layouts.productCategory.product_category')->with('products', $product_detail)->with('successMsg',"Already Exist.");
			                 
			                }   
                    

			
		

		                 } 
							    
    }
    
	public function editproductCategory(Request $request)
    {
	
	$edit_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='edit') { 	 
	
	$get_product_detail = TblMwEmojiCategory::select('*')->where([['id', '=', $edit_product_id],])->first();
		
	 return view('layouts.productCategory.edit_product_category')->with('products', $get_product_detail);
	}
							
	}
	
	
	// assign logo to user
	public function getUserLogo(Request $request)
    {
	$delete_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='delete') { 	 
	TblUserSpecialLogo::where('id', $delete_product_id)->delete();  
	return redirect()->back()->with('message', 'Delete Successfully');
	}
	
	$logos = TblUserSpecialLogo::select('*')->where('status', 1)->get();
	
	return view('layouts.userLogo.userlogo')->with('products', $logos);

    }
	
	public function addUserLogo(Request $request)
    {

	$app = realpath(__DIR__ . '/../../../../..');
	$upload_img_dir = $app . '/images/user_special_logos/';
    
	$product_name =  $request['txt_cat_name'];
    $product_desc =  $request['txt_cat_desc'];
    $hid_id =  $request['hdd_product_id'];

	if(empty($product_name))
	{
		return redirect()->back()->with('message', 'Please Fill Logo Name');
	}

    
							if (!empty($hid_id)) {
							TblUserSpecialLogo::where('id', $hid_id)
							->update([
							'image_name' => $product_name,
							'image_desc' => $product_desc,
							 ]);
							
					 		if ($request->hasFile('myfile')) {
							$image = $request->file('myfile');
							
							$name = 'special_logo_' . $hid_id . '.' .$image->getClientOriginalExtension();
							$uploadfile = $upload_img_dir . $name;
							ShortPixel\setKey("OHakDFltn0morEP8s1G4");
                            $image->move($upload_img_dir, $name);
                            ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
							TblUserSpecialLogo::where('id', $hid_id)->update(['image' => $name]);
							}  
							
							$product_detail = TblUserSpecialLogo::select('*')->get();
			                return view('layouts.userLogo.userlogo')->with('products', $product_detail)->with('successMsg',"User Logo Updated Successfully.");
							
							     
							 } else {
								 
							$product_detail = TblUserSpecialLogo::select('*')->get();	
							$isNotExist = count(TblUserSpecialLogo::select('*')->where([['image_name', '=', $product_name],])->get());
						
							if($isNotExist == 0){
							$entry = new TblUserSpecialLogo;  
							$entry->image_name = $product_name;
							$entry->image_desc = $product_desc;
							$entry->status = 1;
							$entry->createdon = Now();
	
							$entry->save();
						   
					
					 		$product_id = $entry->id;
							
							if ($request->hasFile('myfile')) {
							$image = $request->file('myfile');
							
							$name = 'special_logo_' . $product_id . '.' .$image->getClientOriginalExtension();
							$uploadfile = $upload_img_dir . $name;
							ShortPixel\setKey("OHakDFltn0morEP8s1G4");
                            $image->move($upload_img_dir, $name);
                            
                            ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
						
							TblUserSpecialLogo::where('id', $product_id)->update(['image' => $name]);
							} 
							
			                $product_detail = TblUserSpecialLogo::select('*')->get();
			                return view('layouts.userLogo.userlogo')->with('products', $product_detail)->with('successMsg',"User Logo Added Successfully.");
			         

							

							
			                } 
			                else 
			                { 
			                return view('layouts.userLogo.userlogo')->with('products', $product_detail)->with('successMsg',"Already Exist.");
			                 
			                }   
                    

			
		

		                 } 
							    
    }
    
	public function editUserLogo(Request $request)
    {
	
	$edit_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='edit') { 	 
	
	$get_product_detail = TblUserSpecialLogo::select('*')->where([['id', '=', $edit_product_id],])->first();
		
	 return view('layouts.userLogo.edit_userlogo')->with('products', $get_product_detail);
	}
							
	}
	
	// assign logo to user detail
	public function getUserLogoDetail(Request $request)
    {
	$delete_product_id = $request->id;

   $action = $request->action;
	
	if ($action =='delete') { 	 
	TblUserSpecialLogoDetail::where('id', $delete_product_id)->delete();  
	return redirect()->back()->with('message', 'Delete Successfully');
	}
	
	// $logos = TblUserSpecialLogoDetail::select('*')->with('user')->with('speciallogo')->where('status', 1)->first();
// dd($logos);

		 $sql = " SELECT mycol.id, mycol.user_id, mycol.user_special_logos_id , tu.user_id , tu.user_name  , tu.image as user_image,logo.image_name,logo.image  
					FROM tbl_user_special_logos_detail as  mycol 
					INNER JOIN  tbl_user as tu ON (mycol.user_id = tu.user_id)  
					 INNER JOIN tbl_user_special_logos as logo 
					 ON (mycol.user_special_logos_id = logo.id)
					WHERE mycol.status =1"; 

		$logos = DB::select($sql);
	
	return view('layouts.userLogoDetail.userlogo_detail')->with('products', $logos);

    }
	
	public function addUserLogoDetail(Request $request)
    {

	$app = realpath(__DIR__ . '/../../../../..');
	$upload_img_dir = $app . '/images/user_special_logos/';
    
	$username =  $request['txt_cat_name'];
     $hid_id =  $request['hid_id'];

	if(empty($username))
	{
		return redirect()->back()->with('message', 'Please Select Username');
	}	
							$sql = " SELECT mycol.id, mycol.user_id, mycol.user_special_logos_id , tu.user_id , tu.user_name  , tu.image as user_image,logo.image_name,logo.image  
							FROM tbl_user_special_logos_detail as  mycol 
							INNER JOIN  tbl_user as tu ON (mycol.user_id = tu.user_id)  
							INNER JOIN tbl_user_special_logos as logo 
							ON (mycol.user_special_logos_id = logo.id)
							WHERE mycol.status =1"; 

							$product_detail = DB::select($sql);
			
    	 
							$user = User::select('user_id')->where([['user_name', '=', $username],])->first();
							$user_id = $user->user_id;

							
							$checkdata = TblUserSpecialLogoDetail::select('*')->where
											([
											['user_id', '=', $user_id],
											['user_special_logos_id', '=', $hid_id],
											])->get();
							
							$isNotExist = count($checkdata);
						
							if($isNotExist == 0){
								
							$logodetail = TblUserSpecialLogo::select('*')->where([['id', '=', $hid_id],])->first();
							$product_id = $logodetail->id;
							$product_name = $logodetail->image_name;
							$product_desc = $logodetail->image_desc;
								
								
							$entry = new TblUserSpecialLogoDetail;  
							$entry->user_id = $user_id;
							$entry->user_special_logos_id = $product_id ;
	
							$entry->save();
						   
							$sql = " SELECT mycol.id, mycol.user_id, mycol.user_special_logos_id , tu.user_id , tu.user_name  , tu.image as user_image,logo.image_name,logo.image  
							FROM tbl_user_special_logos_detail as  mycol 
							INNER JOIN  tbl_user as tu ON (mycol.user_id = tu.user_id)  
							INNER JOIN tbl_user_special_logos as logo 
							ON (mycol.user_special_logos_id = logo.id)
							WHERE mycol.status =1"; 

							$product_detail = DB::select($sql);
			             
			                return view('layouts.userLogoDetail.userlogo_detail')->with('products', $product_detail)->with('successMsg',"User Logo Added Successfully.");
			         

							

							
			                } 
			                else 
			                { 
			                return view('layouts.userLogoDetail.userlogo_detail')->with('products', $product_detail)->with('successMsg',"Already Exist.");
			                 
			                }   
                    

			
		

		                 
							    
    }
    
	
	// Leaderboard
	public function getLeaderboard(Request $request)
    {
	$p_str = $request->type;

	$startdate ='';
	$enddate='';
	$today = date('Y-m-d',  strtotime("-3 hour"));
	
	if($p_str== 'w')
	{   
		$startdate = date('Y-m-d', strtotime("-7 day") );
		$enddate= date('Y-m-d',  strtotime("-3 hour"));
	}
	else if($p_str== 'm')
	{
			
		$todaymonth = date('m',  strtotime("-3 hour"));  	 		
		
		$startdate = date('Y-m-d', strtotime("-1 month") ); 
		$enddate  = date('Y-m-d',  strtotime("-3 hour"));		
	}
	else //by default showing day
	{
	$startdate =date('Y-m-d',  strtotime("-3 hour"));
		$enddate=date('Y-m-d',  strtotime("-3 hour"));	
	
	}
 
	
	 // $list = TblLeaderBoard::select('user_id',\DB::raw('sum( totalpoints ) as  lbtotalpoints'),) 
							// ->with('user')
							// ->whereBetween('date', [$startdate, $enddate])
							// ->where ([['user_id', '!=', 18]])
							// ->groupBy('user_id')
							// ->orderBy('lbtotalpoints', 'DESC')
							// ->take(100)
							// ->get();
							
								$qry = "SELECT lb.user_id ,sum(lb.totalpoints) as lbtotalpoints,    
												urs.user_name,urs.image, urs.totalpoints , urs.position, urs.rank
												FROM tbl_leaderboard lb INNER JOIN tbl_user urs ON (lb.user_id = urs.user_id)  
												where   `date` between '$startdate' and '$enddate'  and lb.user_id !=18
												group by user_id
												order by lbtotalpoints desc
												limit 100
												";
												
							$list = DB::select($qry);

	return view('layouts.leaderboard.leaderboard')->with('products', $list);

    }
	
	public function leaderboardDetail(Request $request)
    {
	$p_str = $request->type;
	$panme = $request->pname;
	$userid = $request->userid;

	$startdate ='';
	$enddate='';
	$today = date('Y-m-d',  strtotime("-3 hour"));
	
	if($p_str== 'w')
	{   
		$startdate = date('Y-m-d', strtotime("-7 day") );
		$enddate= date('Y-m-d',  strtotime("-3 hour"));
	}
	else if($p_str== 'm')
	{
		
		
		$todaymonth = date('m',  strtotime("-0 hour"));  	 		
		
		$startdate = date('Y-m-d', strtotime("-1 month") ); 
		$enddate  = date('Y-m-d',  strtotime("-0 hour"));
			
	}
	else //by default showing day
	{
		$startdate =date('Y-m-d',  strtotime("-0 hour"));
		$enddate=date('Y-m-d',  strtotime("-0 hour"));	
		
	}
	
	
	
 
	
	 // $list = TblLeaderBoardDetail::select('id','user_id','availpoints','Type','createdon as date','Park_name') 
							// ->with('user')
							// ->whereBetween('date', [$startdate, $enddate])
							// ->where([['user_id', '=', $userid],['Park_name', '=', $panme]])
							// ->get();
							
								$qry = "select lb.id,lb.user_id, lb.availpoints, lb.Type, createdon, lb.Park_name, tbl_user.user_name 
								from  tbl_leaderboard_details as lb INNER JOIN tbl_user ON (lb.user_id = tbl_user.user_id)
								where  date(`createdon`) between '$startdate' and '$enddate'  and lb.user_id ='$userid'  and Park_name='".$panme."'"; 
												
							 $list = DB::select($qry);
					
	return view('layouts.leaderboard.leaderboardDetail')->with('products', $list);

    }
	
	public function wdwLeaderboard(Request $request)
    {
	$p_str = $request->type;

	$startdate ='';
	$enddate='';
	$today = date('Y-m-d',  strtotime("-3 hour"));
	
	if($p_str== 'w')
	{   
		$startdate = date('Y-m-d', strtotime("-7 day") );
		$enddate= date('Y-m-d',  strtotime("-3 hour"));
	}
	else if($p_str== 'm')
	{
		
		$todaymonth = date('m',  strtotime("-3 hour"));  	 		
		//$startdate = date('Y-m-d', strtotime("-1 month") ); 
		$startdate = date('Y-m-d', strtotime("-6 month") ); 
		$enddate  = date('Y-m-d',  strtotime("-3 hour"));	
					
	}
	else //by default showing day
	{
	
		$startdate =date('Y-m-d',  strtotime("-3 hour"));
		$enddate=date('Y-m-d',  strtotime("-3 hour"));
	}
	
	
	 // $list = WdwLeaderBoard::select('user_id','availpoints','Type','createdon as date','Park_name') 
							// ->with('user')
							// ->whereBetween('date', [$startdate, $enddate])
							// ->where([['user_id', '=', $userid],['Park_name', '=', $panme]])
							// ->get();
							
							$qry = "SELECT lb.user_id ,sum(lb.totalpoints) as lbtotalpoints,    
									urs.user_name,urs.image, rnk.totalpoints, rnk.position, rnk.rank
									FROM wdw_leaderboard lb INNER JOIN tbl_user urs ON (lb.user_id = urs.user_id)
										INNER JOIN wdw_rank_report  rnk ON (lb.user_id = rnk.user_id)
									where   `date` between '$startdate' and '$enddate'  and lb.user_id !=18
									group by user_id
									order by lbtotalpoints desc
									limit 100
									";
												
							 $list = DB::select($qry);
					//dd($list);
	return view('layouts.leaderboard.wdwLeaderboard')->with('products', $list);

    }
	
	
	// Right
	public function getRight(Request $request)
    {
	
/*  	$msg = '';
	$delete_product_id = $request->id;

	
	if ($delete_product_id != '') { 
	$result =  TblAdminNews::select('*')->where([['id', '=', $delete_product_id ]])->first();	
	$ddl_park = $result->park;
	TblAdminNews::where('id', $delete_product_id)->delete(); 
		if ($ddl_park == 'DL') {
			$sql = "delete from tbl_myrealtime where reff_id=$delete_product_id and entryfrom='AdminNews'";
			DB::select($sql);
		}
	return redirect()->back()->with('message', 'Delete Successfully');
		
	} */ 
	
 	$nResult_user_rights = TblRight::select('*')->where([['status', '=',1]])->get();

	return view('layouts.right.rights')->with('products', $nResult_user_rights);
	}
	
    public function addRight(Request $request)
    {

		$hid_id = $request->id;
		$msg =""; 
		$newstitle = $request["tbox_newstitle"];
		$newsdesc =  $request["tbox_newsdesc"];
		$istoday_news = $request["chkbox_news"];
		if($istoday_news == null){$istoday_news = 0;}else{$istoday_news = 1;}		
			

	
		


    
							if ($hid_id > 0) {
								
							/* TblAdminNews::where('id', $hid_id)
							->update([
							'new_title' => $newstitle,
							'news_description' => $newsdesc,
							'news_description_web' => $newsdesc_web,
							'news_description_wdw' => $newsdesc_wdw,
							'news_description_web_wdw' => $newsdesc_web_wdw,
							'user_id' => 18,
							'park' => $ddl_park,
							'pulse_updated' => $pulse_updated,
							'istoday_news' => $istoday_news,
							'hyperlink' => $hyperlink,
							'texttolink' => $texttolink,
							'newstype_free' => $rdo_newstype_free,
							'newstype_paid' => $rdo_newstype_paid,
							'newstype_normal' => $rdo_newstype_normail,
							'updated_on' => NOW(),
							 ]);

				
						
							
							$product_detail = TblAdminNews::select('*')->orderBy('park', 'ASC')->get();
			                 return view('layouts.adminNews.news')->with('products', $product_detail)->with('successMsg',"News Updated Successfully.");
							 
							    */  
							 } 
							 else 
							 {
								 
					
						
							$entry = new TblRight;  
							$entry->right_group = $newstitle;
							$entry->rights = $newsdesc;
							$entry->status = $istoday_news;
							$entry->createdon = NOW();
							$entry->save();
							
							$product_detail = TblRight::select('*')->get();
			                return view('layouts.right.rights')->with('products', $product_detail)->with('successMsg',"Right Added Successfully.");
							
                    

			
		

		                 } 
							    
    }
    
/* 	public function editRight(Request $request)
    {

	$edit_product_id = $request->id;
	$get_product_detail = TblAdminNews::select('*')->where([['id', '=', $edit_product_id],])->first();
	return view('layouts.adminNews.edit_news')->with('products', $get_product_detail);

							
	} */
	
	
	
	// user permission menu
	public function getUserPermissionMenu(Request $request)
    {
	$search = $request->search;
	if($search != null){
	$logos = User::select('user_id','user_name','image')->where([['user_name', 'LIKE', '%'. $search. '%']])->paginate(50);
	}
	else
	{
	$logos = User::select('user_id','user_name','image')->where('user_status', 1)->paginate(50);
	}
	return view('layouts.userPermissionMenu.user_permission_menu')->with('products', $logos);

    }
	
	public function editUserPermissionMenu(Request $request)
    {
	
	$edit_product_id = $request->id;
	$user = User::select('user_id','user_name')->where([['user_id', '=', $edit_product_id],])->first();
	$nResult_rights = TblUserRight::select('user_id','rights_id')->where([['user_id', '=', $edit_product_id]])->get();
	$nResult_user_rights = TblRight::select('id','right_group')->where([['status', '=',1]])->get();
	
	return view('layouts.userPermissionMenu.edit_user_permission_menu')->with('products',$nResult_rights)->with('items',$nResult_user_rights)->with('user',$user);
	

							
	}
	
	public function addUserPermissionMenu(Request $request)
    {
	$msg = '';
	$user_id = $request->id;
	
	$tags_id_all = $request->Chkboxadd;  
	//$user_id = strip_tags($request->hdd_user_id);
	
		if($tags_id_all != null)		
		  {   
			 
			TblUserRight::where('user_id', $user_id)->delete();  
			
			for($i=0; $i < count($tags_id_all) ; $i++)
			{
				$count = 0;
				
				$right_id = trim($tags_id_all[$i]);   
				$sql = TblUserRight::select('user_id','rights_id')
								->where([['user_id', '=', $user_id],['rights_id', '=', $right_id]])->get();
			
				$count = count($sql);
				
				
				if( $count == 0)
				{
					$entry = new TblUserRight;  
					$entry->user_id = $user_id;
					$entry->rights_id = $right_id;
					$entry->save(); 
					
				} 
				
			}  
				$msg="Added Successfully"; 
			} 
		else
		{	
				TblUserRight::where('user_id', $user_id)->delete();  
				
		}
	
	
	
	
	$user = User::select('user_id','user_name')->where([['user_id', '=', $user_id],])->first();
	$nResult_rights = TblUserRight::select('user_id','rights_id')->where([['user_id', '=', $user_id]])->get();
	$nResult_user_rights = TblRight::select('id','right_group')->where([['status', '=',1]])->get();
	//$logos = User::select('user_id','user_name','image')->where('user_status', 1)->paginate(50);
	return redirect()->back()->with('products',$nResult_rights)->with('items',$nResult_user_rights)->with('user',$user)->with('message',$msg);	

	// return redirect()->route('backend.user_permission_menu')->with('products', $logos)->with('message', $msg);
							
	}
	
	// Tags
	public function getTag(Request $request)
    {
	$msg = '';
	$delete_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='delete') { 	 
	Tag::where('id', $delete_product_id)->delete(); 
	$msg = 'Tag Delete Successfully.';	
	}
	
 	$res =  Tag::select('*')->orderBy('lastupdatedon','DESC')->get();
	return view('layouts.tag.tag')->with('products', $res)->with('successMsg',$msg);
	}
	
	public function addTag(Request $request)
    {
	$hid_id = $request->id;
	$tags_name =  $request['tboxtagsName'];
	$tagsmappingurl =  $request['tboxtagsmappingurl'];
    $tagsDesc =  $request['tAreatagsDesc'];
    $tagsmetatitle =  $request['tboxtagsmetatitle'];
    $tagsmetadescription =  $request['tboxtagsmetadescription'];
    $tagsmetakeywords =  $request['tboxtagsmetakeywords'];
    $chkstatus =  $request['chkstatus'];

	$ip_address = $_SERVER['REMOTE_ADDR'];
	$user_id = 18;
	

	if(empty($tags_name))
	{
		return redirect()->back()->with('message', 'Please Fill Tag Name');
	}

    
							if (!empty($hid_id)) {
								if($chkstatus == null){$chkstatus = 0;}else{$chkstatus = 1;}
						
							Tag::where('id', $hid_id)
							->update([
							'tags_name' => $tags_name,
							'tags_description' => $tagsDesc,
							'mapping_url' => $tagsmappingurl,
							'meta_titles' => $tagsmetatitle,
							'meta_description' => $tagsmetadescription,
							'meta_keywords' => $tagsmetakeywords,
							'status' => $chkstatus,
							 ]);
							
							$product_detail = Tag::select('*')->orderBy('lastupdatedon','DESC')->get();		
			                return view('layouts.tag.tag')->with('products', $product_detail)->with('successMsg',"Tag Updated Successfully.");
							 
							     
							 } else {
							$product_detail = Tag::select('*')->orderBy('lastupdatedon','DESC')->get();		 
							$isNotExist = count(Tag::select('*')->where([['tags_name', '=', $tags_name],])->get());
						
							if($isNotExist == 0){
							$entry = new Tag;  
							$entry->tags_name = $tags_name;
							$entry->tags_description = $tagsDesc;
							$entry->mapping_url = $tagsmappingurl;
							$entry->user_id = $user_id;
							$entry->ip_address = $ip_address;
							$entry->status = 1;
							$entry->meta_titles = $tagsmetatitle;
							$entry->meta_description = $tagsmetadescription;
							$entry->meta_keywords = $tagsmetakeywords;
							$entry->save();
							
							$product_detail = Tag::select('*')->orderBy('lastupdatedon','DESC')->get();	
			                return view('layouts.tag.tag')->with('products', $product_detail)->with('successMsg',"Tag Added Successfully.");
							} 
			                else 
			                { 
			                return view('layouts.tag.tag')->with('products', $product_detail)->with('successMsg',"Already Exist.");
			                 
			                }   
                    

			
		

		                 } 
							    
    }
    
	public function editTag(Request $request)
    {
	
	$edit_product_id = $request->id;
    $action = $request->action;
	
	if ($action =='edit') { 	 
	
	$get_product_detail = Tag::select('*')->where([['id', '=', $edit_product_id],])->first();

	 return view('layouts.tag.edit_tag')->with('products', $get_product_detail);
	}
							
	}
	
		// advertise Post
	public function getAdvertisePost(Request $request)
    {
 	$msg = '';
	$delete_product_id = $request->msgid;

	
	if ($delete_product_id != '') { 	 
	TblAdvertisePost::where('id', $delete_product_id)->delete(); 
	return redirect()->back()->with('message', 'Delete Successfully');
		
	} 
	
 	$res =  TblAdvertisePost::select('*')->with('chat')->get();
	return view('layouts.advertisePost.advertisepost')->with('products', $res);
	}
	
	public function addAdvertisePost(Request $request)
    {
		
	$hid_id = $request->eid;

	$msg =""; 
	$tboxroomname ='' ; 
	$tboxsubtitle ='';
	$search_locaiton_id = 0;
	$e_id = '0';   
	$e_chat_msg =''; 
	$e_chat_image = ''; 
	$e_chat_video = ''; 
	$e_chat_status = '';  
	$e_chat_username = ''; 
	$e_chat_username_link = '';  
	$e_chat_user_image = ''; 
	$e_after_noofpost = ''; 
	$e_datetime = ''; 
	$e_chat_id = '0'; 
	$chat_id = '0'; 
	$e_chat_reply_update_time = ''; 
	$ip_address = $_SERVER['REMOTE_ADDR'];
  	$chat_video = '';
	

		// $tbox_username = '';
		// $tbox_noofposts = '';
		// $chkisreplaced = 0;
		// $chkpriority = 0;
	
		
		$user_id = '1';
		$chat_status = 2;
		$hdd_addpostid = $request['hdd_addpostid'];
		$hdd_chatid = $request['hdd_chatid']; 
		
		$tbox_postmsg = addslashes(str_replace("&#39;", "'", $request['tbox_postmsg']));   
		$chat_video = trim($request["tbox_video"]);   
		$tbox_username = trim($request["tbox_username"]);  
		$tbox_username_link = $request['tbox_username_link'];
		$chkstatus =  $request['chkstatus'] ;
		$tbox_noofposts =  $request['tbox_noofposts'] ;
		$chkisreplaced  =  $request['chkisreplaced'] ;
		$chkpriority  =  $request['ispriority'] ;
		$lounge  =  $request['ddl_lounge'] ;

		if($chkstatus == null){$chkstatus = 0;}else{$chkstatus = 1;}		
		if($chkisreplaced == null){$chkisreplaced = 0;}else{$chkisreplaced = 1;}		
		if($chkpriority == null){$chkpriority = 0;}else{$chkpriority = 1;}		
		if($tbox_username_link == null){$tbox_username_link = '';}		
 
		$app = realpath(__DIR__ . '/../../../../..');
		$upload_img_dir = $app . '/disneyland/images/thumbs/'; // for user image
		
		//for WDW
		$wdw_upload_img_dir = $app . '/disneyworld/chat_images/';
		$wdw_upload_img_dir_two = $app . '/disneyworld/chat_images_thumbnail/';
		$wdw_upload_img_dir_three = $app . '/disneyworld/chat_images_medium/';
	
		//for DL
		$dl_upload_img_dir = $app . '/disneyland/chat_images/';
		$dl_upload_img_dir_two = $app . '/disneyland/chat_images_thumbnail/';
		$dl_upload_img_dir_three = $app . '/disneyland/chat_images_medium/';
	


	if(empty($tbox_postmsg))
	{
		return redirect()->back()->with('message', 'Please Fill Message In Editor');
	}

    
							if ($hdd_chatid > 0 and $hdd_addpostid > 0 ) {
								
									$chat_id = $hdd_chatid;
									//dd($chat_id);
									if ($request->hasFile('myfile')) {
									$image = $request->file('myfile');
									$name =  $chat_id.'_c_img'.'.'.$image->getClientOriginalExtension() ;
							
							
								
									if($lounge == 'WDW' or $lounge == 'ALL'){
								
									$uploadfile = $wdw_upload_img_dir . $name;
									//ShortPixel\setKey("OHakDFltn0morEP8s1G4");
									$image->move($wdw_upload_img_dir, $name);
									//ShortPixel\fromFile($uploadfile)->toFiles($wdw_upload_img_dir);
									$uploadfilecopyfirst = $wdw_upload_img_dir_two . $name;
									\File::copy($uploadfile,$uploadfilecopyfirst);
									$uploadfilecopysecond = $wdw_upload_img_dir_three . $name;
									\File::copy($uploadfile,$uploadfilecopysecond);
									
									WdwChat::where('dl_chat_id', $chat_id)->update(['chat_img' => $name]);
									
									}
									
									
									if($lounge == 'DL' or $lounge == 'ALL'){
									$uploadfile = $dl_upload_img_dir . $name;
									//ShortPixel\setKey("OHakDFltn0morEP8s1G4");
									$image->move($dl_upload_img_dir, $name);
									//ShortPixel\fromFile($uploadfile)->toFiles($dl_upload_img_dir);
									$uploadfilecopyfirst = $dl_upload_img_dir_two . $name;
									\File::copy($uploadfile,$uploadfilecopyfirst);
									$uploadfilecopysecond = $dl_upload_img_dir_three . $name;
									\File::copy($uploadfile,$uploadfilecopysecond);
									
									TblChat::where('chat_id', $chat_id)->update(['chat_img' => $name]);
									
									}
								
									}				 
							
									
									if($lounge == 'WDW' or $lounge == 'ALL')
									{
										WdwChat::where('dl_chat_id', $chat_id)
										->update([
										'chat_msg' => $tbox_postmsg,
										'chat_reply_update_time' => NOW(),
										'chat_video' => $chat_video,
										 ]);
									  
									}
									
									if($lounge == 'DL' or $lounge == 'ALL')
									{ 
										TblChat::where('chat_id', $chat_id)
										->update([
										'chat_msg' => $tbox_postmsg,
										'chat_reply_update_time' => NOW(),
										'chat_video' => $chat_video,
										 ]);
									 
									}
									
									if ( $hdd_addpostid > 0 ) 
									{ 
									TblAdvertisePost::where('id', $hdd_addpostid)
									->update([
									'status' => $chkstatus,
									'username' => $tbox_username,
									'username_link' => $tbox_username_link,
									'show_after_noof_post' => '',
									'ispriority' => $chkpriority,
									'isreplaced' => $chkisreplaced,
									'lounge' => $lounge,
									 ]);
									 
									
									if ($request->hasFile('myuserpicsfile')) {
									$image = $request->file('myuserpicsfile');
									$name =  $hdd_addpostid.'_add_user'.'.'.$image->getClientOriginalExtension() ;
									$uploadfile = $upload_img_dir . $name;
									//ShortPixel\setKey("OHakDFltn0morEP8s1G4");
									$image->move($upload_img_dir, $name);
									//ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
									TblAdvertisePost::where('id', $hdd_addpostid)->update(['user_image' => $name]);
									} 
									}
						
							
							$product_detail =TblAdvertisePost::select('*')->with('chat')->get();	
			                return redirect('/advertisePost')->with('products', $product_detail)->with('successMsg',"Post Updated Successfully.");
							 
							     
							 } 
							 else 
							 {
								 
					
						
							if($lounge == 'DL' or $lounge == 'ALL')
							{
							$entry = new TblChat;  
							$entry->user_id = $user_id;
							$entry->chat_msg = $tbox_postmsg;
							$entry->chat_video = $chat_video;
							$entry->ip_address = $ip_address;
							$entry->chat_room_id = 0;
							$entry->chat_room_name = 'Advertise Post';
							$entry->chat_reply_update_time = NOW();
							$entry->showonmain = 0;
							$entry->chat_img = '';
							$entry->chat_status = $chat_status;
							$entry->isadvertisepost = 1;
							$entry->save();
							
							$chat_id = $entry->id;
							}
					
							if($lounge == 'WDW' or $lounge == 'ALL')
							{
							$entry = new WdwChat;  
							$entry->dl_chat_id = $chat_id;
							$entry->user_id = $user_id;
							$entry->chat_msg = $tbox_postmsg;
							$entry->chat_video = $chat_video;
							$entry->ip_address = $ip_address;
							$entry->chat_room_id = 0;
							$entry->chat_room_name = 'Advertise Post';
							$entry->chat_reply_update_time = NOW();
							$entry->showonmain = 0;
							$entry->chat_img = '';
							$entry->chat_status = $chat_status;
							$entry->isadvertisepost = 1;
							$entry->save();
							}
							
							if ( $chat_id > 0 ) {
							$entryAdvertise = new TblAdvertisePost;  
							$entryAdvertise->chat_id = $chat_id;
							$entryAdvertise->user_id = $user_id;
							$entryAdvertise->status = $chkstatus; 
							$entryAdvertise->username = $tbox_username;
							$entryAdvertise->username_link = $tbox_username_link;
							$entryAdvertise->user_image = '';
							$entryAdvertise->show_after_noof_post = '';  //$tbox_noofposts
							$entryAdvertise->ip_address = $ip_address;
							$entryAdvertise->isreplaced = $chkisreplaced;
							$entryAdvertise->ispriority = $chkpriority;
							$entryAdvertise->lounge = $lounge;
							$entryAdvertise->save();
							$addpost_id = $entryAdvertise->id;
							
							
								if ($request->hasFile('myfile')) {
								$image = $request->file('myfile');
								$name =  $chat_id.'_c_img'.'.'.$image->getClientOriginalExtension() ;
							
							
								
									if($lounge == 'WDW' or $lounge == 'ALL'){
								
									$uploadfile = $wdw_upload_img_dir . $name;
									//ShortPixel\setKey("OHakDFltn0morEP8s1G4");
									$image->move($wdw_upload_img_dir, $name);
									//ShortPixel\fromFile($uploadfile)->toFiles($wdw_upload_img_dir);
									$uploadfilecopyfirst = $wdw_upload_img_dir_two . $name;
									\File::copy($uploadfile,$uploadfilecopyfirst);
									$uploadfilecopysecond = $wdw_upload_img_dir_three . $name;
									\File::copy($uploadfile,$uploadfilecopysecond);
									
									WdwChat::where('dl_chat_id', $chat_id)->update(['chat_img' => $name]);
									
									}
									
									
									if($lounge == 'DL' or $lounge == 'ALL'){
									$uploadfile = $dl_upload_img_dir . $name;
									//ShortPixel\setKey("OHakDFltn0morEP8s1G4");
									$image->move($dl_upload_img_dir, $name);
									//ShortPixel\fromFile($uploadfile)->toFiles($dl_upload_img_dir);
									$uploadfilecopyfirst = $dl_upload_img_dir_two . $name;
									\File::copy($uploadfile,$uploadfilecopyfirst);
									$uploadfilecopysecond = $dl_upload_img_dir_three . $name;
									\File::copy($uploadfile,$uploadfilecopysecond);
									
									TblChat::where('chat_id', $chat_id)->update(['chat_img' => $name]);
									
									}
								
								
								
								
								
								}
							
							}
							
						
							
							if ( $addpost_id > 0 ) 
							{ 
							if ($request->hasFile('myuserpicsfile')) {
							$image = $request->file('myuserpicsfile');
							$name =  $addpost_id.'_add_user'.'.'.$image->getClientOriginalExtension() ;
							$uploadfile = $upload_img_dir . $name;
							//ShortPixel\setKey("OHakDFltn0morEP8s1G4");
                            $image->move($upload_img_dir, $name);
                            //ShortPixel\fromFile($uploadfile)->toFiles($upload_img_dir);
							TblAdvertisePost::where('id', $addpost_id)->update(['user_image' => $name]);
							} 
							}
												
						
							
							
							
							
							$product_detail =TblAdvertisePost::select('*')->with('chat')->get();	
			                return view('layouts.advertisePost.advertisepost')->with('products', $product_detail)->with('successMsg',"Post Added Successfully.");
							
                    

			
		

		                 } 
							    
    }
    
	public function editAdvertisePost(Request $request)
    {

	$edit_product_id = $request->eid;
	$get_product_detail = TblAdvertisePost::select('*')->with('chat')->where([['id', '=', $edit_product_id],])->first();
	//dd($get_product_detail);
	return view('layouts.advertisePost.edit_advertisepost')->with('products', $get_product_detail);

							
	}
	
	// songs
	public function getSong(Request $request)
    {
 	$msg = '';
	
 	$delete_product_id = $request->id;
	if ($delete_product_id != '') { 	 
	TblSong::where('id', $delete_product_id)->update(['status' => 0]);
	return redirect()->back()->with('message', 'Delete Successfully');
		
	} 
	
							
			$sortedBy = $request->Radio;
			if($sortedBy =='old' )
			{
				$sortOrder = ' order by createdon asc';
			}
			else
			{
				$sortOrder = ' order by createdon desc';
			}
			


			if ($request->txt_search!="") {
				$name = trim($request->txt_search);
				$searchBy = $request->RadioGroup1;
				$chk ='and status = 1 ' ;  
				
				if($searchBy == 'singer')
				{
					$whereClaus =" where singer_name like '%$name%' ".$chk .$sortOrder;
				}
				else if($searchBy == 'song')
				{
					$whereClaus =" where  song_name like '%$name%' " .$sortOrder;
				}
				else if($searchBy == 'album')
				{
					$whereClaus =" where  album_name like '%$name%' ".$sortOrder ;
				}  
				  
				 $qry = "SELECT * FROM tbl_songs  ".$whereClaus;  
				 
			}
			else {

				 $qry = "SELECT * FROM tbl_songs where status = 1".$sortOrder;  
				 
			}	 
												
			
		$result= DB::select($qry); 
							
				
	return view('layouts.adminSong.song')->with('products', $result)->with('time', $sortedBy);
	}
	
	public function addSong(Request $request)
    {

	$hid_id = $request->id;
	$tboxSongName =  $request['tboxSongName'];
	$tboxSingerName =  $request['tboxSingerName'];
    $tboxAlbumName =  $request['tboxAlbumName'];
    $tboxSongURL =  $request['tboxSongURL'];
    $tboxRank =  $request['tboxRank'];
    $tAreaSongDesc =  $request['tAreaSongDesc'];

	

	if(empty($tboxSongName))
	{
		return redirect()->back()->with('message', 'Please Fill Song Name');
	}

    
							if (!empty($hid_id)) {
							TblSong::where('id', $hid_id)
							->update([
							'singer_name' => $tboxSongName,
							'song_url' => $tboxSongURL,
							'album_name' => $tboxAlbumName,
							'rank_to_show' => $tboxRank,
							'song_name' => $tboxSongName,
							'song_description' => $tAreaSongDesc,
							 ]);
							
							$product_detail = TblSong::select('*')->where([['status', '=', 1],])->orderBy('createdon','DESC')->get();	
			                return view('layouts.adminSong.song')->with('products', $product_detail)->with('time', '')->with('successMsg',"Song Updated Successfully.");
						
							     
							 } 
							 else {
							
						
							$entry = new TblSong;  
							$entry->singer_name = $tboxSongName;
							$entry->song_url = $tboxSongURL;
							$entry->album_name = $tboxAlbumName;
							$entry->rank_to_show = $tboxRank;
							$entry->song_name = $tboxSongName;
							$entry->song_description = $tAreaSongDesc;
							$entry->status = 1;
							$entry->createdon = NOW();
							$entry->save();
							
					// we not sending email old file m code commnet h
						 /* 	if($tboxRank >0 )
									{
									
					
										
									$strquery =	TblRankReport::select('*')->with('user')->where([
												['user_id', '>', '0'],
												['rank', '>', $tboxRank],])->get();
										
										
					
										foreach($strquery as $row )
										{
											
											$user_name  = $row['user_name'];
											$user_email  = $row['user_email'];
											$user_id  = $row['user_id'];
											if($user_email !="")
											{
												//SendEmail($user_name , $user_email ) ;
											}  
											
										}
									}  
							 */
							
							
							
							
							
							
							$product_detail = TblSong::select('*')->where([['status', '=', 1],])->orderBy('createdon','DESC')->get();	
			                return view('layouts.adminSong.song')->with('products', $product_detail)->with('time', '')->with('successMsg',"Song Added Successfully.");
							   
                    

			
		

		                 } 
							    
    }
	
	public function editSong(Request $request)
    {

	$edit_product_id = $request->id;
	$get_product_detail = TblSong::select('*')->where([['id', '=', $edit_product_id],])->first();
	//dd($get_product_detail);
	return view('layouts.adminSong.edit_song')->with('products', $get_product_detail);

							
	}
	
	// news
	public function getNews(Request $request)
    {
 	$msg = '';
	$delete_product_id = $request->id;

	
	if ($delete_product_id != '') { 
	$result =  TblAdminNews::select('*')->where([['id', '=', $delete_product_id ]])->first();	
	$ddl_park = $result->park;
	TblAdminNews::where('id', $delete_product_id)->delete(); 
		if ($ddl_park == 'DL') {
			$sql = "delete from tbl_myrealtime where reff_id=$delete_product_id and entryfrom='AdminNews'";
			DB::select($sql);
		}
	return redirect()->back()->with('message', 'Delete Successfully');
		
	} 
	
 	$res =  TblAdminNews::select('*')->orderBy('park', 'ASC')->get();

	return view('layouts.adminNews.news')->with('products', $res);
	}
	
    public function addNews(Request $request)
    {
		
	$hid_id = $request->id;

	$msg =""; 
	
		$newstitle = "";
		$newsdesc = "";
		$id = 0;
		$newstype = 0;
		$rdo_newstype_free = '';
		$rdo_newstype_paid = '';
		$rdo_newstype_normail = '';
		
		$newstitle = str_replace("'", "\'", stripslashes(trim($request["tbox_newstitle"])));
		//echo "<br>";
		$newsdesc = str_replace("&#39;", "\'", stripslashes($request["tbox_newsdesc"]));
		//echo "<br>";echo "<br>";
		$newsdesc_web = str_replace("&#39;", "\'", stripslashes($request["tbox_newsdesc_web"]));
		//echo "<br>"; echo "<br>";

		//echo "<br>";
		$newsdesc_wdw = str_replace("&#39;", "\'", stripslashes($request["tbox_newsdesc_wdw"]));
		//echo "<br>";echo "<br>";
		$newsdesc_web_wdw = str_replace("&#39;", "\'", stripslashes($request["tbox_newsdesc_web_wdw"]));
		//echo "<br>"; echo "<br>";

		$ddl_park = $request["ddl_park"];
		$istoday_news = $request["chkbox_news"];
		$rdo_newstype_free = $request["chk_newstype_free"];
		$rdo_newstype_paid = $request["chk_newstype_paid"];
		$rdo_newstype_normail = $request["chk_newstype_normal"];

		$hyperlink = $request["tbox_hyperlink"];
		$texttolink = $request["tbox_texttolink"];

		$pulse_updated = date('Y-m-d H:i:s', strtotime(date("Y-m-d  H:i:s") . "+1 hour"));

		
		$newsdesc_web = addslashes(str_replace('&#39;', "\'", $newsdesc_web));
		//echo "<br>"; echo "<br>";
		$newsdesc = addslashes(str_replace('&#39;', "\'", $newsdesc));
		//echo "<br>"; echo "<br>";
		$newsdesc_web_wdw = addslashes(str_replace('&#39;', "\'", $newsdesc_web_wdw));
		//echo "<br>"; echo "<br>";
		$newsdesc_wdw = addslashes(str_replace('&#39;', "\'", $newsdesc_wdw));
		//echo "<br>"; echo "<br>";


// echo $newstitle;
// echo $newsdesc;
// echo $newsdesc_web;
// echo $newsdesc_web_wdw;
// echo $newsdesc_wdw;
// echo $rdo_newstype_normail;
// echo $rdo_newstype_paid;
// echo $rdo_newstype_free;
// echo $istoday_news;
// echo $ddl_park;
// echo $pulse_updated;
 // die;

		if($istoday_news == null){$istoday_news = 0;}else{$istoday_news = 1;}		
		if($rdo_newstype_free == null){$rdo_newstype_free = 0;}else{$rdo_newstype_free = 1;}		
		if($rdo_newstype_paid == null){$rdo_newstype_paid = 0;}else{$rdo_newstype_paid = 1;}		
		if($rdo_newstype_normail == null){$rdo_newstype_normail = 0;}else{$rdo_newstype_normail = 1;}		

	
		


    
							if ($hid_id > 0) {
								
							TblAdminNews::where('id', $hid_id)
							->update([
							'new_title' => $newstitle,
							'news_description' => $newsdesc,
							'news_description_web' => $newsdesc_web,
							'news_description_wdw' => $newsdesc_wdw,
							'news_description_web_wdw' => $newsdesc_web_wdw,
							'user_id' => 18,
							'park' => $ddl_park,
							'pulse_updated' => $pulse_updated,
							'istoday_news' => $istoday_news,
							'hyperlink' => $hyperlink,
							'texttolink' => $texttolink,
							'newstype_free' => $rdo_newstype_free,
							'newstype_paid' => $rdo_newstype_paid,
							'newstype_normal' => $rdo_newstype_normail,
							'updated_on' => NOW(),
							 ]);

						/* 	$reff_id = $hid_id;
							TblRealtime::where('id', $hid_id)
							->update([
							'news_description' => $newsdesc,
					
							 ]); */
						
							
							$product_detail = TblAdminNews::select('*')->orderBy('park', 'ASC')->get();
			                 return view('layouts.adminNews.news')->with('products', $product_detail)->with('successMsg',"News Updated Successfully.");
							 
							     
							 } 
							 else 
							 {
								 
					
						
							$entry = new TblAdminNews;  
							$entry->new_title = $newstitle;
							$entry->news_description = $newsdesc;
							$entry->news_description_web = $newsdesc_web;
							$entry->news_description_wdw = $newsdesc_wdw;
							$entry->news_description_web_wdw = $newsdesc_web_wdw;
							$entry->user_id = 18;
							$entry->park = $ddl_park;
							$entry->pulse_updated = $pulse_updated;
							$entry->istoday_news = $istoday_news;
							$entry->hyperlink = $hyperlink;
							$entry->texttolink = $texttolink;
							$entry->newstype_free = $rdo_newstype_free;
							$entry->newstype_paid = $rdo_newstype_paid;
							$entry->newstype_normal = $rdo_newstype_normail;
							$entry->updated_on = NOW();
							$entry->save();
							$reff_id = $entry->id;
								
								if ($reff_id > 0 and $id == 0 and $ddl_park == 'DL') {
								$username = "Admin: ";
								$entryreal = new TblRealtime;  
								$entryreal->datetime = NOW();
								$entryreal->prefix = $username;
								$entryreal->msg = $newsdesc;
								$entryreal->reff_id = $reff_id;
								$entryreal->entryfrom = 'AdminNews';
								$entryreal->save();
									}
							

								
						
					
							
							$product_detail = TblAdminNews::select('*')->orderBy('park', 'ASC')->get();
			                return view('layouts.adminNews.news')->with('products', $product_detail)->with('successMsg',"Post Added Successfully.");
							
                    

			
		

		                 } 
							    
    }
    
	public function editNews(Request $request)
    {

	$edit_product_id = $request->id;
	$get_product_detail = TblAdminNews::select('*')->where([['id', '=', $edit_product_id],])->first();
	return view('layouts.adminNews.edit_news')->with('products', $get_product_detail);

							
	}
	
	// email Template
	public function getEmailTemplate(Request $request)
    {
 
	
 	$res =  TblEmailTemplate::select('*')->where('status','1')->get();
	return view('layouts.emailTemplate.emailtemplate')->with('products', $res);
	}
	
	public function addEmailTemplate(Request $request)
    {
		
	$hid_id = $request->id;

	$ddl_template_for = strip_tags($request['ddl_template_for']);
	$tboxdescription = strip_tags($request['tboxdescription']); 
	$tboxtemplate = trim($request["tboxtemplate"]);  
	$tboxsubject = trim($request["tboxsubject"]);
	$templatefor = trim($request["templatefor"]);

							if ($hid_id > 0) {
								
							TblEmailTemplate::where('id', $hid_id)
							->update([
							'template_for' => $templatefor,
							'subject' => $tboxsubject,
							'template' => $tboxtemplate,
							'description' => $tboxdescription,
							 ]);
							
							
							$product_detail = TblEmailTemplate::select('*')->where('status','1')->get();	
			                return view('layouts.emailTemplate.emailtemplate')->with('products', $product_detail)->with('successMsg',"Template Updated Successfully.");
							 
							     
							 } 
							
							
							else 
							{
							$entry = new TblEmailTemplate;  
							$entry->template_for = $templatefor;
							$entry->subject = $tboxsubject;
							$entry->template = $tboxtemplate;
							$entry->description = $tboxdescription;
							$entry->save();
							
							$product_detail = TblEmailTemplate::select('*')->where('status','1')->get();	
			                return view('layouts.emailTemplate.emailtemplate')->with('products', $product_detail)->with('successMsg',"Template Added Successfully.");
							
	
							} 
							    
    }
    
	public function editEmailTemplate(Request $request)
    {
	$edit_product_id = $request->id;
	$get_product_detail = TblEmailTemplate::select('*')->where([['id', '=', $edit_product_id],])->first();
	return view('layouts.emailTemplate.edit_emailtemplate')->with('products', $get_product_detail);

							
	}
	
	
	 //sticker product
    public function userDailyBestOfTheDayEmail(Request $request)
    {
 
	$current_date = date('Y-m-d'); 
	// $current_date =date('Y-m-d',strtotime("-300 days")); // go back 300 day check kaerne k liye							
	 $qry = " SELECT tbl_leaderboard_details.user_id , round( sum( tbl_leaderboard_details.availpoints ) , 2 ) as today_rank, tbl_user.user_name, tbl_user.user_email  ,tbl_user.totalpoints, tbl_user.position, tbl_user.rank, tbl_user.quality_rank , tbl_user.likes_points, tbl_user.thanks_points  
	FROM `tbl_leaderboard_details` INNER JOIN  tbl_user  ON (tbl_leaderboard_details.user_id = tbl_user.user_id)  and  tbl_user.user_status = 1 
	WHERE date( tbl_leaderboard_details.createdon ) = '$current_date'  
	and tbl_leaderboard_details.user_id not in (SELECT user_id FROM `tbl_user_dailyranks_email_unsubscription` )   
	and tbl_leaderboard_details.user_id != 18 
	GROUP BY tbl_leaderboard_details.user_id " ;
	$entries = DB::select($qry);
	
	 foreach ($entries as $row) {
		$user_id = $row->user_id;
		$user_name = $row->user_name;
		$user_email = $row->user_email;
		$user_today_rank = $row->today_rank;
		$user_overall_totalpoints = $row->totalpoints;
		$user_overall_position = $row->position;
		$user_overall_rank = $row->rank;
		$user_quality_rank = $row->quality_rank;
		$user_likes_points = $row->likes_points;
		$user_thanks_points = $row->thanks_points;
		
		$message  =  "Hello ".$user_name.",<br><br><br>"; 
		$message .=  "You've earned ".$user_today_rank." MouseRank points AND Credits today, great job!<br><br>"; 
		
		$message .=  "Your total MouseRank is ".$user_overall_rank.", your overall rank is #".$user_overall_position.", and your Quality ranking is #".$user_quality_rank.". <br><br>";
		$message .= "Thanks for contributing! <br><br><br>";
		$message .=  "Team MouseWait <br>";
		$message .=  "Follow us on Twitter http://twitter.com/mousewait<br>";
		$message .=  "Follow us on Facebook http://facebook.mousewait.com<br>"; 
	/* 	$my_message .=  "To Unsubscribe click here https://www.mousewait.com/unsubscribe_dailyranks.php?user_id=".$user_id."  <br><br><br>"; */
		$message .=  "<br><br><br>";
		
		
		
	   /*  $myVar = new AlertController();
	    $alertSetting = $myVar->bestOfTheDayEmail($user_name,$user_email,$message);  */
		} 
	
		$delete_product_id = $request->id;
		$action = $request->action;
		
		if ($action =='delete') { 	 
		TblBofDaySuscriber::where('id', $delete_product_id)->delete();  
		return redirect()->back()->with('message', 'Delete Successfully');
		} 						
								
		$product_detail = TblBofDaySuscriber::select('*')->with('user')->where([['status', '=', 1],])->orderBy('user_id', 'ASC')->get();						
		
							
							
	
	return view('layouts/bestofthedayemail')->with('products', $product_detail);

    }
	
}
