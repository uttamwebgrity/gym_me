<?php 
include_once("includes/header.php");
if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes" || $_SESSION['user_type']!="trainer"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}

$small="trainer_logo/small/";
$original="trainer_logo/";


$gym_small="trainer_photo/small/";
$gym_medium="trainer_photo/medium/";
$gym_original="trainer_photo/";

$data=array();




if(isset($_GET['now']) && $_GET['now']=="DELETE"){
	$path=$_REQUEST['path'];
	$field=$_REQUEST['field'];
		
	@mysql_query("update personal_trainers set $field=' ' where id=" . (int) $_SESSION['trainer_id'] . "");	
	
	@unlink($original.$path);
	@unlink($small.$path);		
	
	
		$_SESSION['user_message'] = "Your gym logo deleted!";	   
	$general_func->header_redirect($general_func->site_url."trainer-account-setup/");	
}

if(isset($_GET['now']) && $_GET['now']=="delete_bulk"){//***************  delete bulk files
	$bulk_id=$_REQUEST['bulk_id'];
	$file_name=$_REQUEST['file_name'];
		
	@mysql_query("delete from  trainer_photos  where id=" . (int) $bulk_id . "");
	
	@unlink($gym_small.$file_name);	
	@unlink($gym_medium.$file_name);	
	@unlink($gym_original.$file_name);	
	
	$_SESSION['user_message'] = "The photo that you have chosed deleted!";		
	$general_func->header_redirect($general_func->site_url."trainer-account-setup/");
}

	
	


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$name=trim($_REQUEST['name']);
	$street_address=trim($_REQUEST['street_address']);
	$town=trim($_REQUEST['town']);	
	$short_info=trim($_REQUEST['short_info']);		
	$description=trim($_REQUEST['description']);
	$price_per_session=trim($_REQUEST['price_per_session']);
	$county=trim($_REQUEST['county']);
	$area=trim($_REQUEST['area']);
	$youtube_videos=trim($_REQUEST['youtube_videos']);
	$website_URL=trim($_REQUEST['website_URL']);		
	
	//$qualification=trim($_REQUEST['qualification']);	
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
	
	
	
	
	$facebook_fan_page_link=trim($_REQUEST['facebook_fan_page_link']);
	$twitter_tweets_page_link=trim($_REQUEST['twitter_tweets_page_link']);	
	
	
	
	
	$data['name']=$name;
						
	$data['seo_link']=$general_func->create_seo_link($name);			
	//*** check whether this name alreay exit ******//
	if($db->already_exist_update("personal_trainers","id",$_SESSION['trainer_id'],"seo_link",$data['seo_link'])){//******* exit
		$data['seo_link']=$_SESSION['trainer_id'] ."-".$data['seo_link'];
	}
	//*********************************************//
	
	$_SESSION['user_seo_link']=$data['seo_link'];
	
	$data['street_address']=$street_address;
	$data['website_URL']=$website_URL;
	$data['town']=$town;			
	$data['short_info']=$short_info;		
	$data['description']=$description;
	$data['price_per_session']=$price_per_session;
	$data['county']=$county;
	$data['area']=$area;
	$data['youtube_videos']=$youtube_videos;
	
	
	if(trim($_REQUEST['old_street_address']) != trim($street_address) || trim($_REQUEST['old_town']) != trim($town) || trim($_REQUEST['old_county']) != trim($county) || trim($_REQUEST['old_area']) != trim($area)){
		$gen_lat=array();	
		$for_map=  $area .",". trim($street_address).", " .trim($town) .", Dublin, Ireland";	
		$gen_lat=$general_func->getLnt($for_map);				
		$data['geo_lat']=$gen_lat['lat'];	
		$data['geo_long']=$gen_lat['lng'];
	}		
	
	//$data['qualification']=$qualification;
	
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
			
			
	$data['specialty1']=$specialty1;
	$data['specialty2']=$specialty2;
	$data['specialty3']=$specialty3;
	$data['specialty4']=$specialty4;
	$data['specialty5']=$specialty5;
			
	$data['facebook_fan_page_link']=$facebook_fan_page_link;
	$data['twitter_tweets_page_link']=$twitter_tweets_page_link;
		
	$data['modified']='now()';
			
	$db->query_update("personal_trainers",$data,"id='".$_SESSION['trainer_id'] ."'");
	
	
	
	//****************************  upload logo ********************************//			
	if($_FILES['logo_name']['size'] >0){
		@unlink($original.$_REQUEST['logo_name']);
		@unlink($small.$_REQUEST['logo_name']);
						
		$uploaded_name=array();
					
		$userfile_name=$_FILES['logo_name']['name'];
		$userfile_tmp= $_FILES['logo_name']['tmp_name'];
		$userfile_size=$_FILES['logo_name']['size'];
		$userfile_type= $_FILES['logo_name']['type'];
								
		$path=$_SESSION['trainer_id'] ."_".$general_func->remove_space_by_hypen($userfile_name);
		$img=$original.$path;
		move_uploaded_file($userfile_tmp, $img) or die();
								
		$uploaded_name['logo_name']=$path;
		$db->query_update("personal_trainers",$uploaded_name,'id='.$_SESSION['trainer_id']);
				
				
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
											
				$uploaded_name['trainer_id']=$_SESSION['trainer_id'];
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
			$_SESSION['user_message']="Your profile successfully updated!";
			
	$general_func->header_redirect($general_func->site_url."trainer-account-setup/");
		
}



