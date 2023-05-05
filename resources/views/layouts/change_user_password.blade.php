 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		       @if(!empty($success))
				<div class="alert alert-success"> {{ $success }}</div>
				@endif
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
 <form action="{{ route('backend.changeUserPassword') }}?uid={{ $users->user_id}}" method="POST" enctype="multipart/form-data">
 @csrf	
				<table class="table table-bordered">
 
  <tbody>
    <tr>
      <td class="col-4">User Name</td>
      <td class="col-8"><input class="w-75" type="text" name="txtuser_name"  id="txtuser_name" value="{{$users->user_name}}"></td>
     </tr>
	  
	     <tr>
      <td class="col-4">User Email</td>
      <td><input type="email" class="w-75" name="txtuser_email"  id="txtuser_email" value="{{$users->user_email}}"></td>
     </tr>
	    <tr>
      <td>Password</td>
      <td><input type="password" class="w-75" name="txtuser_password" id="txtuser_password" value=""></td>
     </tr>
	    <tr>
      <td>Confirm Password</td>
      <td><input type="password" class="w-75" name="txtuser_cpassword"  id="txtuser_cpassword" value=""></td>
     </tr>
	

	  
	  <tr>
   
      <td><button type="submit" name="btnupdate" id="btnupdate" value="Update" class="btn btn-sm btn-primary">&nbsp; Update</button></td>
	
	  </tr>
  
   
  </tbody>
</table>
	</form>	
		</div>
          
  </div>
        
  
  @endsection