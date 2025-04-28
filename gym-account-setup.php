<?php 
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes" || $_SESSION['user_type']!="gym"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}



$small="gym_logo/small/";
$original="gym_logo/";


$gym_small="gym_photo/small/";
$gym_medium="gym_photo/medium/";
$gym_original="gym_photo/";

if(isset($_GET['now']) && $_GET['now']=="DELETE"){
	$path=$_REQUEST['path'];
	$field=$_REQUEST['field'];
		
	@mysql_query("update gyms set $field=' ' where id=" . (int) $_SESSION['gym_id'] . "");	
	
	@unlink($original.$path);
	@unlink($small.$path);	
	
	$_SESSION['user_message'] = "Your gym logo deleted!";	   
	$general_func->header_redirect($general_func->site_url."gym-account-setup/");	
}

if(isset($_GET['now']) && $_GET['now']=="delete_bulk"){//***************  delete bulk files
	$bulk_id=$_REQUEST['bulk_id'];
	$file_name=$_REQUEST['file_name'];
		
	@mysql_query("delete from  gym_photos  where id=" . (int) $bulk_id . "");
	
	@unlink($gym_small.$file_name);	
	@unlink($gym_medium.$file_name);	
	@unlink($gym_original.$file_name);	
	
	$_SESSION['user_message'] = "The photo that you have chosed deleted!";	
	
	$general_func->header_redirect($general_func->site_url."gym-account-setup/");		
	
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$name=trim($_REQUEST['name']);
	$website_URL=trim($_REQUEST['website_URL']);		
	$phone=trim($_REQUEST['phone']);		
	$short_info=trim($_REQUEST['short_info']);		
	$description=trim($_REQUEST['description']);
	$town=trim($_REQUEST['town']);
	$county=trim($_REQUEST['county']);
	$area=trim($_REQUEST['area']);
	$opening_time=trim($_REQUEST['opening_time']);	
	$closing_time=trim($_REQUEST['closing_time']);	
		
	$street_address=trim($_REQUEST['street_address']);
	$facebook_fan_page_link=trim($_REQUEST['facebook_fan_page_link']);
	$twitter_tweets_page_link=trim($_REQUEST['twitter_tweets_page_link']);	
	
	$working_day=array();
	$working_day=$_REQUEST['working_day'];
	
	
	$data=array();
	
	$data['name']=$name;
	$data['seo_link']=$general_func->create_seo_link($name);			
	
	//*** check whether this name alreay exit ******//
	if($db->already_exist_update("gym","id",$_SESSION['gym_id'],"seo_link",$data['seo_link'])){//******* exit
		$data['seo_link']=$_SESSION['gym_id'] ."-".$data['seo_link'];
	}
	//*********************************************//
	
	$_SESSION['user_seo_link']=$data['seo_link'];
		
	if(trim($_REQUEST['old_street_address']) != trim($street_address) || trim($_REQUEST['old_town']) != trim($town) || trim($_REQUEST['old_county']) != trim($county) || trim($_REQUEST['old_area']) != trim($area)){
		$gen_lat=array();	
		$for_map=  $area .",". trim($street_address).", " .trim($town) .", Dublin, Ireland";	
		$gen_lat=$general_func->getLnt($for_map);				
		$data['geo_lat']=$gen_lat['lat'];	
		$data['geo_long']=$gen_lat['lng'];
	}	
			
	$data['short_info']=$short_info;		
	$data['description']=$description;
	$data['town']=$town;
	
	$data['website_URL']=$website_URL;
	$data['phone']=$phone;
	$data['youtube_videos']=trim($_REQUEST['youtube_videos']);	
	
	$data['county']=$county;
	$data['area']=$area;
	$data['opening_time']=$opening_time;
	$data['closing_time']=$closing_time;	
	$data['street_address']=$street_address;
	$data['facebook_fan_page_link']=$facebook_fan_page_link;
	$data['twitter_tweets_page_link']=$twitter_tweets_page_link;
	
	$data['modified']='now()';
			
	$db->query_update("gyms",$data,"id='".$_SESSION['gym_id'] ."'");
	
	
	$db->query("delete from gym_working_days where gym_id='" . $_SESSION['gym_id'] . "'");			
	
	if(count($working_day)> 0){
		$working_id_data = "INSERT INTO `gym_working_days` (`gym_id`, `working_day`,`opening_time`,`closing_time`) VALUES ";
				
		for($p=0; $p<count($working_day); $p++){
			$working_id_data .="('" . $_SESSION['gym_id'] ."', '" . $working_day[$p] ."','" . $_REQUEST['opening_time_'.$working_day[$p]]. "','" . $_REQUEST['closing_time_'.$working_day[$p]]. "'), ";
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
							
		$path=$_SESSION['gym_id'] ."_".$general_func->remove_space_by_hypen($userfile_name);
		$img=$original.$path;
		move_uploaded_file($userfile_tmp, $img) or die();
								
		$uploaded_name['logo_name']=$path;
		$db->query_update("gyms",$uploaded_name,'id='.$_SESSION['gym_id']);
				
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
											
			$uploaded_name['gym_id']=$_SESSION['gym_id'];
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
		$_SESSION['user_message']="Your account successfully updated!";
	
	$general_func->header_redirect($general_func->site_url."gym-account-setup/");
		
	
}	



$sql="select * from gyms where id=" . (int)  $_SESSION['gym_id']  . " limit 1";
$result=$db->fetch_all_array($sql);	
		
$name=$result[0]['name'];
$short_info=$result[0]['short_info'];			
$description=$result[0]['description']; 
$town=$result[0]['town'];

$website_URL=$result[0]['website_URL'];
$phone=$result[0]['phone'];
$youtube_videos=$result[0]['youtube_videos'];	

$county=$result[0]['county'];
$area=$result[0]['area'];
$opening_time=$result[0]['opening_time'];	
$closing_time=$result[0]['closing_time'];	
		
$street_address=$result[0]['street_address']; 
$facebook_fan_page_link=$result[0]['facebook_fan_page_link'];
$twitter_tweets_page_link=$result[0]['twitter_tweets_page_link'];
$logo_name=$result[0]['logo_name'];	
//$status=$result[0]['status'];
		
	
//************ working_days **********************//

$sql_working_day="select working_day,opening_time,closing_time from gym_working_days where gym_id='" . $_SESSION['gym_id'] . "'";
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
		
$img_diff_view_rs=@mysql_query("select id,photo_name from  gym_photos where gym_id='".(int)  $_SESSION['gym_id']  ."'");
while($img_diff_view_rw=mysql_fetch_object($img_diff_view_rs)){
	$array_accolades[$accolades_index]['id']=$img_diff_view_rw->id;
	$array_accolades[$accolades_index++]['photo_name']=$img_diff_view_rw->photo_name;				
}
		
$val_accolades=count($array_accolades)+1;
$val_accolades=$val_accolades==1?2:$val_accolades;



?>	
<script type="text/javascript" src="<?=$general_func->site_url?>highslide/highslide.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$general_func->site_url?>highslide/highslide.css" />
<script type="text/javascript">
	hs.graphicsDir = '<?=$general_func->site_url?>highslide/graphics/';
	hs.wrapperClassName = 'wide-border';
	

function validate(){
	
	if(!validate_text(document.ff.name,1,"Enter Gym Name"))
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
			
				
	/*if(parseInt(document.ff.opening_time.value) >= parseInt(document.ff.closing_time.value)){
		alert("Closing time must be greater than opening time");
		document.ff.closing_time.focus();
		return false;			
	}	*/	
		
			
	
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
	
		
		
	/*if(document.ff.status.selectedIndex == 0){
		alert("Please select a status");
		document.ff.status.focus();
		return false;
	}*/	
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
			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Account setup</h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			<form method="post" action="gym-account-setup/"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        	<input type="hidden" name="enter" value="yes" />        	
        	<input type="hidden" name="logo_name" value="<?=$logo_name?>" />
       		<input type="hidden" name="old_town" value="<?=$town?>" />
       		<input type="hidden" name="old_county" value="<?=$county?>" />
       		<input type="hidden" name="old_area" value="<?=$area?>" />   
       		 <input type="hidden" name="old_street_address" value="<?=$street_address?>" />     
	        <ul class="contact-form column_form_container">
            <div class="column_form_row">
	          <li>
	            <label>Gym Name<span>*</span></label>
	            <input type="text" name="name" value="<?=$name?>" />
	          </li>
              
              <!--<li>
	            <label>Short Info</label>
	            <textarea name="short_info"><?=$short_info?></textarea>
	          </li>-->
              
            </div> 
            
            
             <div class="column_form_row">
	          <li>
	            <label>Website</label>
	            <input type="text" name="website_URL" value="<?=$website_URL?>"  />
	          </li>
	       
	          <li>
	            <label>Phone</label>
	            <input type="text" name="phone" value="<?=$phone?>" />
	          </li>
            </div> 
            
            <div class="column_form_row">
	          <li>
	            <label>Street Address<span>*</span></label>
	            <input type="text" name="street_address" value="<?=$street_address?>" />
	          </li>
	       
	          <li>
	            <label>Town<span>*</span></label>
	            <input type="text" name="town" value="<?=$town?>" />
	          </li>
            </div> 
            
            <div class="column_form_row">
	          <li>
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
                        <option value="Dublin 6W" <?=trim($area)=="Dublin 6W"?'selected="selected"':'';?>>Dublin 6W</option>
                        <option value="Co. Dublin (North)" <?=trim($area)=="Co. Dublin (North)"?'selected="selected"':'';?>>Co. Dublin (North)</option>
                        <option value="Co. Dublin (South)" <?=trim($area)=="Co. Dublin (South)"?'selected="selected"':'';?>>Co. Dublin (South)</option>
                </select>
                </div>
	          </li>
	          
	          <li>
	            <label>County<span>*</span></label>
	            <div class="select_box">
                <select name="county">
                <option value="Dublin">Dublin</option>
                </select>
                </div>
	          </li>
	       
	          
            </div> 
            
            
            <!--<div class="column_form_row">
	          <li>
	            <label>Opening Time</label>
	            <div class="select_box">
                <select name="opening_time">
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$opening_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
                </div>
	          </li>
	       
	          <li>
	            <label>Closing Time</label>
	            <div class="select_box">
                <select name="closing_time">
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$closing_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
                </div>
	          </li>
            </div>-->
            
            <div class="column_form_row">
	          <li>
	            <label>Facebook Fan Page Link</label>
	            <input type="text" name="facebook_fan_page_link" value="<?=$facebook_fan_page_link?>" />
	          </li>
	       
	          <li>
	            <label>Twitter Tweets Page Link</label>
	            <textarea autocomplete="OFF" name="twitter_tweets_page_link"><?=$twitter_tweets_page_link?></textarea>
                <p>Need help? <a href="twitter-help.php" target="_blank">Click here</a></p>
	          </li>
            </div> 
            
            
            <div class="column_form_row for_open_close_time">
	          <li style="width:100% !important;">
	            <label>Working Days</label>
	            
	            
	             <?php
					foreach($all_days_in_a_week as $day_index=>$day_value){?>
					  <div class="check_row">
					  	<input type="checkbox" name="working_day[]" id="working_day" <?=in_array($day_index,$working_days)?'checked="checked"':'';?>  value="<?=$day_index?>" >
					<span><?=$day_value?></span>
					
					<select name="opening_time_<?=$day_index?>" id="opening_time_<?=$day_index?>">
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
					<select name="closing_time_<?=$day_index?>" id="closing_time_<?=$day_index?>">
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
                
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>Description</label>
	            <textarea name="description" style="height:150px !important;"><?=$description?></textarea>
	          </li>
            </div> 
            
              <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>You Tube Share this Video Link <!--<img src="images/youtube.jpg" style="margin:0 0 0 5px; position:relative; top:4px;" />--></label>
	            <textarea name="youtube_videos" style="height:150px !important;"><?=$youtube_videos?></textarea>
                <p>(You can add multiple videos Link separated by a comma.)   Need help? <a href="youtube_video_help.php" target="_blank">Click here</a> </p>
             
	          </li>
            </div> 
             <div class="column_form_row">
	          <li>
	            <label><?=trim($logo_name) != NULL?'Update':'Upload';?> Main Profile Picture:</label>
                <div class="customfile-container">
                	<?php if(trim($logo_name) != NULL){?>
                    <div class="highslide_row" style="margin-bottom:10px;">
                    		<a href="<?=$general_func->site_url.$original.$logo_name?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.$small.$logo_name?>" border="0" /></a>&nbsp;&nbsp;
                    		<a href="gym-account-setup.php?now=DELETE&field=logo_name&path=<?=$logo_name?>" class="htext" ><strong><img src="images/del_product_icon.png" /></strong></a></div>
                  			
                    <?php }	?>		
                	
	            <input type="file" name="logo_name"  />
                </div>
	          </li>
            </div> 
              <div class="column_form_row">
	 
	        <li>
	            <label>Upload Image</label>                
                 <?php                  
					for($upload=1; $upload <=20; $upload++){?>
						 <div class="customfile-container" style="margin:0px; padding:0px;">
						<?php if($array_accolades[$upload-1]){?>
                        
                        <div class="highslide_row">
							<a href="<?=$general_func->site_url.$gym_original.$array_accolades[$upload-1]['photo_name']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.$gym_small.$array_accolades[$upload-1]['photo_name']?>" border="0" /></a>
							<a href=gym-account-setup.php?now=delete_bulk&bulk_id=<?=$array_accolades[$upload-1]['id']?>&file_name=<?=$array_accolades[$upload-1]['photo_name']?>" class="htext"><img src="images/del_product_icon.png" /></a></div>
                            
						
						<?php } ?>
						<div  id="accolades<?=$upload?>" style="width:100%; margin-top:10px; display:<?php if($upload==1 || $array_accolades[$upload-1]){ echo "block;";}else{ echo "none;";}?> ">
							<input name="upload_file[]" value="" type="file"   />
						</div>
						</div>
						<?php	}  ?>
                
                  <?php if($val_accolades < 21){?>
                <div class="inner_button" id="lblmoreaccolades"><a style="padding:5px 10px; border-radius:5px; font-size:15px; margin-top:10px;" onclick="add_more_accolades_and_special_recognitions(document.ff.accolades.value);">Add More</a></div>
	           <?php   } ?>
	          <input type="hidden" name="accolades" value="<?php echo $val_accolades; ?>" />
	          
	          </li>
            </div> 
            
             
              <div class="column_form_row">
	          <li style="background:none;">
	            <input type="submit" value="Update" />
	          </li>
              </div>
              
	        </ul>
	      </form>							      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>