$sql="select * from personal_trainers where id=" . (int)  $_SESSION['trainer_id']  . " limit 1";
$result=$db->fetch_all_array($sql);	
		
$name=$result[0]['name'];
$street_address=$result[0]['street_address'];
$town=$result[0]['town'];
	
$short_info=$result[0]['short_info'];			
$description=$result[0]['description']; 
$price_per_session=$result[0]['price_per_session'];
$county=$result[0]['county'];
$area=$result[0]['area'];
$youtube_videos=$result[0]['youtube_videos'];
$website_URL=$result[0]['website_URL'];

//$qualification=$result[0]['qualification'];	

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
	
$facebook_fan_page_link=$result[0]['facebook_fan_page_link'];
$twitter_tweets_page_link=$result[0]['twitter_tweets_page_link'];
$logo_name=$result[0]['logo_name'];	
	
		
/*	
$sql_service="select specialy_id from personal_trainer_specialities where trainer_id='" .  $_SESSION['trainer_id']  . "'";
$result_service=$db->fetch_all_array($sql_service);	
$gym_services_array=array();	
	
for($i=0; $i<count($result_service); $i++){
	$gym_services_array[]=$result_service[$i]['specialy_id'];	
}	
	*/
		
$array_accolades=array();	
$accolades_index=0;
		
