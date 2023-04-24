 
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
                    <th width="300">Chat Post</th>
                    <th width="100">Image</th>
                    <th width="100">Posted By </th>
                    <th width="100">Reported By </th>
                    <th width="100">Reported on </th>
                    <th width="100">Current Status</th>
                    <th width="250">Reason</th>
                    <th width="100">Action</th>
                   
                  </tr>
                </thead>
                <tbody>
					
					@foreach($reports as $report)
					<tr>
					<?php if($report->chat != null){ ?>
                    <td style="word-break: break-word;">{{ $report->chat->chat_msg}}</td>
					 <td><img src="{{ env('APP_URL_IMAGE') }}/disneyland/chat_images/{{ $report->chat->chat_img}}" width="80" height="80"></td>
					  <td style="word-break: break-all;">{{ $report->chat->user->user_name}}</td>
                    <td style="word-break: break-all;">{{ $report->repusername}}</td>
                    <td style="word-break: break-all;">{{ $report->createdon}}</td>
                    <td style="word-break: break-all;">{{ $report->chat->chat_status}}</td>
                    <td style="word-break: break-word;">{{ $report->reasion_for_report}}</td>
                    <td>
					
					<a class="action_link" onclick="return confirm('are you sure to restore this post?')"  href="{{ request()->route()->uri }}?id={{$report->chat->chat_id}}&action=restore">Restore</a> 
					
					
					&nbsp;&nbsp;<a class="action_link"  onclick="return confirm('are you sure?')"  href="{{ request()->route()->uri }}?id={{$report->chat->chat_id}}&action=delete">Delete</a> 
					
					</td>
					<?php } ?>
                   
                   
                  
                  </tr>
                @endforeach
               
                </tbody>
              </table>
              <div class="pagination-list">{{$reports->links()}}</div>
            
            </div>
						
					</div>
</div>
          
        </div>
        
  
  @endsection