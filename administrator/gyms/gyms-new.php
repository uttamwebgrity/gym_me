<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";




$small=$path_depth ."gym_logo/small/";
$original=$path_depth ."gym_logo/";


$gym_small=$path_depth ."gym_photo/small/";
$gym_medium=$path_depth ."gym_photo/medium/";
$gym_original=$path_depth ."gym_photo/";

$data=array();
$return_url=$_REQUEST['return_url'];




if(isset($_GET['now']) && $_GET['now']=="DELETE"){
	$path=$_REQUEST['path'];
	$field=$_REQUEST['field'];
		
	@mysql_query("update gyms set $field=' ' where id=" . (int) $_REQUEST['id'] . "");	
	
	@unlink($original.$path);
	@unlink($small.$path);		
	
	
	$redirect_path=basename($_SERVER['PHP_SELF']) . "?id=".$_GET['id']."&action=EDIT&return_url=".$return_url;
	$general_func->header_redirect($redirect_path);	
}

if(isset($_GET['now']) && $_GET['now']=="delete_bulk"){//***************  delete bulk files
	$bulk_id=$_REQUEST['bulk_id'];
	$file_name=$_REQUEST['file_name'];
		
	@mysql_query("delete from  gym_photos  where id=" . (int) $bulk_id . "");
	
	@unlink($gym_small.$file_name);	
	@unlink($gym_medium.$file_name);	
	@unlink($gym_original.$file_name);	
	
	$redirect_path=basename($_SERVER['PHP_SELF']) . "?id=".$_GET['id']."&action=EDIT&return_url=".$return_url;
	$general_func->header_redirect($redirect_path);		
	
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){		
	
	$sql="select * from gyms where id=" . (int)  $_REQUEST['id']  . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$name=$result[0]['name'];
	$email_address=$result[0]['email_address'];
	$password=$EncDec->decrypt_me($result[0]['password']);
		
	$website_URL=$result[0]['website_URL'];	
	$phone=$result[0]['phone'];	
	$youtube_videos=$result[0]['youtube_videos'];	
		
	
	$short_info=$result[0]['short_info'];			
	$description=$result[0]['description']; 
	$town=$result[0]['town'];
	$county=$result[0]['county'];
	$area=$result[0]['area'];
	$opening_time=$result[0]['opening_time'];	
	$closing_time=$result[0]['closing_time'];	
		
	$street_address=$result[0]['street_address']; 
	$facebook_fan_page_link=$result[0]['facebook_fan_page_link'];
	$twitter_tweets_page_link=$result[0]['twitter_tweets_page_link'];
	$logo_name=$result[0]['logo_name'];	
	$status=$result[0]['status'];
		
	
	//************ working_days **********************//	
	$sql_working_day="select working_day,opening_time,closing_time from gym_working_days where gym_id='" . $_REQUEST['id'] . "'";
	$result_working_day=$db->fetch_all_array($sql_working_day);
	$total_working_day=count($result_working_day);
	
	$working_days=array();
	$opening_and_closing_hours=array();
	
	
	for($day=0; $day<$total_working_day; $day++){
		$working_days[]=$result_working_day[$day]['working_day'];
		$opening_and_closing_hours[$result_working_day[$day]['working_day']]['opening_time']=$result_working_day[$day]['opening_time'];
		$opening_and_closing_hours[$result_working_day[$day]['working_day']]['closing_time']=$result_working_day[$day]['closing_time'];
	}
	
	
	
		
	$array_accolades=array();	
	$accolades_index=0;
		
	$img_diff_view_rs=@mysql_query("select id,photo_name from  gym_photos where gym_id='".(int)  $_REQUEST['id']  ."'");
	while($img_diff_view_rw=mysql_fetch_object($img_diff_view_rs)){
		$array_accolades[$accolades_index]['id']=$img_diff_view_rw->id;
		$array_accolades[$accolades_index++]['photo_name']=$img_diff_view_rw->photo_name;				
	}
		
	$val_accolades=count($array_accolades)+1;
	
	$button="Update";
}else{
			
	$name="";
	$email_address="";
	$password="";
	$youtube_videos="";
	$website_URL="";
	$phone="";	
	
	$short_info="";			
	$description="";
	$town="";
	$county="";
	$area="";
	$opening_time=$general_func->opening_time;	
	$closing_time=$general_func->closing_time;	
		
	$street_address="";
	$facebook_fan_page_link="";
	$twitter_tweets_page_link="";
	$logo_name="";	
	$status=0;	
	//$working_days=array(1,2,3,4,5,6);	
	$working_days=array();	
	$opening_and_closing_hours=array();
	$array_accolades=array();
	
	$val_accolades=2;
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$name=trim($_REQUEST['name']);
	$email_address=trim($_REQUEST['email_address']);
	$password=trim($_REQUEST['password']);
	$short_info=trim($_REQUEST['short_info']);		
	$description=trim($_REQUEST['description']);
	$town=trim($_REQUEST['town']);
	$county=trim($_REQUEST['county']);
	$area=trim($_REQUEST['area']);
	$opening_time=trim($_REQUEST['opening_time']);	
	$closing_time=trim($_REQUEST['closing_time']);
	
	$website_URL=trim($_REQUEST['website_URL']);
	$phone=trim($_REQUEST['phone']);	
		
	$street_address=trim($_REQUEST['street_address']);
	$facebook_fan_page_link=trim($_REQUEST['facebook_fan_page_link']);
	$twitter_tweets_page_link=trim($_REQUEST['twitter_tweets_page_link']);
	$youtube_videos=trim($_REQUEST['youtube_videos']);
		
	$status=trim($_REQUEST['status']);	
	$working_day=array();
	$working_day=$_REQUEST['working_day'];
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("gyms","email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";		
		}else{
			$data['name']=$name;
			
			$data['seo_link']=$general_func->create_seo_link($name);
			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_inset("gyms","seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$db->max_id("gyms","id") + 1 ."-".$data['seo_link'];
			}
			//*********************************************//
			
			$data['email_address']=$email_address;		
			$data['password']=$EncDec->encrypt_me($password);	
					
			$data['website_URL']=$website_URL;
			$data['phone']=$phone;
			$data['youtube_videos']=$youtube_videos;
			
			
			$data['short_info']=$short_info;		
			$data['description']=$description;
			$data['town']=$town;
			$data['county']=$county;
			$data['area']=$area;
			$data['opening_time']=$opening_time;
			$data['closing_time']=$closing_time;	
			$data['street_address']=$street_address;
			$data['facebook_fan_page_link']=$facebook_fan_page_link;
			$data['twitter_tweets_page_link']=$twitter_tweets_page_link;	
			
				
			//*************** lat & long ***************************//			
			$gen_lat=array();	
			$for_map=  $area .",". trim($street_address).", " .trim($town) .", Dublin, Ireland";	
			$gen_lat=$general_func->getLnt($for_map);				
			$data['geo_lat']=$gen_lat['lat'];	
			$data['geo_long']=$gen_lat['lng'];
			//*******************************************************//			
			
					
			$data['email_confirmed']=1;
			$data['membership_type']=2;
			$data['status']=$status;
			$data['created']='now()';
			$data['modified']='now()';
			
			$inserted_id=$db->query_insert("gyms",$data);
			
			
			if(count($working_day)> 0){
				$working_id_data = "INSERT INTO `gym_working_days` (`gym_id`, `working_day`,`opening_time`,`closing_time`) VALUES ";
				
				for($p=0; $p<count($working_day); $p++){
					$working_id_data .="('" . $inserted_id ."', '" . $working_day[$p] ."','" . $_REQUEST['opening_time_'.$working_day[$p]]. "','" . $_REQUEST['closing_time_'.$working_day[$p]]. "'), ";
				}
				
				$working_id_data = substr($working_id_data,0,-2);
				$working_id_data .=";";
				
				$db->query($working_id_data);
			}
			
			//****************************  upload logo ********************************//			
			if($_FILES['logo_name']['size'] >0){
						
				$uploaded_name=array();
					
				$userfile_name=$_FILES['logo_name']['name'];
				$userfile_tmp= $_FILES['logo_name']['tmp_name'];
				$userfile_size=$_FILES['logo_name']['size'];
				$userfile_type= $_FILES['logo_name']['type'];
								
				$path=$inserted_id ."_".$general_func->remove_space_by_hypen($userfile_name);
				$img=$original.$path;
				move_uploaded_file($userfile_tmp, $img) or die();
								
				$uploaded_name['logo_name']=$path;
				$db->query_update("gyms",$uploaded_name,'id='.$inserted_id);
				
				
				list($width, $height) = getimagesize($img);
				
				if($width > 177 || $height > 113){				
					$upload->uploaded_image_resize(177,113,$original,$small,$path);
				}else{
					copy($img,$small.$path); 
				}							
					
						
				if($width > 800 || $height > 700){
					$upload->uploaded_image_resize(800,700,$original,$original,$path);
				}	
			}
					
			//*************************  Upload photos *************************************//	
			for($j=0;$j<20;$j++){
				if(trim($_FILES['upload_file']['name'][$j]) != NULL && $_FILES['upload_file']['size'][$j] >0){
					$uploaded_name=array();					
					$userfile_name=$_FILES['upload_file']['name'][$j];
					$userfile_tmp= $_FILES['upload_file']['tmp_name'][$j];
					$userfile_size=$_FILES['upload_file']['size'][$j];
					$userfile_type= $_FILES['upload_file']['type'][$j];
							
					$path=time()."_". $general_func->remove_space_by_hypen($userfile_name);	
					$img=$gym_original.$path;
					move_uploaded_file($userfile_tmp, $img) or die();
											
					$uploaded_name['gym_id']=$inserted_id;
					$uploaded_name['photo_name']=$path;				
						
					$db->query_insert("gym_photos",$uploaded_name);	
					
					list($width, $height) = getimagesize($img);
					
					if($width > 144 || $height > 94){				
						$upload->uploaded_image_resize(144,94,$gym_original,$gym_small,$path);
					}else{
						copy($img,$gym_small.$path); 
					}	
					
					
					if($width > 475 || $height > 372){				
						$upload->uploaded_image_resize(475,372,$gym_original,$gym_medium,$path);
					}else{
						copy($img,$gym_medium.$path); 
					}	
										
							
					if($width > 800 || $height > 600){
						$upload->uploaded_image_resize(800,600,$gym_original,$gym_original,$path);
					}		
				}	
			}

			
			$_SESSION['msg']="Gym profile successfully created!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{	
		if($db->already_exist_update("gym","id",$_REQUEST['id'],"email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";		
		}else{
			$data['name']=$name;
						
			$data['seo_link']=$general_func->create_seo_link($name);			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_update("gym","id",$_REQUEST['id'],"seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$_REQUEST['id'] ."-".$data['seo_link'];
			}
			//*********************************************//
			
			
			$data['email_address']=$email_address;		
			$data['password']=$EncDec->encrypt_me($password);	
			if(trim($_REQUEST['old_street_address']) != trim($street_address) || trim($_REQUEST['old_town']) != trim($town) || trim($_REQUEST['old_county']) != trim($county) || trim($_REQUEST['old_area']) != trim($area)){
				$gen_lat=array();	
					$for_map=  $area .",". trim($street_address).", " .trim($town) .", Dublin, Ireland";	
				$gen_lat=$general_func->getLnt($for_map);				
				$data['geo_lat']=$gen_lat['lat'];	
				$data['geo_long']=$gen_lat['lng'];
			}	
			$data['website_URL']=$website_URL;
			$data['phone']=$phone;
			$data['youtube_videos']=$youtube_videos;
			$data['short_info']=$short_info;		
			$data['description']=$description;
			$data['town']=$town;
			$data['county']=$county;
			$data['area']=$area;
			$data['opening_time']=$opening_time;
			$data['closing_time']=$closing_time;	
			$data['street_address']=$street_address;
			$data['facebook_fan_page_link']=$facebook_fan_page_link;
			$data['twitter_tweets_page_link']=$twitter_tweets_page_link;
			$data['status']=$status;
			
			$data['modified']='now()';
			
			
			$db->query_update("gyms",$data,"id='".$_REQUEST['id'] ."'");
	
	
			$db->query("delete from gym_working_days where gym_id='" . $_REQUEST['id'] . "'");			
			if(count($working_day)> 0){
				$working_id_data = "INSERT INTO `gym_working_days` (`gym_id`, `working_day`,`opening_time`,`closing_time`) VALUES ";
				
				for($p=0; $p<count($working_day); $p++){
					$working_id_data .="('" . $_REQUEST['id'] ."', '" . $working_day[$p] ."','" . $_REQUEST['opening_time_'.$working_day[$p]]. "','" . $_REQUEST['closing_time_'.$working_day[$p]]. "'), ";
				}
				
				$working_id_data = substr($working_id_data,0,-2);
				$working_id_data .=";";
				
				$db->query($working_id_data);
			}
	
			//****************************  upload logo ********************************//			
			if($_FILES['logo_name']['size'] >0){
					
				@unlink($original.$_REQUEST['logo_name']);
				@unlink($small.$_REQUEST['logo_name']);
						
				$uploaded_name=array();
					
				$userfile_name=$_FILES['logo_name']['name'];
				$userfile_tmp= $_FILES['logo_name']['tmp_name'];
				$userfile_size=$_FILES['logo_name']['size'];
				$userfile_type= $_FILES['logo_name']['type'];
								
				$path=$_REQUEST['id'] ."_".$general_func->remove_space_by_hypen($userfile_name);
				$img=$original.$path;
				move_uploaded_file($userfile_tmp, $img) or die();
								
				$uploaded_name['logo_name']=$path;
				$db->query_update("gyms",$uploaded_name,'id='.$_REQUEST['id']);
				
				
				list($width, $height) = getimagesize($img);
				
				if($width > 177 || $height > 113){				
					$upload->uploaded_image_resize(177,113,$original,$small,$path);
				}else{
					copy($img,$small.$path); 
				}							
					
						
				if($width > 800 || $height > 700){
					$upload->uploaded_image_resize(800,700,$original,$original,$path);
				}	
			}
					
			//*************************  Upload photos *************************************//	
			for($j=0;$j<20;$j++){
				if(trim($_FILES['upload_file']['name'][$j]) != NULL && $_FILES['upload_file']['size'][$j] >0){
					$uploaded_name=array();					
					$userfile_name=$_FILES['upload_file']['name'][$j];
					$userfile_tmp= $_FILES['upload_file']['tmp_name'][$j];
					$userfile_size=$_FILES['upload_file']['size'][$j];
					$userfile_type= $_FILES['upload_file']['type'][$j];
							
					$path=time()."_". $general_func->remove_space_by_hypen($userfile_name);	
					$img=$gym_original.$path;
					move_uploaded_file($userfile_tmp, $img) or die();
											
					$uploaded_name['gym_id']=$_REQUEST['id'];
					$uploaded_name['photo_name']=$path;				
						
					$db->query_insert("gym_photos",$uploaded_name);	
					
					list($width, $height) = getimagesize($img);
					
					if($width > 144 || $height > 94){				
						$upload->uploaded_image_resize(144,94,$gym_original,$gym_small,$path);
					}else{
						copy($img,$gym_small.$path); 
					}	
					
					
					if($width > 475 || $height > 372){				
						$upload->uploaded_image_resize(475,372,$gym_original,$gym_medium,$path);
					}else{
						copy($img,$gym_medium.$path); 
					}	
										
							
					if($width > 800 || $height > 600){
						$upload->uploaded_image_resize(800,600,$gym_original,$gym_original,$path);
					}		
				}	
			}
		
			if($db->affected_rows > 0)
				$_SESSION['msg']="Gym profile successfully updated!";
			
			$general_func->header_redirect($return_url);
		}
	}
}	

?>

<script type="text/javascript" src="<?=$general_func->site_url?>highslide/highslide.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$general_func->site_url?>highslide/highslide.css" />
<script type="text/javascript">
	hs.graphicsDir = '<?=$general_func->site_url?>highslide/graphics/';
	hs.wrapperClassName = 'wide-border';
	

function validate(){
	
	if(!validate_text(document.ff.name,1,"Enter Gym Name"))
		return false;	
	
	if(!validate_email(document.ff.email_address,1,"Enter Email Address"))
		return false;	
	
	if(!validate_text(document.ff.password,1,"Enter Password"))
		return false;		

	/*if(!validate_text(document.ff.short_info,1,"Enter Gym Short Info"))
		return false;*/	
		
	
	if(!validate_text(document.ff.town,1,"Enter Gym Town"))
			return false;
	
	if(!validate_text(document.ff.street_address,1,"Enter Gym Street Address"))
		return false;
	
	if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
		return false;
	}
	
	var working_day=document.ff.working_day;
	
	/*if(working_day[0].checked== false && working_day[1].checked== false && working_day[2].checked== false && working_day[3].checked== false  && working_day[4].checked== false  && working_day[5].checked== false  && working_day[6].checked== false ){
		alert("Please choose at least a working day");		
		return false;	
	}*/
	
	if(working_day[0].checked == true){//**** monday
		if(parseInt(document.ff.opening_time_1.value) >= parseInt(document.ff.closing_time_1.value)){
			alert("Monday closing time must be greater than opening time");
			document.ff.closing_time_1.focus();
			return false;			
		}
	}
	
	if(working_day[1].checked == true){//**** tuesday
		if(parseInt(document.ff.opening_time_2.value) >= parseInt(document.ff.closing_time_2.value)){
			alert("Tuesday closing time must be greater than opening time");
			document.ff.closing_time_2.focus();
			return false;			
		}
	}
	
	if(working_day[2].checked == true){//**** wednesday
		if(parseInt(document.ff.opening_time_3.value) >= parseInt(document.ff.closing_time_3.value)){
			alert("Wednesday closing time must be greater than opening time");
			document.ff.closing_time_3.focus();
			return false;			
		}		
	}
	
	if(working_day[3].checked == true){//**** thrusday
		if(parseInt(document.ff.opening_time_4.value) >= parseInt(document.ff.closing_time_4.value)){
			alert("Thrusday closing time must be greater than opening time");
			document.ff.closing_time_4.focus();
			return false;			
		}		
	}
	
	if(working_day[4].checked == true){//**** friday
		if(parseInt(document.ff.opening_time_5.value) >= parseInt(document.ff.closing_time_5.value)){
			alert("Friday closing time must be greater than opening time");
			document.ff.closing_time_5.focus();
			return false;			
		}	
		
	}
	
	if(working_day[5].checked == true){//**** saturday
		if(parseInt(document.ff.opening_time_6.value) >= parseInt(document.ff.closing_time_6.value)){
			alert("Saturday closing time must be greater than opening time");
			document.ff.closing_time_6.focus();
			return false;			
		}
		
	}
	
	if(working_day[6].checked == true){//**** sunday
		if(parseInt(document.ff.opening_time_7.value) >= parseInt(document.ff.closing_time_7.value)){
			alert("Sunday closing time must be greater than opening time");
			document.ff.closing_time_7.focus();
			return false;			
		}
	}
	
		
	if(document.ff.status.selectedIndex == 0){
		alert("Please select a status");
		document.ff.status.focus();
		return false;
	}	
}	


