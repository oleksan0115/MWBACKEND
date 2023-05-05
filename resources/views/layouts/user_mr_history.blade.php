 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		  
	
				
	<a href="{{ env('APP_URL') }}users"><button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back</button></a> 


			
						
	<div class="row pt-5">
							
	


<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Points</th>
      <th scope="col">Date</th>
      <th scope="col">Location</th>
      <th scope="col">Who is</th>
      <th scope="col">Ip Address</th>
  
    </tr>
  </thead>
  <tbody>
  <?php foreach($result as $row){ ?>
    <tr>
	  <td>{{ $row->username}}</td>
      <td>{{ $row->availpoints}}</td>
      <td>{{ $row->tld_date}}</td>
      <td>{{ $row->Type}}</td>
	  <td>{{ $row->whois}}</td>
	  <td>{{ $row->ip_address}}</td>

    </tr>
  <?php } ?>
  </tbody>
</table>
 
           
           		
				</div>
				
		</div>
          
  </div>
        
  
  @endsection