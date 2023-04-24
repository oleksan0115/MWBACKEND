 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
       <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}song">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Edit Song</h3>
       </div>
       <div class="row pt-5">
         <form action="" method="POST" enctype="multipart/form-data" class="product_table"> 
		 @csrf 
		 <table width="633" border="0" cellpadding="3" cellspacing="3">
             <tr>
               <td align="center" class="page_heading_gray"></td>
             </tr>
              <form action="{{ route('backend.add_song') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf <table width="633" border="0" cellpadding="3" cellspacing="3">
             <tr>
               <td align="center" class="page_heading_gray"></td>
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Song Name:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxSongName" id="tboxSongName" type="text" value="{{ $products->song_name}}" class="input_textbox" />
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Singer Name:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxSingerName" id="tboxSingerName" type="text" value="{{ $products->singer_name}}" class="input_textbox" />
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Album Name:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxAlbumName" id="tboxAlbumName" type="text" value="{{ $products->album_name}}" class="input_textbox" />
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Song URL:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
                 <input name="tboxSongURL" id="tboxSongURL" type="text" value="{{ $products->song_url}}" class="input_textbox" />
               </td>
             </tr>
			      <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Rank Value:</td>
               <td width="1"></td>
               <td width="458" align="left" valign="top">
			    Rank to unlock Song in Apps	
                 <input name="tboxRank" id="tboxRank" type="text" value="{{ $products->rank_to_show}}" class="input_textbox" />
				 
               </td>
			  
             </tr>
             <tr>
               <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Song Description:</td>
               <td width="1"></td>
               <td width="458" valign="top" align="left">
                 <textarea name="tAreaSongDesc" id="tAreaSongDesc" cols="50" rows="5">{{ $products->song_description}}</textarea>
               </td>
             </tr>
         
             <td valign="top" align="center">
               <input type="hidden" name="hid_id" id="hid_id" value="" />
               <button type="submit" name="submit" class="btn btn-sm btn-primary">
                 <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Submit </button>
             </td>
             </tr>
           </table>
         </form>
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