function add_more_accolades_and_special_recognitions(val){
	var myval=parseInt(document.ff.accolades.value);
	//alert(myval);
	if(myval<=20){
		document.ff.accolades.value =myval+1;
		var menu ="accolades"+ parseInt(val);
		document.getElementById(menu).style.display = 'block';
	}	
	if(myval==20)
		document.getElementById("lblmoreaccolades").style.display = 'none';
}

</script>			

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg"><?=$button?>
            Gym</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input type="hidden" name="return_url" value="<?php echo $_REQUEST['return_url']?>" />
       <input type="hidden" name="logo_name" value="<?=$logo_name?>" />
       <input type="hidden" name="old_town" value="<?=$town?>" />
       <input type="hidden" name="old_county" value="<?=$county?>" />
       <input type="hidden" name="old_area" value="<?=$area?>" />  
          <input type="hidden" name="old_street_address" value="<?=$street_address?>" />     
          
   
        <table width="883" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" height="30"></td>
          </tr>
          <?php if(isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL){?>
          <tr>
            <td colspan="2" class="message_error"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></td>
          </tr>
          <tr>
            <td colspan="2" class="body_content-form" height="30"></td>
          </tr>
          <?php  } ?>
          <tr>
            <td width="73" align="left" valign="top"></td>
            <td width="780" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="10">
                <tr>
                  <td width="20%" class="body_content-form">Gym Name:<font class="form_required-field"> *</font></td>
                  <td width="80%"><input name="name" value="<?=$name?>" type="text" autocomplete="off" class="form_inputbox" size="55" />
                  </td>
                </tr>               
                 <tr>
                  <td class="body_content-form" valign="top">Email  Address:<font class="form_required-field"> *</font></td>
                  <td  class="body_content-form"  valign="top"><input name="email_address" value="<?=$email_address?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 <tr>
                  <td class="body_content-form">Password:<font class="form_required-field"> *</font></td>
                  <td ><input name="password" value="<?=$password?>" type="password" autocomplete="off" class="form_inputbox" size="55" />
                  </td>
                </tr>
                
               <!--  <tr>
             	<td class="body_content-form">Short Info:<font class="form_required-field"> *</font></td>
                <td> </td>			
            </tr>-->
                
                
                  <tr>
                  <td  class="body_content-form" valign="top">Description:</td>
                  <td  valign="top">
                  	<textarea name="description"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="10"><?=$description?></textarea>
                  	               	
                  </td>
                </tr> 
                  <tr>
             	<td class="body_content-form" style="line-height: 20px;">You Tube Share this Video Link: <!-- <img src="../images/youtube.jpg">--></td>
                <td><textarea name="youtube_videos"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="4"><?=$youtube_videos?></textarea> <br/>
                	(You can add multiple videos Link separated by a comma.)                 	
                </td>			
            </tr>
                        
                 
                <tr>
                  <td class="body_content-form" valign="top">Website URL:</td>
                  <td style="line-height: 22px;" ><input name="website_URL" value="<?=$website_URL?>" type="text" autocomplete="off" class="form_inputbox" size="55" /><br/>
                  	If exists, enter full URL (Ex: http://abc.com)
                  	
                  </td>
                </tr>
                
                
                 <tr>
                  <td class="body_content-form">Phone:</td>
                  <td ><input name="phone" value="<?=$phone?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td  class="body_content-form"> Street Address:<font class="form_required-field"> *</font></td>
                  <td ><input name="street_address" value="<?=$street_address?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 
                 
                <tr>
                  <td class="body_content-form">Town:<font class="form_required-field"> *</font></td>
                  <td ><input name="town" value="<?=$town?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                
                 <tr>
                  <td  class="body_content-form" valign="top">Area:<font class="form_required-field"> *</font></td>
                  <td valign="top"><select name="area"  class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
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
                  </td>
                </tr>
                 
                 <tr>
                  <td  class="body_content-form" valign="top">County:<font class="form_required-field"> *</font></td>
                  <td valign="top"><select name="county" class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
                     <option value="Dublin">Dublin</option>
                   </select> 
                  </td>
                </tr>
                
                 
                
                
                 <tr>
                  <td  class="body_content-form">Facebook Fan Page Link:</td>
                  <td ><input name="facebook_fan_page_link" value="<?=$facebook_fan_page_link?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                
                 <tr>
             	<td class="body_content-form">Twitter Embedded Timeline code:</td>
                <td><textarea name="twitter_tweets_page_link"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$twitter_tweets_page_link?></textarea> 
                	<br/>Need help? <a class="htext" target="_blank" href="<?=$general_func->site_url?>twitter-help.php">Click here</a>
                	
                	</td>			
            </tr>      
              
                
               <tr>
                  <td  class="body_content-form">Working Days:</td>
                  <td  style="line-height: 20px;">                  	
                  	 <?php
					foreach($all_days_in_a_week as $day_index=>$day_value){?>
					<div style="width: 100%; padding-bottom: 10px;">
					<div style="width: 100px !important; float: left;"><input type="checkbox" name="working_day[]" id="working_day" <?=in_array($day_index,$working_days)?'checked="checked"':'';?>  value="<?=$day_index?>" >
					<?=$day_value?></div>
					
					<select name="opening_time_<?=$day_index?>" id="opening_time_<?=$day_index?>" class="inputbox_select" style="width: 100px; padding: 2px 1px 2px 0px;">
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$opening_and_closing_hours[$day_index]['opening_time']==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
                   
                   &nbsp; &nbsp;
					
					<select name="closing_time_<?=$day_index?>" id="closing_time_<?=$day_index?>"  class="inputbox_select" style="width: 100px; padding: 2px 1px 2px 0px;">
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$opening_and_closing_hours[$day_index]['closing_time']==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
					
					</div>				
					<?php }	?>
                  	
                  </td>
                </tr> 
                
                 
                
                 
                <tr>
                  <td  class="body_content-form" valign="top"><?=trim($logo_name) != NULL?'Update':'Upload';?>
                     Main Profile Picture:</td>
                  <td  valign="top">
                  <?php if(trim($logo_name) != NULL){?>
                    		<a href="<?=$general_func->site_url.substr($original,6).$logo_name?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($small,6).$logo_name?>" border="0" /></a>&nbsp;&nbsp;
                    		<a href="gyms/gyms-new.php?id=<?=$_REQUEST['id']?>&now=DELETE&field=logo_name&path=<?=$logo_name?>" class="htext" ><strong>Delete</strong></a>
                  			
                    <?php }	?>							
                	
                  <input type="file" name="logo_name" /></td>
                </tr>
               
                <tr>
                  <td  class="body_content-form" valign="top">Upload Image:</td>
                  <td  valign="top">
                  <div class="div_clear"></div>
						<?php                  
						for($upload=1; $upload <=20; $upload++){?>
						
						<?php if($array_accolades[$upload-1]){?>
							<a href="<?=$general_func->site_url.substr($gym_original,6).$array_accolades[$upload-1]['photo_name']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($gym_small,6).$array_accolades[$upload-1]['photo_name']?>" border="0" /></a>&nbsp;&nbsp;
							<a href="gyms/gyms-new.php?id=<?=$_REQUEST['id']?>&now=delete_bulk&bulk_id=<?=$array_accolades[$upload-1]['id']?>&file_name=<?=$array_accolades[$upload-1]['photo_name']?>" class="htext">Delete</a>
						<div class="div_clear"></div>
						<?php } ?>
						<div class="select_box"  id="accolades<?=$upload?>" style="display:<?php if($upload==1 || $array_accolades[$upload-1]){ echo "block;";}else{ echo "none;";}?>">
							<input name="upload_file[]" value="" type="file"   />
						</div>	
						
						<div class="div_clear"></div>	
						<?php	}
						
						
						 ?>                  	
						<input type="hidden" name="accolades" value="<?php echo $val_accolades; ?>" />
                <?php if($val_accolades < 21){?>
                	<div class="add_attachment" id="lblmoreaccolades" onclick="add_more_accolades_and_special_recognitions(document.ff.accolades.value);">Add More Image</div>
					
               <?php   } ?></td>
                </tr>
               
               
                <tr>
                  <td  class="body_content-form" valign="top">Status:<font class="form_required-field"> *</font></td>
                  <td valign="top"><select name="status"  class="inputbox_select" style="width: 100px;" >
                      <option value="">Choose One</option>
                      <option value="1" <?=$status==1?'selected="selected"':'';?>>Active</option>
                      <option value="0" <?=$status==0?'selected="selected"':'';?>>Inactive</option>
                    </select>
                    <p>&nbsp; </p></td>
                </tr>
              </table></td>
            <td width="8" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" height="30" align="center"><table width="879" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="33%"><table border="0" align="right" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                        <td align="left" valign="middle" class="body_tab-middilebg"><input name="submit" type="submit" class="submit1" value="<?=$button?>" /></td>
                        <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                      </tr>
                    </table></td>
                  <td width="4%"></td>
                  <td width="63%"><?php if($button !="Add New"){?>
                    <table border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                        <td align="left" valign="middle" class="body_tab-middilebg">
                        	<input type="button" class="submit1"  name="back" value="Back"  onclick="history.back();" />
                        	
                        	<!--<input name="back" onclick="location.href='<?=$return_url?>'"  type="button" class="submit1" value="Back" />--></td>
                        <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                      </tr>
                    </table>
                    <?php  }else 
							echo "&nbsp;";
						 ?></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="4" height="30"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
