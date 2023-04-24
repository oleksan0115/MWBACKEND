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
            <a href="{{URL::to('newsAdd')}}">
              <button type="button" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>&nbsp; Add News </button>
            </a>
          </h4>
        </div>
		
		 
        <div class="table-responsive" style="height:60vh;">
          <table class="table mt-3">
            <thead>
              <tr>
                <th scope="col">Park</th>
                <th scope="col">Title</th>
                <th scope="col">DL Mob</th>
                <th scope="col">DL For Web</th>
                <th scope="col">WDW Mob</th>
                <th scope="col">WDW Web</th>
                <th scope="col">Today News</th>
                <th scope="col">Hyperlink</th>
                <th scope="col">Text</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody> @foreach($products as $product) <tr>

                <td>{{ $product->park}}</td>
                <td><?php echo(stripcslashes($product->new_title)) ?></td>
                <td><?php echo(stripcslashes($product->news_description)) ?></td>
                <td><?php echo(stripcslashes($product->news_description_web)) ?></td>
                <td><?php echo(stripcslashes($product->news_description_wdw)) ?></td>
                <td><?php echo(stripcslashes($product->news_description_web_wdw)) ?></td>
                <td><?php if($product->istoday_news ==1){echo 'Yes';}else {echo 'No';} ?> </td>
                <td>{{ $product->hyperlink}}</td>
                <td>{{ $product->texttolink}}</td>
                <td class="tblrows userlogos" align="center">
                  <a onclick="return confirm('are you sure?')" href="{{ request()->route()->uri }}?id={{$product->id}}&action=delete">Delete</a>&nbsp; <a href="{{URL::to('newsEdit')}}?id={{$product->id}}&action=edit">Edit</a>&nbsp;
                </td>
              </tr> @endforeach </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> @endsection