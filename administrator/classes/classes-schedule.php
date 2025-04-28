<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


$data=array();


if(isset($_REQUEST['class']) && trim($_REQUEST['class']) !=NULL){
	$_SESSION['scheduled_class']=trim($_REQUEST['class']);	
}	

if(isset($_REQUEST['return_url']) && trim($_REQUEST['return_url']) !=NULL){
	$_SESSION['scheduled_return_url']=trim($_REQUEST['return_url']);	
}		
	
if(isset($_REQUEST['gym_id']) && trim($_REQUEST['gym_id']) !=NULL){
	$_SESSION['scheduled_gym_id']=trim($_REQUEST['gym_id']);	
}	

if(isset($_REQUEST['class_id']) && trim($_REQUEST['class_id']) !=NULL){
	$_SESSION['scheduled_class_id']=trim($_REQUEST['class_id']);	
}

if(isset($_GET['action']) && $_GET['action']=='delete'){			
	
	@mysql_query("delete from  classes_scheduled  where id=" . (int) $_REQUEST['id'] . "");
	$_SESSION['msg']="Your selected class schedule deleted!";
	$general_func->header_redirect($_SERVER['PHP_SELF']);
}
 


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){		
	
	$sql="select * from classes_scheduled where id=" . (int)  $_REQUEST['id']  . " and gym_id=" . (int) $_SESSION['scheduled_gym_id']  . "  and class_id=" . (int)  $_SESSION['scheduled_class_id']  . " limit 1";
	$result=$db->fetch_all_array($sql);	
		
	$working_day=$result[0]['working_day'];
	$start_time=$result[0]['start_time'];		
	$end_time=$result[0]['end_time'];	
	$status=$result[0]['status'];
	
	$button="Update";
}else{			
	$working_day="";
	$start_time="";				
	$end_time="";	
	$status=0;	
			
	$button="Add New";
}

if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$working_day=trim($_REQUEST['working_day']);	
	$start_time=trim($_REQUEST['start_time']);
	$end_time=trim($_REQUEST['end_time']);
	$status=trim($_REQUEST['status']);	
	
	if($_POST['submit']=="Add New"){		
		//if(mysql_num_rows(mysql_query("select id from classes_scheduled where working_day='" . $working_day . "' and gym_id='" . $_SESSION['scheduled_gym_id']. "' and class_id='" . $_SESSION['scheduled_class_id']. "' and (($start_time BETWEEN start_time AND end_time) OR ($end_time BETWEEN start_time AND end_time)) limit 1")) == 0){
			$data['gym_id']=$_SESSION['scheduled_gym_id'];
			$data['class_id']=$_SESSION['scheduled_class_id'];				
			$data['working_day']=$working_day;
			$data['start_time']=$start_time;
			$data['end_time']=$end_time;
			$data['status']=$status;
			
			$db->query_insert("classes_scheduled",$data);
			$_SESSION['msg']="Class '" . $_SESSION['scheduled_class'] ."' schedule successfully added.";
		/*}else{
			$_SESSION['msg']="Class '" . $_SESSION['scheduled_class'] ."' has already been scheduled within your specified time peroid.";
		}*/
		$general_func->header_redirect($_SERVER['PHP_SELF']);			

	}else{
		
		//if(mysql_num_rows(mysql_query("select id from classes_scheduled where id != '" . $_REQUEST['id'] . "' and working_day='" . $working_day . "'  and  gym_id='" . $_SESSION['scheduled_gym_id']. "' and class_id='" . $_SESSION['scheduled_class_id']. "' and (($start_time BETWEEN start_time AND end_time) OR ($end_time BETWEEN start_time AND end_time)) limit 1")) == 0){
			$data['working_day']=$working_day;
			$data['start_time']=$start_time;
			$data['end_time']=$end_time;
			$data['status']=$status;
			$db->query_update("classes_scheduled",$data,"id='".$_REQUEST['id'] ."'");
			$_SESSION['msg']="Class '" . $_SESSION['scheduled_class'] ."' schedule successfully updated.";
		/*}else{
			$_SESSION['msg']="Class '" . $_SESSION['scheduled_class'] ."' has already been scheduled within your specified time peroid.";		
		}*/	
		$general_func->header_redirect($_SERVER['PHP_SELF']);
	}	
}	
?>

<script type="text/javascript">	

function validate(){
	
	if(document.ff.working_day.selectedIndex == 0){
		alert("Please select a working day");
		document.ff.working_day.focus();
		return false;
	}
	
	if(parseInt(document.ff.start_time.value) >= parseInt(document.ff.end_time.value)){
		alert("End time must be greater than start time");
		document.ff.closing_time.focus();
		return false;			
	}
		
	if(document.ff.status.selectedIndex == 0){
		alert("Please select a status");
		document.ff.status.focus();
		return false;
	}	
}	

function del(id,name){
	var a=confirm("Are you sure, you want to delete your selected '" + name +"'s class schedule?");
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete";
    }  
} 

