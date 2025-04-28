<?php
include_once("includes/configuration.php");

$email_address=base64_decode($_REQUEST['varify_email']);

$sql="select id,name,email_address,password from personal_trainers where email_address='". $email_address ."' and email_confirmed=0 limit 1";
$result=$db->fetch_all_array($sql);

if((int)count($result) == 1){	
	$db->query("update personal_trainers set email_confirmed=1,membership_type=2,last_login_date=now() 	 where  email_address='". $email_address ."'");	
	
	$email_content='<tr>
					    <td align="left" valign="top" style="padding:20px; margin:0;">
					    <h1 style="font:normal 20px/30px Georgia, \'Times New Roman\', Times, serif; color:#949393; line-height: 20px; ">Welcome!</h1>
					    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
					
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Dear <span style="color:#949393;">'. $result[0]['name'] .',</span></td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Your account has been created at '. $general_func->site_title .' website!</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">This registration request has been made from "'. $general_func->get_ip() .'"</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr> 
					<td class="bigtxt" style="font:12px Arial; color:#949393; text-decoration:none;"><strong>Your Login information is given below:</strong></td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px; padding-top:10px;"><strong>Email Address Name:</strong> '. $result[0]['email_address'] .'<br /><br />
					<strong>Password:</strong> '. $EncDec->decrypt_me($result[0]['password']) .'</td>
					</tr>
					
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px; padding-top:10px;">
					By clicking <a href="'. $general_func->site_url .'"> here </a> you can login to your account.
					
					</td>
					</tr>
					
					<tr>
					<td>&nbsp;</td>
					</tr>
					
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Please do not reply to this email as this is a computer-generated response.</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					</table></td>
				  </tr>';
				  
	//*******************  send email to employer *******************//
	$recipient_info=array();
	$recipient_info['recipient_subject']="Your account has been created at ".$general_func->site_title . " website";
	$recipient_info['recipient_content']=$email_content;
	$recipient_info['recipient_email']=$email_address;		
	$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);				
	//***************************************************************//
	
	$_SESSION['trainer_id']=$result[0]['id'];
	$_SESSION['trainer_name']=$result[0]['name'];
	$_SESSION['trainer_email_address']=$result[0]['email_address'];
	$_SESSION['trainer_membership_type']=2;
	
	$_SESSION['user_login']= "yes"; 
	$_SESSION['user_type']="trainer";
				
	$_SESSION['user_message'] ="Thank you for your registration with us your account has been created. \n Your login information has been sent to your specified email address!";
	$general_func->header_redirect($general_func->site_url);  
}else{	
	$_SESSION['user_message'] = "Sorry, your varification link was invalid or you have already varified your email address!";
	$general_func->header_redirect($general_func->site_url);
}		


?>