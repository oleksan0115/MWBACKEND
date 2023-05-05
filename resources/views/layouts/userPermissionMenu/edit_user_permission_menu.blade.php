 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
	        @if(session()->has('message'))
      <div class="alert alert-success">
         {{ session()->get('message') }}
      </div>
      @endif
       <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}getUserPermissionMenu">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Assign User Right's</h3>
       </div>
	   
	   
       <div class="row pt-5">
         <form action="" method="POST" enctype="multipart/form-data" class="product_table"> @csrf <table>
             <tr>
               <td valign="top" align="center" height="70">
                 <div style="font-size:16px; font-weight:bold; color:#00F;"> User Name: {{ $user->user_name}} </div>
                 <br>
                 <br>
				 <?php 
				 $ary_user_rights = array() ;
		
					foreach($products as $row )
					{  
				
						$ary_user_rights[] = $row->rights_id; 
					} 
	
		  
	
				foreach($items as $nUser_rights_Rows)
				{
					 
					$rights_id =  $nUser_rights_Rows->id;
					$rights =  $nUser_rights_Rows->rights;
					$rights_name =  $nUser_rights_Rows->right_group;  
					 
					if (in_array( $rights_id ,$ary_user_rights)) 
					{
						echo ' <label><input type="checkbox" name="Chkboxadd[]" value="'.$rights_id.'" checked="checked"  id="CheckboxGroup" />'.$rights_name.'</label> ';	
					}
					else
					{
						echo ' <label><input type="checkbox" name="Chkboxadd[]" value="'.$rights_id.'"  id="CheckboxGroup" />'.$rights_name.'</label> ';
					} 
				
			
				
				}
				echo ' <input name="hdd_user_id"  id="hdd_user_id"  type="hidden" value='.$user->user_id.' />';
				echo '<br></br><div> <button type="submit" name="submit" class="btn btn-sm btn-primary">Submit </button> </div>';
				
			   
		
		 
			
			?>
               </td>
             </tr>
           </table>
          
         </form>
       </div>
     </div>
   </div> @endsection