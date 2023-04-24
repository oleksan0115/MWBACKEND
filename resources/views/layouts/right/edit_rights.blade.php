 @extends('layouts.common.dashboard') @section('content') <div class="content-wrapper">
   <div class="content">
     <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
       <div class="d-flex justify-content-between">
         <h2 class="text-dark font-weight-medium"></h2>
       </div>
       <div class="d-flex">
         <a href="{{ env('APP_URL') }}news">
           <button type="button" class="btn btn-sm btn-primary">
             <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back </button>
         </a>
         <h3 class="font-weight-bold ml-5 pl-5">Edit News</h3>
       </div>
       <div class="row pt-5">
         <form action="" method="POST" enctype="multipart/form-data" class="product_table"> 
		 @csrf 
		<table class="advertise mt-2" border="0" cellpadding="3" cellspacing="3">
		 
             <tr>
               <td>Park :</td>
               <td>
                 <select id="ddl_park" name="ddl_park">
				     <option value="DL" <?php
												if ($products->park == 'DL') {echo 'selected="selected"';
												}
											?>   >DL</option>
					                           <option value="WDW" <?php
												if ($products->park == 'WDW') {echo 'selected="selected"';
												}
											?>  >WDW</option>
					                            <option value="NR" <?php
												if ($products->park == 'NR') {echo 'selected="selected"';
												}
											?>  >Normal</option>
         
                 </select>
               </td>
             </tr>
             <tr>
               <td>Is today News :</td>
               <td>
                 <input name="chkbox_news" id="chkbox_news" type="checkbox" value="1" 
				 <?php if ($products->istoday_news  == '1') {echo 'checked="checked"';} ?>
				 />
               </td>
             </tr>
             <tr>
               <td>News Type :</td>
               <td>
                 <input name="chk_newstype_free" id="chk_newstype_free" type="checkbox" value="1" 
				  <?php if ($products->newstype_free  == '1') {echo 'checked="checked"';} ?>>Free</input>
                 <input name="chk_newstype_paid" id="chk_newstype_paid" type="checkbox" value="1"
				  <?php if ($products->newstype_paid  == '1') {echo 'checked="checked"';} ?>>Paid</input>
                 <input name="chk_newstype_normal" id="chk_newstype_normal" type="checkbox" value="1"
				  <?php if ($products->newstype_normal  == '1') {echo 'checked="checked"';} ?>>None</input>
               </td>
             </tr>
             <tr>
               <td>Title :</td>
               <td>
                 <input name="tbox_newstitle" id="tbox_newstitle" type="text" value="<?php echo $products->new_title; ?>" style="width:400px; height:30px" />
               </td>
             </tr>
             <tr>
               <td>Hyperlink in News :</td>
               <td>
                 <input name="tbox_hyperlink" id="tbox_hyperlink" type="text" value="<?php echo $products->hyperlink; ?>" style="width:400px; height:30px" />
               <td>http://www.google.com</td>
               </td>
             </tr>
             <tr>
               <td>Text to link :</td>
               <td>
                 <input name="tbox_texttolink" id="tbox_texttolink" type="text" value="<?php echo $products->texttolink; ?>" style="width:400px; height:30px" />
               <td>Google</td>
               </td>
             </tr>
           </table>
           <table class="advertise">
             <tr>
			 <td>News DL Mobile:</td>
               <td>
                 <textarea name="tbox_newsdesc" id="tbox_newsdesc" class="ckeditor"><?php echo $products->news_description; ?></textarea>
               </td>
             </tr>
             <tr>
			 <td>News DL Web:</td>
               <td>
                 <textarea name="tbox_newsdesc_web" id="tbox_newsdesc_web" class="ckeditor"><?php echo $products->news_description_web; ?></textarea>
               </td>
             </tr>
             <tr>
			 <td>News for WDW Mobile:</td>
               <td>
                 <textarea name="tbox_newsdesc_wdw" id="tbox_newsdesc_wdw" class="ckeditor"><?php echo $products->news_description_wdw; ?></textarea>
               </td>
             </tr>
             <tr>
			 <td>News For WDW Web:</td>
               <td>
                 <textarea name="tbox_newsdesc_web_wdw" id="tbox_newsdesc_web_wdw" class="ckeditor"><?php echo $products->news_description_web_wdw; ?></textarea>
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
   
   
