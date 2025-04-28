<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

function getExtension($str){
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}




$return_url=$_REQUEST['return_url'];




if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	
	$fieldseparator = "\t";
    $lineseparator = "\n";
		
	$csv_name="data".'.'.xls;
	$newname=$csv_name;
	$copied = copy($_FILES['upload_file']['tmp_name'], $newname);
	if (!$copied) {
		$_SESSION['errmessage']="Copy unsuccessfull";
		$errors=1;
	}
	$file = fopen($newname,"r");
	$size = filesize($newname);
	if(!$size) {
		$_SESSION['errmessage']= "File is empty.\n";
		exit;
	}
	require_once 'Excel/reader.php';

	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	   
	$data->read($newname);
		
		
	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {					
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
			//echo $j."=\"".$data->sheets[0]['cells'][$i][$j]."\",";					
		}
		
		
		
		if(trim($data->sheets[0]['cells'][$i][1]) != "Class Name"){
			
			
			$gym_id=mysql_result(mysql_query("select id from gyms where seo_link='" . trim($data->sheets[0]['cells'][$i][4]) ."' limit 1"),0,0);
			$class_name=trim($data->sheets[0]['cells'][$i][1]);
			
			
			if( ! $db->already_exist_inset("classes","name",$class_name,"gym_id",$gym_id)){					
								
				$data_upload=array();							
				$data_upload['name']=$class_name;							
				$data_upload['seo_link']=$general_func->create_seo_link($class_name);				
							
				if($db->already_exist_inset("classes","seo_link",$data_upload['seo_link'])){//******* exit
					$data_upload['seo_link']=$db->max_id("classes","id") + 1 ."-".$data_upload['seo_link'];
				}
							
				$data_upload['gym_id']=$gym_id;			
				$data_upload['description']=trim($data->sheets[0]['cells'][$i][2]);					
				$data_upload['status']=1;
				$data_upload['created']='now()';
				$data_upload['modified']='now()';	
				
				$created_id=$db->query_insert("classes",$data_upload);
											
				
				$classes_category=array();
				
				if(trim($data->sheets[0]['cells'][$i][6]) != NULL){
					$tag_id=@mysql_result(mysql_query("select id from category where seo_link='" . trim($data->sheets[0]['cells'][$i][6]) ."' limit 1"),0,0);	
					if(intval($tag_id) > 0){
						$classes_category[]=$tag_id;
					}					
				}
				
				if(trim($data->sheets[0]['cells'][$i][7]) != NULL){
					$tag_id=@mysql_result(mysql_query("select id from category where seo_link='" . trim($data->sheets[0]['cells'][$i][7]) ."' limit 1"),0,0);	
					if(intval($tag_id) > 0){
						$classes_category[]=$tag_id;
					}					
				}
				
				if(trim($data->sheets[0]['cells'][$i][8]) != NULL){
					$tag_id=@mysql_result(mysql_query("select id from category where seo_link='" . trim($data->sheets[0]['cells'][$i][8]) ."' limit 1"),0,0);	
					if(intval($tag_id) > 0){
						$classes_category[]=$tag_id;
					}					
				}
				
				if(trim($data->sheets[0]['cells'][$i][9]) != NULL){
					$tag_id=@mysql_result(mysql_query("select id from category where seo_link='" . trim($data->sheets[0]['cells'][$i][9]) ."' limit 1"),0,0);	
					if(intval($tag_id) > 0){
						$classes_category[]=$tag_id;
					}					
				}
				
				
				
				
				$total_category=count($classes_category);
					
				if($total_category > 0){
					$client_services_data = "INSERT INTO `classes_categories` (`class_id`, `category_id`) VALUES ";
							
					for($p=0; $p<$total_category; $p++){
						$client_services_data .="('" . $created_id ."', '" . $classes_category[$p] ."'), ";
					}
								
					$client_services_data = substr($client_services_data,0,-2);
					$client_services_data .=";";
								
					$db->query($client_services_data);
				}
					
				
						
				$_SESSION['msg']="Data successfully uploaded.";	
			
				
			}			
		}	
	 }
		
	unlink($csv_name);
}
	
	
	/*
	$filename = stripslashes($_FILES['upload_file']['name']);
	$extension = getExtension($filename);
	$extension = strtolower($extension);
	$ext=$extension;
		
	
	if($_FILES['upload_file']['size'] >0 && $ext=="csv"){
		$uploaded_name=array();
					
		$userfile_name=$_FILES['upload_file']['name'];
		$userfile_tmp= $_FILES['upload_file']['tmp_name'];
		$userfile_size=$_FILES['upload_file']['size'];
		$userfile_type= $_FILES['upload_file']['type'];
		
		move_uploaded_file($userfile_tmp, $csvfile) or die();
		
		
		$filename = stripslashes($csvfile);
		$extension = getExtension($filename);
		$extension = strtolower($extension);
		$ext=$extension;
		
		if($ext=="csv"){
			$fieldseparator = ",";
        	$lineseparator = "\n";
		
			$newname="data".'.'.$extension;
		
		
			$file = fopen($newname,"r");
			$size = filesize($newname);
			if(!$size) {
				echo "File is empty.\n";
				exit;
			}
		
			$csvcontent = fread($file,$size);
			fclose($file);
		
			$lines = 0;
			$queries = "";
			$linearray = array();
			$lines = 0;
			$queries = "";
			$linearray = array();
		
			foreach(@split($lineseparator,$csvcontent) as $line) {
				$lines++;
	
				$line = trim($line," ,");
		
				$line = str_replace("\r","",$line);
		
			
				$line = str_replace("'","\'",$line);
				
		
		
				$linearray = @explode($fieldseparator,$line);
				
						
				
				
				$data=array();
				$Gym_Name=trim($linearray[0],'""');
				$Email_Address=trim($linearray[1],'""');
				$Password=trim($linearray[2],'""');
				$Short_Info=trim($linearray[3],'""');
				$Description=trim($linearray[4],'""');
				$You_tube=trim($linearray[5],'""');
				$Website_URL=trim($linearray[6],'""');
				$Phone=trim($linearray[7],'""');
				$Street_Address=trim($linearray[8],'""');				
				$Town=trim($linearray[9],'""');
				$Area=trim($linearray[10],'""');
				$County=trim($linearray[11],'""');
				$Facebook_Fan_Link=trim($linearray[12],'""');
				$Twitter_Embedded=trim($linearray[13],'""');
				 	
			
			    if(trim($Gym_Name) != "Gym Name"){
			    	if(!$db->already_exist_inset("gyms","email_address",$Email_Address)){
						$data=array();							
						$data['name']=trim($Gym_Name);
						
						$data['seo_link']=$general_func->create_seo_link(trim($Gym_Name));
						
						
						if($db->already_exist_inset("gyms","seo_link",$data['seo_link'])){//******* exit
							$data['seo_link']=$db->max_id("gyms","id") + 1 ."-".$data['seo_link'];
						}
						
						
						$data['email_address']=$Email_Address;		
						$data['password']=$EncDec->encrypt_me($Password);
						$data['short_info']=$Short_Info;		
						$data['description']=$Description;
						$data['youtube_videos']=$You_tube;
						$data['website_URL']=$Website_URL;
						$data['phone']=$Phone;
						$data['street_address']=$Street_Address;
						$data['town']=$Town;
						$data['area']=$Area;						
						$data['county']=$County;
						$data['facebook_fan_page_link']=$Facebook_Fan_Link;
						$data['twitter_tweets_page_link']=$Twitter_Embedded;
							
						
						$gen_lat=array();	
						$for_map=  $area .",". trim($Street_Address).", " .trim($Town) .", Dublin, Ireland";	
						$gen_lat=$general_func->getLnt($for_map);				
						$data['geo_lat']=$gen_lat['lat'];	
						$data['geo_long']=$gen_lat['lng'];
										
								
						$data['email_confirmed']=1;
						$data['membership_type']=2;
						$data['status']=1;
						$data['created']='now()';
						$data['modified']='now()';	
												
											
						$db->query_insert("gyms",$data);
						
						$_SESSION['msg']="Data successfully uploaded.";				    							    
				}
				
			}
		}
		
		}	
	}
	$_SESSION['msg']="Sorry, your uploaded file must be .csv file!"; */	
//}	

?>

		

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">Upload Gym Classes</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" enctype="multipart/form-data" >
        <input type="hidden" name="enter" value="yes" />
        
   
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
                  <td  width="20%" class="body_content-form" valign="top">Upload Gym Classes (Excel file only):</td>
                  <td width="80%"  valign="top"><input type="file" name="upload_file"  class="form_inputbox" size="55" />
                  	<br/> (.xls file only)
                  	
                  </td>
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
                        <td align="left" valign="middle" class="body_tab-middilebg"><input name="submit" type="submit" class="submit1" value="Upload" /></td>
                        <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                      </tr>
                    </table></td>
                  <td width="4%"></td>
                  <td width="63%"></td>
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
