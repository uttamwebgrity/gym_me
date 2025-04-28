<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

if((int)$_SESSION['admin_access_level'] != 1){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	
	
	$data=array();
	$data['option_value']=$_REQUEST['opening_time'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='opening_time'");
	
	$data=array();
	$data['option_value']=$_REQUEST['site_title'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='site_title'");
	
	$data=array();
	$data['option_value']=$_REQUEST['site_address'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='site_address'");
	
	$data=array();
	$data['option_value']=$_REQUEST['admin_address'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='admin_address'");
	
	$data=array();
	$data['option_value']=$_REQUEST['testimonials'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='testimonials'");
	
	$data=array();
	$data['option_value']=$_REQUEST['home_page_video'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='home_page_video'");
	
	$data=array();
	$data['option_value']=$_REQUEST['admin_recoed_per_page'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='admin_recoed_per_page'");
	
	$data=array();
	$data['option_value']=$_REQUEST['front_end_recoed_per_page'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='front_end_recoed_per_page'");
	
	$data=array();
	$data['option_value']=$_REQUEST['subscription_amount_per_month'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='subscription_amount_per_month'");
	
	$data=array();
	$data['option_value']=$_REQUEST['minimum_subscription_month'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='minimum_subscription_month'");
	
	$data=array();
	$data['option_value']=$_REQUEST['maximum_subscription_month'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='maximum_subscription_month'");

	$data=array();
	$data['option_value']=$_REQUEST['global_meta_title'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='global_meta_title'");
	
	$data=array();
	$data['option_value']=$_REQUEST['global_meta_keywords'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='global_meta_keywords'");
	
	$data=array();
	$data['option_value']=$_REQUEST['global_meta_description'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='global_meta_description'");
	
	$data=array();
	$data['option_value']=$_REQUEST['address'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='address'");
	
	$data=array();
	$data['option_value']=$_REQUEST['phone'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='phone'");
	
	$data=array();
	$data['option_value']=$_REQUEST['email'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='email'");
	
	
	
	$data=array();
	$data['option_value']=$_REQUEST['twitter'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='twitter'");
	
	$data=array();
	$data['option_value']=$_REQUEST['linkedin'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='linkedin'");
	
	$data=array();
	$data['option_value']=$_REQUEST['facebook'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='facebook'");
	
	$data=array();
	$data['option_value']=$_REQUEST['Instagram'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='Instagram'");
	
	
	
	$data=array();
	$data['option_value']=$_REQUEST['gym_free'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='gym_free'");
		
	
	$data=array();
	$data['option_value']=$_REQUEST['gym_paid'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='gym_paid'");
	
	
	$data=array();
	$data['option_value']=$_REQUEST['trainer_free'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='trainer_free'");
	
	
	$data=array();
	$data['option_value']=$_REQUEST['trainer_paid'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='trainer_paid'");
		
	
	
	$data=array();
	$data['option_value']=$_REQUEST['closing_time'];
	$db->query_update("tbl_options",$data,"admin_admin_id=1 and option_name='closing_time'");
	 
	
	
	$_SESSION['msg']="General settings successfully saved.";
	$general_func->header_redirect($_SERVER['PHP_SELF']);
}




$sql="select option_name,option_value from tbl_options where admin_admin_id=1 and (option_name='site_title' or option_name='site_address' or option_name='admin_address' or";
$sql .=" option_name='testimonials' or option_name='home_page_video' or option_name='admin_recoed_per_page' or option_name='front_end_recoed_per_page' or";
$sql .=" option_name='subscription_amount_per_month' or option_name='minimum_subscription_month' or option_name='maximum_subscription_month' or";
$sql .=" option_name='linkedin' or option_name='twitter' or option_name='pinterest' or option_name='facebook' or option_name='address' or option_name='phone' or option_name='email' or  option_name='handling_charge_on_deposit_amount' or";
$sql .=" option_name='box_height' or option_name='box_length' or option_name='box_width' or";
$sql .=" option_name='opening_time' or option_name='closing_time' or ";
$sql .=" option_name='gym_free' or option_name='gym_paid' or option_name='trainer_free' or option_name='trainer_paid' or ";
$sql .=" option_name='global_meta_title' or option_name='global_meta_keywords' or option_name='global_meta_description' or option_name='admin_commission_on_bid' or option_name='handling_charge_on_deposit_amount_hundred' or option_name='handling_charge_on_deposit_amount_less_hundred' or option_name='handling_charge_on_deposit_amount_details')";



$result=$db->fetch_all_array($sql);

if(count($result) > 0){
	for($i=0; $i <count($result); $i++){
		$$result[$i]['option_name']=trim($result[$i]['option_value']);
	}
}else{
	$site_title="";
	
	$site_address="";
	$admin_address="";
	
	$testimonials="";
	$home_page_video="";
	
	$address="";
	$phone="";
	$email="";
	
	
	$admin_recoed_per_page="";
	$front_end_recoed_per_page="";
	
	
	
	$global_meta_title="";
	$global_meta_keywords="";
	$global_meta_description="";
		
	$gym_free="";
	$gym_paid="";	
	$trainer_free="";
	$trainer_paid="";
	
	$twitter="";
	$linkedin="";
	$facebook="";
	$admin_commission_on_bid="";
	$opening_time="540";
	$closing_time="1140";
	

	
	
}

?>
<script language="javascript" type="text/javascript"> 
function validate(){
	if(!validate_text(document.ff.site_title,1,"Site title should not be blank"))
		return false;
	
	if(!validate_text(document.ff.address,1,"Address should not be blank"))
		return false;
		
	if(!validate_text(document.ff.phone,1,"Phone should not be blank"))
		return false;
						
	if(!validate_text(document.ff.email,1,"Email should not be blank"))
		return false;
		
	if(parseInt(document.ff.opening_time.value) >= parseInt(document.ff.closing_time.value)){
		alert("Closing time must be greater than opening time");
		document.ff.closing_time.focus();
		return false;			
	}	
				
			
	if(!validate_integer(document.ff.admin_recoed_per_page,1,"Admin recoed per page should not be blank and must be a valid [0-9] number"))
		return false;	
	
	if(!validate_text(document.ff.admin_commission_on_bid,1,"Enter Site Commission On Per Bid"))
		return false;		
		
	if(!validate_price(document.ff.admin_commission_on_bid,1,"Enter Site Commission (%) On Per Bid"))
		return false;		
			
		
	
	if(!validate_text(document.ff.global_meta_title,1,"Global meta title should not be blank"))
		return false;		
			
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg another_bg_color">General Settings</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()">
    <input type="hidden" name="enter" value="yes" /> 
        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
           <tr>
                  <td colspan="3" class="body_content-form" height="30"></td>
            </tr>
            <?php if(isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL){?>
			<tr>
                  <td colspan="3" class="message_error"><?=$_SESSION['msg']; $_SESSION['msg']="";?></td>
            </tr>
             <tr>
                  <td colspan="3" class="body_content-form" height="10"></td>
            </tr>
			 <?php  } ?>
            
            
          <tr>
            <td align="left" valign="top" colspan="3"><table width="95%" border="0"  align="center" cellspacing="2" cellpadding="6">
                <tr>
                  <td width="15%" class="body_content-form">Site Title: <font class="form_required-field">*</font> </td>
                  <td width="85%"><input name="site_title" type="text" value="<?=$site_title?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr>               
                
                 <tr>
                  <td width="15%" class="body_content-form">Address: <font class="form_required-field">*</font> </td>
                  <td width="85%"><input name="address" type="text" value="<?=$address?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr><tr>
                  <td width="15%" class="body_content-form">Phone: <font class="form_required-field">*</font> </td>
                  <td width="85%"><input name="phone" type="text" value="<?=$phone?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr>
                
                <tr>
                  <td width="15%" class="body_content-form">Email: <font class="form_required-field">*</font> </td>
                  <td width="85%"><input name="email" type="text" value="<?=$email?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr>
                  <tr>
                  <td width="15%" class="body_content-form">Twitter:  </td>
                  <td width="85%"><input name="twitter" type="text" value="<?=$twitter?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr>
              <tr>
                  <td width="15%" class="body_content-form">Facebook: </td>
                  <td width="85%"><input name="facebook" type="text" value="<?=$facebook?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr>
                 <tr>
                  <td width="15%" class="body_content-form">You Tube:  </td>
                  <td width="85%"><input name="linkedin" type="text" value="<?=$linkedin?>" autocomplete="off" class="form_inputbox" size="60" /></td>
                </tr>
                
                
                <tr>
                  <td width="15%" class="body_content-form">Opening Time (24 hours): <font class="form_required-field">*</font> </td>
                  <td width="85%"><select name="opening_time">
                    	<?php for ($i = 0; $i <= 1430; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$opening_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                    		
                    	</select></td>
                </tr>
                
                  <tr>
                  <td width="15%" class="body_content-form">Closing Time (24 hours): <font class="form_required-field">*</font> </td>
                  <td width="85%">	<select name="closing_time">
                    	<?php for ($i = 0; $i <= 1445; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$closing_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                    		
                    	</select></td>
                </tr>
                
                
                    
                  
              
                  <tr>
                  <td width="15%" class="body_content-form">Recoed per page:<font class="form_required-field"> * </font></td>
                  <td width="85%"><input name="admin_recoed_per_page" type="text" value="<?=$admin_recoed_per_page?>" autocomplete="off" class="form_inputbox"  size="5"/>&nbsp;&nbsp;<small>(Admin Panel)</small></td>
                </tr>
                
                
                
                  <tr>
                  <td width="15%" class="body_content-form" valign="top">Gym free membership short info:</td>
                  <td width="85%"  valign="top"><textarea name="gym_free"  autocomplete="off" class="form_textarea" cols="90" rows="8"><?=$gym_free?></textarea></td>
                </tr>
                
                  <tr>
                  <td width="15%" class="body_content-form" valign="top">Gym paid membership short info:</td>
                  <td width="85%"  valign="top"><textarea name="gym_paid"  autocomplete="off" class="form_textarea" cols="90" rows="8"><?=$gym_paid?></textarea></td>
                </tr>
                  <tr>
                  <td width="15%" class="body_content-form" valign="top">Personal trainer free membership short info:</td>
                  <td width="85%"  valign="top"><textarea name="trainer_free"  autocomplete="off" class="form_textarea" cols="90" rows="8"><?=$trainer_free?></textarea></td>
                </tr>
                
                  <tr>
                  <td width="15%" class="body_content-form" valign="top">Personal trainer paid membership short info:</td>
                  <td width="85%"  valign="top"><textarea name="trainer_paid"  autocomplete="off" class="form_textarea" cols="90" rows="8"><?=$trainer_paid?></textarea></td>
                </tr>
                
                
                
                         
                 <tr>
                  <td width="15%" class="body_content-form" valign="top">Google Analytics code:</td>
                  <td width="85%"  valign="top"><textarea name="testimonials"  autocomplete="off" class="form_textarea" cols="90" rows="8"><?=$testimonials?></textarea></td>
                </tr>
                
                       
                 <tr>
                  <td width="15%" class="body_content-form">Global Meta Title:<font class="form_required-field"> * </font></td>
                  <td width="85%"><input name="global_meta_title" type="text" value="<?=$global_meta_title?>" autocomplete="off" class="form_inputbox"  size="93"/></td>
                </tr>
                
                 <tr>
                  <td width="15%" class="body_content-form" valign="top">Global Meta Keywords:</td>
                  <td width="85%"  valign="top"><textarea name="global_meta_keywords"  autocomplete="off" class="form_textarea" cols="90" rows="5"><?=$global_meta_keywords?></textarea></td>
                </tr>
                
                 <tr>
                  <td width="15%" class="body_content-form"  valign="top">Global Meta Description:</td>
                  <td width="85%"  valign="top"><textarea name="global_meta_description"  autocomplete="off" class="form_textarea"  cols="90" rows="5"><?=$global_meta_description?></textarea></td>
                </tr>              
                
                 <tr>
                  <td colspan="2" class="body_content-form" height="10"></td>
                 </tr>
                <tr>
                  <td width="15%" class="body_content-form">&nbsp;</td>
            <td width="85%"><table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="button" type="submit" class="submit1" value="Save Changes" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                        </table> </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="32" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
