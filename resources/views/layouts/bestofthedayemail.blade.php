 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		      @if(!empty($successMsg))
				<div class="alert alert-success"> {{ $successMsg }}</div>
				@endif
				
				 @if(session()->has('message'))
				<div class="alert alert-success">
				{{ session()->get('message') }}
				</div>
				@endif
				
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
						<div class="row pt-5">
							
					
           
           
            <div class="table-responsive">
              <table class="table mt-3 table-striped" style="width:max-content">
                <thead>
                  <tr>
                    <th>User Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Today</th>
                    <th>Last Email</th>
                    <th>Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>
					
		@foreach($products as $product)
					<tr>
                    <td>{{ $product->user->user_id}}</td>
                    <td><a href="{{URL::to('changeUserDetail')}}?uid={{ $product->user->user_id}}">{{ $product->user->user_name}}</a></td>
                    <td>{{ $product->user->user_email}}</td>
                    <td>{{ $product->istodaysent}}</td>
                    <td>{{ $product->sentdatetime}}</td>
               
                    <td> 
					<a class="action_link" href="{{ request()->route()->uri }}?id={{ $product->id}}&action=delete" onclick="return confirm('are you sure?')" >Delete</a>  
					</td>
                     
                  
                  </tr>
                @endforeach
               
                </tbody>
              </table>
             
           
            </div>
			
			
						
					</div>
</div>
          
        </div>

  @endsection
  
