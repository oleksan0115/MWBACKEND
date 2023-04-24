 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6"> @if(session()->has('message')) <div class="alert alert-success">
         {{ session()->get('message') }}
       </div> @endif <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}news">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Add News</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_news') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf 
		 <table class="advertise mt-2" border="0" cellpadding="3" cellspacing="3">
             <tr>
               <td>Park :</td>
               <td>
                 <select id="ddl_park" name="ddl_park">
                   <option  value="DL">DL</option>
                   <option  value="WDW">WDW</option>
                   <option value="NR">Normal</option>
                 </select>
               </td>
             </tr>
             <tr>
               <td>Is today News :</td>
               <td>
                 <input name="chkbox_news" id="chkbox_news" type="checkbox" value="1" />
               </td>
             </tr>
             <tr>
               <td>News Type :</td>
               <td>
                 <input name="chk_newstype_free" id="chk_newstype_free" type="checkbox" value="1">Free</input>
                 <input name="chk_newstype_paid" id="chk_newstype_paid" type="checkbox" value="1">Paid</input>
                 <input name="chk_newstype_normal" id="chk_newstype_normal" type="checkbox" value="1">None</input>
               </td>
             </tr>
             <tr>
               <td>Title :</td>
               <td>
                 <input name="tbox_newstitle" id="tbox_newstitle" type="text" value="" style="width:400px; height:30px" />
               </td>
             </tr>
             <tr>
               <td>Hyperlink in News :</td>
               <td>
                 <input name="tbox_hyperlink" id="tbox_hyperlink" type="text" value="" style="width:400px; height:30px" />
               <td>http://www.google.com</td>
               </td>
             </tr>
             <tr>
               <td>Text to link :</td>
               <td>
                 <input name="tbox_texttolink" id="tbox_texttolink" type="text" value="" style="width:400px; height:30px" />
               <td>Google</td>
               </td>
             </tr>
           </table>
           <table class="advertise">
             <tr>
			 <td>News DL Mobile:</td>
               <td>
                 <textarea name="tbox_newsdesc" id="tbox_newsdesc" class="ckeditor"></textarea>
               </td>
             </tr>
             <tr>
			 <td>News DL Web:</td>
               <td>
                 <textarea name="tbox_newsdesc_web" id="tbox_newsdesc_web" class="ckeditor"></textarea>
               </td>
             </tr>
             <tr>
			 <td>News for WDW Mobile:</td>
               <td>
                 <textarea name="tbox_newsdesc_wdw" id="tbox_newsdesc_wdw" class="ckeditor"></textarea>
               </td>
             </tr>
             <tr>
			 <td>News For WDW Web:</td>
               <td>
                 <textarea name="tbox_newsdesc_web_wdw" id="tbox_newsdesc_web_wdw" class="ckeditor"></textarea>
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