 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		  
		       @if(!empty($message))
				<div class="alert alert-danger"> {{ $message }}</div>
				@endif
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
		       @if(!empty($success))
				<div class="alert alert-success"> {{ $success }}</div>
				@endif
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
				
 <form action="{{ route('backend.changeUserDetail') }}?uid={{ $changeuser->user_id}}" method="POST" enctype="multipart/form-data">
 @csrf		

	<div class="row pb-3">
		<div class="col-xl-3 col-lg-4">
	<a href="{{ env('APP_URL') }}users"><button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back</button></a> 
		
		</div>
		
		<div class="col-xl-3 col-lg-4">
	
		
		<label>Search By Username</label>
		<div class="input-group">

		<input type="search" name="search" class="form-control rounded" placeholder="Username" aria-label="Search" aria-describedby="search-addon" />
		<button type="submit" class="btn btn-outline-primary">search</button>
		</div>
		
		</div>
	</div>

						
						
	<div class="row pt-5">
							
							
<table class="table table-bordered">
  <thead>
  
  </thead>
  <tbody>
    <tr>
      <td>Username</td>
      <td><input type="text" required name="txtuser_name" style="width:300px;" id="txtuser_name" value="{{ $changeuser->user_name}}"><button type="submit" name="btnupdatename" id="btnupdatename" value="Update" class="btn btn-sm btn-primary ml-2">&nbsp; Update User Name</button></td>
	    <td></td>
     </tr>
	  <tr>
      <td>User Email</td>
      <td><input type="text" required name="txtuser_email" style="width:300px;" id="txtuser_email" value="{{ $changeuser->user_email}}"><button type="submit" name="btnupdateemail" id="btnupdateemail" value="Update" class="btn btn-sm btn-primary ml-2">&nbsp; Update User Email</button></td>
     </tr>
	  <tr>
      <td>User Mac Address</td>
      <td><input type="text" name="txtumac_address" style="width:300px;" id="txtumac_address" value="{{ $changeuser->mac_address}}"></td>
     </tr>
	  <tr>
      <td>User Points</td>
      <td><input type="text" name="txtrtotalpoints" id="txtrtotalpoints" style="width:200px;" value="{{ $changeuser->totalpoints}}">
	
		<button type="submit" name="btnupdatepoints" id="btnupdatepoints" value="Update Points" class="btn btn-sm btn-primary">&nbsp; Update Points</button>
<br>
 For example current points are 500 you want to give 200.
just type 200 it will add 500+200=700
</td>
     </tr>
	 
	  <tr>
      <td>Likes Points</td>
      <td><input type="text" name="txtlikes_points" id="txtlikes_points" style="width:200px;" value="{{ $changeuser->likes_points}}">


<button type="submit" name="btnlikes_points" id="btnlikes_points" value="Update Points" class="btn btn-sm btn-primary">&nbsp; Update Points</button>
<br>
For example current points are 500 you want to give 200.
just type 200 it will add 500+200=700
</td>
     </tr>
	  <tr>
      <td>Thanks Points</td>
      <td><input type="text" name="txtthanks_points" id="txtthanks_points" style="width:200px;" value="{{ $changeuser->thanks_points}}">

<button type="submit" name="btnthanks_points" id="btnthanks_points" value="Update Points" class="btn btn-sm btn-primary">&nbsp; Update Points</button>
<br>
For example current points are 500 you want to give 200.
just type 200 it will add 500+200=700
</td>
     </tr>
	  <tr>
      <td>Update Credits</td>
     <td><input type="text" name="txtuser_credits" id="txtuser_credits" style="width:200px;" value="{{ $changeuser->user_credits}}">
	 <button type="submit" name="btncredits" id="btncredits" value="Update Credits" class="btn btn-sm btn-primary">&nbsp; Update Credits</button>

<br>
For example current credits are 500 you want to give 200.
just type 200 it will add 500+200=700
</td>
     </tr>
	 
	  <tr>
      <td>Signup IP</td>
      <td>{{ $changeuser->signup_ip_address}}</td>
     </tr>
	 
	  <tr>
      <td>Current IP</td>
      <td>{{ $changeuser->ip_address}}</td></tr> 
	  
	
  
   
  </tbody>
</table>


<table class="table">

    <tr>
	<td>
<a href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=delete" onclick="javascript:return confirm('Are you sure to permanently delete this user.')"  class="action_link">Delete</a>  &nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=moderator">Moderator</a>&nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=ispress">Press</a>&nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=iswebcast">Webcast</a>&nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=iscomposer">Composer</a>&nbsp;&nbsp;     
                    <a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=isprivate">News</a>&nbsp;&nbsp;
                 	<a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=admin">Admin</a>&nbsp;&nbsp;
                  	<a class="action_link" href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=Approved">Approved</a> &nbsp;&nbsp;
                  	<a class="action_link" href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=disapprove">disapprove</a> &nbsp;&nbsp;
					
					<a class="action_link" href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=banall">Ban User All</a> &nbsp;&nbsp;
					<a class="action_link" href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=bandevice">Ban User</a> &nbsp;&nbsp;
					<a class="action_link" href="{{ request()->route()->uri }}?uid={{ $changeuser->user_id}}&action=unban">UnBan All</a> &nbsp;&nbsp;
                    
					
				
		        	
                        
    </td>
    </tr>
	
	<tr>
	<td>
		<a  class="action_link" href="{{URL::to('changeUserPassword')}}?uid={{ $changeuser->user_id}}">Change Password</a>&nbsp;&nbsp;					
		
		{{-- <span style="cursor:pointer; text-decoration:underline;" onclick="javascript:showbadge({{ $changeuser->user_id}});"><strong>Assign Badge</strong></span>&nbsp;&nbsp;
		<a  class="action_link" href="delete_badges?uid={{ $changeuser->user_id}}">Remove Badge</a>&nbsp;&nbsp;
		--}}
		<a  class="action_link" href="{{URL::to('sendUserMail')}}?uid={{ $changeuser->user_id}}">Send Email</a> 
	</td>
	</tr>
	
 
</table>


<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">User Id</th>
      <th scope="col">User Name</th>
      <th scope="col">User Email</th>
      <th scope="col">Mac Address</th>
      <th scope="col">Ip Address</th>
      <th scope="col">Total Points</th>
      <th scope="col">Rank</th>
      <th scope="col">Credits</th>
      <th scope="col">Admin</th>
      <th scope="col">Moderator</th>
      <th scope="col">Press</th>
      <th scope="col">Composer</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{ $searchornot->user_id}}</td>
      <td>{{ $searchornot->user_name}}</td>
      <td style="word-break:break-all">{{ $searchornot->user_email}}</td>
      <td>{{ $searchornot->mac_address}}</td>
	  <td>{{ $searchornot->ip_address}}</td>
	  <td>{{ $searchornot->totalpoints}}</td>
      <td>{{ $searchornot->rank}}</td>
      <td>{{ $searchornot->user_credits}}</td>
      <td>{{$searchornot->isadmin =='1' ? 'Yes' : 'No' }}</td>
	  <td>{{$searchornot->ismoderator =='1' ? 'Yes' : 'No' }}</td>
      <td>{{$searchornot->ispress =='1' ? 'Yes' : 'No' }}</td>
      <td>{{$searchornot->iscomposer =='1' ? 'Yes' : 'No' }}</td>
      <td><a class="action_link"  href="{{ request()->route()->uri }}?uid={{ $searchornot->user_id}}">Edit</a></td>
    </tr>
   
  </tbody>
</table>
 
           
           		
				</div>
				</form>
		</div>
          
  </div>
        
  
  @endsection