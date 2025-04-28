<?php 
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes" || $_SESSION['user_type']!="gym"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}

$data=array();


if(isset($_REQUEST['class']) && trim($_REQUEST['class']) !=NULL){
	$_SESSION['scheduled_class']=trim($_REQUEST['class']);	
}	



if(isset($_REQUEST['class_id']) && trim($_REQUEST['class_id']) !=NULL){
	$_SESSION['scheduled_class_id']=trim($_REQUEST['class_id']);	
}

if(isset($_GET['action']) && $_GET['action']=='delete'){			
	
	@mysql_query("delete from  classes_scheduled  where id=" . (int) $_REQUEST['id'] . "");
	$_SESSION['user_message']="Your selected class schedule deleted!";
	$general_func->header_redirect($general_func->site_url."classes-schedule.php?class=" .$_SESSION['scheduled_class'] . "&class_id=".$_SESSION['scheduled_class_id']);
}
 


if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){		
	
	$sql="select * from classes_scheduled where id=" . (int)  $_REQUEST['id']  . " and gym_id=" . (int) $_SESSION['gym_id']  . "  and class_id=" . (int)  $_SESSION['scheduled_class_id']  . " limit 1";
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
		if(mysql_num_rows(mysql_query("select id from classes_scheduled where working_day='" . $working_day . "' and gym_id='" . $_SESSION['gym_id']. "' and class_id='" . $_SESSION['scheduled_class_id']. "' and (($start_time BETWEEN start_time AND end_time) OR ($end_time BETWEEN start_time AND end_time)) limit 1")) == 0){
			$data['gym_id']=$_SESSION['gym_id'];
			$data['class_id']=$_SESSION['scheduled_class_id'];				
			$data['working_day']=$working_day;
			$data['start_time']=$start_time;
			$data['end_time']=$end_time;
			$data['status']=$status;
			
			$db->query_insert("classes_scheduled",$data);
			$_SESSION['user_message']="Class '" . $_SESSION['scheduled_class'] ."' schedule successfully added.";
		}else{
			$_SESSION['user_message']="Class '" . $_SESSION['scheduled_class'] ."' has already been scheduled within your specified time peroid.";
		}
		$general_func->header_redirect($general_func->site_url."classes-schedule.php?class=" .$_SESSION['scheduled_class'] . "&class_id=".$_SESSION['scheduled_class_id']);			

	}else{
		
		if(mysql_num_rows(mysql_query("select id from classes_scheduled where id != '" . $_REQUEST['id'] . "' and working_day='" . $working_day . "'  and  gym_id='" . $_SESSION['gym_id']. "' and class_id='" . $_SESSION['scheduled_class_id']. "' and (($start_time BETWEEN start_time AND end_time) OR ($end_time BETWEEN start_time AND end_time)) limit 1")) == 0){
			$data['working_day']=$working_day;
			$data['start_time']=$start_time;
			$data['end_time']=$end_time;
			$data['status']=$status;
			$db->query_update("classes_scheduled",$data,"id='".$_REQUEST['id'] ."'");
			$_SESSION['user_message']="Class '" . $_SESSION['scheduled_class'] ."' schedule successfully updated.";
		}else{
			$_SESSION['user_message']="Class '" . $_SESSION['scheduled_class'] ."' has already been scheduled within your specified time peroid.";		
		}	
		$general_func->header_redirect($general_func->site_url."classes-schedule.php?class=" .$_SESSION['scheduled_class'] . "&class_id=".$_SESSION['scheduled_class_id']);			
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
		document.ff.end_time.focus();
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

			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Schedule for class  '<?=$_SESSION['scheduled_class']?>'</h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			<form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff"  onsubmit="return validate()">
       		 <input type="hidden" name="enter" value="yes" />
        	<input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />    
	        <ul class="contact-form column_form_container">
            <div class="column_form_row">
	          <li>
	            <label>Working Day<span>*</span></label>
	            <div class="select_box">
                <select name="working_day" >
                      <option value="">Choose a Day</option>
                     <?php
						foreach($all_days_in_a_week as $day_index=>$day_value){?>							    	
							<option value="<?=$day_index?>" <?=$day_index==$working_day?'selected="selected"':'';?>><?=$day_value?></option>								    				
					<?php } ?>	
                    </select>     
                </div>
	          </li>
               </div> 
              
              <div class="column_form_row">
	          <li>
	            <label>Start Time<span>*</span></label>
	            <div class="select_box">
               <select name="start_time"  >
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
                </div>
	          </li>
            </div>
              
              <div class="column_form_row">
              <li>
	            <label>End Time<span>*</span></label>
	            <div class="select_box">
               <select name="end_time">
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
	            <input name="submit" type="submit" value="<?=$button?>" />
	          </li>
              </div>
              
	        </ul>
	      </form>	
           <?php
			$sql="select id,working_day,start_time,end_time,status from classes_scheduled where gym_id='" . $_SESSION['gym_id']. "' and class_id='" . $_SESSION['scheduled_class_id']. "' order by working_day ASC, start_time + 0 ASC";				
			$result=$db->fetch_all_array($sql);
			//*******************************************************************************************************************//
			?>
          <h1>Scheduled Classes</h1>
          <div class="class_list">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr class="class_list_head">
		    <td>Day</td>
		    <td align="center">Start Time</td>
		    <td align="center">End Time</td>
		    <td align="center">Status</td>
		    <td align="center">Action</td>
		  </tr>
		   <?php for($j=0;$j<count($result);$j++){?>
		  
		  <tr>
		    <td><?=$all_days_in_a_week[$result[$j]['working_day']]?></td>
		    <td align="center"><?=$general_func->show_hour_min($result[$j]['start_time'])?></td>
		    <td align="center"><?=$general_func->show_hour_min($result[$j]['end_time'])?></td>
		    <td align="center"><?=$general_func->show_status($result[$j]['status'])?></td>
		    <td align="center"><a href="classes-schedule.php?id=<?=$result[$j]['id']?>&action=EDIT"><img src="images/class_list_edit.png" style="margin-right:5px;" /></a>&nbsp;&nbsp;  <a onclick="del('<?=$result[$j]['id']?>','<?=$all_days_in_a_week[$result[$j]['working_day']]?>');" style="cursor:pointer;"><img src="images/class_list_delete.png" /></a></td>
		  </tr> 
		  
		  <?php } ?>

			</table>

          </div>
          						      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>