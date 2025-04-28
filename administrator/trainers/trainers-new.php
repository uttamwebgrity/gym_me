<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";




$small=$path_depth ."trainer_logo/small/";
$original=$path_depth ."trainer_logo/";


$gym_small=$path_depth ."trainer_photo/small/";
$gym_medium=$path_depth ."trainer_photo/medium/";
$gym_original=$path_depth ."trainer_photo/";

$data=array();
$return_url=$_REQUEST['return_url'];



if(isset($_GET['now']) && $_GET['now']=="DELETE"){
	$path=$_REQUEST['path'];
	$field=$_REQUEST['field'];
		
	@mysql_query("update personal_trainers set $field=' ' where id=" . (int) $_REQUEST['id'] . "");	
	
	@unlink($original.$path);
	@unlink($small.$path);		
	
	
	$redirect_path=basename($_SERVER['PHP_SELF']) . "?id=".$_GET['id']."&action=EDIT&return_url=".$return_url;
	$general_func->header_redirect($redirect_path);	
}

if(isset($_GET['now']) && $_GET['now']=="delete_bulk"){//***************  delete bulk files
	$bulk_id=$_REQUEST['bulk_id'];
	$file_name=$_REQUEST['file_name'];
		
	@mysql_query("delete from  trainer_photos  where id=" . (int) $bulk_id . "");
	
	@unlink($gym_small.$file_name);	
	@unlink($gym_medium.$file_name);	
	@unlink($gym_original.$file_name);	
	
	$redirect_path=basename($_SERVER['PHP_SELF']) . "?id=".$_GET['id']."&action=EDIT&return_url=".$return_url;
	$general_func->header_redirect($redirect_path);	
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){		
	
	$sql="select * from personal_trainers where id=" . (int)  $_REQUEST['id']  . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$name=$result[0]['name'];
	$email_address=$result[0]['email_address'];
	$password=$EncDec->decrypt_me($result[0]['password']);
	$youtube_videos=$result[0]['youtube_videos'];	
	$phone=$result[0]['phone'];
	$street_address=$result[0]['street_address'];
	$town=$result[0]['town'];
	$website_URL=$result[0]['website_URL'];	

	
	$experience=$result[0]['experience'];
	$special_offers=$result[0]['special_offers'];
	
	$qualification1=$result[0]['qualification1'];
	$qualification2=$result[0]['qualification2'];
	$qualification3=$result[0]['qualification3'];
	$qualification4=$result[0]['qualification4'];
	$qualification5=$result[0]['qualification5'];
		
	$qualification6=$result[0]['qualification6'];
	$qualification7=$result[0]['qualification7'];
	$qualification8=$result[0]['qualification8'];
	$qualification9=$result[0]['qualification9'];
	$qualification10=$result[0]['qualification10'];
	
	
	$specialty1=$result[0]['specialty1'];
	$specialty2=$result[0]['specialty2'];
	$specialty3=$result[0]['specialty3'];
	$specialty4=$result[0]['specialty4'];
	$specialty5=$result[0]['specialty5'];
	
	
	$short_info=$result[0]['short_info'];			
	$description=$result[0]['description']; 
	$price_per_session=$result[0]['price_per_session'];
	$county=$result[0]['county'];
	$area=$result[0]['area'];
	//$qualification=$result[0]['qualification'];	
	
	$facebook_fan_page_link=$result[0]['facebook_fan_page_link'];
	$twitter_tweets_page_link=$result[0]['twitter_tweets_page_link'];
	$logo_name=$result[0]['logo_name'];	
	$status=$result[0]['status'];
		
	
	/*$sql_service="select specialy_id from personal_trainer_specialities where trainer_id='" .  $_REQUEST['id']  . "'";
	$result_service=$db->fetch_all_array($sql_service);	
	$gym_services_array=array();	
	
	for($i=0; $i<count($result_service); $i++){
		$gym_services_array[]=$result_service[$i]['specialy_id'];	
	}	
	*/
		
	$array_accolades=array();	
	$accolades_index=0;
		
	$img_diff_view_rs=@mysql_query("select id,photo_name from  trainer_photos where trainer_id='".(int)  $_REQUEST['id']  ."'");
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
		
	$phone="";
	$street_address="";
	$town="";
	$youtube_videos="";
	$short_info="";			
	$description="";
	$price_per_session="";
	$county="";
	$area="";
	//$qualification="";	
	$website_URL="";
	
	$experience="";
	$special_offers="";
	
	$qualification1="";
	$qualification2="";
	$qualification3="";
	$qualification4="";
	$qualification5="";
		
	$qualification6="";
	$qualification7="";
	$qualification8="";
	$qualification9="";
	$qualification10="";
	
	
	$specialty1="";
	$specialty2="";
	$specialty3="";
	$specialty4="";
	$specialty5="";

	$facebook_fan_page_link="";
	$twitter_tweets_page_link="";
	$logo_name="";	
	$status=0;	
	
	//$gym_services_array=array();	
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
	$price_per_session=trim($_REQUEST['price_per_session']);
	$county=trim($_REQUEST['county']);
	$area=trim($_REQUEST['area']);
	//$qualification=trim($_REQUEST['qualification']);
	$youtube_videos=trim($_REQUEST['youtube_videos']);
	$website_URL=trim($_REQUEST['website_URL']);
	
	$experience=trim($_REQUEST['experience']);
	$special_offers=trim($_REQUEST['special_offers']);
	
	$qualification1=trim($_REQUEST['qualification1']);
	$qualification2=trim($_REQUEST['qualification2']);
	$qualification3=trim($_REQUEST['qualification3']);
	$qualification4=trim($_REQUEST['qualification4']);
	$qualification5=trim($_REQUEST['qualification5']);
	$qualification6=trim($_REQUEST['qualification6']);
	$qualification7=trim($_REQUEST['qualification7']);	
	$qualification8=trim($_REQUEST['qualification8']);
	$qualification9=trim($_REQUEST['qualification9']);
	$qualification10=trim($_REQUEST['qualification10']);
	
	$specialty1=trim($_REQUEST['specialty1']);
	$specialty2=trim($_REQUEST['specialty2']);
	$specialty3=trim($_REQUEST['specialty3']);
	$specialty4=trim($_REQUEST['specialty4']);
	$specialty5=trim($_REQUEST['specialty5']);
	
	$phone=trim($_REQUEST['phone']);
	$street_address=trim($_REQUEST['street_address']);
	$town=trim($_REQUEST['town']);
	
	$facebook_fan_page_link=trim($_REQUEST['facebook_fan_page_link']);
	$twitter_tweets_page_link=trim($_REQUEST['twitter_tweets_page_link']);	
	$status=trim($_REQUEST['status']);	
	
	
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("personal_trainers","email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";		
		}else{
			$data['name']=$name;
			
			$data['seo_link']=$general_func->create_seo_link($name);
			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_inset("personal_trainers","seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$db->max_id("personal_trainers","id") + 1 ."-".$data['seo_link'];
			}
			//*********************************************//
			
			$data['email_address']=$email_address;		
			$data['password']=$EncDec->encrypt_me($password);	
			$data['website_URL']=$website_URL;	
			$data['youtube_videos']=$youtube_videos;
			$data['phone']=$phone;	
			$data['street_address']=$street_address;	
			$data['town']=$town;			
			
			$data['experience']=$experience;
			$data['special_offers']=$special_offers;
			
			
			//*************** lat & long ***************************//			
			$gen_lat=array();	
			$for_map=  $area .",". trim($street_address).", " .trim($town) .", Dublin, Ireland";	
			$gen_lat=$general_func->getLnt($for_map);				
			$data['geo_lat']=$gen_lat['lat'];	
			$data['geo_long']=$gen_lat['lng'];
			//*******************************************************//		
			
			
			$data['qualification1']=$qualification1;
			$data['qualification2']=$qualification2;
			$data['qualification3']=$qualification3;
			$data['qualification4']=$qualification4;
			$data['qualification5']=$qualification5;
			
			
			$data['qualification6']=$qualification6;
			$data['qualification7']=$qualification7;
			$data['qualification8']=$qualification8;
			$data['qualification9']=$qualification9;
			$data['qualification10']=$qualification10;
			
			$data['specialty1']=$specialty1;
			$data['specialty2']=$specialty2;
			$data['specialty3']=$specialty3;
			$data['specialty4']=$specialty4;
			$data['specialty5']=$specialty5;
			
			$data['short_info']=$short_info;		
			$data['description']=$description;
			$data['price_per_session']=$price_per_session;
			$data['county']=$county;
			$data['area']=$area;
			//$data['qualification']=$qualification;
			
			$data['facebook_fan_page_link']=$facebook_fan_page_link;
			$data['twitter_tweets_page_link']=$twitter_tweets_page_link;			
			$data['email_confirmed']=1;
			$data['membership_type']=2;
			$data['status']=$status;
			$data['created']='now()';
			$data['modified']='now()';
			
			$inserted_id=$db->query_insert("personal_trainers",$data);
			
			
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
				$db->query_update("personal_trainers",$uploaded_name,'id='.$inserted_id);
				
				
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
											
					$uploaded_name['trainer_id']=$inserted_id;
					$uploaded_name['photo_name']=$path;				
						
					$db->query_insert("trainer_photos",$uploaded_name);	
					
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

			
			$_SESSION['msg']="Personal trainer profile successfully created!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{	
		if($db->already_exist_update("personal_trainers","id",$_REQUEST['id'],"email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";		
		}else{
			$data['name']=$name;
						
			$data['seo_link']=$general_func->create_seo_link($name);			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_update("personal_trainers","id",$_REQUEST['id'],"seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$_REQUEST['id'] ."-".$data['seo_link'];
			}
			//*********************************************//
			
			
			$data['email_address']=$email_address;		
			$data['password']=$EncDec->encrypt_me($password);	
			$data['youtube_videos']=$youtube_videos;
			$data['phone']=$phone;	
			$data['street_address']=$street_address;	
			$data['town']=$town;			
			$data['website_URL']=$website_URL;
			$data['experience']=$experience;
			$data['special_offers']=$special_offers;
			
			$data['qualification1']=$qualification1;
			$data['qualification2']=$qualification2;
			$data['qualification3']=$qualification3;
			$data['qualification4']=$qualification4;
			$data['qualification5']=$qualification5;
			
			$data['qualification6']=$qualification6;
			$data['qualification7']=$qualification7;
			$data['qualification8']=$qualification8;
			$data['qualification9']=$qualification9;
			$data['qualification10']=$qualification10;
			
			if(trim($_REQUEST['old_street_address']) != trim($street_address) || trim($_REQUEST['old_town']) != trim($town) || trim($_REQUEST['old_county']) != trim($county) || trim($_REQUEST['old_area']) != trim($area)){
				$gen_lat=array();	
				$for_map=  $area .",". trim($street_address).", " .trim($town) .", Dublin, Ireland";	
				$gen_lat=$general_func->getLnt($for_map);				
				$data['geo_lat']=$gen_lat['lat'];	
				$data['geo_long']=$gen_lat['lng'];
			}	
			
			
			
			$data['specialty1']=$specialty1;
			$data['specialty2']=$specialty2;
			$data['specialty3']=$specialty3;
			$data['specialty4']=$specialty4;
			$data['specialty5']=$specialty5;
			
			
			$data['short_info']=$short_info;		
			$data['description']=$description;
			$data['price_per_session']=$price_per_session;
			$data['county']=$county;
			$data['area']=$area;
			//$data['qualification']=$qualification;
			
			$data['facebook_fan_page_link']=$facebook_fan_page_link;
			$data['twitter_tweets_page_link']=$twitter_tweets_page_link;
			$data['status']=$status;
			
			$data['modified']='now()';
			
			
			$db->query_update("personal_trainers",$data,"id='".$_REQUEST['id'] ."'");
	
	
			//************  specialities ************************************************//
				/*$db->query("delete from `personal_trainer_specialities`  where trainer_id='" .$_REQUEST['id']. "'");
								
				$client_services=$_REQUEST['gym_services'];
				
				$total_client_services=count($client_services);
					
				if($total_client_services > 0){
					$client_services_data = "INSERT INTO `personal_trainer_specialities` (`trainer_id`, `specialy_id`) VALUES ";
							
					for($p=0; $p<$total_client_services; $p++){
						$client_services_data .="('" . $_REQUEST['id'] ."', '" . $client_services[$p] ."'), ";
					}
							
					$client_services_data = substr($client_services_data,0,-2);
					$client_services_data .=";";
							
					$db->query($client_services_data);
				}
				*/
	
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
				$db->query_update("personal_trainers",$uploaded_name,'id='.$_REQUEST['id']);
				
				
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
											
					$uploaded_name['trainer_id']=$_REQUEST['id'];
					$uploaded_name['photo_name']=$path;				
						
					$db->query_insert("trainer_photos",$uploaded_name);	
					
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
				$_SESSION['msg']="Personal trainer successfully updated!";
			
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
	
	if(!validate_text(document.ff.name,1,"Enter Trainer Name"))
		return false;	
	
	if(!validate_email(document.ff.email_address,1,"Enter Email Address"))
		return false;	
	
	if(!validate_text(document.ff.password,1,"Enter Password"))
		return false;		

	if(!validate_text(document.ff.experience,1,"Enter About Trainer"))
		return false;	
		
	
	/*if(!validate_text(document.ff.price_per_session,1,"Enter Trainer Price Per Session"))
		return false;
	
	
	if(!validate_price(document.ff.price_per_session,1,"Enter a Valid Price Per Session"))
		return false;
	*/
	
	/*if(!validate_text(document.ff.qualification,1,"Enter Trainer Qualification"))
		return false;*/
	
	if(!validate_text(document.ff.street_address,1,"Enter Trainer Street Address"))
		return false;
	
	if(!validate_text(document.ff.town,1,"Enter Trainer Town"))
			return false;
	
	
	
	if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
		return false;
	}
	
	
	/*
	var check=false;
	var frm=document.ff;
	if(parseInt(frm.gym_services.length)){
		for(var i=0;i<frm.gym_services.length;i++){
			if(frm.gym_services[i].checked == true){
				check=true;
				break;
			}	
		}
			
		if(check == false){
			alert("Please select at least a specialty");
			return false;
		}	
			
	}else{
		if(frm.gym_services.checked == false){
			alert("Please select at least a specialty");
			return false;
		}	
	}		
	*/
		
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
            Trainer</td>
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
                  <td width="20%" class="body_content-form">Trainer Name:<font class="form_required-field"> *</font></td>
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
                      
            <tr>
             	<td class="body_content-form">About Trainer:<font class="form_required-field"> *</font></td>
                <td><textarea name="experience"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$experience?></textarea> </td>			
            </tr>
            
                    
                 <tr>
             	<td class="body_content-form">Additional Info:</td>
                <td><textarea name="short_info"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$short_info?></textarea> </td>			
            </tr>
                
                  
                  <tr>
             	<td class="body_content-form">Special Offers:</td>
                <td><textarea name="special_offers"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$special_offers?></textarea> </td>			
            </tr>
                
                
                <tr>
                  <td class="body_content-form">Qualification 1:</td>
                  <td ><input name="qualification1" value="<?=$qualification1?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Qualification 2:</td>
                  <td ><input name="qualification2" value="<?=$qualification2?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Qualification 3:</td>
                  <td ><input name="qualification3" value="<?=$qualification3?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Qualification 4:</td>
                  <td ><input name="qualification4" value="<?=$qualification4?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Qualification 5:</td>
                  <td ><input name="qualification5" value="<?=$qualification5?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                
                 <tr>
                  <td class="body_content-form">Qualification 6:</td>
                  <td ><input name="qualification6" value="<?=$qualification6?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 <tr>
                  <td class="body_content-form">Qualification 7:</td>
                  <td ><input name="qualification7" value="<?=$qualification7?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 <tr>
                  <td class="body_content-form">Qualification 8:</td>
                  <td ><input name="qualification8" value="<?=$qualification8?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 <tr>
                  <td class="body_content-form">Qualification 9:</td>
                  <td ><input name="qualification9" value="<?=$qualification9?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 <tr>
                  <td class="body_content-form">Qualification 10:</td>
                  <td ><input name="qualification10" value="<?=$qualification10?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                 <tr>
                  <td class="body_content-form" colspan="2"><strong>List up to 5 specialist areas (eg. Strenth and Conditioning, Weight Loss...)</strong></td>
                 
                </tr>
                
                  <tr>
                  <td class="body_content-form">Specialty 1:</td>
                  <td ><input name="specialty1" value="<?=$specialty1?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>               
                
                <tr>
                  <td class="body_content-form">Specialty 2:</td>
                  <td ><input name="specialty2" value="<?=$specialty2?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Specialty 3:</td>
                  <td ><input name="specialty3" value="<?=$specialty3?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Specialty 4:</td>
                  <td ><input name="specialty4" value="<?=$specialty4?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                <tr>
                  <td class="body_content-form">Specialty 5:</td>
                  <td ><input name="specialty5" value="<?=$specialty5?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>                
                 
                 <tr>
             	<td class="body_content-form" style="line-height: 20px;">You Tube Share this Video Link: <!-- <img src="../images/youtube.jpg">--></td>
                <td><textarea name="youtube_videos"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="4"><?=$youtube_videos?></textarea> <br/>
                	(You can add multiple videos Link separated by a comma.)                	
                </td>			
            </tr>       
                 
                <tr>
                  <td class="body_content-form">Price (&euro;):</td>
                  <td ><input name="price_per_session" value="<?=$price_per_session?>" type="text" autocomplete="off" class="form_inputbox" size="55" /> Per Session</td>
                </tr>
                
               
                
              
               
                
                 <tr>
                  <td class="body_content-form">Phone:</td>
                  <td ><input name="phone" value="<?=$phone?>" type="text" autocomplete="off" class="form_inputbox" size="55" /></td>
                </tr>
                
                 <tr>
                  <td class="body_content-form">Street Address:<font class="form_required-field"> *</font></td>
                  <td ><input name="street_address" value="<?=$street_address?>" type="text" autocomplete="off" class="form_inputbox" size="55" /> </td>
                </tr>
              
              <tr>
                  <td class="body_content-form">Town:<font class="form_required-field"> *</font></td>
                  <td ><input name="town" value="<?=$town?>" type="text" autocomplete="off" class="form_inputbox" size="55" /> </td>
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
                  <td class="body_content-form" valign="top">Website URL:</td>
                  <td style="line-height: 22px;" ><input name="website_URL" value="<?=$website_URL?>" type="text" autocomplete="off" class="form_inputbox" size="55" /><br/>
                  	If exists, enter full URL (Ex: http://abc.com)
                  	
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
                
               
                <!--
               <tr>
                  <td class="body_content-form" valign="top">Specialities: </td>
                  <td  valign="top">
                  	 <?php
				$services_sql="SELECT id,name FROM `specialty`  ORDER BY display_order + 0 ASC";
				$result_services=$db->fetch_all_array($services_sql);
				$total_services=count($result_services);
				for($services=0; $services < $total_services; $services +=4 ){ ?>
				<div class="check_row" style="line-height: 22px;">		
					<div class="check_block"><input type="checkbox" name="gym_services[]"  id="gym_services"  <?=in_array($result_services[$services]['id'],$gym_services_array)?'checked="checked"':'';?> value="<?=$result_services[$services]['id']?>" /><div><?=$result_services[$services]['name']?></div></div>	
					
					<?php if(trim($result_services[$services+1]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="gym_services[]" id="gym_services" <?=in_array($result_services[$services+1]['id'],$gym_services_array)?'checked="checked"':'';?> value="<?=$result_services[$services+1]['id']?>" /><div><?=$result_services[$services+1]['name']?></div></div>
					<?php  } ?>
					
					<?php if(trim($result_services[$services+2]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="gym_services[]" id="gym_services" <?=in_array($result_services[$services+2]['id'],$gym_services_array)?'checked="checked"':'';?> value="<?=$result_services[$services+2]['id']?>" /><div><?=$result_services[$services+2]['name']?></div></div>
					<?php  } ?>
					
					<?php if(trim($result_services[$services+3]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="gym_services[]" id="gym_services" <?=in_array($result_services[$services+3]['id'],$gym_services_array)?'checked="checked"':'';?> value="<?=$result_services[$services+3]['id']?>" /><div><?=$result_services[$services+3]['name']?></div></div>
					<?php  } ?>
					
				</div>
				<div class="check_row_gap"></div>										
				<?php }	?>	
                  	
                  </td>
                </tr>             
                
                
               -->
                 
                
                 
                <tr>
                  <td  class="body_content-form" valign="top"><?=trim($logo_name) != NULL?'Update':'Upload';?>
                     Main Profile Picture:</td>
                  <td  valign="top">
                  <?php if(trim($logo_name) != NULL){?>
                    		<a href="<?=$general_func->site_url.substr($original,6).$logo_name?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($small,6).$logo_name?>" border="0" /></a>&nbsp;&nbsp;
                    		<a href="trainers/trainers-new.php?id=<?=$_REQUEST['id']?>&now=DELETE&field=logo_name&path=<?=$logo_name?>" class="htext" ><strong>Delete</strong></a>
                  			
                    <?php }	?>							
                	
                  <input type="file" name="logo_name" /></td>
                </tr>
               
                <tr>
                  <td  class="body_content-form" valign="top">Upload Images:</td>
                  <td  valign="top">
                  <div class="div_clear"></div>
						<?php                  
						for($upload=1; $upload <=20; $upload++){?>
						
						<?php if($array_accolades[$upload-1]){?>
							<a href="<?=$general_func->site_url.substr($gym_original,6).$array_accolades[$upload-1]['photo_name']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($gym_small,6).$array_accolades[$upload-1]['photo_name']?>" border="0" /></a>&nbsp;&nbsp;
							<a href="trainers/trainers-new.php?id=<?=$_REQUEST['id']?>&now=delete_bulk&bulk_id=<?=$array_accolades[$upload-1]['id']?>&file_name=<?=$array_accolades[$upload-1]['photo_name']?>" class="htext">Delete</a>
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
