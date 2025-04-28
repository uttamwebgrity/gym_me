<?php
include_once("includes/header.php"); 

if(isset($_POST['enter']) && $_POST['enter']=="gymregistration"){
	$_SESSION['gym_register']['name']=trim($_REQUEST['name']);
	$_SESSION['gym_register']['email_address']=trim($_REQUEST['email_address']);
	$_SESSION['gym_register']['website_URL']=trim($_REQUEST['website_URL']);
	$_SESSION['gym_register']['phone']=trim($_REQUEST['phone']);
	$_SESSION['gym_register']['street_address']=trim($_REQUEST['street_address']);
	$_SESSION['gym_register']['town']=trim($_REQUEST['town']);
	$_SESSION['gym_register']['county']=trim($_REQUEST['county']);
	$_SESSION['gym_register']['area']=trim($_REQUEST['area']);
	$_SESSION['gym_register']['password']=trim($_REQUEST['password']);
	$_SESSION['gym_register']['cpassword']=trim($_REQUEST['cpassword']);		
	
	
	if($db->already_exist_inset("gyms","email_address",$_SESSION['gym_register']['email_address'])){
		$_SESSION['user_message']="Sorry, your specified email address is already taken!";		
	}else{
		$data['name']=$_SESSION['gym_register']['name'];
			
		$data['seo_link']=$general_func->create_seo_link($_SESSION['gym_register']['name']);
			
		//*** check whether this name alreay exit ******//
		if($db->already_exist_inset("gyms","seo_link",$data['seo_link'])){//******* exit
			$data['seo_link']=$db->max_id("gyms","id") + 1 ."-".$data['seo_link'];
		}
		//*********************************************//
			
		$data['email_address']=$_SESSION['gym_register']['email_address'];		
		$data['password']=$EncDec->encrypt_me($_SESSION['gym_register']['password']);	
		$data['town']=$_SESSION['gym_register']['town'];
		$data['county']=$_SESSION['gym_register']['county'];
		$data['area']=$_SESSION['gym_register']['area'];
		$data['website_URL']=$_SESSION['gym_register']['website_URL'];
		$data['phone']=$_SESSION['gym_register']['phone'];
		$data['street_address']=$_SESSION['gym_register']['street_address'];
	
				
		//*************** lat & long ***************************//			
		$gen_lat=array();	
		$for_map=trim($_SESSION['gym_register']['town']).", " .$_SESSION['gym_register']['county'] .", ". $_SESSION['gym_register']['area'] .", Ireland";	
		$gen_lat=$general_func->getLnt($for_map);				
		$data['geo_lat']=$gen_lat['lat'];	
		$data['geo_long']=$gen_lat['lng'];
		//*******************************************************//			
			
					
		$data['email_confirmed']=0;
		$data['membership_type']="";
		$data['status']=1;
		$data['created']='now()';
		$data['modified']='now()';
			
		$db->query_insert("gyms",$data);
		
		$email_content='<tr>
					    <td align="left" valign="top" style="padding:20px; margin:0;">
					    <h1 style="font:normal 20px/30px Georgia, \'Times New Roman\', Times, serif; color:#949393; line-height: 20px; ">Welcome!</h1>
					    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Dear <span style="color:#949393;">'. $_SESSION['gym_register']['name'] .',</span></td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">You have created an '. $general_func->site_title .' account with this email address!</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Click here to verify your email.</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px; padding-top:10px;">
					<a href="'. $general_func->site_url .'gym-registration-confirmation.php?varify_email='. base64_encode($_SESSION['gym_register']['email_address']).'">'. $general_func->site_url .'gym-registration-confirmation.php?varify_email='. base64_encode($_SESSION['gym_register']['email_address']).'</a>
					</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">If you did not request an account with '. $general_func->site_title .', please disregard this email.</td>
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
		$recipient_info['recipient_subject']="Verify Email Address";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=$_SESSION['gym_register']['email_address'];		
		$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);				
		//***************************************************************//
		
		$_SESSION['user_message'] = "Your account has been created and an activation link has been sent to the e-mail address you entered. \n Note that you must activate the account by clicking on the activation link when you get the e-mail before you can login.";
		
		unset($_SESSION['gym_register']);	
		$general_func->header_redirect($general_func->site_url);
	}
}else if(isset($_POST['enter']) && $_POST['enter']=="gymtrainer"){
	$_SESSION['trainer_register']['email_address']=trim($_REQUEST['email_address']);
	$_SESSION['trainer_register']['name']=trim($_REQUEST['name']);
	$_SESSION['trainer_register']['phone']=trim($_REQUEST['phone']);
	$_SESSION['trainer_register']['price_per_session']=trim($_REQUEST['price_per_session']);
	$_SESSION['trainer_register']['street_address']=trim($_REQUEST['street_address']);
	$_SESSION['trainer_register']['town']=trim($_REQUEST['town']);
	$_SESSION['trainer_register']['county']=trim($_REQUEST['county']);
	$_SESSION['trainer_register']['area']=trim($_REQUEST['area']);
	$_SESSION['trainer_register']['password']=trim($_REQUEST['password']);
	$_SESSION['trainer_register']['cpassword']=trim($_REQUEST['cpassword']);	
	$_SESSION['trainer_register']['website_URL']=trim($_REQUEST['website_URL']);		
	
	
	if($db->already_exist_inset("personal_trainers","email_address",$_SESSION['trainer_register']['email_address'])){
		$_SESSION['user_message']="Sorry, your specified email address is already taken!";		
	}else{
		$data['name']=$_SESSION['trainer_register']['name'];
			
		$data['seo_link']=$general_func->create_seo_link($_SESSION['trainer_register']['name']);
			
		//*** check whether this name alreay exit ******//
		if($db->already_exist_inset("personal_trainers","seo_link",$data['seo_link'])){//******* exit
			$data['seo_link']=$db->max_id("personal_trainers","id") + 1 ."-".$data['seo_link'];
		}
		//*********************************************//
		
		
		//*************** lat & long ***************************//			
		$gen_lat=array();	
		$for_map=trim($_SESSION['trainer_register']['town']).", " .$_SESSION['trainer_register']['county'] .", ". $_SESSION['trainer_register']['area'] .", Ireland";	
		$gen_lat=$general_func->getLnt($for_map);				
		$data['geo_lat']=$gen_lat['lat'];	
		$data['geo_long']=$gen_lat['lng'];
		//*******************************************************//	
		
			
		$data['email_address']=$_SESSION['trainer_register']['email_address'];		
		$data['password']=$EncDec->encrypt_me($_SESSION['trainer_register']['password']);	
		$data['phone']=$_SESSION['trainer_register']['phone'];
		$data['price_per_session']=$_SESSION['trainer_register']['price_per_session'];
		$data['street_address']=$_SESSION['trainer_register']['street_address'];
		$data['website_URL']=$_SESSION['trainer_register']['website_URL'];
		$data['town']=$_SESSION['trainer_register']['town'];
		$data['county']=$_SESSION['trainer_register']['county'];
		$data['area']=$_SESSION['trainer_register']['area'];					
		$data['email_confirmed']=0;
		$data['membership_type']="";
		$data['status']=1;
		$data['created']='now()';
		$data['modified']='now()';
			
		$db->query_insert("personal_trainers",$data);
		
		$email_content='<tr>
					    <td align="left" valign="top" style="padding:20px; margin:0;">
					    <h1 style="font:normal 20px/30px Georgia, \'Times New Roman\', Times, serif; color:#949393; line-height: 20px; ">Welcome!</h1>
					    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Dear <span style="color:#949393;">'. $_SESSION['trainer_register']['name'] .',</span></td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">You have created an '. $general_func->site_title .' account with this email address!</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Click here to verify your email.</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px; padding-top:10px;">
					<a href="'. $general_func->site_url .'trainer-registration-confirmation.php?varify_email='. base64_encode($_SESSION['trainer_register']['email_address']).'">'. $general_func->site_url .'trainer-registration-confirmation.php?varify_email='. base64_encode($_SESSION['trainer_register']['email_address']).'</a>
					</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">If you did not request an account with '. $general_func->site_title .', please disregard this email.</td>
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
		$recipient_info['recipient_subject']="Verify Email Address";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=$_SESSION['trainer_register']['email_address'];		
		$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);				
		//***************************************************************//
		
		$_SESSION['user_message'] = "Your account has been created and an activation link has been sent to the e-mail address you entered. \n Note that you must activate the account by clicking on the activation link when you get the e-mail before you can login.";
		
		unset($_SESSION['trainer_register']);	
		$general_func->header_redirect($general_func->site_url);
	}

}else if(isset($_REQUEST['submit']) && trim($_REQUEST['submit']) == "gym_login"){//*********** employer login
	
	$email_address=trim($_REQUEST['email_address']);
	$password=trim($_REQUEST['password']);
	
	$sql="select id,name,email_address,seo_link,logo_name,membership_type,membership_start,membership_end,email_confirmed,status from gyms where email_address='". $email_address ."' and password='". $EncDec->encrypt_me($password) ."' limit 1";
	$result=$db->fetch_all_array($sql);
	
	if((int)count($result) == 1){
		
		if(intval($result[0]['email_confirmed']) == 0){//****************  check whether email varified 
			$_SESSION['user_message'] = "You must verify your account before proceeding by clicking on the activation link that we sent you at " . $result[0]['email_address'];
		}else if(intval($result[0]['status']) == 0){//****************  check whether suspended by admin 
			$_SESSION['user_message'] = "Account suspended, contact admin to resolve this issue!";
		}else{				
			$_SESSION['gym_id']=$result[0]['id'];
			$_SESSION['gym_name']=$result[0]['name'];
			$_SESSION['gym_email_address']=$result[0]['email_address'];
			$_SESSION['gym_membership_type']=$result[0]['membership_type'];									
			$_SESSION['gym_membership_start']=$result[0]['membership_start'];
			$_SESSION['gym_membership_end']=$result[0]['membership_end'];
			$_SESSION['gym_logo_name']=$result[0]['logo_name'];
			$_SESSION['user_seo_link']=$result[0]['seo_link'];	
			
			$_SESSION['user_login']= "yes"; 
			$_SESSION['user_type']="gym";	
						
			//***************** save last login date *****************************//
			$db->query("update gyms set last_login_date=now() where id='" . $_SESSION['gym_id'] . "'");		
			//******************************************************************//			
			
			if(isset($_SESSION['redirect_to_front_end']) && trim($_SESSION['redirect_to_front_end'])!=NULL){
				$path=$_SESSION['redirect_to_front_end']."?".$_SESSION['redirect_to_query_string'];
				$general_func->header_redirect($path);		
			}else{
				if(intval($_SESSION['gym_membership_type']) ==0)
					$general_func -> header_redirect("gym-choose-account/");	
				else
					$general_func -> header_redirect($_SESSION['user_type']."-account-setup.php");				
			}			
		}
	}else{		
		$_SESSION['user_message'] = "Access denied. Incorrect Username and/or Password!";		
	}
		
}else if(isset($_REQUEST['submit']) && trim($_REQUEST['submit']) == "trainer_login"){//*********** employer login
	
	$email_address=trim($_REQUEST['email_address']);
	$password=trim($_REQUEST['password']);
	
	$sql="select id,name,email_address,seo_link,membership_type,membership_start,membership_end,email_confirmed,logo_name,status from personal_trainers where email_address='". $email_address ."' and password='". $EncDec->encrypt_me($password) ."' limit 1";
	$result=$db->fetch_all_array($sql);
	
	if((int)count($result) == 1){
		
		if(intval($result[0]['email_confirmed']) == 0){//****************  check whether email varified 
			$_SESSION['user_message'] = "You must verify your account before proceeding by clicking on the activation link that we sent you at " . $result[0]['email_address'];
		}else if(intval($result[0]['status']) == 0){//****************  check whether suspended by admin 
			$_SESSION['user_message'] = "Account suspended, contact admin to resolve this issue!";
		}else{
				
			$_SESSION['trainer_id']=$result[0]['id'];
			$_SESSION['trainer_name']=$result[0]['name'];
			$_SESSION['trainer_email_address']=$result[0]['email_address'];
			$_SESSION['trainer_membership_type']=$result[0]['membership_type'];									
			$_SESSION['trainer_membership_start']=$result[0]['membership_start'];
			$_SESSION['trainer_membership_end']=$result[0]['membership_end'];
			$_SESSION['trainer_logo_name']=$result[0]['logo_name'];
			$_SESSION['user_seo_link']=$result[0]['seo_link'];
			
			$_SESSION['user_login']= "yes"; 
			$_SESSION['user_type']="trainer";	
			
			
			//***************** save last login date *****************************//
			$db->query("update personal_trainers set last_login_date=now() where id='" . $_SESSION['trainer_id'] . "'");		
			//******************************************************************//
				
			
			if(isset($_SESSION['redirect_to_front_end']) && trim($_SESSION['redirect_to_front_end'])!=NULL){
				$path=$_SESSION['redirect_to_front_end']."?".$_SESSION['redirect_to_query_string'];
				$general_func->header_redirect($path);		
			}else{
				if(intval($_SESSION['trainer_membership_type']) ==0)
					$general_func -> header_redirect("trainer-choose-account/");	
				else
					$general_func -> header_redirect($_SESSION['user_type']."-account-setup.php");				
			}			
		}
	}else{		
		$_SESSION['user_message'] = "Access denied. Incorrect Username and/or Password!";		
	}	
	
}else if(isset($_REQUEST['submit']) && (trim($_REQUEST['submit']) == "gymforgot" || trim($_REQUEST['submit']) == "trainerforgot") ){	
	
	$table_name=trim($_REQUEST['submit']) =="gymforgot"?'gyms':'personal_trainers';
	
	$sql="select name,email_address,password from $table_name where email_address='". trim($_REQUEST['email_address']) ."'  and status=1 limit 1";
	$result=$db->fetch_all_array($sql);
	
	if(count($result) == 1){
					
		$email_content='<tr>
					    <td align="left" valign="top" style="padding:20px; margin:0;">					    
					    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
					
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Dear <span style="color:#949393;">'. $result[0]['name'] .',</span></td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					
					<tr>
					<td class="bigtxt" style="font:12px Arial; color:#949393; text-decoration:none;"><strong>Your Login information is given below:</strong></td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px; padding-top:10px;"><strong>Email Address:</strong> '. $result[0]['email_address'] .'<br /><br />
					<strong>Password:</strong> '. $EncDec->decrypt_me($result[0]['password']) .'</td>
					</tr>
						<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px; padding-top:10px;">
					By clicking <a href="'. $general_func->site_url . '"> here </a> you can login to your website.
					
					</td>
					</tr>
					
					
					<tr>
					<td>&nbsp;</td>
					</tr>
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">This password request has been made from "'. $general_func->get_ip() .'"</td>
					</tr>
					
															
					<tr>
					<td class="bodytxt" style="font:12px Arial; color:#949393; text-decoration:none; text-align:justify; line-height:16px; padding-left:20px;">Please do not reply to this email as this is a computer-generated response.</td>
					</tr>
					<tr>
					<td>&nbsp;</td>
					</tr>
					</table></td>
				  </tr>
				  ';
		
		
		//*******************  send email to employer *******************//
		$recipient_info=array();
		$recipient_info['recipient_subject']=$general_func->site_title ." Password";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=trim($_REQUEST['email_address']);		
		$sendmail -> logininfo_to_user($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);				
		//***************************************************************//
				
		$_SESSION['user_message'] = "Your password has been sent to your specified email address!";
		$general_func -> header_redirect($general_func->site_url);	
	}else{
		$_SESSION['user_message'] = "Sorry, E-Mail Address was not found in our records, please try again!";
		$general_func -> header_redirect($general_func->site_url);		
	}	
}	

?>

<script type="text/javascript">
var auto_refresh = setInterval(
	function (){
		$('#load').load('reload.php').fadeIn("slow");
	}, 10000); // refresh every 50000 milliseconds
</script>
<div class="box_banner">
      <div class="main_container">
    <div class="main" id="load">
    	<?php
    	$gold_gym="select name,seo_link,description,logo_name from gyms where email_confirmed=1 and status=1 and membership_type=2 and (membership_end IS NULL or membership_end >=$today_date) order by RAND() limit 1";
    	$result_gold_gym=$db->fetch_all_array($gold_gym);
		if(count($result_gold_gym) == 1){ ?>
        	<div class="box_banner_img for_g_anlst_box_banner">
        		<?php if(trim($result_gold_gym[0]['logo_name']) != NULL && file_exists("gym_logo/".$result_gold_gym[0]['logo_name'])){?>
        			<img src="gym_logo/<?=$result_gold_gym[0]['logo_name']?>" alt="<?=$result_gold_gym[0]['name']?>" />	
        		<?php }else{
        			echo '<img src="images/big_no_image.jpg" alt="" />';
        		}
        		?>
        		</div>
          <div class="box_banner_detail for_g_anlyst_box_banner_detail">
        <h6><?=$result_gold_gym[0]['name']?></h6>
        <p> <?=substr(strip_tags($result_gold_gym[0]['description']),0,200)?></p>
        <div class="inner_button"><a href="gym/<?=$result_gold_gym[0]['seo_link']?>">View Gym</a></div>
      </div>
		<?php } ?>
        
        <div class="google_anlst"></div>
        
        </div>
  </div>
    </div>
