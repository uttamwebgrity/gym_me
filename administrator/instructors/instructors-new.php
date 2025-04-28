<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";



$small=$path_depth ."instructor/small/";
$original=$path_depth ."instructor/";



$data=array();
$return_url=$_REQUEST['return_url'];



if(isset($_GET['now']) && $_GET['now']=="DELETE"){
	$path=$_REQUEST['path'];
	$field=$_REQUEST['field'];
		
	@mysql_query("update instructors set $field=' ' where id=" . (int) $_REQUEST['id'] . "");	
	
	@unlink($original.$path);
	@unlink($small.$path);		
	
	
	$redirect_path=basename($_SERVER['PHP_SELF']) . "?id=".$_GET['id']."&action=EDIT&return_url=".$return_url;
	$general_func->header_redirect($redirect_path);	
}



if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){		
	
	$sql="select * from instructors where id=" . (int)  $_REQUEST['id']  . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$gym_id=$result[0]['gym_id'];
	$name=$result[0]['name'];	
	$description=$result[0]['description'];			
	$qualification=$result[0]['qualification']; 
	//$county=$result[0]['county'];
	//$area=$result[0]['area'];
	$photo_name=$result[0]['photo_name'];	
	$status=$result[0]['status'];
		
	$button="Update";
}else{	
	$gym_id="";
	$name="";
	$description="";	
	$photo_name="";
	$qualification="";
	//$county="";
	//$area="";
	$status="";	
		
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$gym_id=trim($_REQUEST['gym_id']);	
	$name=trim($_REQUEST['name']);	
	$description=trim($_REQUEST['description']);	
	$qualification=trim($_REQUEST['qualification']);	
	//$county=trim($_REQUEST['county']);	
	//$area=trim($_REQUEST['area']);	
	$status=trim($_REQUEST['status']);	
	
	
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("instructors","name",$name,"gym_id",$gym_id)){
			$_SESSION['msg']="Sorry, your specified instructor is already taken!";		
		}else{
			$data['name']=$name;
			
			$data['seo_link']=$general_func->create_seo_link($name);
			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_inset("instructors","seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$db->max_id("instructors","id") + 1 ."-".$data['seo_link'];
			}
			//*********************************************//
			
			$data['gym_id']=$gym_id;							
			$data['description']=$description;		
			$data['qualification']=$qualification;			
			//$data['county']=$county;
			//$data['area']=$area;			
			$data['status']=$status;
			$data['created']='now()';
			$data['modified']='now()';
			
			$inserted_id=$db->query_insert("instructors",$data);
			
			
			//****************************  upload logo ********************************//			
			if($_FILES['photo_name']['size'] >0){
						
				$uploaded_name=array();
					
				$userfile_name=$_FILES['photo_name']['name'];
				$userfile_tmp= $_FILES['photo_name']['tmp_name'];
				$userfile_size=$_FILES['photo_name']['size'];
				$userfile_type= $_FILES['photo_name']['type'];
								
				$path=$inserted_id ."_".$general_func->remove_space_by_hypen($userfile_name);
				$img=$original.$path;
				move_uploaded_file($userfile_tmp, $img) or die();
								
				$uploaded_name['photo_name']=$path;
				$db->query_update("instructors",$uploaded_name,'id='.$inserted_id);
				
				
				list($width, $height) = getimagesize($img);
				
				if($width > 80 || $height > 80){				
					$upload->uploaded_image_resize(80,80,$original,$small,$path);
				}else{
					copy($img,$small.$path); 
				}							
					
						
				if($width > 200 || $height > 200){
					$upload->uploaded_image_resize(200,200,$original,$original,$path);
				}	
			}
					
			
			$_SESSION['msg']="Instructor profile successfully created!";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{	
		if($db->already_exist_update("instructors","id",$_REQUEST['id'],"name",$name,"gym_id",$gym_id)){
			$_SESSION['msg']="Sorry, your specified instructor is already taken!";				
		}else{
			$data['name']=$name;
						
			$data['seo_link']=$general_func->create_seo_link($name);			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_update("instructors","id",$_REQUEST['id'],"seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$_REQUEST['id'] ."-".$data['seo_link'];
			}
			//*********************************************//
									
			$data['gym_id']=$gym_id;							
			$data['description']=$description;		
			$data['qualification']=$qualification;			
			//$data['county']=$county;
			//$data['area']=$area;			
			$data['status']=$status;			
			$data['modified']='now()';
			
			
			$db->query_update("instructors",$data,"id='".$_REQUEST['id'] ."'");
	
	
			//****************************  upload logo ********************************//			
			if($_FILES['photo_name']['size'] >0){
					
				@unlink($original.$_REQUEST['photo_name']);
				@unlink($small.$_REQUEST['photo_name']);
						
				$uploaded_name=array();
					
				$userfile_name=$_FILES['photo_name']['name'];
				$userfile_tmp= $_FILES['photo_name']['tmp_name'];
				$userfile_size=$_FILES['photo_name']['size'];
				$userfile_type= $_FILES['photo_name']['type'];
								
				$path=$_REQUEST['id'] ."_".$general_func->remove_space_by_hypen($userfile_name);
				$img=$original.$path;
				move_uploaded_file($userfile_tmp, $img) or die();
								
				$uploaded_name['photo_name']=$path;
				$db->query_update("instructors",$uploaded_name,'id='.$_REQUEST['id']);
				
				
				list($width, $height) = getimagesize($img);
				
				if($width > 80 || $height > 80){				
					$upload->uploaded_image_resize(80,80,$original,$small,$path);
				}else{
					copy($img,$small.$path); 
				}							
					
						
				if($width > 200 || $height > 200){
					$upload->uploaded_image_resize(200,200,$original,$original,$path);
				}	
			}			
		
			if($db->affected_rows > 0)
				$_SESSION['msg']="Instructor profile successfully updated!";
			
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
		
	if(!validate_text(document.ff.name,1,"Enter instructor Name"))
		return false;	
	
	if(!validate_text(document.ff.description,1,"Enter description"))
		return false;	
			
	if(!validate_text(document.ff.qualification,1,"Enter qualification"))
		return false;
	
	/*if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
		return false;
	}
	*/		
		
	if(document.ff.status.selectedIndex == 0){
		alert("Please select a status");
		document.ff.status.focus();
		return false;
	}	
}	



</script>			

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg"><?=$button?>
            Instructor</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input type="hidden" name="return_url" value="<?php echo $_REQUEST['return_url']?>" />
       <input type="hidden" name="photo_name" value="<?=$photo_name?>" />
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
                  <td width="80%" valign="top"><select name="gym_id"  class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
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
                  <td  class="body_content-form">Name:<font class="form_required-field"> *</font></td>
                  <td ><input name="name" value="<?=$name?>" type="text" autocomplete="off" class="form_inputbox" size="55" />
                  </td>
                </tr>  
                
                                       
               
                
                 <tr>
             	<td class="body_content-form">Qualification(s):<font class="form_required-field"> *</font></td>
                <td><textarea name="qualification"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="10"><?=$qualification?></textarea> </td>			
            </tr>                
                
                  <tr>
                  <td  class="body_content-form" valign="top">Description:<font class="form_required-field"> *</font></td>
                  <td  valign="top">
                  	<textarea name="description"  AUTOCOMPLETE=OFF class="form_textarea"  cols="90" rows="5"><?=$description?></textarea>
                  	              	
                  </td>
                </tr>
                
                 
                <tr>
                  <td  class="body_content-form" valign="top"><?=trim($photo_name) != NULL?'Update':'Upload';?>
                    Photo:</td>
                  <td  valign="top">
                  <?php if(trim($photo_name) != NULL){?>
                    		<a href="<?=$general_func->site_url.substr($original,6).$photo_name?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($small,6).$photo_name?>" border="0" /></a>&nbsp;&nbsp;
                    		<a href="instructors/instructors-new.php?id=<?=$_REQUEST['id']?>&now=DELETE&field=photo_name&photo_name=<?=$photo_name?>" class="htext" ><strong>Delete</strong></a>
                  			
                    <?php }	?>							
                	
                  <input type="file" name="photo_name" /></td>
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
