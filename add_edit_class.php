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
		
	if(trim($_REQUEST['old_town']) != trim($town) || trim($_REQUEST['old_county']) != trim($county) || trim($_REQUEST['old_area']) != trim($area)){
		$gen_lat=array();	
		$for_map=trim($town).", " .$county .", ". $area .", Ireland";	
		$gen_lat=$general_func->getLnt($for_map);				
		$data['geo_lat']=$gen_lat['lat'];	
		$data['geo_long']=$gen_lat['lng'];
	}	
			
	$data['short_info']=$short_info;		
	$data['description']=$description;
	$data['town']=$town;
	
	$data['website_URL']=$website_URL;
	$data['phone']=$phone;
	
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
		$working_id_data = "INSERT INTO `gym_working_days` (`gym_id`, `working_day`) VALUES ";
		
		for($p=0; $p<count($working_day); $p++){
			$working_id_data .="('" . $_SESSION['gym_id'] ."', '" . $working_day[$p] ."'), ";
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
$sql_working_day="select working_day from gym_working_days where gym_id='" . $_SESSION['gym_id'] . "'";
$result_working_day=$db->fetch_all_array($sql_working_day);
$total_working_day=count($result_working_day);
	
$working_days=array();
	
for($day=0; $day<$total_working_day; $day++){
	$working_days[]=$result_working_day[$day]['working_day'];	
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
		
	if(!validate_text(document.ff.short_info,1,"Enter Gym Short Info"))
		return false;	
			
	if(!validate_text(document.ff.town,1,"Enter Gym Town"))
			return false;
	
	if(!validate_text(document.ff.street_address,1,"Enter Gym Street Address"))
		return false;
	
	if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
		return false;
	}
			
				
	if(parseInt(document.ff.opening_time.value) >= parseInt(document.ff.closing_time.value)){
		alert("Closing time must be greater than opening time");
		document.ff.closing_time.focus();
		return false;			
	}		
		
	var working_day=document.ff.working_day;
	
	if(working_day[0].checked== false && working_day[1].checked== false && working_day[2].checked== false && working_day[3].checked== false  && working_day[4].checked== false  && working_day[5].checked== false  && working_day[6].checked== false ){
		alert("Please choose at least a working day");		
		return false;	
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
			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Add edit class</h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			<form method="post" action="gym-account-setup/"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        	<input type="hidden" name="enter" value="yes" />        	
        	<input type="hidden" name="logo_name" value="<?=$logo_name?>" />
       		<input type="hidden" name="old_town" value="<?=$town?>" />
       		<input type="hidden" name="old_county" value="<?=$county?>" />
       		<input type="hidden" name="old_area" value="<?=$area?>" />     
	        <ul class="contact-form column_form_container">
            <div class="column_form_row">
	          <li>
	            <label>Working Day</label>
	            <div class="select_box">
                <select name="county">
                <option value="Dublin">Monday</option>
                <option value="Dublin">Tuesday</option>
                <option value="Dublin">Wednesday</option>
                <option value="Dublin">Thursday</option>
                <option value="Dublin">Friday</option>
                <option value="Dublin">Saturday</option>
                <option value="Dublin">Sunday</option>
                </select>
                </div>
	          </li>
               </div> 
              
              <div class="column_form_row">
	          <li>
	            <label>Start Time</label>
	            <div class="select_box">
                <select name="county">
                <option value="Dublin">06.00</option>
                </select>
                </div>
	          </li>
              </div>
              
              <div class="column_form_row">
              <li>
	            <label>End Time</label>
	            <div class="select_box">
                <select name="county">
                <option value="Dublin">06.00</option>
                </select>
                </div>
	          </li>
               </div> 
           
            
            
             <div class="column_form_row">
	          <li>
	            <label>Status</label>
	            <div class="select_box">
                <select name="county">
                <option value="Dublin">Active</option>
                </select>
                </div>
	          </li>
               </div> 
            
             
            
            
            
            
            
            
               
              <div class="column_form_row">
	          <li style="background:none;">
	            <input type="submit" value="Update" />
	          </li>
              </div>
              
	        </ul>
	      </form>	
          
          <h1>Class List</h1>
          <div class="class_list">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="class_list_head">
    <td>Day</td>
    <td>Start Time</td>
    <td>End Time</td>
    <td>Status</td>
    <td>Action</td>
  </tr>
  <tr>
    <td>Monday</td>
    <td>08 : 00</td>
    <td>16 : 30</td>
    <td>Active</td>
    <td><a><img src="images/class_list_edit.png" style="margin-right:5px;" /></a><a><img src="images/class_list_delete.png" /></a></td>
  </tr>
 <tr>
    <td>Monday</td>
    <td>08 : 00</td>
    <td>16 : 30</td>
    <td>Active</td>
    <td><a><img src="images/class_list_edit.png" style="margin-right:5px;" /></a><a><img src="images/class_list_delete.png" /></a></td>
  </tr>
 <tr>
    <td>Monday</td>
    <td>08 : 00</td>
    <td>16 : 30</td>
    <td>Active</td>
    <td><a><img src="images/class_list_edit.png" style="margin-right:5px;" /></a><a><img src="images/class_list_delete.png" /></a></td>
  </tr>
<tr>
    <td>Monday</td>
    <td>08 : 00</td>
    <td>16 : 30</td>
    <td>Active</td>
    <td><a><img src="images/class_list_edit.png" style="margin-right:5px;" /></a><a><img src="images/class_list_delete.png" /></a></td>
  </tr>
<tr>
    <td>Monday</td>
    <td>08 : 00</td>
    <td>16 : 30</td>
    <td>Active</td>
    <td><a><img src="images/class_list_edit.png" style="margin-right:5px;" /></a><a><img src="images/class_list_delete.png" /></a></td>
<tr>
    <td>Monday</td>
    <td>08 : 00</td>
    <td>16 : 30</td>
    <td>Active</td>
    <td><a><img src="images/class_list_edit.png" style="margin-right:5px;" /></a><a><img src="images/class_list_delete.png" /></a></td>
  </tr>
</table>

          </div>
          						      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>