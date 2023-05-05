 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
	 @if(session()->has('message')) <div class="alert alert-success">
         {{ session()->get('message') }}
       </div> @endif 
	   <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}userCreditSetting">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Add Credit Sale</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_user_credit_setting') }}" method="POST" enctype="multipart/form-data" class="product_table"> 
		 @csrf 
		 <table width="633" border="0" cellpadding="3" cellspacing="3">
            
	 <div class="row mb-5 pb-3">
  
    <div class="col-12 col-md-8">
	<h3 class="font-weight-bold text-center">Credits Setting</h3>
	<h4 class="font-weight-bold text-center mt-3">Current Server Time : {{ date('Y-m-d H:i:s') }}</h4>
	</div>
  
  </div>

	<div class="row mb-5">
    <div class="col-6 col-md-2">Number of Times:</div>
    <div class="col-6 col-md-10"><input required name="tbox_no_of_time" type="text" value="" class="input_textbox">
	<span class="text-dark ml-2">1 Mean normal ,2 Mean double , 3 Mean tripple point </span></div>
   
  </div>
	
	<div class="row mb-5">
    <div class="col-6 col-md-2">From Date:</div>

	
	 <div class="col-6 col-md-10"><input required type="text" value="" id="from_datetime" name="from_datetime">
	</div>
   
	</div>
  
    <div class="row mb-5">
    <div class="col-6 col-md-2">End Date:</div>
   
	
	<div class="col-6 col-md-10"><input required type="text" value="" id="end_datetime" name="end_datetime">
	</div>
   
	</div>
  
    <div class="row mb-5">
    <div class="col-6 col-md-2">Status:</div>
    <div class="col-6 col-md-10"><input required id="chk_status" name="chk_status" type="checkbox" value="1"></div>
   
	</div>
  
 
	<div class="row mb-5">
	    <div class="col-6 col-md-10">
		<input id="hidden_id" name="hidden_id" type="hidden" value="0">
		 <button type="submit" name="submit" class="btn btn-sm btn-primary">
		<i class="mdi mdi-keyboard-backspace"></i>&nbsp; Submit </button>
		</div>
   
	</div>		
  
	</table>
         </form>
       </div>
     </div>
   </div> @endsection
