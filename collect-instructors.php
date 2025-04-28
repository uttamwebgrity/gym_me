<?php
include_once("includes/configuration.php");

$gym_id=intval($_REQUEST['gym_id']);

$sql_instructor="SELECT id,name FROM `instructors` where gym_id='" . $gym_id . "'  ORDER BY name ASC";
$result_instructor=$db->fetch_all_array($sql_instructor);
$total_instructor=count($result_instructor);
for($instructor=0; $instructor < $total_instructor; $instructor +=4 ){ ?>
	<div class="check_row">		
		<div class="check_block"><input type="checkbox" name="classes_instructor[]"  id="classes_instructor"  <?=in_array($result_instructor[$instructor]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor]['id']?>" /><div><?=$result_instructor[$instructor]['name']?></div></div>	
		<?php if(trim($result_instructor[$instructor+1]['id']) != NULL){?>
			<div class="check_block"><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+1]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+1]['id']?>" /><div><?=$result_instructor[$instructor+1]['name']?></div></div>
		<?php  } 
		if(trim($result_instructor[$instructor+2]['id']) != NULL){?>
			<div class="check_block"><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+2]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+2]['id']?>" /><div><?=$result_instructor[$instructor+2]['name']?></div></div>
		<?php  } 
		if(trim($result_instructor[$instructor+3]['id']) != NULL){?>
			<div class="check_block"><input type="checkbox" name="classes_instructor[]" id="classes_instructor" <?=in_array($result_instructor[$instructor+3]['id'],$classes_instructor_array)?'checked="checked"':'';?> value="<?=$result_instructor[$instructor+3]['id']?>" /><div><?=$result_instructor[$instructor+3]['name']?></div></div>
		<?php  } ?>
	</div>
	<div class="check_row_gap"></div>										
<?php }	?>	