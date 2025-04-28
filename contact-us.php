<?php 
include_once("includes/header.php");


if(isset($_REQUEST['enter']) && $_REQUEST['enter']=="contactus"){	
	
	$email_content='<tr>
						<td align="left" valign="top" style="padding:20px; margin:0; line-">
					    	<table width="700" cellspacing="3" cellpadding="6" border="0" align="center" style="line-height: 25px;">
					        	<tr>
					            	<td width="100" align="left" style="font:normal 13px/22px Georgia," ><strong> Name:</strong></td>
					                 <td width="600" align="left" style="font:normal 13px/22px Georgia,">' . $_REQUEST['name'] . '</td>
					              </tr>					                               
					               <tr>
					                  <td align="left" style="font:normal 13px/22px Georgia, "><strong>Email: </strong></td>
					                  <td align="left" style="font:normal 13px/22px Georgia, ">' . $_REQUEST['email'] . '</td>
					              	</tr>
					               	<tr>
					                 <td align="left" style="font:normal 13px/22px Georgia, " ><strong>Phone No.:</strong></td>
					                  <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['phone'] . '</td>
					                </tr>					               
					               	<tr>
					               		<td valign="top" align="left" style="font:normal 13px/22px Georgia, " ><strong>Message:</strong></td>
					                    <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['comments'] . '</td>
					             	</tr>
					            </table>
					   		</td>
				  		</tr>';		
		
		//*******************  send email to employer *******************//
		$recipient_info=array();
		$recipient_info['recipient_subject']=$general_func->site_title ." Website Contact Us Form Details";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=$general_func->email;		
		$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);				
		//***************************************************************//	
		$general_func->header_redirect($general_func->site_url . "thank-you/");
}
?>	
<script>
function check_validate(){
	if(!validate_text(document.frmcontactus.name,1,"Blank space not allowed. Please enter your name."))
		return false;
		
	if(!validate_email(document.frmcontactus.email,1,"Blank space not allowed. Please enter your email address. "))
		return false;
		
	if(!validate_text(document.frmcontactus.phone,1,"Blank space not allowed. Please enter your phone number."))
		return false;		
	
	if(!validate_text(document.frmcontactus.comments,1,"Blank space not allowed. Please enter your message."))
	   return false;	
}
</script>			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1><?php echo trim($dynamic_content['page_title']); ?></h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			 <form name="frmcontactus" method="post"  action="contact-us/" onsubmit="return check_validate();">
			 <input type="hidden" name="enter" value="contactus"  />	
	        <ul class="contact-form">
	          <li>
	            <label>Name<span>*</span></label>
	            <input type="text" name="name" placeholder="Enter name" />
	          </li>
	          <li>
	            <label>Email Address<span>*</span></label>
	            <input type="text" name="email" placeholder="Enter email address" />
	          </li>
	          <li>
	            <label>Phone Number<span>*</span></label>
	            <input type="text" name="phone" placeholder="Enter phone number" />
	          </li>
	          <li>
	            <label>Message<span>*</span></label>
	            <textarea name="comments" rows="1" cols="1" placeholder="Enter your message"></textarea>
	          </li>
	          <li style="background:none;">
	            <input type="submit" value="Submit" />
	          </li>
	        </ul>
	      </form>							      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>