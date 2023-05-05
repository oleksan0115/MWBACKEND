 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
       <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}userLogo">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Edit User Logo</h3>
       </div>
       <div class="row pt-5">
         <form action="" method="POST" enctype="multipart/form-data" class="product_table"> @csrf <table width="633" border="0" cellpadding="3" cellspacing="3">
             <tr>
               <td align="center" class="page_heading_gray"></td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Product Name:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="txt_cat_name" id="txt_cat_name" type="text" value="{{ $products->image_name}}" class="input_textbox" />
               </td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Product Description:</td>
               <td width="1"></td>
               <td width="458" valign="top" align="left">
                 <textarea name="txt_cat_desc" id="txt_cat_desc" cols="50" rows="5">{{ $products->image_desc}}</textarea>
               </td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Image:</td>
               <td width="1"></td>
               <td width="458" height="30" valign="top" align="left">
                 <input name="myfile" id="myfile" type="file"  onchange="readURL(this)" style="margin-bottom:1rem" />
				  <img id="img-preview" width="50px" src="/images/user_special_logos/{{ $products->image}}" />
               </td>
             </tr>
             <tr>
               <td valign="top" align="center">
                 <input type="hidden" name="hdd_product_id" id="hdd_product_id" value="{{ $products->id}}" />
                 <button type="submit" name="submit" class="btn btn-sm btn-primary">
                   <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Submit </button>
               </td>
             </tr>
           </table>
         </form>
       </div>
     </div>
   </div> @endsection
   
   
      <script>
   //Change this to your no-image file

function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
		
      $("#img-preview").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  } 
}

   </script>