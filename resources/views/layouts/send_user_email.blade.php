 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		       @if(!empty($success))
				<div class="alert alert-success"> {{ $success }}</div>
				@endif
			 <form action="{{ route('backend.sendUserMail') }}?uid={{ $users->user_id}}" method="POST" enctype="multipart/form-data">
			@csrf	
			
			<div class="email-wrapper rounded border bg-white">
    <div class="row no-gutters">
  
      
	  
	  
	  <div class="col-lg-12 col-xl-9 col-xxl-10">
        <div class="email-right-column  email-body p-4 p-xl-5">
          <div class="email-body-head mb-5 ">
            <h4 class="text-dark text-uppercase">SEND MAIL TO {{ $users->user_name}}</h4>
          </div>
         
            
            <div class="form-group">
			<label for="exampleSubject">Subject</label>
              <input type="text" name="tboxsubject" class="form-control" id="exampleSubject" placeholder="Subject ">
            </div>
           <div class="form-group shadow-textarea">
		<label for="exampleFormControlTextarea6">Message</label>
		<textarea class="form-control z-depth-1" name="tboxmessage" id="exampleFormControlTextarea6" rows="3" placeholder="Write something here..."></textarea>
		</div>
            
        
         
          <button type="submit" name="btnsubmit" id="btnsubmit" value="Send Mail" class="btn btn-primary btn-pill mb-5" >Send Mail</button>
        </div>
      </div>
    </div>
  </div>

				
	</form>	
		</div>
          
  </div>
        
  
  @endsection