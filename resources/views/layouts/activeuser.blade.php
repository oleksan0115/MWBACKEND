 
  @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		      <div  style=" font-size:18px; text-align:center; font-family:'Courier New', Courier, monospace">Active Users </div>
						<!--div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium">Invoice #264648</h2>
							<div class="btn-group">
								<button class="btn btn-sm btn-light">
									<i class="mdi mdi-content-save"></i> Save</button>
								<button class="btn btn-sm btn-secondary">
									<i class="mdi mdi-printer"></i> Print</button>
							</div>
						</div-->
						<div class="row pt-5">
							
							<div class="col-xl-3 col-lg-4">
								<p class="text-dark mb-2">Section !</p>
							
							</div>
							<div class="col-xl-4 col-lg-4">
								<p class="text-dark">Statistics:  {{ $startdate}} TO:  {{ $enddate}}</p>
							    <p class="text-dark">Post:  {{$getpostcountbyday}}</p>
							    <p class="text-dark">Comments:  {{$getcommentcountbyday}}</p>
							    <p class="text-dark">Replies:  {{$getreplycountbyday}}</p>
							    <p class="text-dark">Post Thanks:  {{$getthankyoucountbyday}}</p>
							    <p class="text-dark">Post Likes:  {{$getlikecountbyday}}</p>
							    <p class="text-dark">Comment Likes:  {{$getcommentlikecountbyday}}</p>
							    <p class="text-dark">Active Users:  {{$getactiveusercountbyday}}</p>
							</div>
							<!--div class="col-xl-3 col-lg-4">
								<p class="text-dark mb-2">Details</p>
								<address>
									Invoice ID:
									<span class="text-dark">#2365546</span>
									<br> March 25, 2018
									<br> VAT: PL6541215450
								</address>
							</div-->
            </div>
		
           
           
        
           
           
           
           
           
            <div class="table-responsive">
              <table class="table mt-3 table-striped" style="width:max-content">
                <thead>
                  <tr>
                    <th width="100">Image</th>
                    <th width="100">User Name</th>
                    <th width="100">User ID</th>
                    <th width="200">User Email</th>
                    <th width="100">Signup IP</th>
                    <th width="100">Datetime</th>
                    <th width="100">Last Ip Address</th>
                    <th width="100">User Rank</th>
                    <th width="100">Position</th>
                    <th width="200">Total Point</th>
                  </tr>
                </thead>
                <tbody>
					
					@foreach($posts as $user)
					<tr>
                    <td><img src="{{ env('APP_URL_IMAGE') }}/disneyland/images/thumbs/{{ $user->user->image}}" width="80" height="80"></td>
                    <td width="100" style="word-break: break-all;">{{ $user->user_name}}</td>
                    <td>{{ $user->user_id}}</td>
                    <td style="word-break: break-all;">{{ $user->user->user_email}}</td>
                    <td style="word-break: break-all;">{{ $user->ip_address}}</td>
                    <td>{{ $user->login_datetime}}</td>
                    <td style="word-break: break-all;">{{ $user->user->ip_address}}</td>
                    <td>{{ $user->user->rank}}</td>
                    <td>{{ $user->user->position}}</td>
                    <td>{{ $user->user->totalpoints}}</td>
                  </tr>
              @endforeach
               
                </tbody>
              </table>
            <div class="pagination-list">{{$posts->links()}}</div>
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