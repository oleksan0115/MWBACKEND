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
							
							
						<div class="col-sm-6"><h4><a href="{{URL::to('productAdd')}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Sticker</button></a></h4></div>	
           
           
           
           
            <div class="table-responsive">
              <table class="table mt-3 table-striped" style="width:max-content">
                <thead>
                  <tr>
                    <th width="250">product Name</th>
                    <th>Description</th>
                    <th>product</th>
                    <th>Credits</th>
                    <th>Quantity</th>
                    <th>Owner only</th>
                    <th>Status</th>
                    <th>Activation Start</th>
                    <th>Emojies</th>
                    <th>Action</th>
                    
                   
                  </tr>
                </thead>
                <tbody>
					
		@foreach($products as $product)
					<tr>
                    <td>{{ $product->product_name}}</td>
                    <td>{{ $product->product_description}}</td>
                    <td><img src="{{ env('APP_URL_IMAGE') }}/disneyland/images/products_thumbnail/{{ $product->product_image}}" width="80" height="80"></td>
                    <td>{{ $product->product_price}}</td>
                   
                    <td>
					
					{{-- <form action="{{ route('backend.add_product') }}" method="POST" enctype="multipart/form-data" class="product_table"  >
					@csrf
                   <div id="point_update{{ $product->id}}" style="display:none;">
											<input type="text" name="update_point" size="7" value="{{ $product->product_quantity}}" /> 
											<br />
											<a class="action_link" href="{{ request()->route()->uri }}?id={{ $product->id}}&action=quantity">Update</a>
											<br />
											<a class="action_link" href="Javascript:" onclick="Hidediv('point_update{{ $product->id}}')">Cancel</a>
					</div>
					</form>	--}}
					
											                             
											<div id="point_update_actions{{ $product->id}}" style="display:block;"><span id="p_qnty{{ $product->id}}"  name ="p_qnty{{ $product->id}}" >{{ $product->product_quantity}} </span>
											<br />
											
											{{-- <a class="action_link" href="Javascript:Showdiv('point_update{{ $product->id}}')">Update</a> --}}
											
											</div>     
                    
                    </td>
                    <td>{{ $product->owner_only}}</td>
                   
                    @switch($product->status)
                    @case('0')
                        <td>In Active</td>
                        @break
                
                    @case('1')
                        <td>Active</td>
                        @break
                
                      @case('2')
                        <td>Deleted</td>
                        @break
                    
                    @case('4')
                        <td>Special</td>
                        @break
                @endswitch
                   
                   
                    <td>{{ $product->active_datetime}}</td>
                    <td>{{ $product->isemojis =='0' ? 'No' : 'Yes' }}</td>
                    <td> 
					
					<a class="action_link" href="{{URL::to('productEdit')}}?id={{ $product->id}}&action=edit"><img src="{{ env('APP_URL_IMAGE') }}/admin/images/page_white_edit.png" border="0" /></a>&nbsp;&nbsp; 
                    
					<a class="action_link" href="{{ request()->route()->uri }}?id={{ $product->id}}&action=delete" onclick="return confirm('are you sure?')" ><img src="{{ env('APP_URL_IMAGE') }}/admin/images/file_delete.png" border="0" /></a>  
										
			</td>
                     
                  
                  </tr>
                @endforeach
               
                </tbody>
              </table>
             
             <div class="pagination-list">{{$products->links()}}</div>
            </div>
			
			
						
					</div>
</div>
          
        </div>

<script>
	function Showdiv(name) {
		var divname = name;
		temp = divname.split('point_update');
		var secdiv = "point_update_actions" + temp[1];

		var targetElement = document.getElementById(name);
		var targetElement2 = document.getElementById(secdiv);
		targetElement.style.display = 'block';
		targetElement2.style.display = 'none';
	}
	
		function Hidediv(name) {
		var divname = name;
		temp = divname.split('point_update');
		var secdiv = "point_update_actions" + temp[1];

		var targetElement = document.getElementById(name);
		var targetElement2 = document.getElementById(secdiv);
		targetElement.style.display = 'none';
		targetElement2.style.display = 'block';
	}
</script>
  
  @endsection
  
