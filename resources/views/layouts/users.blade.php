 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		      
				       @if(!empty($success))
				<div class="alert alert-success"> {{ $success }}</div>
				@endif
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
						<div class="row pt-5">
							
							<!--div class="col-xl-3 col-lg-4">
							    <ul>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Pending Users</span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/approvedUser')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Approved/Active Users</span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Disapproved/Deleted Users</span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>All Users </span></a></li>
                                 </ul>
                
							
							</div>
							<div class="col-xl-3 col-lg-4">
								    <ul>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Export Users </span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Ban Users Devices</span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Flaged Users</span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>Text Messages </span></a></li>
                                 </ul>
					
							</div>
							<div class="col-xl-3 col-lg-4">
							    <ul>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i>MR Ranks Detail</span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i> DL Users </span></a></li>
								  <li class="mb-2"><a class="sidenav-item-link" href="{{URL::to('/users')}}"><span class="text-dark font-weight-bold"><i class="mdi mdi-cursor-pointer"></i> WDW Users </span></a></li>
                                 </ul>
							</div-->
		
			<div class="col-xl-3 col-lg-4">
			    <form action="{{ route('backend.users') }}" method="POST" enctype="multipart/form-data">
			          @csrf
			     <label>Search By Username</label>
							   <div class="input-group">
							      
  <input type="search" name="search" class="form-control rounded" placeholder="Username" aria-label="Search" aria-describedby="search-addon" />
  <button type="submit" class="btn btn-outline-primary">search</button>
</div>
</form>
							</div>
           
           
        
           
           
           
           
           
            <div class="table-responsive" style="height:60vh">
	
			  <table class="table mt-3 table-striped" style="width:max-content">
                <thead>
                  <tr>
                    <th>User Id</th>
                    <th>Mac Address</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Verify Email</th>
                    <th>Reg. by</th>
                    <th>Ip Address</th>
                    <th>Signup Ip Add</th>
                    <th>Is Admin</th>
                    <th>Moderator</th>  
                    <th>Press</th>  
                    <th>Webcast</th>  
                    <th>News</th>  
                    <th>Composer</th>
                    <th>Action</th>
                   
                  </tr>
                </thead>
                <tbody>
		
				{{--	<table class="table mt-3 table-striped user-table" style="table-layout: fixed">
                <thead>
                  <tr>
                    <th style="width: 5%">User Id</th>
                    <th style="width: 20%">Mac Address</th>
                    <th style="width: 30%">Name</th>
                    <th style="width: 30%">Email</th>
                    <th style="width: 8%">Status</th>
                    <th style="width: 8%">Verify Email</th>
                    <th style="width: 8%">Reg. by</th>
                    <th style="width: 10%">Ip Address</th>
                    <th style="width: 10%">Signup Ip Add</th>
                    <th style="width: 10%">Is Admin</th>
                    <th style="width: 15%">Moderator</th>  
                    <th style="width: 10%">Press</th>  
                    <th style="width: 10%">Webcast</th>  
                    <th style="width: 10%">News</th>  
                    <th style="width: 12%">Composer</th>
                    <th style="width: 25%">Action</th>
                   
                  </tr>
                </thead>
                <tbody> --}}
		
             
					
		@foreach($users as $user)
					<tr>
                    <td>{{ $user->user_id}}</td>
                    <td style="word-break:break-all">{{$user->mac_address}}</td>
                    <td style="word-break:break-all"><a href="{{URL::to('changeUserDetail')}}?uid={{ $user->user_id}}" style="cursor:pointer;text-decoration:underline">{{ $user->user_name}}</a></td>
                    <td style="word-break:break-all">{{ $user->user_email}}</td>
                    @if($user->user_status =='0')<td>Pending</td> @elseif($user->user_status =='1')<td>Active</td> @else <td>Disapproved/Removed</td> @endif
                    <td>{{ $user->isvarified =='1' ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->user_registerby}}</td>
                    <td style="word-break:break-all">{{ $user->ip_address}}</td>
                    <td style="word-break:break-all">{{ $user->signup_ip_address}}</td>
                    <td>{{ $user->isadmin =='1' ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->ismoderator =='1' ? 'Yes' : 'No' }}</td>  
                    <td>{{ $user->ispress =='1' ? 'Yes' : 'No' }}</td>  
                    <td>{{ $user->iswebcast =='1' ? 'Yes' : 'No' }}</td>  
                    <td>{{ $user->isprivate =='1' ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->iscomposer =='1' ? 'Yes' : 'No' }}</td>  
                    <td>
                    <a href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=delete" onclick="javascript:return confirm('Are you sure to permanently delete this user.')"  class="action_link">Delete</a>  &nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=moderator">Moderator</a>&nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=ispress">Press</a>&nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=iswebcast">Webcast</a>&nbsp;&nbsp;
                    <a class="action_link"  href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=iscomposer">Composer</a>&nbsp;&nbsp;     
                    <a class="action_link"  href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=isprivate">News</a>&nbsp;&nbsp;
                 	<a class="action_link"  href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=admin">Admin</a>&nbsp;&nbsp;
                  	<a class="action_link" href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=Approved">Approved</a> &nbsp;&nbsp;
                  	<a class="action_link" href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=disapprove">disapprove</a> &nbsp;&nbsp;
                    <a class="action_link" href="{{ request()->route()->uri }}?id={{ $user->user_id}}&action=varified">Verify email</a> &nbsp;&nbsp;
                 
					<a  class="action_link" href="changeUserDetail?uid={{ $user->user_id}}">Change Info</a>&nbsp;&nbsp;
		        	<a  class="action_link" href="changeUserPassword?uid={{ $user->user_id}}">Change Password</a>	   
						
					<a  class="action_link" href="{{URL::to('userMrHistory')}}?uid={{ $user->user_id}}" style="cursor:pointer;text-decoration:underline">User MR history</a>&nbsp;&nbsp;				
					{{--<span style="cursor:pointer; text-decoration:underline;" onclick="javascript:showbadge({{ $user->user_id}});"><strong>Assign Badge</strong></span>&nbsp;&nbsp;
                    <a  class="action_link" href="delete_badges?uid={{ $user->user_id}}">Remove Badge</a>&nbsp;&nbsp;--}}
                    <a class="action_link" href="{{URL::to('userIpHistory')}}?uid={{ $user->user_id}}">User IPs History</a> 
                        	      
                        
                    </td>  
                
                
                
                  </tr>
                @endforeach
               
                </tbody>
              </table>
              <div class="pagination-list">{{$users->links()}}</div>
            
            </div>
						
					</div>
</div>
          
        </div>
        
  
  @endsection