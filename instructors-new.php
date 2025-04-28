<?php 
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes" || $_SESSION['user_type']!="gym"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}


$small="instructor/small/";
$original="instructor/";



$data=array();

if(isset($_GET['now']) && $_GET['now']=="DELETE"){
	$path=$_REQUEST['path'];
	$field=$_REQUEST['field'];
		
	@mysql_query("update instructors set $field=' ' where id=" . (int) $_REQUEST['id'] . "");	
	
	@unlink($original.$path);
	@unlink($small.$path);	
	
	
	$_SESSION['user_message'] = "Your instructor photo deleted!";	   
	$general_func->header_redirect($general_func->site_url."instructors-new/".$_REQUEST['id']);	
}



if(isset($_REQUEST['id']) && intval($_REQUEST['id']) > 0){		
	
	$sql="select * from instructors where id=" . (int)  $_REQUEST['id']  . "  and gym_id=" . (int)  $_SESSION['gym_id']  . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$name=$result[0]['name'];	
	$description=$result[0]['description'];			
	$qualification=$result[0]['qualification']; 
	//$county=$result[0]['county'];
	//$area=$result[0]['area'];
	$photo_name=$result[0]['photo_name'];	
	$status=$result[0]['status'];
		
	$button="Update";
}else{		
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
	$name=trim($_REQUEST['name']);	
	$description=trim($_REQUEST['description']);	
	$qualification=trim($_REQUEST['qualification']);	
	//$county=trim($_REQUEST['county']);	
	//$area=trim($_REQUEST['area']);	
	$status=trim($_REQUEST['status']);	
	
	
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("instructors","name",$name,"gym_id",$_SESSION['gym_id'])){
			$_SESSION['user_message']="Sorry, your specified instructor is already taken!";		
		}else{
			$data['name']=$name;
			
			$data['seo_link']=$general_func->create_seo_link($name);
			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_inset("instructors","seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$db->max_id("instructors","id") + 1 ."-".$data['seo_link'];
			}
			//*********************************************//
			
			$data['gym_id']=$_SESSION['gym_id'];							
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
					
			
			$_SESSION['user_message']="Instructor profile successfully created!";
			$general_func->header_redirect($general_func->site_url."instructors-new/");
		}	

	}else{	
		if($db->already_exist_update("instructors","id",$_REQUEST['id'],"name",$name,"gym_id",$_SESSION['gym_id'])){
			$_SESSION['user_message']="Sorry, your specified instructor is already taken!";				
		}else{
			$data['name']=$name;
						
			$data['seo_link']=$general_func->create_seo_link($name);			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_update("instructors","id",$_REQUEST['id'],"seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$_REQUEST['id'] ."-".$data['seo_link'];
			}
			//*********************************************//
				
										
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
				$_SESSION['user_message']="Instructor profile successfully updated!";
			
			$general_func->header_redirect($general_func->site_url."instructors/");
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
			
	if(!validate_text(document.ff.name,1,"Enter instructor Name"))
		return false;	
	
	/*if(document.ff.area.selectedIndex == 0){
		alert("Please select an area");
		document.ff.area.focus();
		return false;
	}*/
	
	if(!validate_text(document.ff.qualification,1,"Enter qualification"))
		return false;
	
	if(!validate_text(document.ff.description,1,"Enter description"))
		return false;	
			
	
	if(document.ff.status.selectedIndex == 0){
		alert("Please select a status");
		document.ff.status.focus();
		return false;
	}	
}	



</script>			
			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Add new instructor</h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			<form method="post" action="instructors-new/<?=$_REQUEST['id']?>"  name="ff" enctype="multipart/form-data"  onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />       
       <input type="hidden" name="photo_name" value="<?=$photo_name?>" />	
	        <ul class="contact-form column_form_container">
            
            <div class="column_form_row">
	          <li>
	            <label>Instructor Name<span>*</span></label>
	            <input type="text"name="name" value="<?=$name?>" />
	          </li>
            </div> 
            
            <!-- <div class="column_form_row">
	          <li>
	            <label>County</label>
	            <div class="select_box">
               <select name="county">
                     <option value="Dublin">Dublin</option>
                   </select> 
                </div>
	          </li>
            </div> 
            
            <div class="column_form_row">
	          
	       
	          <li>
	            <label>Area</label>
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
	          </li>
            </div> -->
            
             <div class="column_form_row">
	          <li class="full_width_form_li" style="width:100% !important;">
	            <label>Qualification(s)<span>*</span></label>
	            <textarea name="qualification" style="height:150px !important;"><?=$qualification?></textarea>
	          </li>
            </div>
            
            <div class="column_form_row">
	          <li class="full_width_form_li" style="width:100% !important;">
	            <label>Description<span>*</span></label>
	            <textarea name="description" style="height:150px !important;"><?=$description?></textarea>
	          </li>
            </div> 
            
            
              <div class="column_form_row">
	          <li>
	            <label><?=trim($photo_name) != NULL?'Update':'Upload';?> Photo</label>
                <div class="customfile-container">
	             <?php if(trim($photo_name) != NULL){?>
                    		 <div class="highslide_row" style="margin-bottom:10px;">
                    		<a href="<?=$general_func->site_url.$original.$photo_name?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.$small.$photo_name?>" border="0" /></a>&nbsp;&nbsp;
                    		<a href="instructors-new.php?id=<?=$_REQUEST['id']?>&now=DELETE&field=photo_name&photo_name=<?=$photo_name?>" class="htext" ><strong>Delete</strong></a>
                  		</div>	
                    <?php }	?>							
                	
                  <input type="file" name="photo_name" />
                </div>
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