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
      <div class="row">
         <div class="col-sm-6">
            <h4><a href="{{URL::to('advertisePostAdd')}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Advertise Post</button></a></h4>
         </div>
        <div class="table-responsive" style="height:60vh;">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">Id</th>
                     <th scope="col">Post</th>
                     <th scope="col">Post image</th>
                     <th scope="col">Video</th>
                     <th scope="col">Username</th>
                     <th scope="col">Username Link</th>
                     <th scope="col">Pics</th>
                     <th scope="col">Status</th>
                     <th scope="col">Is Priority</th>
                     <th scope="col">Lounge</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
               <tbody>
			  
                  @foreach($products as $product)
                  <tr>
				  <?php if($product['chat'] != null){  ?>
                     <td>{{ $product->id}}</td>
                     <td><?php echo(stripcslashes($product['chat']['chat_msg'])) ?></td>
                     <td><img src="{{ env('APP_URL_IMAGE') }}/disneyland/chat_images_thumbnail/{{ $product->chat->chat_img}}" width="50" height="50"  /></td>
                     <td><?php echo $product['chat']['chat_video'] ?></td>
                     <td>{{ $product->username}}</td>
                     <td>{{ $product->username_link}}</td>
                     <td><img src="{{ env('APP_URL_IMAGE') }}/disneyland/images/thumbs/{{ $product->user_image}}" width="50" height="50"  /></td>
                   
				     @switch($product->status)
						@case('0')
							<td>0</td>
							@break
					
						@case('1')	
							<td>1</td>
							@break
					@endswitch
					
					  <td>{{ $product->ispriority}}</td>
                     <td>{{ $product->lounge}}</td>
						<td>
						 <a  href="{{URL::to('advertisePostEdit')}}?eid={{$product->id}}&lounge={{$product->lounge}}">Edit</a>&nbsp;
					  <a onclick="return confirm('are you sure?')"  href="{{ request()->route()->uri }}?msgid={{$product->id}}&lounge={{$product->lounge}}">Delete</a>&nbsp;
					 
					
					  </td>  
				  <?php } ?>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection