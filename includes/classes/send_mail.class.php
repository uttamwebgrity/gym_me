<?php
class send_mail{	
    //****************  mail header ****************************************//
	function mail_header($site_title,$site_url){
		$header='<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>' . $site_title . '</title>
				<style type="text/css"></style>
				
				</head>
				
				<body>
				<table width="620" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				    <td align="left" valign="top" style="padding:0; margin:0; border-bottom:1px solid #dcdcdc; padding:10px 0 10px 10px;">
				    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
				          <tr>
				            <td align="left"  valign="top" style="padding:0; margin:0;"><a href="'. $site_url .'"><img src="'. $site_url .'email_images/logo.jpg" alt="' . $site_title . '"  border="0" /></a></td>
				         </tr>
				        </table>
				
				    </td>
				  </tr>';
		return ($header);
	}
	
	//********************* mail footer *************************************//
	function mail_footer($site_title,$site_url){
					$footer='<tr>
							    <td align="left" valign="top" style="padding:10px; margin:0; border-top:1px solid #dcdcdc;">
							    <p style="font:normal 12px/20px Tahoma, Geneva, sans-serif; color:#9d9d9d; float:left;">Best Regards,<br/>
Team GymMe </p>
							    </td>
							  </tr>
					
					<tr>
							    <td align="left" valign="top" style="padding:10px; margin:0; border-top:1px solid #dcdcdc;">
							    <p style="font:normal 12px/12px Tahoma, Geneva, sans-serif; color:#9d9d9d; float:left;">&copy; Copyright. <span>gymme.ie</span>. All right reserved </p>
							    </td>
							  </tr>
							</table>
							
							</body>
							</html>';
		return ($footer);
	}
	
	public function make_link($url,$text=''){
		return "<a href=\"".$url."\" >".($text==''?$url:$text)."</a>";
	}


	
	function register_welcome_to_employer($recipient_info,$admin_email_id,$site_title,$site_url){		
		$subject=$recipient_info['recipient_subject'];			
		
		$message=$this->mail_header($site_title,$site_url);
		$message .=$recipient_info['recipient_content'];
		$message .=	$this->mail_footer($site_title,$site_url);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		
		@mail($recipient_info['recipient_email'],$subject,$message,$headers);
		
		/*print $recipient_info['recipient_email'];
		print $message;
		exit;*/	
	}
	
	function logininfo_to_user($recipient_info,$admin_email_id,$site_title,$site_url){		
		$subject=$recipient_info['recipient_subject'];			
		
		$message=$this->mail_header($site_title,$site_url);
		$message .=$recipient_info['recipient_content'];
		$message .=	$this->mail_footer($site_title,$site_url);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		
		@mail($recipient_info['recipient_email'],$subject,$message,$headers);
		
		/*print $recipient_info['recipient_email'];
		print $message;
		exit;*/	
	}
	
	function register_welcome_to_physician($recipient_info,$admin_email_id,$site_title,$site_url){		
		$subject=$recipient_info['recipient_subject'];			
		
		$message=$this->mail_header($site_title,$site_url);
		$message .=$recipient_info['recipient_content'];
		$message .=	$this->mail_footer($site_title,$site_url);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		
		@mail($recipient_info['recipient_email'],$subject,$message,$headers);
		
		/*print $recipient_info['recipient_email'];
		print $message;
		exit;*/	
	}
	
	
	function send_email($recipient_info,$admin_email_id,$site_title,$site_url){		
		$subject=$recipient_info['recipient_subject'];			
		
		$message=$this->mail_header($site_title,$site_url);
		$message .=$recipient_info['recipient_content'];
		$message .=	$this->mail_footer($site_title,$site_url);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= "From: ". $site_title ." <". $admin_email_id .">\r\n";
		
		@mail($recipient_info['recipient_email'],$subject,$message,$headers);
		
		/*print $recipient_info['recipient_email'];
		print $message;
		exit;*/
	}
	
	
	
	

}
?>
