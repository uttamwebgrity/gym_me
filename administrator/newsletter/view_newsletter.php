<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

$return_url=$_REQUEST['return_url'];


$result=mysql_fetch_object(mysql_query("select subject,message,(CASE send_to WHEN 0 THEN 'All' WHEN 1 THEN 'Customers'WHEN 2 THEN 'Subscribers' ELSE 'Donars' END) as send_to,subject,DATE_FORMAT(send_date,'%a %b, %Y') as send_date,send_to_emails,email_address from newsletters where id=" . (int)$_REQUEST['id']. " limit 1"));

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        
         <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg another_bg_color">NEWSLETTER EMAIL on <?=$result->send_date?></td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr> 
        
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
        <table width="883" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
          	<td colspan="4" height="30"></td>
          </tr>
          
          
          <tr>
            <td width="73" align="left" valign="top"></td>
            <td width="700" align="left" valign="top"><table width="94%" border="0" cellspacing="0" cellpadding="8">
                
                <tr>
                  <td width="21%" class="body_content-form"  valign="top">Subject:</td>
                  <td width="79%"  valign="top"><?php echo $result->subject; ?></td>
                </tr>
                <tr>
                  <td width="21%" class="body_content-form"  valign="top">Message:</td>
                  <td width="79%"  valign="top">
				  <table width="620" border="0" cellspacing="0" cellpadding="0">
			  <tr>
			    <td align="left" valign="top" style="padding:0; margin:0; border-bottom:1px solid #dcdcdc; padding:10px 0 10px 10px;">
			    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td align="left" valign="top" style="padding:0; margin:0;"><img src="<?=$general_func->site_url?>email_images/logo.jpg" width="107" height="110" alt="" /></td>
			            <td align="right" valign="top" style="margin:0;"><img src="<?=$general_func->site_url?>email_images/headerBg.jpg" width="115" height="93" alt="" /></td>
			          </tr>
			        </table>			
			    </td>
			  </tr>
			  <tr>
			    <td align="left" valign="top" style="padding:20px; margin:0;">
				  					<?php echo $result->message; ?>
				  					
								 </td>
			  </tr>
			  <tr>
			    <td align="left" valign="top" style="padding:10px; margin:0; border-top:1px solid #dcdcdc;">
			    <p style="font:normal 12px/12px Tahoma, Geneva, sans-serif; color:#9d9d9d; float:left;">Copyright &copy; 2013 <a href="http://happy-in-style.com/" target="_blank" style="color:#cf81a7; text-decoration:none;">happy-in-style.com</a>. All rights reserved</p>
			    <img src="<?=$general_func->site_url?>email_images/footerBg.jpg" width="250" height="34" alt="" style="margin:0; padding:0; float:right;" /></td>
			  </tr>
			</table>
				  					
				  			
						
                  </td>
                </tr>
                <tr>
                  <td width="21%" class="body_content-form"  valign="top">Sent To:</td>
                  <td width="79%"  valign="top"><?php 
				  if(strlen($result->send_to_emails) < 6 )
				   echo $result->email_address;
				  
				  echo str_replace("_~_","<br/>",$result->send_to_emails); ?></td>
                </tr>
                
               
            </table></td>
           
           
          </tr>
           <tr>
          	<td colspan="4" height="20"></td>
          </tr>
           <tr>
          	<td colspan="4" height="30" align="center"><table width="879" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
                  <td width="24%"></td>
                  <td width="23%">&nbsp;</td>
      <td width="7%"><table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onClick="location.href='<?=$general_func->admin_url?>newsletter/<?=$_REQUEST['return_url']?>'"  type="button" class="submit1" value="Back" /></td>
                              
                            </tr>
                          </table></td>
                  <td width="46%">                  </td>
                </tr>
                    </table></td>
          </tr>
           <tr>
          	<td colspan="4" height="30"></td>
          </tr>
        </table>
     </td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
