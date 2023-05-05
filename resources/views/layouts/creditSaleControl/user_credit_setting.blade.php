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
         <div class="col-sm-6 mb-3">
            <h4><a href="{{URL::to('userCreditSettingAdd')}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Credit Sale</button></a></h4>
         </div>
         <div class="table-responsive">
            
<table class="table">
  <thead>
    <tr>
      <th scope="col">No Of Times</th>
      <th scope="col">From Datetime</th>
      <th scope="col">End Datetime</th>
      <th scope="col">Type</th>
      <th scope="col">Status</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
   @foreach($allcredit as $row)
    <tr>
      <th scope="row">{{ $row->no_of_times }}</th>
      <td>{{ $row->start_date }}</td>
      <td>{{ $row->end_date}}</td>
      <td>{{ $row->type}}</td>
      <td>{{ $row->status =='1' ? 'Active' : 'Inactive' }}</td>
      <td> <a  href="{{URL::to('userCreditSettingEdit')}}?id={{$row->id}}&action=edit">Edit</a>&nbsp;
					  <a onclick="return confirm('are you sure?')"  href="{{ request()->route()->uri }}?id={{$row->id}}&action=delete">Delete</a>&nbsp;</td>
    </tr>
	
	  @endforeach
    
  </tbody>
</table>

         </div>
      </div>
   </div>
</div>
@endsection