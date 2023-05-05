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
		   <h4><a href="{{URL::to('/leaderboard?type=d')}}"><button type="button" class="btn btn-sm btn-primary">Days</button></a></h4>
		    <h4 class="ml-2"><a href="{{URL::to('/leaderboard?type=w')}}"><button type="button" class="btn btn-sm btn-primary">Weekly</button></a></h4>
			<h4 class="ml-2"><a href="{{URL::to('/leaderboard?type=m')}}"><button type="button" class="btn btn-sm btn-primary">Monthly</button></a></h4>
			
          
           
           
         </div>
         <div class="table-responsive">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">S.No.</th>
                     <th scope="col">User Name</th>
                     <th scope="col">Period Points</th>
                     <th scope="col">Overall Total Points</th>
                     <th scope="col">Overall Rank</th>
                     <th scope="col">Overall Position</th>
                  </tr>
               </thead>
               <tbody>
			   <?php $counter = 1; ?>
                  @foreach($products as $product)
                  <tr>
                   
					  <td>{{ $counter}}</td>
                     <td> <a style="text-decoration:underline" href="{{URL::to('leaderboardDetail')}}?type={{request()->get('type')}}&pname=DL&userid={{ $product->user_id}}">{{ $product->user_name}}</a></td>
                     <td>{{ $product->lbtotalpoints}}</td>
                     <td>{{ $product->totalpoints}}</td>
                     <td>{{ $product->rank}}</td>
                     <td>{{ $product->position}}</td>
                 
					  <?php $counter += 1;  ?>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection