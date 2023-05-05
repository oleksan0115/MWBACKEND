 @extends('layouts.common.dashboard')
  @section('content')

    <div class="content-wrapper">
          <div class="content">					
		  <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
		      
				<div class="d-flex justify-content-between">
							<h2 class="text-dark font-weight-medium"></h2>
							
						</div>
						<div class="d-flex">
						<a href="{{ env('APP_URL') }}products"><button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back</button></a>
					<h3 class="font-weight-bold ml-5 pl-5">Edit Product</h3>
					</div>
						<div class="row pt-5">
							
							
							 <form action="" method="POST" enctype="multipart/form-data" class="product_table"  >
							     @csrf
					<table width="633" border="0" cellpadding="3" cellspacing="3">
 
 

  <tr>
    <td align="center" class="page_heading_gray"></td>
  </tr>



																		
					
				<tr>
				<td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Product Name:</td>
				<td width="1"></td>
				<td width="458" align="left" valign="top"><input name="tboxproductName" id="tboxproductName" type="text" value="{{ $products->product_name}}"  class="input_textbox"  />		
				</td>
				
				</tr>
				
				   <tr>
							<td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Product Description:</td>
							<td width="1"></td>
							<td width="458" valign="top" align="left">
							  <textarea name="tAreaproductDesc" id="tAreaproductDesc" cols="50" rows="5">{{ $products->product_description}}</textarea>		
							</td>  
						</tr>
						
						
							<tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Quantity</td>
						  <td width="1"></td>
						  <td valign="top" align="left"><input name="tboxProductQty" id="tboxProductQty" type="text" value="{{ $products->product_quantity}}"  class="input_textbox"/></td>
					  </tr>
					  
					  <tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Price</td>
						  <td></td>
						  <td valign="top" align="left"><input name="tboxproductPrice" id="tboxproductPrice" type="text" value="{{ $products->product_price}}"  class="input_textbox"/></td>
					  </tr>
					  
					  
					    <tr>
						  <td align="left" valign="top" class="left_lable"></td>
						  <td></td>
						  <td valign="top" align="left"><input id="chkowner" name="chkowner" type="checkbox" value="1" @if($products->owner_only) checked @endif />&nbsp;&nbsp;Owner Only</td>
					  </tr>
                       <tr>
						  <td align="left" valign="top" class="left_lable"></td>
						  <td></td>
						  <td valign="top" align="left"><input id="chkstatus" name="chkstatus" type="checkbox" value="1" @if($products->status) checked @endif  />&nbsp;&nbsp;Active</td>
					  </tr>
                     <tr>
						  <td align="left" valign="top" class="left_lable"></td>
						  <td></td>
						  <td valign="top" align="left"><input id="chkemojis" name="chkemojis" type="checkbox" value="1" @if($products->isemojis) checked @endif />&nbsp;&nbsp;Isemojis</td>
					  </tr>  
                       <tr>
						  <td align="left" valign="top" class="left_lable text-dark" style="vertical-align:middle">Emoji Category:</td>
						  <td></td>
						  <td valign="top" align="left">
                          <select id="ddlemojicategory" name="ddlemojicategory" style="margin-top:1rem">
                          
                          <option value=""  >Select emoji category</option>
                         
                         @foreach($emoji as $row)
						<option value="{{ $row->id }}" 
					   {{ $products->emoji_category_id == $row->id ? 'selected' : '' }}>
					   {{ $row->emoji_category_name }}
					   </option>     
					
					
						  @endforeach
                          </select>
                          </td>
					  </tr> 
					  
					  
					  <tr>
							<td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Full Image:</td>
							<td width="1"></td>
							<td width="458"  height="30"valign="top" align="left">
							 	<input name="myfile" id="myfile" type="file" style="margin-bottom:1rem"/> 
							</td>
						</tr>
                        <tr>
							<td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Thumbnail Image:</td>
							<td width="1"></td>
							<td width="458"  height="30"valign="top" align="left">
							 	<input name="myfile_thumbnail" id="myfile_thumbnail" type="file" style="margin-bottom:1rem"/> 
							</td>
						</tr>
						
						
						
						   <tr>
						  <td align="left" valign="top" class="left_lable text-dark"></td>
						  <td></td>
						  <td valign="top" align="left"><input id="chkisauction" name="chkisauction" type="checkbox" value="1" @if($products->isauction) checked @endif />&nbsp;&nbsp;auction</td>
					  </tr>    
                     
                     <tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;auction Start</td>
						  <td></td>
						  <td valign="top" align="left"><input name="tboxstartdate" id="tboxstartdate" type="text" value="{{ $products->start_auction_date}}"  class="input_textbox text-dark"  style="margin-top:1rem"/> format: "< 2013-10-05 23:59 >"</td>
					  </tr>
                      <tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;auction End Date</td>
						  <td></td>
						  <td valign="top" align="left"><input name="tboxenddate" id="tboxenddate" type="text" value="{{ $products->end_auction_date}}"  class="input_textbox text-dark"/>  format: "< 2013-10-05 23:59 >"</td>
					  </tr>
                     <tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Intial Bid</td>
						  <td></td>
						  <td valign="top" align="left"><input name="tboxinitialcredits" id="tboxinitialcredits" type="text" value="{{ $products->initial_bid}}"  class="input_textbox"/></td>
					  </tr> 
					  
					  
					  <tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Current Date time on Server :</td>
						  <td></td>
						  <td class="text-dark" valign="top" align="left">{{ date('Y-m-d H:i') }}</td>
					  </tr>
					  
					   <tr>
						  <td align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Activation Start Date time</td>
						  <td></td>
						  <td valign="top" align="left"><input name="tbox_active_datetime" id="tbox_active_datetime" type="text" value="{{ $products->active_datetime}}"  class="input_textbox"/> format: "< 2013-10-05 23:59 >"</td>
					  </tr>
                        
		    	<tr>
				<td valign="top" align="center">
			    <input type="hidden" name="hdd_product_id" id="hdd_product_id" value="{{ $products->id}}" />
               
				<button type="submit" name="submit" class="btn btn-sm btn-primary"><i class="mdi mdi-keyboard-backspace"></i>&nbsp; Submit</button>
				</td> 
			   </tr> 
		
		</table>
 	
  
					
					
						
                        </form>
           
           
           
           		
					</div>
</div>
          
        </div>
        
  
  @endsection