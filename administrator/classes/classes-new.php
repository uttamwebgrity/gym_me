<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


$gym_small=$path_depth ."class_photo/small/";
$gym_medium=$path_depth ."class_photo/medium/";
$gym_original=$path_depth ."class_photo/";

$data=array();
$return_url=$_REQUEST['return_url'];



if(isset($_GET['now']) && $_GET['now']=="delete_bulk"){//***************  delete bulk files
	$bulk_id=$_REQUEST['bulk_id'];
	$file_name=$_REQUEST['file_name'];
		
	@mysql_query("delete from  classes_photos  where id=" . (int) $bulk_id . "");
	
	@unlink($gym_small.$file_name);	
	@unlink($gym_medium.$file_name);	
	@unlink($gym_original.$file_name);	
	
	$redirect_path=basename($_SERVER['PHP_SELF']) . "?id=".$_GET['id']."&action=EDIT&return_url=".$return_url;
	$general_func->header_redirect($redirect_path);	
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){		
	
	$sql="select * from classes where id=" . (int)  $_REQUEST['id']  . " limit 1";
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


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
		
	$name=trim($_REQUEST['name']);	
	$gym_id=trim($_REQUEST['gym_id']);			
	$description=trim($_REQUEST['description']);	
	$youtube_videos=trim($_REQUEST['youtube_videos']);
	$status=trim($_REQUEST['status']);	
	
	
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("classes","name",$name,"gym_id",$gym_id)){
			$_SESSION['msg']="Sorry, your specified class is already taken!";		
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
			$data['gym_id']=$gym_id;
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

			
			$_SESSION['msg']="Class information successfully created!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{	
		if($db->already_exist_update("classes","id",$_REQUEST['id'],"name",$name,"gym_id",$gym_id)){
			$_SESSION['msg']="Sorry, your specified class is already taken!";		
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
			$data['gym_id']=$gym_id;			
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
				$_SESSION['msg']="Class information successfully updated!";
			
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
	
	if(document.ff.gym_id.selectedIndex == 0){
		alert("Please select a gym");
		document.ff.gym_id.focus();
		return false;
	}
	
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
		xmlhttp.open("GET","<?=$general_func->site_url?>collect-instructors.php?gym_id="+val,false);
		xmlhttp.send();
		var str=xmlhttp.responseText;		
		document.getElementById("instructors_div").innerHTML=xmlhttp.responseText;
	}
}
</script>			

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg"><?=$button?>
            Class</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input type="hidden" name="return_url" value="<?php echo $_REQUEST['return_url']?>" />     
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
                  <td  width="20%" class="body_content-form" valign="top">Gym Name:<font class="form_required-field"> *</font></td>
                  <td width="80%" valign="top"><select name="gym_id" onchange="collect_instructors(this.value);"  class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
                      <option value="">Choose Gym</option>
                     <?php
						$result=mysql_query("select id,name from gyms  order by name ASC");
						while($row=mysql_fetch_object($result)){		
							$snme=ucwords(strtolower($row->name)); ?>								    	
								    	<option value="<?=$row->id?>" <?=$row->id==$gym_id?'selected="selected"':'';?>><?=$snme?></option>								    				
								 <?php } ?>	
                    </select>      
                  </td>
                </tr>   
                <tr>
                  <td class="body_content-form" valign="top">Instructors: </td>
                  <td  valign="top">
                  	<div id="instructors_div">
                  	
                  	 <?php
				$sql_instructor="SELECT id,name FROM `instructors` where gym_id='" . $gym_id . "'  ORDER BY name ASC";
				$result_instructor=$db->fetch_all_array($sql_instructor);
				$total_instructor=count($result_instructor);
				for($instructor=0; $instructor < $total_instructor; $instructor +=4 ){ ?>
				<div class="check_row" >		
					<div class="check_block"><input type="checkbox" name="classes_instructor[]"  id="classes_instructor"  <?=in_array($result_instructor[$instructor]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor]['id']?>" /><div><?=$result_instructor[$instructor]['name']?></div></div>	
					
					<?php if(trim($result_instructor[$instructor+1]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+1]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+1]['id']?>" /><div><?=$result_instructor[$instructor+1]['name']?></div></div>
					<?php  } ?>
					
					<?php if(trim($result_instructor[$instructor+2]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+2]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+2]['id']?>" /><div><?=$result_instructor[$instructor+2]['name']?></div></div>
					<?php  } ?>
					
					<?php if(trim($result_instructor[$instructor+3]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+3]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+3]['id']?>" /><div><?=$result_instructor[$instructor+3]['name']?></div></div>
					<?php  } ?>
					
				</div>
				<div class="check_row_gap"></div>										
				<?php }	?>	
                  	</div>
                  </td>
                </tr>             
                 <tr>
                  <td class="body_content-form" valign="top">Class Types / Tags: </td>
                  <td  valign="top">
                  	
                  	
                  	 <?php
				$sql_category="SELECT id,name FROM `category` ORDER BY name ASC";
				$result_category=$db->fetch_all_array($sql_category);
				$total_category=count($result_category);
				for($category=0; $category < $total_category; $category +=4 ){ ?>
				<div class="check_row" >		
					<div class="check_block"><input type="checkbox" name="classes_category[]"  id="classes_category"  <?=in_array($result_category[$category]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category]['id']?>" /><div><?=$result_category[$category]['name']?></div></div>	
					
					<?php if(trim($result_category[$category+1]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="classes_category[]" id="classes_category" <?=in_array($result_category[$category+1]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category+1]['id']?>" /><div><?=$result_category[$category+1]['name']?></div></div>
					<?php  } ?>
					
					<?php if(trim($result_category[$category+2]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="classes_category[]" id="classes_category" <?=in_array($result_category[$category+2]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category+2]['id']?>" /><div><?=$result_category[$category+2]['name']?></div></div>
					<?php  } ?>
					
					<?php if(trim($result_category[$category+3]['id']) != NULL){?>
						<div class="check_block"><input type="checkbox" name="classes_category[]" id="classes_category" <?=in_array($result_category[$category+3]['id'],$classes_category_array)?'checked="checked"':'';?> value="<?=$result_category[$category+3]['id']?>" /><div><?=$result_category[$category+3]['name']?></div></div>
					<?php  } ?>
					
				</div>
				<div class="check_row_gap"></div>										
				<?php }	?>	
                  
                  </td>
                </tr>             
                
                
                <tr>
                  <td width="20%" class="body_content-form">Class Name:<font class="form_required-field"> *</font></td>
                  <td width="80%"><input name="name" value="<?=$name?>" type="text" autocomplete="off" class="form_inputbox" size="55" />
                  </td>
                </tr>               
                
                
                 <tr>
             	<td class="body_content-form">Description:<font class="form_required-field"> *</font></td>
                <td><textarea name="description"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$description?></textarea> </td>			
            </tr>
             <tr>
             	<td class="body_content-form" style="line-height: 20px;">You Tube Share this Video Link: <!--<img src="../images/youtube.jpg">--></td>
                <td><textarea name="youtube_videos"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="4"><?=$youtube_videos?></textarea> <br/>
                (You can add multiple videos Link separated by a comma.)               	
                </td>			
            </tr>
                               
                <tr>
                  <td  class="body_content-form" valign="top">Upload Images:</td>
                  <td  valign="top">
                  <div class="div_clear"></div>
						<?php                  
						for($upload=1; $upload <=20; $upload++){?>
						
						<?php if($array_accolades[$upload-1]){?>
							<a href="<?=$general_func->site_url.substr($gym_original,6).$array_accolades[$upload-1]['photo_name']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($gym_small,6).$array_accolades[$upload-1]['photo_name']?>" border="0" /></a>&nbsp;&nbsp;
							<a href="classes/classes-new.php?id=<?=$_REQUEST['id']?>&now=delete_bulk&bulk_id=<?=$array_accolades[$upload-1]['id']?>&file_name=<?=$array_accolades[$upload-1]['photo_name']?>" class="htext">Delete</a>
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
