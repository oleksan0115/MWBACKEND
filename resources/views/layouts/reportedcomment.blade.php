 
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
                    <th width="350">Chat Post</th>
                
                    <th width="150">Posted By </th>
                    <th width="150">Reported By </th>
                    <th width="150">Reported on </th>
              
                    <th width="250">Reason</th>
                    <th width="50">Chat Type</th>
                    <th width="100">Action</th>
                   
                  </tr>
                </thead>
                <tbody>
					
					@foreach ($reports as  $report)
					<tr>
					     @foreach ($report->comments as $comment)
                    <td style="word-break: break-word;">{{ $comment->chat_msg}}</td>
                     <td style="word-break: break-all;">{{ $comment->commentuser->user_name}}</td>
                    @endforeach
                   
                    <td style="word-break: break-all;">{{ $report->repusername}}</td>
                    <td style="word-break: break-all;">{{ $report->createdon}}</td>
                    <td style="word-break: break-word;">{{ $report->reasion_for_report}}</td>
                    <td style="word-break: break-all;">{{ $report->type}}</td>
                    
					@foreach ($report->comments as $comment)
                    <td>
					<a class="action_link" onclick="return confirm('are you sure to restore this comment?')"  href="{{ request()->route()->uri }}?id={{$comment->chat_reply_id}}&action=restore">Restore</a> 
					
					
					&nbsp;&nbsp;<a class="action_link"  onclick="return confirm('are you sure?')"  href="{{ request()->route()->uri }}?id={{$comment->chat_reply_id}}&action=delete">Delete</a> 
					</td>
                   @endforeach
                  </tr>
                @endforeach
               
                </tbody>
              </table>
              <div class="pagination-list">{{$reports->links()}}</div>
            
            </div>
						<!--div class="row justify-content-end">
							<div class="col-lg-5 col-xl-4 col-xl-3 ml-sm-auto">
								<ul class="list-unstyled mt-4">
									<li class="mid pb-3 text-dark"> Subtotal
										<span class="d-inline-block float-right text-default">$7.897,00</span>
									</li>
									<li class="mid pb-3 text-dark">Vat(10%)
										<span class="d-inline-block float-right text-default">$789,70</span>
									</li>
									<li class="pb-3 text-dark">Total
										<span class="d-inline-block float-right">$8.686,70</span>
									</li>
								</ul>
								<a href="#" class="btn btn-block mt-2 btn-lg btn-primary btn-pill"> Procced to Payment</a>
							</div>
						</div-->
					</div>
</div>
          
        </div>
        
  
  @endsection