</script>			

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">Schedule for class '<?=$_SESSION['scheduled_class']?>'</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff"  onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />          
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
                  <td  width="20%" class="body_content-form" valign="top">Working Day:<font class="form_required-field"> *</font></td>
                  <td width="80%" valign="top"><select name="working_day"   class="inputbox_select" style="width: 200px; padding: 2px 1px 2px 0px;">
                      <option value="">Choose a Day</option>
                     <?php
						foreach($all_days_in_a_week as $day_index=>$day_value){?>							    	
							<option value="<?=$day_index?>" <?=$day_index==$working_day?'selected="selected"':'';?>><?=$day_value?></option>								    				
					<?php } ?>	
                    </select>      
                  </td>
                </tr> 
                 <tr>
                  <td  class="body_content-form" valign="top">Start Time:<font class="form_required-field"> *</font></td>
                  <td valign="top"><select name="start_time"  class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$start_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
                  </td>
                </tr>
                
                 <tr>
                  <td  class="body_content-form" valign="top">End Time:<font class="form_required-field"> *</font></td>
                  <td valign="top"><select name="end_time"  class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
                    <?php for ($i = $general_func->opening_time; $i <= $general_func->closing_time; $i += 15) {
								$hour_min="";	
								$hours = $i / 60;
    							$min = $i % 60;	
								
								$disp_hour=strlen(floor($hours))==1?'0'.floor($hours):floor($hours);
								$disp_min=strlen($min)==1?'0'.$min:$min;							
								$hour_min=$disp_hour ." : " . $disp_min;								
                    		?>
                    		<option value="<?=$i?>" <?=$end_time==$i?'selected="selected"':'';?>><?=$hour_min?></option>
                    		<?php }?>
                   </select> 
                  </td>
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
  <tr>
  	<td style="height: 20px;"></td>
  </tr>
  <tr>
    <td align="left" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
        
        <?php
			$sql="select id,working_day,start_time,end_time,status from classes_scheduled where gym_id='" . $_SESSION['scheduled_gym_id']. "' and class_id='" . $_SESSION['scheduled_class_id']. "' order by working_day ASC, start_time + 0 ASC";				
			$result=$db->fetch_all_array($sql);
			//*******************************************************************************************************************//
			?>
        <tr>
          <td align="left" valign="top"><table width="800" align="center" border="0" 
cellpadding="5" cellspacing="1">
            
              <tr>
                <td width="250"  align="left" valign="middle" class="table_heading">Day</a></td>
  
                <td width="250"  align="left" valign="middle" class="table_heading">Start Time</td>                
                 
                  <td width="100"  align="center" valign="middle" class="table_heading">End Time</td>
                 
                 <td width="70"  align="left" valign="middle" class="table_heading">Status</td>             
                <td width="80"  align="center" valign="middle" class="table_heading">Action</td>
              </tr>
              <?php if(count($result) == 0){?>
              <tr>
                <td colspan="5" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no class schedule found!</td>
              </tr>
              <?php }else{
					for($j=0;$j<count($result);$j++){?>
              <tr bgcolor="<?=$j%2==0?$general_func->color2:$general_func->color1;?>">
                <td align="left" valign="middle" class="table_content-blue"><?=$all_days_in_a_week[$result[$j]['working_day']]?></td>				            
                <td  align="left" valign="middle" class="table_content-blue"><?=$general_func->show_hour_min($result[$j]['start_time'])?></td> 
                <td  align="center" valign="middle" class="table_content-blue"><?=$general_func->show_hour_min($result[$j]['end_time'])?></td> 
                <td  align="left" valign="middle" class="table_content-blue"><?=$general_func->show_status($result[$j]['status'])?></td>
                <td  align="center" valign="middle" class="table_content-blue">
                	<?php if(isset($_SESSION['access_permission']['classes']['edit']) && intval($_SESSION['access_permission']['classes']['edit'])==1){ ?>
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>classes/classes-schedule.php?id=<?=$result[$j]['id']?>&action=EDIT'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />
                	<?php } 
                	 if(isset($_SESSION['access_permission']['classes']['delete']) && intval($_SESSION['access_permission']['classes']['delete'])==1){ ?>
                	&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=$all_days_in_a_week[$result[$j]['working_day']]?>');" style="cursor:pointer;" />
                	<?php } ?>
                	 </td>
              </tr>
              <?php }
				}
			
			
	  		?>
              <tr>
                <td colspan="8" align="center" valign="middle" height="4"></td>
              </tr>
              <tr>
                <td colspan="8" align="center" valign="middle" height="30" class="table_content-blue"><?php 
		if ($total_count>$recperpage) {
		?>
                  <table width="795" height="20" border="0"  cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="295" align="left" valign="bottom" class="htext">&nbsp;Jump to page
                        <select name="in_page" style="width:45px;" onChange="javascript:location.href='<?php echo str_replace("&in_page=".$page,"",$url);?>&in_page='+this.value;">
                          <?php for($m=1; $m<=ceil($total_count/$recperpage); $m++) {?>
                          <option value="<?php echo $m;?>" <?php echo $page==$m?'selected':''; ?>><?php echo $m;?></option>
                          <?php }?>
                        </select>
                        of <?php echo ceil($total_count/$recperpage); ?> </td>
                      <td width="467" align="right" valign="bottom" class="htext"><?php echo " ".$showing." ".$prev." ".$next." &nbsp;";?></td>
                    </tr>
                  </table>
                  <!-- / show category -->
                  <?php  }?></td>
              </tr>
              <tr>
                <td colspan="8" align="center" valign="middle" height="30" class="table_content-blue"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  
</table>
<?php
include("../foot.htm");
?>
