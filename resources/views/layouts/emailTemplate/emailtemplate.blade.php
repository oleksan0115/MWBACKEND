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
         <div class="col-sm-6">
            <h4><a href="{{URL::to('emailTemplateAdd')}}"><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Email Template</button></a></h4>
         </div>
        <div class="table-responsive" style="height:60vh;">
            <table class="table mt-3">
               <thead>
                  <tr>
                     <th scope="col">Id</th>
                     <th scope="col">Template For</th>
                     <th scope="col">Subject</th>
                     <th scope="col">Description</th>
                     <th scope="col">Template</th>
                     <th scope="col">Action</th>
                  </tr>
               </thead>
               <tbody>
			  
                  @foreach($products as $product)
                  <tr>
			
                     <td>{{ $product->id}}</td>
                     <td>{{ $product->template_for}}</td>
					 <td>{{ $product->subject}}</td>
					 <td>{{ $product->description}}</td>
					   <td><?php echo(stripcslashes($product['template'])) ?></td>

					<td>
					<a  href="{{URL::to('emailTemplateEdit')}}?id={{$product->id}}">Edit</a>&nbsp;
					
					  </td>  
				
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection