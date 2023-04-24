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
      {{-- {{request()->get('type')}} to get request varin=ble in blade file--}}
      <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
      </div>
      <div class="row pt-5">
         
		 <div class="col-sm-6 d-flex myclass">
		      <h4><a href="{{URL::to('/wdwLeaderboard?type=d')}}"><button type="button" class="btn btn-sm btn-primary">Days</button></a></h4>
			  	 <h4 class="ml-2"><a href="{{URL::to('/wdwLeaderboard?type=w')}}"><button type="button" class="btn btn-sm btn-primary">Weekly</button></a></h4>
			<h4 class="ml-2"><a href="{{URL::to('/wdwLeaderboard?type=m')}}"><button type="button" class="btn btn-sm btn-primary">Monthly</button></a></h4>
		
       
		 </div>
		   
		   
         <div class="table-responsive">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">S.No</th>
                     <th scope="col">User Name</th>
                     <th scope="col">Points avail</th>
                     <th scope="col">Point from</th>
                     <th scope="col">Date</th>
                     <th scope="col">Park</th>
                  </tr>
               </thead>
												
										 
                                         
                               
								
               <tbody>
			   <?php $counter = 1; $totalpoints = 0; ?>
                  @foreach($products as $product)
				  <?php $availpoints = $product->availpoints; ?>
                  <tr>
                    <td>{{ $counter}}</td>
                     <td>{{ $product->user_name}}</td>
                     <td>{{ $product->availpoints}}</td>
                     <td>{{ $product->Type}}</td>
                     <td>{{ $product->createdon}}</td>
                     <td>{{ $product->Park_name}}</td>
                   
           <?php $counter += 1; $totalpoints+=$availpoints ; ?>
                  </tr>
                  @endforeach
				  
				  
				     <tr>
                     <td></td>
                     <td><strong>Grand Total</strong></td>
                     <td><strong><?php echo $totalpoints; ?></strong></td>
                     <td></td>
                     <td></td>
                     <td></td>
					</tr>
					
					
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection