<?php 
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes" || $_SESSION['user_type']!="gym"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}



$gym_small="class_photo/small/";
$gym_medium="class_photo/medium/";
$gym_original="class_photo/";




if(isset($_GET['now']) && $_GET['now']=="delete_bulk"){//***************  delete bulk files
	$bulk_id=$_REQUEST['bulk_id'];
	$file_name=$_REQUEST['file_name'];
		
	@mysql_query("delete from  classes_photos  where id=" . (int) $bulk_id . "");
	
	@unlink($gym_small.$file_name);	
	@unlink($gym_medium.$file_name);	
	@unlink($gym_original.$file_name);	
	
	
	$_SESSION['user_message'] = "Your class photo deleted!";	   
	$general_func->header_redirect($general_func->site_url."class-new/".$_REQUEST['id']);	
	
	
}





if(isset($_POST['enter']) && $_POST['enter']=="yes"){
		
	$name=trim($_REQUEST['name']);
		
	$description=trim($_REQUEST['description']);	
	$youtube_videos=trim($_REQUEST['youtube_videos']);
	$status=trim($_REQUEST['status']);	
	
	
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("classes","name",$name,"gym_id",$_SESSION['gym_id'])){
			$_SESSION['user_message']="Sorry, your specified class is already taken!";		
		}else{
			$data['name']=$name;
			
			$data['seo_link']=$general_func->create_seo_link($name);
			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_inset("classes","seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$db->max_id("classes","id") + 1 ."-".$data['seo_link'];
			}
			//*********************************************//
					
			$data['youtube_videos']=$youtube_videos;				
			$data['description']=$description;
			$data['gym_id']=$_SESSION['gym_id'];
			$data['status']=$status;
			$data['created']='now()';
			$data['modified']='now()';
			
			$inserted_id=$db->query_insert("classes",$data);
			
			
			
			
			//************  classes_instructor ************************************************//			
			$classes_instructor=$_REQUEST['classes_instructor'];
				
				$total_client_services=count($classes_instructor);
					
				if($total_client_services > 0){
					$client_services_data = "INSERT INTO `classes_instructors` (`class_id`, `instructor_id`) VALUES ";
							
					for($p=0; $p<$total_client_services; $p++){
						$client_services_data .="('" . $inserted_id ."', '" . $classes_instructor[$p] ."'), ";
					}
							
					$client_services_data = substr($client_services_data,0,-2);
					$client_services_data .=";";
							
					$db->query($client_services_data);
				}
						
			
			//************  classes_instructor ************************************************//			
			$classes_category=$_REQUEST['classes_category'];
				
			$total_category=count($classes_category);
					
			if($total_category > 0){
				$client_services_data = "INSERT INTO `classes_categories` (`class_id`, `category_id`) VALUES ";
						
				for($p=0; $p<$total_category; $p++){
					$client_services_data .="('" . $inserted_id ."', '" . $classes_category[$p] ."'), ";
				}
							
				$client_services_data = substr($client_services_data,0,-2);
				$client_services_data .=";";
							
				$db->query($client_services_data);
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
											
					$uploaded_name['class_id']=$inserted_id;
					$uploaded_name['photo_name']=$path;				
						
					$db->query_insert("classes_photos",$uploaded_name);	
					
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

			
			$_SESSION['user_message']="Class information successfully created!";
			$general_func->header_redirect($general_func->site_url."class-new/");
		}	

	}else{	
		if($db->already_exist_update("classes","id",$_REQUEST['id'],"name",$name,"gym_id",$_SESSION['gym_id'])){
			$_SESSION['user_message']="Sorry, your specified class is already taken!";		
		}else{
			$data['name']=$name;
						
			$data['seo_link']=$general_func->create_seo_link($name);			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_update("classes","id",$_REQUEST['id'],"seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$_REQUEST['id'] ."-".$data['seo_link'];
			}
			//*********************************************//
		
			$data['youtube_videos']=$youtube_videos;
			$data['description']=$description;
			$data['gym_id']=$_SESSION['gym_id'];			
			$data['status']=$status;
			$data['modified']='now()';
			
			
			$db->query_update("classes",$data,"id='".$_REQUEST['id'] ."'");
	
	
			//************  classes_instructor ************************************************//			
			$db->query("delete from `classes_instructors`  where class_id='" .$_REQUEST['id']. "'");
			
				$classes_instructor=$_REQUEST['classes_instructor'];
				
				$total_client_services=count($classes_instructor);
					
				if($total_client_services > 0){
					$client_services_data = "INSERT INTO `classes_instructors` (`class_id`, `instructor_id`) VALUES ";
							
					for($p=0; $p<$total_client_services; $p++){
						$client_services_data .="('" . $_REQUEST['id'] ."', '" . $classes_instructor[$p] ."'), ";
					}
							
					$client_services_data = substr($client_services_data,0,-2);
					$client_services_data .=";";
							
					$db->query($client_services_data);
				}
								
		//************  classes_instructor ************************************************//			
			$db->query("delete from `classes_categories`  where class_id='" .$_REQUEST['id']. "'");
			
			$classes_category=$_REQUEST['classes_category'];
				
			$total_category=count($classes_category);
					
			if($total_category > 0){
				$client_services_data = "INSERT INTO `classes_categories` (`class_id`, `category_id`) VALUES ";
						
				for($p=0; $p<$total_category; $p++){
					$client_services_data .="('" . $_REQUEST['id'] ."', '" . $classes_category[$p] ."'), ";
				}
							
				$client_services_data = substr($client_services_data,0,-2);
				$client_services_data .=";";
							
				$db->query($client_services_data);
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
											
					$uploaded_name['class_id']=$_REQUEST['id'];
					$uploaded_name['photo_name']=$path;				
						
					$db->query_insert("classes_photos",$uploaded_name);	
					
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
				$_SESSION['user_message']="Class information successfully updated!";
			
			$general_func->header_redirect($general_func->site_url."gym-classes/");
		}
	}
}	





if(isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0){
	$sql="select * from classes where id=" . (int)  $_REQUEST['id']  . "  and gym_id=" . (int)  $_SESSION['gym_id']  . " limit 1";
	$result=$db->fetch_all_array($sql);	
			
	$name=$result[0]['name'];
	$gym_id=$result[0]['gym_id'];		
	$description=$result[0]['description'];
	$youtube_videos=$result[0]['youtube_videos'];
	$status=$result[0]['status'];
				
		
	$sql_category="select category_id from classes_categories where class_id='" .  $_REQUEST['id']  . "'";
	$result_category=$db->fetch_all_array($sql_category);	
	$classes_category_array=array();	
		
	for($i=0; $i<count($result_category); $i++){
		$classes_category_array[]=$result_category[$i]['category_id'];	
	}	
		
		
	$sql_service="select instructor_id from classes_instructors where class_id='" .  $_REQUEST['id']  . "'";
	$result_service=$db->fetch_all_array($sql_service);	
	$classes_instructor_array=array();	
		
	for($i=0; $i<count($result_service); $i++){
		$classes_instructor_array[]=$result_service[$i]['instructor_id'];	
	}	
		
		
				
	$array_accolades=array();	
	$accolades_index=0;
			
	$img_diff_view_rs=@mysql_query("select id,photo_name from  classes_photos where class_id='".(int)  $_REQUEST['id']  ."'");
	while($img_diff_view_rw=mysql_fetch_object($img_diff_view_rs)){
		$array_accolades[$accolades_index]['id']=$img_diff_view_rw->id;
		$array_accolades[$accolades_index++]['photo_name']=$img_diff_view_rw->photo_name;				
	}
			
	$val_accolades=count($array_accolades)+1;
	$button="Update";
	
}else{
	
	$name="";
	$gym_id="";				
	$description="";
	$youtube_videos="";
	$status=0;		
	
	$array_accolades=array();	
	$classes_instructor_array=array();
	$classes_category_array=array();
	$val_accolades=2;
		
	$button="Add New";
	
}		





?>	
<script type="text/javascript" src="<?=$general_func->site_url?>highslide/highslide.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$general_func->site_url?>highslide/highslide.css" />
<script type="text/javascript">
	hs.graphicsDir = '<?=$general_func->site_url?>highslide/graphics/';
	hs.wrapperClassName = 'wide-border';
	

function validate(){	
	
	var check=false;
	var frm=document.ff;
	if(parseInt(frm.classes_category.length)){
		for(var i=0;i<frm.classes_category.length;i++){
			if(frm.classes_category[i].checked == true){
				check=true;
				break;
			}	
		}
			
		if(check == false){
			alert("Please select at least a class type");
			return false;
		}	
			
	}else{
		if(frm.classes_category.checked == false){
			alert("Please select at least a class type");
			return false;
		}	
	}		
	
	
	
	if(!validate_text(document.ff.name,1,"Enter Class Name"))
		return false;	
	
	
	if(!validate_text(document.ff.description,1,"Enter Description"))
		return false;	
		
	if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
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


function collect_instructors(val){	
	if(val ==""){
		document.getElementById("instructors_div").innerHTML="";
	}else{
		xmlhttp.open("GET","<?=$general_func->site_url?>collect-instructors-list.php?gym_id="+val,false);
		xmlhttp.send();
		var str=xmlhttp.responseText;		
		document.getElementById("instructors_div").innerHTML=xmlhttp.responseText;
	}
}
</script>				
			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Add new class</h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			<form method="post" action="class-new/<?=$_REQUEST['id']?>"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
      
	        <ul class="contact-form column_form_container">            
              
              <div class="column_form_row">
               <li style="width:100% !important;">
	            <label>Instructor(s)</label>           
	      
				<div class="check_row" id="instructors_div" style="line-height: 22px;">
					
                  	
                  	 <?php
				$sql_instructor="SELECT id,name FROM `instructors` where gym_id='" . $_SESSION['gym_id'] . "'  ORDER BY name ASC";
				$result_instructor=$db->fetch_all_array($sql_instructor);
				$total_instructor=count($result_instructor);
				for($instructor=0; $instructor < $total_instructor; $instructor +=4 ){ ?>
				<span><input type="checkbox" name="classes_instructor[]"  id="classes_instructor"  <?=in_array($result_instructor[$instructor]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor]['id']?>" /><strong><?=$result_instructor[$instructor]['name']?></strong></span>	
					
					<?php if(trim($result_instructor[$instructor+1]['id']) != NULL){?>
						<span><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+1]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+1]['id']?>" /><strong><?=$result_instructor[$instructor+1]['name']?></strong></span>
					<?php  } ?>
					
					<?php if(trim($result_instructor[$instructor+2]['id']) != NULL){?>
						<span><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+2]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+2]['id']?>" /><strong><?=$result_instructor[$instructor+2]['name']?></strong></span>
					<?php  } ?>
					
					<?php if(trim($result_instructor[$instructor+3]['id']) != NULL){?>
						<span><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+3]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+3]['id']?>" /><strong><?=$result_instructor[$instructor+3]['name']?></strong></span>
					<?php  }
					 }	?>	
                  	</div>					
				
                
	          </li>
              
              </div>
              
              
              <div class="column_form_row">
               <li style="width:100% !important;">
	            <label>Class Type(s)<span>*</span></label>
				<div class="check_row" style="line-height: 22px;">
						
                  	 <?php
				$sql_category="SELECT id,name FROM `category` ORDER BY name ASC";
				$result_category=$db->fetch_all_array($sql_category);
				$total_category=count($result_category);
				for($category=0; $category < $total_category; $category +=4 ){ ?>
				<span><input type="checkbox" name="classes_category[]"  id="classes_category"  <?=in_array($result_category[$category]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category]['id']?>" /><strong><?=$result_category[$category]['name']?></strong></span>	
					
					<?php if(trim($result_category[$category+1]['id']) != NULL){?>
						<span><input type="checkbox" name="classes_category[]" id="classes_category" <?=in_array($result_category[$category+1]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category+1]['id']?>" /><strong><?=$result_category[$category+1]['name']?></strong></span>
					<?php  } ?>
					
					<?php if(trim($result_category[$category+2]['id']) != NULL){?>
						<span><input type="checkbox" name="classes_category[]" id="classes_category" <?=in_array($result_category[$category+2]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category+2]['id']?>" /><strong><?=$result_category[$category+2]['name']?></strong></span>
					<?php  } ?>
					
					<?php if(trim($result_category[$category+3]['id']) != NULL){?>
						<span><input type="checkbox" name="classes_category[]" id="classes_category" <?=in_array($result_category[$category+3]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category+3]['id']?>" /><strong><?=$result_category[$category+3]['name']?></strong></span>
					<?php  }
					}	?>	
					
                </div>
	          </li>
              
              </div>
           
            
            
             <div class="column_form_row">
	          <li>
	            <label>Class name<span>*</span></label>
	            <input type="text" name="name" value="<?=$name?>"  />
	          </li>
            </div> 
            
             
            
            
           

            
            
            
            
            <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>Description<span>*</span></label>
	            <textarea name="description" style="height:150px !important;"><?=$description?></textarea>
	          </li>
            </div> 
            
              <div class="column_form_row">
	          <li style="width:100% !important;">
	            <label>You Tube Share this Video Link</label>
	            <textarea name="youtube_videos" style="height:150px !important;"><?=$youtube_videos?></textarea>
                <p> (You can add multiple videos Link separated by a comma.)  Need help? <a href="youtube_video_help.php" target="_blank">Click here</a> </p>
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
							<a href=class-new.php?id=<?=$_REQUEST['id']?>&now=delete_bulk&bulk_id=<?=$array_accolades[$upload-1]['id']?>&file_name=<?=$array_accolades[$upload-1]['photo_name']?>" class="htext"><img src="images/del_product_icon.png" /></a></div>
                            
						
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
	          <li>
	            <label>Status</label>
	            <div class="select_box">
               <select name="status">
                      <option value="">Choose One</option>
                      <option value="1" <?=$status==1?'selected="selected"':'';?>>Active</option>
                      <option value="0" <?=$status==0?'selected="selected"':'';?>>Inactive</option>
                    </select>
                </div>
	          </li>
            </div> 
              
            
               
              <div class="column_form_row">
	          <li style="background:none;">
	            <input type="submit" name="submit" value="<?=$button?>" />
	          </li>
              </div>
              
	        </ul>
	      </form>							      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>