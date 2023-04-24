 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6"> @if(session()->has('message')) <div class="alert alert-success">
         {{ session()->get('message') }}
       </div> @endif <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}emailTemplate">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Add Email Template</h3>
       </div>
       <div class="row pt-5">
         <form action="{{ route('backend.add_emailtemplate') }}" method="POST" enctype="multipart/form-data" class="product_table"> @csrf 
		 
		 <table class="advertise mt-2" width="633" border="0" cellpadding="3" cellspacing="3">
		 
		    <tr>
               <td>Template For :</td>
               <td>
                 <input name="templatefor" id="templatefor" type="text" value="" style="width:400px; height:30px" />
               </td>
             </tr>
             <!--tr>
               <td align="left" valign="top" class="left_lable text-dark" style="vertical-align:middle">Template For:</td>
               <td width="424" align="left">
                 <select name="ddl_template_for" id="ddl_template_for"> 
				 <?php   
					  /*  $qry = "SELECT  distinct template_for  FROM `tbl_email_templates`  WHERE status =1 ORDER BY template_for ASC";
					   $ddl_results = DB::select($qry);
						
						foreach ($ddl_results as $row) 
						{ 
							$ddl_template = $row->template_for;  
						
								 echo '
									<option value="'.$ddl_template.'">'.$ddl_template.'   </option>'	;		
						         
						}  */
					?>
					</select>
               </td>
             </tr -->
             <tr>
               <td>Email Subject :</td>
               <td>
                 <input name="tboxsubject" id="tboxsubject" type="text" value="" style="width:400px; height:30px" />
               </td>
             </tr>
             <tr>
               <td>Template Description:</td>
               <td>
                 <input name="tboxdescription" id="tboxdescription" type="text" value="" style="width:400px; height:30px" />
               </td>
             </tr>
           </table>
           <table class="advertise">
             <tr>
               <td>Template Content:</td>
             </tr>
             <tr>
               <td>
                 <textarea name="tboxtemplate" id="tboxtemplate" class="tboxtemplate ckeditor "></textarea>
               </td>
               <td class="ck-td"> Following Strings will be replaced in Email Tempalates. <br />
                 <br /> %USERNAME% &nbsp;&nbsp;&nbsp;(User Name ) <br /> %USERPASSWORD% &nbsp;&nbsp;&nbsp;(User Password ) <br /> %USER_TODAY_RANK% &nbsp;&nbsp;&nbsp;(User Today Rank will be replaced) <br /> %USER_OVERALL_RANK% &nbsp; &nbsp;&nbsp;(User Over All Rank ) <br /> %USER_OVERALL_POSITION% &nbsp;&nbsp;&nbsp;(User Overall position ) <br /> %USER_QUALITY_RANK% &nbsp;&nbsp;&nbsp;(User Quality Ranks) <br /> %USER_ID% &nbsp;&nbsp;&nbsp;(User Id ) <br /> %DATETIME% &nbsp;&nbsp;&nbsp;(Date time) <br /> %CHAT_MESSAGE% &nbsp;&nbsp;&nbsp;(Post Message) <br /> %POST_COMMENTS% &nbsp;&nbsp;&nbsp;(Comment Message) <br /> %CHAT_USER_NAME% &nbsp;&nbsp;&nbsp;(Post User Name) <br /> %URL% &nbsp;&nbsp;&nbsp;(URL Replace) <br /> %FRIEND_USER_NAME% &nbsp;&nbsp;&nbsp;(USER NAME) <br />
				 
				 
				 %REPORT_USER_NAME% &nbsp;&nbsp;&nbsp;(REPORT USER NAME) <br />%REPORT_USER_ID% &nbsp;&nbsp;&nbsp;(REPORT USER ID) <br />%REASON_FOR_REPORT% &nbsp;&nbsp;&nbsp;(REPORT FOR REPORT) <br />%USER_IMAGE% &nbsp;&nbsp;&nbsp;(USER IMAGE) <br />%REPORT_USER_LINK% &nbsp;&nbsp;&nbsp;(REPORT USER LINK) <br />
				 %DELETE% &nbsp;&nbsp;&nbsp;(DELETE) <br />%REMOVE% &nbsp;&nbsp;&nbsp;(REMOVE) <br />%RESTORE% &nbsp;&nbsp;&nbsp;(RESTORE) <br />%MOVEHUB% &nbsp;&nbsp;&nbsp;(MOVE HUB) <br />%MOVESILENT% &nbsp;&nbsp;&nbsp;(MOVE SILENT) <br />%DM% &nbsp;&nbsp;&nbsp;(DM) <br />
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