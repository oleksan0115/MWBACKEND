 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		      
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
						<div class="row pt-5">
							
							<div class="col-xl-3 col-lg-4">
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
							</div>
		
			<div class="col-xl-3 col-lg-4">
			     <label>Search By Username</label>
							   <div class="input-group">
							      
  <input type="search" class="form-control rounded" placeholder="Username" aria-label="Search" aria-describedby="search-addon" />
  <button type="button" class="btn btn-outline-primary">search</button>
</div>
							</div>
           
           
        
           
           
           
           
           
            <div class="table-responsive">
              <table class="table mt-3 table-striped" style="width:max-content">
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Mac Address</th>
                    <th width="50">IP Address</th>
                    <th width="50">Status</th>
                    <th width="50">Email Status</th>
                    <th width="50">Created on</th>
                    <th width="300">Action</th>
                   
                  </tr>
                </thead>
                <tbody>
					
	            @foreach ($approvedusers as  $approveduser)
					<tr>
					    
                    <td>{{ $approveduser->user_id}}</td>
                    <td>{{ $approveduser->user_name}}</td>
                    <td>{{ $approveduser->user_email}}</td>
                    <td>{{ $approveduser->mac_address}}</td>
                    <td style="word-break: break-all;">{{ $approveduser->ip_address}}</td>
                    <td style="word-break: break-all;">{{ $approveduser->user_status}}</td>
                    <td style="word-break: break-all;">{{ $approveduser->isvarified}}</td>
                    <td style="word-break: break-all;">{{ $approveduser->creation_date}}</td>
                    <td><a class="action_link" href="{{ request()->route()->uri }}?id={{ $approveduser->user_id}}&action=disapprove">disapprove</a>
                                              &nbsp;&nbsp;<a class="action_link" href="{{ request()->route()->uri }}?id={{ $approveduser->user_id}}&action=verifyemail">Verify email</a> </td>
                    
                    
                  
                  </tr>
                @endforeach
               
                </tbody>
              </table>
              <div class="pagination-list"></div>
            
            </div>
						
					</div>
</div>
          
        </div>
        
  
  @endsection