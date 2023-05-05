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
							
							
						<div class="col-sm-6"><h4><a href="{{URL::to('productCategoryAdd')}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Emojis Category</button></a></h4></div>	
           
					     
           
            <div class="table-responsive">
              <table class="table mt-3">
           
					  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">Image</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($products as $product)
    <tr>
   
      <td>{{ $product->emoji_category_name}}</td>
      <td>{{ $product->description}}</td>
   
	   <td><img src="{{ env('APP_URL_IMAGE') }}/disneyland/images/products_thumbnail/{{ $product->enoji_image}}" width="80" height="80"></td>
      <td>		<a class="action_link" href="{{URL::to('productCategoryEdit')}}?id={{$product->id}}&action=edit"><img src="{{ env('APP_URL_IMAGE') }}/admin/images/page_white_edit.png" border="0" /></a>&nbsp;&nbsp; 
                    
					<a class="action_link" href="{{ request()->route()->uri }}?id={{$product->id}}&action=delete" onclick="return confirm('are you sure?')" ><img src="{{ env('APP_URL_IMAGE') }}/admin/images/file_delete.png" border="0" /></a> </td>
    </tr>
     @endforeach
  </tbody>
               

			</table>
             
           
            </div>
			
			
				
						
					</div>
</div>
          
        </div>

  
  @endsection
  
