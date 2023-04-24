@extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
  <div class="content">
    <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6"> @if(!empty($successMsg)) <div class="alert alert-success"> {{ $successMsg }}</div> @endif @if(session()->has('message')) <div class="alert alert-success">
        {{ session()->get('message') }}
      </div> @endif <div class="d-flex justify-content-between">
        <h2 class="text-dark font-weight-medium"></h2>
      </div>
      <div class="row pt-5">
        <div class="col-sm-12 d-flex">
          <h4>
            <a href="{{URL::to('songAdd')}}">
              <button type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>&nbsp; Add Song </button>
            </a>
          </h4>
		 <form class="ml-5" action="{{ route('backend.adminSong.song') }}" method="POST" enctype="multipart/form-data"> 
		  @csrf <label>Sorted By</label>

            <div>
              <label class="radio_text">
                <input type="radio" name="Radio" value="new" checked <?php if($time =='new'){echo 'checked';} ?>> Newest </label>
              <label class="radio_text">
                <input type="radio" name="Radio" value="old" <?php if($time =='old'){echo 'checked';} ?>> Oldest </label>
              <button type="submit" class="btn btn-outline-primary">Sort</button>
            </div>
          </form>
		  
		      <form class="ml-5" action="{{ route('backend.adminSong.song') }}" method="POST" enctype="multipart/form-data"> 
			@csrf 
			 <div>
			 <label class="mr-2">Search BY :</label>
              <label class="radio_text">
                <input type="radio" name="RadioGroup1" value="singer" checked >  Singer Name </label>
              <label class="radio_text">
                <input type="radio" name="RadioGroup1" value="song">  Song Name </label>  
				<label class="radio_text">
                <input type="radio" name="RadioGroup1" value="album"> Album Name </label>
			</div>
			
			<div class="input-group">
			<input type="search" name="txt_search"  />
           
              <button type="submit" class="btn btn-outline-primary">Search</button>
			</div>
          </form>
		  
		  
        </div>
		
		 
        <div class="table-responsive" style="height:60vh;">
          <table class="table mt-3">
            <thead>
              <tr>
                <th scope="col">Song Id</th>
                <th scope="col">Singer Name</th>
                <th scope="col">Song Url</th>
                <th scope="col">Album Name</th>
                <th scope="col">Rank</th>
                <th scope="col">Song Name</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody> @foreach($products as $product) <tr>
                <td>{{ $product->id}}</td>
                <td>{{ $product->singer_name}}</td>
                <td>{{ $product->song_url}}</td>
                <td>{{ $product->album_name}}</td>
                <td>{{ $product->rank_to_show}}</td>
                <td>{{ $product->song_name}}</td>
                <td>{{ $product->status}}</td>
                <td>{{ $product->createdon}}</td>
                <td class="tblrows userlogos" align="center">
                  <a onclick="return confirm('are you sure?')" href="{{ request()->route()->uri }}?id={{$product->id}}&action=delete">Delete</a>&nbsp; <a href="{{URL::to('songEdit')}}?id={{$product->id}}&action=edit">Edit</a>&nbsp;
                </td>
              </tr> @endforeach </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> @endsection