<!-- box banner --> 

<!-- tab -->
<div class="tab_container">
      <div class="main_container">
    <div class="main">
          <div class="tab">
        <div id="tabs" class="htabs">
              <div class="tab_a_container"> <a href="#gym-details">Class</a> <a href="#features">Gym</a> <a href="#classes-offered">Personal Trainer</a> </div>
            </div>
        
        <!-- description -->
        <div id="gym-details" class="tab-content">
              <div class="tab_subject">
            <div class="tab_form"> 
            	<script type="text/javascript">
				function classsearch_validate(){				
					
					if(document.frmclasssearch.county.selectedIndex == 0){
						alert("Please select a county");
						document.frmclasssearch.county.focus();
						return false;
					}
					
					if(document.frmclasssearch.area.selectedIndex == 0){
						alert("Please select an area");
						document.frmclasssearch.area.focus();
						return false;
					}
					
					/*if(document.frmclasssearch.category.selectedIndex == 0){
						alert("Please select a class type");
						document.frmclasssearch.category.focus();
						return false;
					}*/
					
					/*if(document.frmclasssearch.working_day.selectedIndex == 0){
						alert("Please select a day");
						document.frmclasssearch.working_day.focus();
						return false;
					}
					
					if(document.frmclasssearch.start_time.selectedIndex == 0){
						alert("Please select start time");
						document.frmclasssearch.start_time.focus();
						return false;
					}
					
					if(document.frmclasssearch.end_time.selectedIndex == 0){
						alert("Please select end time");
						document.frmclasssearch.end_time.focus();
						return false;
					}
					*/
					
				}
				</script>	
            	
            	
            	  <form method="post" action="class-listing/"  name="frmclasssearch"   onsubmit="return classsearch_validate()">
        		<input type="hidden" name="enter" value="yes" />
                   
                  <!-- row -->
                  <div class="tab_form_row">
                <div class="tab_form_block">
                      <label>County<span>*</span></label>
                      <div class="select_box">
                    <select name="county">
                          <option value="">Select</option>
                          <option value="Dublin">Dublin</option>
                        </select>
                  </div>
                    </div>
                <div class="tab_form_block">
                      <label>Area<span>*</span></label>
                      <div class="select_box">
                    <select name="area">
                         <option value="">Select</option>
                        <option value="Dublin 1" <?=trim($area)=="Dublin 1"?'selected="selected"':'';?>>Dublin 1</option>
                        <option value="Dublin 2" <?=trim($area)=="Dublin 2"?'selected="selected"':'';?>>Dublin 2</option>
                        <option value="Dublin 3" <?=trim($area)=="Dublin 3"?'selected="selected"':'';?>>Dublin 3</option>
                        <option value="Dublin 4" <?=trim($area)=="Dublin 4"?'selected="selected"':'';?>>Dublin 4</option>
                        <option value="Dublin 5" <?=trim($area)=="Dublin 5"?'selected="selected"':'';?>>Dublin 5</option>
                        <option value="Dublin 6" <?=trim($area)=="Dublin 6"?'selected="selected"':'';?>>Dublin 6</option>
                        <option value="Dublin 6W" <?=trim($area)=="Dublin 6W"?'selected="selected"':'';?>>Dublin 6W</option>
                        <option value="Dublin 7" <?=trim($area)=="Dublin 7"?'selected="selected"':'';?>>Dublin 7</option>
                        <option value="Dublin 8" <?=trim($area)=="Dublin 8"?'selected="selected"':'';?>>Dublin 8</option>
                        <option value="Dublin 9" <?=trim($area)=="Dublin 9"?'selected="selected"':'';?>>Dublin 9</option>
                        <option value="Dublin 10" <?=trim($area)=="Dublin 10"?'selected="selected"':'';?>>Dublin 10</option>
                        <option value="Dublin 11" <?=trim($area)=="Dublin 11"?'selected="selected"':'';?>>Dublin 11</option>
                        <option value="Dublin 12" <?=trim($area)=="Dublin 12"?'selected="selected"':'';?>>Dublin 12</option>
                        <option value="Dublin 13" <?=trim($area)=="Dublin 13"?'selected="selected"':'';?>>Dublin 13</option>
                        <option value="Dublin 14" <?=trim($area)=="Dublin 14"?'selected="selected"':'';?>>Dublin 14</option>
                        <option value="Dublin 15" <?=trim($area)=="Dublin 15"?'selected="selected"':'';?>>Dublin 15</option>
                        <option value="Dublin 16" <?=trim($area)=="Dublin 16"?'selected="selected"':'';?>>Dublin 16</option>
                        <option value="Dublin 17" <?=trim($area)=="Dublin 17"?'selected="selected"':'';?>>Dublin 17</option>
                        <option value="Dublin 18" <?=trim($area)=="Dublin 18"?'selected="selected"':'';?>>Dublin 18</option>
                        <option value="Dublin 19" <?=trim($area)=="Dublin 19"?'selected="selected"':'';?>>Dublin 19</option>
                        <option value="Dublin 20" <?=trim($area)=="Dublin 20"?'selected="selected"':'';?>>Dublin 20</option>
                        <option value="Dublin 21" <?=trim($area)=="Dublin 21"?'selected="selected"':'';?>>Dublin 21</option>
                        <option value="Dublin 22" <?=trim($area)=="Dublin 22"?'selected="selected"':'';?>>Dublin 22</option>
                        <option value="Dublin 23" <?=trim($area)=="Dublin 23"?'selected="selected"':'';?>>Dublin 23</option>
                        <option value="Dublin 24" <?=trim($area)=="Dublin 24"?'selected="selected"':'';?>>Dublin 24</option>
                        
                        <option value="Co. Dublin (North)" <?=trim($area)=="Co. Dublin (North)"?'selected="selected"':'';?>>Co. Dublin (North)</option>
                        <option value="Co. Dublin (South)" <?=trim($area)=="Co. Dublin (South)"?'selected="selected"':'';?>>Co. Dublin (South)</option>
                        </select>
                  </div>
                    </div>
                <div class="tab_form_block">
                      <label>Class Type</label>
                      <div class="select_box">
                      	 <select name="category">
                      	  <option value="">Select</option>
                  	 <?php
				$sql_category="SELECT id,name FROM `category` ORDER BY name ASC";
				$result_category=$db->fetch_all_array($sql_category);
				$total_category=count($result_category);
				for($category=0; $category < $total_category; $category++ ){ ?>
					<option value="<?=$result_category[$category]['id']?>"><?=$result_category[$category]['name']?></option>
													
				<?php }	?>
                        </select>
                  </div>
                    </div>
              </div>
              
                  <!-- row --> 
                  
                  <!-- row -->
                  <div class="tab_form_row">
                <div class="tab_form_block">
                      <label>Day</label>
                      <div class="select_box">
                   <select name="working_day">
                      <option value="">Choose a Day</option>
                     <?php
						foreach($all_days_in_a_week as $day_index=>$day_value){?>							    	
							<option value="<?=$day_index?>" <?=$day_index==$working_day?'selected="selected"':'';?>><?=$day_value?></option>								    				
					<?php } ?>	
                    </select>      
                  </div>
                    </div>
                <div class="tab_form_block">
                      <label>Starts Between</label>
                      
                    <div class="select_box" style="float:left;">
                    	<select name="start_time">
                    	 <option value="">Hour : Min</option>	
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$start_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select>
                        </div>
                 
                    </div>
                <div class="tab_form_block">
                      <label>And</label>
                    
                    <div class="select_box" style="float:left;">
                         <select name="end_time">
                         	 <option value="">Hour : Min</option>	
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$end_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
                        </div>
                    
                
                    </div>
              </div>
                  <!-- row -->
                  
                  <input type="submit" value="Search" /> 
                  </form>
                </div>
          </div>
         
            </div>
        <!-- description --> 
        
        <!-- description -->
        <div id="features" class="tab-content">
              <div class="tab_subject">
            <div class="tab_form"> 
			<script type="text/javascript">
			function gymsearch_validate(){				
				
				if(document.frmgymsearch.county.selectedIndex == 0){
					alert("Please select a county");
					document.frmgymsearch.county.focus();
					return false;
				}
				
				if(document.frmgymsearch.area.selectedIndex == 0){
					alert("Please select an area");
					document.frmgymsearch.area.focus();
					return false;
				}
			}
			</script>			

            	
        <form method="post" action="gym-listing/"  name="frmgymsearch"   onsubmit="return gymsearch_validate()">
        <input type="hidden" name="enter" value="yes" />
            	
                  <!-- row -->
                  <div class="tab_form_row">
                <div class="tab_form_block">
                      <label>County<span>*</span></label>
                      <div class="select_box">
                    <select name="county" >
                          <option>Select</option>
                           <option value="Dublin">Dublin</option>
                     </select>
                  </div>
                   </div>
                <div class="tab_form_block">
                      <label>Area<span>*</span></label>
                      <div class="select_box">
                   	 <select name="area" >
                     	<option value="">Select</option>
                        <option value="Dublin 1" <?=trim($area)=="Dublin 1"?'selected="selected"':'';?>>Dublin 1</option>
                        <option value="Dublin 2" <?=trim($area)=="Dublin 2"?'selected="selected"':'';?>>Dublin 2</option>
                        <option value="Dublin 3" <?=trim($area)=="Dublin 3"?'selected="selected"':'';?>>Dublin 3</option>
                        <option value="Dublin 4" <?=trim($area)=="Dublin 4"?'selected="selected"':'';?>>Dublin 4</option>
                        <option value="Dublin 5" <?=trim($area)=="Dublin 5"?'selected="selected"':'';?>>Dublin 5</option>
                        <option value="Dublin 6" <?=trim($area)=="Dublin 6"?'selected="selected"':'';?>>Dublin 6</option>
                        <option value="Dublin 6W" <?=trim($area)=="Dublin 6W"?'selected="selected"':'';?>>Dublin 6W</option>
                        <option value="Dublin 7" <?=trim($area)=="Dublin 7"?'selected="selected"':'';?>>Dublin 7</option>
                        <option value="Dublin 8" <?=trim($area)=="Dublin 8"?'selected="selected"':'';?>>Dublin 8</option>
                        <option value="Dublin 9" <?=trim($area)=="Dublin 9"?'selected="selected"':'';?>>Dublin 9</option>
                        <option value="Dublin 10" <?=trim($area)=="Dublin 10"?'selected="selected"':'';?>>Dublin 10</option>
                        <option value="Dublin 11" <?=trim($area)=="Dublin 11"?'selected="selected"':'';?>>Dublin 11</option>
                        <option value="Dublin 12" <?=trim($area)=="Dublin 12"?'selected="selected"':'';?>>Dublin 12</option>
                        <option value="Dublin 13" <?=trim($area)=="Dublin 13"?'selected="selected"':'';?>>Dublin 13</option>
                        <option value="Dublin 14" <?=trim($area)=="Dublin 14"?'selected="selected"':'';?>>Dublin 14</option>
                        <option value="Dublin 15" <?=trim($area)=="Dublin 15"?'selected="selected"':'';?>>Dublin 15</option>
                        <option value="Dublin 16" <?=trim($area)=="Dublin 16"?'selected="selected"':'';?>>Dublin 16</option>
                        <option value="Dublin 17" <?=trim($area)=="Dublin 17"?'selected="selected"':'';?>>Dublin 17</option>
                        <option value="Dublin 18" <?=trim($area)=="Dublin 18"?'selected="selected"':'';?>>Dublin 18</option>
                        <option value="Dublin 19" <?=trim($area)=="Dublin 19"?'selected="selected"':'';?>>Dublin 19</option>
                        <option value="Dublin 20" <?=trim($area)=="Dublin 20"?'selected="selected"':'';?>>Dublin 20</option>
                        <option value="Dublin 21" <?=trim($area)=="Dublin 21"?'selected="selected"':'';?>>Dublin 21</option>
                        <option value="Dublin 22" <?=trim($area)=="Dublin 22"?'selected="selected"':'';?>>Dublin 22</option>
                        <option value="Dublin 23" <?=trim($area)=="Dublin 23"?'selected="selected"':'';?>>Dublin 23</option>
                        <option value="Dublin 24" <?=trim($area)=="Dublin 24"?'selected="selected"':'';?>>Dublin 24</option>
                        
                        <option value="Co. Dublin (North)" <?=trim($area)=="Co. Dublin (North)"?'selected="selected"':'';?>>Co. Dublin (North)</option>
                        <option value="Co. Dublin (South)" <?=trim($area)=="Co. Dublin (South)"?'selected="selected"':'';?>>Co. Dublin (South)</option>
                     </select> 
                  </div>
                    </div>
              </div>
                  <!-- row -->
                  
                  <input type="submit" value="Search" />
                  </form>
                  
                </div>
          </div>
      
            </div>
        <!-- description --> 
        
        <!-- description -->
        <div id="classes-offered" class="tab-content">
              <div class="tab_subject">
            <div class="tab_form"> 
            	<script type="text/javascript">
			function trainersearch_validate(){				
				
				if(document.frmtrainersearch.county.selectedIndex == 0){
					alert("Please select a county");
					document.frmtrainersearch.county.focus();
					return false;
				}
				
				if(document.frmtrainersearch.area.selectedIndex == 0){
					alert("Please select an area");
					document.frmtrainersearch.area.focus();
					return false;
				}
			}
			</script>	
            	
             <form method="post" action="personal-trainer-listing/"  name="frmtrainersearch"   onsubmit="return trainersearch_validate();">
        	<input type="hidden" name="enter" value="yes" />
            		
                  
                  <!-- row -->
                  <div class="tab_form_row">
                <div class="tab_form_block">
                      <label>County<span>*</span></label>
                      <div class="select_box">
                    <select name="county" >
                          <option>Select</option>
                           <option value="Dublin">Dublin</option>
                     </select>
                  </div>
                    </div>
                <div class="tab_form_block">
                      <label>Area<span>*</span></label>
                      <div class="select_box">
                    <select name="area" >
                     	<option value="">Select</option>
                        <option value="Dublin 1" <?=trim($area)=="Dublin 1"?'selected="selected"':'';?>>Dublin 1</option>
                        <option value="Dublin 2" <?=trim($area)=="Dublin 2"?'selected="selected"':'';?>>Dublin 2</option>
                        <option value="Dublin 3" <?=trim($area)=="Dublin 3"?'selected="selected"':'';?>>Dublin 3</option>
                        <option value="Dublin 4" <?=trim($area)=="Dublin 4"?'selected="selected"':'';?>>Dublin 4</option>
                        <option value="Dublin 5" <?=trim($area)=="Dublin 5"?'selected="selected"':'';?>>Dublin 5</option>
                        <option value="Dublin 6" <?=trim($area)=="Dublin 6"?'selected="selected"':'';?>>Dublin 6</option>
                        <option value="Dublin 6W" <?=trim($area)=="Dublin 6W"?'selected="selected"':'';?>>Dublin 6W</option>
                        <option value="Dublin 7" <?=trim($area)=="Dublin 7"?'selected="selected"':'';?>>Dublin 7</option>
                        <option value="Dublin 8" <?=trim($area)=="Dublin 8"?'selected="selected"':'';?>>Dublin 8</option>
                        <option value="Dublin 9" <?=trim($area)=="Dublin 9"?'selected="selected"':'';?>>Dublin 9</option>
                        <option value="Dublin 10" <?=trim($area)=="Dublin 10"?'selected="selected"':'';?>>Dublin 10</option>
                        <option value="Dublin 11" <?=trim($area)=="Dublin 11"?'selected="selected"':'';?>>Dublin 11</option>
                        <option value="Dublin 12" <?=trim($area)=="Dublin 12"?'selected="selected"':'';?>>Dublin 12</option>
                        <option value="Dublin 13" <?=trim($area)=="Dublin 13"?'selected="selected"':'';?>>Dublin 13</option>
                        <option value="Dublin 14" <?=trim($area)=="Dublin 14"?'selected="selected"':'';?>>Dublin 14</option>
                        <option value="Dublin 15" <?=trim($area)=="Dublin 15"?'selected="selected"':'';?>>Dublin 15</option>
                        <option value="Dublin 16" <?=trim($area)=="Dublin 16"?'selected="selected"':'';?>>Dublin 16</option>
                        <option value="Dublin 17" <?=trim($area)=="Dublin 17"?'selected="selected"':'';?>>Dublin 17</option>
                        <option value="Dublin 18" <?=trim($area)=="Dublin 18"?'selected="selected"':'';?>>Dublin 18</option>
                        <option value="Dublin 19" <?=trim($area)=="Dublin 19"?'selected="selected"':'';?>>Dublin 19</option>
                        <option value="Dublin 20" <?=trim($area)=="Dublin 20"?'selected="selected"':'';?>>Dublin 20</option>
                        <option value="Dublin 21" <?=trim($area)=="Dublin 21"?'selected="selected"':'';?>>Dublin 21</option>
                        <option value="Dublin 22" <?=trim($area)=="Dublin 22"?'selected="selected"':'';?>>Dublin 22</option>
                        <option value="Dublin 23" <?=trim($area)=="Dublin 23"?'selected="selected"':'';?>>Dublin 23</option>
                        <option value="Dublin 24" <?=trim($area)=="Dublin 24"?'selected="selected"':'';?>>Dublin 24</option>
                        
                        <option value="Co. Dublin (North)" <?=trim($area)=="Co. Dublin (North)"?'selected="selected"':'';?>>Co. Dublin (North)</option>
                        <option value="Co. Dublin (South)" <?=trim($area)=="Co. Dublin (South)"?'selected="selected"':'';?>>Co. Dublin (South)</option>
                     </select> 
                  </div>
                    </div>
              </div>
                  <input type="submit" value="Search" />
                  </form>
                </div>
          </div>
      
            </div>
      </div>
        </div>
  </div>
    </div>
<!-- tab --> 
<?php include_once("includes/footer.php"); ?>
