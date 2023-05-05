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
	   <h5 style="font-weight:600">List of Special Products Alloted Users.<h5>
      <div class="row pt-5">
	  
         <div class="col-sm-6">
            <h4><a href="{{URL::to('userLogoDetailAdd')}}?id={{request('id');}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Assign Logo to User</button></a>
				
			</h4>
			
         </div>
	
         <div class="table-responsive">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">User</th>
                     <th scope="col">User Name</th>
                     <th scope="col">Product</th>
                     <th scope="col">Allot Logo</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
               <tbody>
			
                  @foreach($products as $product)
                  <tr>
				    <td><img width="75" height="75" src="../../disneyland/images/thumbs/{{ $product->user_image}}"></td>
                     <td>{{ $product->user_name}}</td>
                     <td>{{ $product->image_name}}</td>
                     <td><img width="75" height="75" src="../../images/user_special_logos/{{ $product->image}}"></td>
					 <td class="tblrows userlogos" align="center">
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