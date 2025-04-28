<?php
include_once("includes/configuration.php");

$gym_id=intval($_REQUEST['gym_id']);

$sql_instructor="SELECT id,name FROM `instructors` where gym_id='" . $gym_id . "'  ORDER BY name ASC";
$result_instructor=$db->fetch_all_array($sql_instructor);
$total_instructor=count($result_instructor);
for($instructor=0; $instructor < $total_instructor; $instructor +=4 ){ ?>
	<span><input type="checkbox" name="classes_instructor[]"  id="classes_instructor"  <?=in_array($result_instructor[$instructor]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor]['id']?>" /><strong><?=$result_instructor[$instructor]['name']?></strong></span>		
		<?php if(trim($result_instructor[$instructor+1]['id']) != NULL){?>
			<span><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+1]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+1]['id']?>" /><strong><?=$result_instructor[$instructor+1]['name']?></strong></span>	
		<?php  } 
		if(trim($result_instructor[$instructor+2]['id']) != NULL){?>
			<span><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+2]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+2]['id']?>" /><strong><?=$result_instructor[$instructor+2]['name']?></strong></span>	
		<?php  } 
		if(trim($result_instructor[$instructor+3]['id']) != NULL){?>
			<span><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+3]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+3]['id']?>" /><strong><?=$result_instructor[$instructor+3]['name']?></strong></span>	
		<?php  } 
		 }	?>	