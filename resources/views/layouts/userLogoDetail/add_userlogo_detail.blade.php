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
         <a href="{{ env('APP_URL') }}userLogo">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Assign Logo to User</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_userlogo_detail') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf <table width="633" border="0" cellpadding="3" cellspacing="3">
         
             <tr>
			<td align="left">
                <input name="txt_cat_name" id="txt_cat_name" type="text" value="" class="user-input input_textbox ml-2" placeholder="Serach User..." />
				  <input type="hidden" name="hid_id" id="hid_id" value="{{ request('id')}}"/>
				 <button type="submit" name="submit" class="btn btn-sm btn-primary">
                 Submit </button> 
               </td>
			   
             </tr>
   

         
           </table>
         </form>
       </div>
     </div>
   </div> @endsection
   