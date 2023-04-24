@extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
  <div class="content">
    <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6"> @if(!empty($successMsg)) <div class="alert alert-success"> {{ $successMsg }}</div> @endif @if(session()->has('message')) <div class="alert alert-success">
        {{ session()->get('message') }}
      </div> @endif <div class="d-flex justify-content-between">
        <h2 class="text-dark font-weight-medium"></h2>
      </div>
      <div class="row pt-5">
        <div class="col-sm-6">
          <h4>
            <a href="{{URL::to('rightAdd')}}">
              <button type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>&nbsp; Add Right </button>
            </a>
          </h4>
        </div>
		
		 
        <div class="table-responsive" style="height:60vh;">
          <table class="table mt-3">
            <thead>
              <tr>
                <th scope="col">Right Group</th>
                <th scope="col">Right</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody> @foreach($products as $product) <tr>

                <td>{{ $product->right_group}}</td>
                <td>{{ $product->rights}}</td>
                <td>{{ $product->status}}</td>
         
              </tr> @endforeach </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> @endsection