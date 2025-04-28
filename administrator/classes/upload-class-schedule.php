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
		
	$csv_name="classes".'.'.xls;
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
			
		
		//if(trim($data->sheets[0]['cells'][$i][1]) != "Gym Slug"){
			
			$working_day=$days_in_a_week[strtolower(trim($data->sheets[0]['cells'][$i][3]))];	
						
			$start_time=(intval(trim($data->sheets[0]['cells'][$i][4])) * 60) + intval(trim($data->sheets[0]['cells'][$i][5]));
			$end_time=(intval(trim($data->sheets[0]['cells'][$i][6])) * 60) + intval(trim($data->sheets[0]['cells'][$i][7]));
						
			
			$gym_id=mysql_result(mysql_query("select id from gyms where seo_link='" . trim($data->sheets[0]['cells'][$i][1]) ."' limit 1"),0,0);
			$class_id=mysql_result(mysql_query("select id from classes where seo_link='" . trim($data->sheets[0]['cells'][$i][2]) ."' limit 1"),0,0);
			
			
			//if(mysql_num_rows(mysql_query("select id from classes_scheduled where working_day='" . $working_day . "' and gym_id='" . $gym_id . "' and class_id='" . $class_id . "' and (($start_time BETWEEN start_time AND end_time) OR ($end_time BETWEEN start_time AND end_time)) limit 1")) == 0){
				$data_upload=array();	
				$data_upload['gym_id']=$gym_id;
				$data_upload['class_id']=$class_id;				
				$data_upload['working_day']=$working_day;
				$data_upload['start_time']=$start_time;
				$data_upload['end_time']=$end_time;
				$data_upload['status']=1;
				
				$db->query_insert("classes_scheduled",$data_upload);
				
				$_SESSION['msg']="Data successfully uploaded.";	
			//}			
		//}
		}	
	// }
		
	//unlink($csv_name);
}
	
?>

		

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">Upload Class Schedule</td>
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
                  <td  width="20%" class="body_content-form" valign="top">Upload Class Schedule (Excel file only):</td>
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
