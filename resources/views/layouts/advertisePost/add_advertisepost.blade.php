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
         <a href="{{ env('APP_URL') }}advertisePost">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Add Advertise Post</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_advertisepost') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf 
		<table class="advertise">
             <tr>
            <td ><textarea name="tbox_postmsg" id="tbox_postmsg" class="postofthelounge ckeditor " ></textarea> </td>
             <td class="ck-td">
                 Top 10 :  					%TOPMOUSEWAITERS% <br />
                Quality Top 100:  			%TOPQUALITY%		<br />
                Monthly Leaders:   			%TOPMONTHLYLEADERS% <br />
                Top 50 News:  				%TOPNEWS% <br />
                Monthly Wait Time Leaders:	%TOPWAITIMELEADERS% <br />
                Weekly Trivilator Leaders:	%TOPTRIVILATORLEADERS% <br />
                Weekly Trivilator Leaders:	%TOPCREDITSPURCHASERS% <br />
                The Latest 10 POSTS:        %THELATESTPOSTS% <br />
                MW Upcoming Events:         %UPCOMINGEVENTS% <br />
                Most added to todo:         %MOSTADDEDTODO% <br />
                Ad Post Contributor:        %ADPOSTCONTRIBUTOR% <br />
                Top six months Mousewaiter	%SIXMONTHSWAITIMELEADERS% <br />
                leaders:    
                Top six month  Leaders       %SIXMONTHSLEADERS% <br />
                
            </td>
        </tr>
		</table>
  
  
 <table class="advertise mt-2" width="633" border="0" cellpadding="3" cellspacing="3">
   <tr>
     <td>Youtube Video link:</td>
     <td>
       <textarea name="tbox_video" id="tbox_video" class="postofthelounge" style="width:400px; height:50px"></textarea>
     </td>
	    <td>Write embed code</td>
   </tr>
   <tr>
     <td>Post Picture :</td>
     <td>
       <input name="myfile" id="myfile" onchange="readURLSecond(this)" type="file">
	    <img style="display:none" id="img-preview-second" width="50px" />
       <br />
     </td>
   </tr>
   <tr>
     <td>Username :</td>
     <td>
       <input name="tbox_username" id="tbox_username" type="text" value="" style="width:400px; height:30px" />
     </td>
   </tr>
   <tr>
     <td>Username Link :</td>
     <td>
       <input name="tbox_username_link" id="tbox_username_link" type="text" value="" style="width:400px; height:30px" />
     </td>
   </tr>
   <tr>
     <td>User Picture :</td>
     <td>
       <input name="myuserpicsfile" id="myuserpicsfile" onchange="readURL(this)" type="file">
	   <img style="display:none" id="img-preview" width="50px" />
       <br />
     </td>
   </tr>
   <tr>
     <td>Active :</td>
     <td>
       <input name="chkstatus" id="chkstatus" type="checkbox" value="1" />
     </td>
   </tr>
   <tr>
     <td>Is Replace :</td>
     <td>
       <input name="chkisreplaced" id="chkisreplaced" type="checkbox" value="1" />
     </td>
   </tr>
   <tr>
     <td>Is priority :</td>
     <td>
       <input name="ispriority" id="ispriority" type="checkbox" value="1" />
     </td>
   </tr>
   <tr>
     <td>Lounge :</td>
     <td>
       <select id="ddl_lounge" name="ddl_lounge">
         <option>DL</option>
         <option>WDW</option>
         <option>ALL</option>
       </select>
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
 