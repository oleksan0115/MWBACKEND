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
         <div class="col-sm-6">
            <h4><a href="{{URL::to('tagAdd')}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Tags</button></a></h4>
         </div>
         <div class="table-responsive">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">Badge Name</th>
                     <th scope="col">Mapping URL</th>
                     <th scope="col">Description</th>
                     <th scope="col">Meta Title</th>
                     <th scope="col">Meta Desc</th>
                     <th scope="col">Meta Keywords</th>
                     <th scope="col">Status</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
               <tbody>
			  
                  @foreach($products as $product)
                  <tr>
				    
                     <td>{{ $product->tags_name}}</td>
                     <td>{{ $product->mapping_url}}</td>
                     <td>{{ $product->tags_description}}</td>
                     <td>{{ $product->meta_titles}}</td>
                     <td>{{ $product->meta_description}}</td>
                     <td>{{ $product->meta_keywords}}</td>
				     @switch($product->status)
						@case('0')
							<td>In Active</td>
							@break
					
						@case('1')
							<td>Active</td>
							@break
					@endswitch
						<td>
						 <a  href="{{URL::to('tagEdit')}}?id={{$product->id}}&action=edit">Edit</a>&nbsp;
					  <a onclick="return confirm('are you sure?')"  href="{{ request()->route()->uri }}?id={{$product->id}}&action=delete">Delete</a>&nbsp;
					 
					
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