$img_diff_view_rs=@mysql_query("select id,photo_name from  trainer_photos where trainer_id='".(int)  $_SESSION['trainer_id']  ."'");
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
	
	if(!validate_text(document.ff.name,1,"Enter Your Name"))
		return false;	


	if(!validate_text(document.ff.town,1,"Enter Town"))
			return false;
	
	if(!validate_text(document.ff.street_address,1,"Enter Street Address"))
		return false;
	
	if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
		return false;
	}

	/*if(!validate_text(document.ff.short_info,1,"Enter Your Additional Info"))
		return false;	
			
	if(!validate_text(document.ff.price_per_session,1,"Enter Your Price Per Session"))
		return false;
		
	if(!validate_price(document.ff.price_per_session,1,"Enter a Valid Price Per Session"))
		return false;*/
		
	/*if(!validate_text(document.ff.qualification,1,"Enter Trainer Qualification"))
		return false;*/
	
	/*var check=false;
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
	
		
	if(document.ff.status.selectedIndex == 0){
		alert("Please select a status");
		document.ff.status.focus();
		return false;
	}	*/
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
			 <form method="post" action="trainer-account-setup/"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
	        <input type="hidden" name="enter" value="yes" />	        
       <input type="hidden" name="logo_name" value="<?=$logo_name?>" />	
       <input type="hidden" name="old_town" value="<?=$town?>" />
       		<input type="hidden" name="old_county" value="<?=$county?>" />
       		<input type="hidden" name="old_area" value="<?=$area?>" />   
       		 <input type="hidden" name="old_street_address" value="<?=$street_address?>" />  
	        <ul class="contact-form column_form_container">
            <div class="column_form_row">
	          <li>
	            <label>Trainer Name<span> *</span></label>
	            <input type="text" name="name" value="<?=$name?>" />
	          </li>	         
	          <li>
	            <label>Website</label>
	            <input type="text" name="website_URL" value="<?=$website_URL?>"  />
	          </li>
            </div> 
            
              <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>About You</label>
	            <textarea name="experience" style="height:150px !important;"><?=$experience?></textarea>
	          </li>
            </div>
             <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>Additional Info</label>
	            <textarea name="short_info" style="height:150px !important;"><?=$short_info?></textarea>
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>Special Offers</label>
	            <textarea name="special_offers" style="height:150px !important;"><?=$special_offers?></textarea>
	          </li>
            </div>
            
            
            <div class="column_form_row">
	          <li>
	            <label>Qualification 1</label>
	            <input type="text" name="qualification1" value="<?=$qualification1?>" />
	          </li>
              <li>
	            <label>Qualification 2</label>
	            <input type="text" name="qualification2" value="<?=$qualification2?>" />
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li>
	            <label>Qualification 3</label>
	            <input type="text" name="qualification3" value="<?=$qualification3?>" />
	          </li>
              <li>
	            <label>Qualification 4</label>
	            <input type="text" name="qualification4" value="<?=$qualification4?>" />
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li>
	            <label>Qualification 5</label>
	            <input type="text" name="qualification5" value="<?=$qualification5?>" />
	          </li>
              
              <li>
	            <label>Qualification 6</label>
	            <input type="text" name="qualification6" value="<?=$qualification6?>" />
	          </li>
        
            </div>
            
            <div class="column_form_row">
	          <li>
	            <label>Qualification 7</label>
	            <input type="text" name="qualification7" value="<?=$qualification7?>" />
	          </li>
              
              <li>
	            <label>Qualification 8</label>
	            <input type="text" name="qualification8" value="<?=$qualification8?>" />
	          </li>
        
            </div>
            
            <div class="column_form_row">
	          <li>
	            <label>Qualification 9</label>
	            <input type="text" name="qualification9" value="<?=$qualification9?>" />
	          </li>
              
              <li>
	            <label>Qualification 10</label>
	            <input type="text" name="qualification10" value="<?=$qualification10?>" />
	          </li>
        
            </div>
            
            
            <p>List up to 5 specialist areas (eg. Strength and Conditioning, Weight Loss...)</p>
            <div class="column_form_row">
	          <li>
	            <label>Specialty 1</label>
	            <input type="text" name="specialty1" value="<?=$specialty1?>" />
	          </li>
              <li>
	            <label>Specialty 2</label>
	            <input type="text" name="specialty2" value="<?=$specialty2?>" />
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li>
	            <label>Specialty 3</label>
	            <input type="text" name="specialty3" value="<?=$specialty3?>" />
	          </li>
              <li>
	            <label>Specialty 4</label>
	            <input type="text" name="specialty4" value="<?=$specialty4?>" />
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li>
	            <label>Specialty 5</label>
	            <input type="text" name="specialty5" value="<?=$specialty5?>" />
	          </li>
	          <li>
	            <label>Price (&euro;)</label>
	            <input type="text" name="price_per_session" value="<?=$price_per_session?>" />
	          </li>   
        
            </div>
            
            
             
            
            <div class="column_form_row">
	          <li>
	            <label>Street Address<span> *</span></label>
	            <input type="text" name="street_address" value="<?=$street_address?>" />
	          </li>
	       
	          <li>
	            <label>Town<span> *</span></label>
	            <input type="text" name="town" value="<?=$town?>" />
	          </li>
            </div> 
            
            <div class="column_form_row">
	          <li>
	            <label>Area<span> *</span></label>
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
	            <label>County<span> *</span></label>
	            <div class="select_box">
                <select name="county">
               	<option value="Dublin">Dublin</option>
                </select>
                </div>
	          </li>
	       
	          
            </div> 
            
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
            
            <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>You Tube Share this Video Link <!--<img src="images/youtube.jpg" style="margin:0 0 0 5px; position:relative; top:4px;" />--></label>
	            <textarea name="youtube_videos" style="height:150px !important;"><?=$youtube_videos?></textarea>
                <p>(You can add multiple videos Link separated by a comma.)  Need help? <a href="youtube_video_help.php" target="_blank">Click here</a> </p>
	          </li>
            </div> 
             <div class="column_form_row">
	          <li>
	            <label><?=trim($logo_name) != NULL?'Update':'Upload';?> Main Profile Picture</label>
                <div class="customfile-container">
	            <?php if(trim($logo_name) != NULL){?>
	            	 <div class="highslide_row" style="margin-bottom:10px;">
                	<a href="<?=$general_func->site_url.$original.$logo_name?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.$small.$logo_name?>" border="0" /></a>&nbsp;&nbsp;
                    <a href="trainer-account-setup.php?now=DELETE&field=logo_name&path=<?=$logo_name?>" class="htext" ><img src="images/del_product_icon.png" /></a>
                	</div>
                 <?php }	?>
                  <input type="file" name="logo_name" />
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
							<a href="<?=$general_func->site_url.$gym_original.$array_accolades[$upload-1]['photo_name']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.$gym_small.$array_accolades[$upload-1]['photo_name']?>" border="0" /></a>&nbsp;&nbsp;
							<a href="trainer-account-setup.php?&now=delete_bulk&bulk_id=<?=$array_accolades[$upload-1]['id']?>&file_name=<?=$array_accolades[$upload-1]['photo_name']?>" class="htext"><img src="images/del_product_icon.png" /></a>
						</div>
						<?php } ?>
						<div id="accolades<?=$upload?>" style="width:100%; margin-top:10px; display:<?php if($upload==1 || $array_accolades[$upload-1]){ echo "block;";}else{ echo "none;";}?>">
							<input name="upload_file[]" value="" type="file"   />
						</div>	
						
						 </div>
						<?php	}
						
						if($val_accolades < 21){?>
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