@extends('layouts.common.dashboard')
@section('content')
<div class="content-wrapper">
<div class="content">
   <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
  
      @if(session()->has('message'))
      <div class="alert alert-success">
         {{ session()->get('message') }}
      </div>
      @endif
      <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
      </div>
      <div class="row pt-5">
     			<div class="col-xl-3 col-lg-4">
			    <form action="{{ route('backend.user_permission_menu') }}" method="POST" enctype="multipart/form-data">
			          @csrf
			     <label>Search User To Assign Right's</label>
							   <div class="input-group">
							      
  <input type="search" name="search" class="form-control rounded" placeholder="Username" aria-label="Search" aria-describedby="search-addon" />
  <button type="submit" class="btn btn-outline-primary">search</button>
</div>
</form>
							</div>
         <div class="table-responsive">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">User Id</th>
                     <th scope="col">UserName</th>
                     <th scope="col">Image</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
              <tbody>
					
					@foreach ($products as  $product)
					<tr>
                    <td style="word-break: break-all;">{{ $product->user_id}}</td>
                    <td style="word-break: break-all;"><a style="text-decoration:underline" href="{{URL::to('getUserPermissionMenuEdit')}}?id={{$product->user_id}}">{{ $product->user_name}}</a></td>
                    <td style="word-break: break-word;"><img width="70" src="../../disneyland/images/thumbs/{{ $product->image}}"></td>
                    <td style="word-break: break-all;"> 
					<a style="text-decoration:underline" href="{{URL::to('getUserPermissionMenuEdit')}}?id={{$product->user_id}}">Edit</a>
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
@endsection