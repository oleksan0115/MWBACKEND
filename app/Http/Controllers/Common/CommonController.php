<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\TblChat;
use App\ToDoList;


class CommonController extends Controller
{
    
	
	 public function getUserToDo($user_id,$type,$event_datetime,$latitude,$longitude,$reff_id)
	{
	   	$todo =  ToDoList::select('*')
							->with('ridebyid')
							->with('ridebyid.park')
							->with('getrestorant')
							->with('getshowtime')
							->where([
							['status', '=', '1'],
							['user_id', '=', $user_id],
							])
							->orderBy('order_no', 'ASC')
	                       ->get();	
						   
	
		return json_decode(json_encode($todo), true);
		
		
	
	}
	
	
	
	
}
