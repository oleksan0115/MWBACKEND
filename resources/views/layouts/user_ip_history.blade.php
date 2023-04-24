 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		  
	
				
	<a href="{{ env('APP_URL') }}users"><button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back</button></a> 


	<div height="1" colspan="3" style="font-size:16px; color:#000; font-family:Arial, Helvetica, sans-serif;" align="center">User History of IPs </div>				
					
			
						
	<div class="row pt-5">
							
	


<table class="table">
  <thead class="thead-dark">
 
    <tr>
      <th scope="col">Ip Address</th>
      <th scope="col">Type</th>
      <th scope="col">User</th>
      <th scope="col">User id</th>
      <th scope="col">DateTime</th>
      <th scope="col">User status</th>
  
    </tr>
  </thead>
  <tbody>
  <?php foreach($result as $row){ ?>
    <tr>
	  <td>{{ $row->ip_address}}</td>
      <td>{{ $row->type}}</td>
      <td>{{ $row->user_name}}</td>
      <td>{{ $row->user_id}}</td>
	  <td>{{ $row->datetime}}</td>
	  <td><?php 	$user_status  = $row->user_status;
					if(!empty($user_status ))
												{
													switch ($user_status)
													{
														case'1':
														$user_status  = 'Active';
														break;
														case'2':
														case'3':
														case'4':
														$user_status  = 'Delete / Ban';
														break; 
													} 
												}
 echo $user_status; ?></td>

    </tr>
  <?php } ?>
  </tbody>
</table>
 
           
           		
				</div>
				
		</div>
          
  </div>
        
  
  @endsection