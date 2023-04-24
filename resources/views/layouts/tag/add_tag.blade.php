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
         <a href="{{ env('APP_URL') }}tag">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Add Tags</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_tag') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf <table width="633" border="0" cellpadding="3" cellspacing="3">
             <tr>
               <td align="center" class="page_heading_gray"></td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Tag  Name:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxtagsName" id="tboxtagsName" type="text" value="" class="input_textbox" />
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Mapping URI:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxtagsmappingurl" id="tboxtagsmappingurl" type="text" value="" class="input_textbox" />
               </td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Tag  Description:</td>
               <td width="1"></td>
               <td width="458" valign="top" align="left">
                 <textarea name="tAreatagsDesc" id="tAreatagsDesc" cols="20" rows="3"></textarea>
               </td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Meta Title:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxtagsmetatitle" id="tboxtagsmetatitle" type="text" value="" class="input_textbox" />
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Meta  Description:</td>
               <td width="1"></td>
               <td width="458" valign="top" align="left">
                 <textarea name="tboxtagsmetadescription" id="tboxtagsmetadescription" cols="20" rows="3"></textarea>
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Meta  Keywords:</td>
               <td width="1"></td>
               <td width="458" valign="top" align="left">
                 <textarea name="tboxtagsmetakeywords" id="tboxtagsmetakeywords" cols="20" rows="3"></textarea>
               </td>
             </tr>
			 
			  <tr>
			  <td align="left" valign="top" class="left_lable"></td>
			  <td></td>
			  <td valign="top" align="left"><input id="chkstatus" name="chkstatus" type="checkbox" value="1"  />&nbsp;&nbsp;Status</td>
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
