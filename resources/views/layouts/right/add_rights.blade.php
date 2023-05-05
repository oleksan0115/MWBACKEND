 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6"> @if(session()->has('message')) <div class="alert alert-success">
         {{ session()->get('message') }}
       </div> @endif <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}right">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Add Right</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_rights') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf 
		 <table class="advertise mt-2" border="0" cellpadding="3" cellspacing="3">
             <tr>
               <td>Right Group :</td>
               <td>
                 <input required name="tbox_newstitle" id="tbox_newstitle" type="text" value="" style="width:400px; height:30px" />
               </td>
             </tr>
             <tr>
               <td>Right :</td>
               <td>
                 <input required name="tbox_newsdesc" id="tbox_newsdesc" type="text" value="" style="width:400px; height:30px" />
               </td>
             </tr>
               <tr>
               <td>Status :</td>
               <td>
                 <input required name="chkbox_news" id="chkbox_news" type="checkbox" value="1" />
               </td>
             </tr>
			       <tr>
               <td valign="top" align="center">
                 <button type="submit" name="submit" class="btn btn-sm btn-primary">
                   <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Submit </button>
               </td>
             </tr>
           </table>
         
		</form>
       </div>
     </div>
   </div> @endsection