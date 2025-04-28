<table width="100%" cellspacing="0" cellpadding="0">
  <tr class="heading">
                  <td style="border-bottom: none;">Time</td>
                  <td>Monday</td>
                  <td>tuesday</td>
                  <td>wednesday</td>
                  <td>thursday</td>
                  <td>friday</td>
                  <td>saturday</td>
                  <td>sunday</td>
                </tr>
     
     
    <?php
    $number_rowspan=($calander_end - $calander_start)/60; 
	$number_rowspan = $number_rowspan+1;
	
	$number_of_cells=$number_rowspan * 4;
	
	$start_the_action=0;
	
	for($calendar=$calander_start; $calendar <=$calander_end; $calendar+=60 ){ 
                	
					$start=$calendar;					
					$end=$calendar + 59;
					
		if($start_the_action == 0){
			$start_the_action ++;
			?>
			<tr>
    <td class="head_td"><?=$general_func->show_hour_min($calendar);?></td>
    <!-- monday -->
    <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_monday_classes=count($monday_array);
		
		if($total_monday_classes == 0){
			echo '<td width="40"><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td> ';
			
			
		}else{
			
			for($m=0; $m < $total_monday_classes; $m++ ){ ?>
		<td width="40"><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($monday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($monday_array[$m]['end']) - intval($monday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$monday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($monday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($monday_array[$m]['end']))?>');" ><?=substr(ucwords(strtolower($monday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$monday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($monday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($monday_array[$m]['end']))?>');" >
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($monday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php }
		}	
		
		?>
    	</tr>
    	</table>
    	 </td>
    <!-- / monday -->
    <!-- tuesday -->
    <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_tues_classes=count($tuesday_array);
		
		if($total_tues_classes == 0){
			
			echo '<td><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td>';
			
		}else{
			for($m=0; $m < $total_tues_classes; $m++ ){ ?>
		<td><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($tuesday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($tuesday_array[$m]['end']) - intval($tuesday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$tuesday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($tuesday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($tuesday_array[$m]['end']))?>');" ><?=substr(ucwords(strtolower($tuesday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$tuesday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($tuesday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($tuesday_array[$m]['end']))?>');">
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($tuesday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php } 
			
		}	
		?>
		
    	</tr>
    	</table>
    	 </td>
    <!-- / tuesday -->
    <!-- wednesday -->
    <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_wednesday_classes=count($wednesday_array);
		
		
		if($total_wednesday_classes == 0){
			
			echo '<td><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td> ';
			
		}else{
			for($m=0; $m < $total_wednesday_classes; $m++ ){ ?>
		<td><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($wednesday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($wednesday_array[$m]['end']) - intval($wednesday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$wednesday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($wednesday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($wednesday_array[$m]['end']))?>');"><?=substr(ucwords(strtolower($wednesday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$wednesday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($wednesday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($wednesday_array[$m]['end']))?>');">
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($wednesday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php } 
			
		}	?>
		
		
    	</tr>
    	</table>
    	 </td>
     <!-- / wednesday -->
    <!-- thru -->
   <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_thursday_classes=count($thursday_array);
		
		if($total_thursday_classes == 0){
			echo '<td><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td> ';
			
			
		}else{
			for($m=0; $m < $total_thursday_classes; $m++ ){ ?>
		<td><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($thursday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($thursday_array[$m]['end']) - intval($thursday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$thursday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($thursday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($thursday_array[$m]['end']))?>');"><?=substr(ucwords(strtolower($thursday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$thursday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($thursday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($thursday_array[$m]['end']))?>');">
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($thursday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php } 
		}	
		
		?>
    	</tr>
    	</table>
    	 </td>
     <!-- / thru -->
    <!-- fri -->
    <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_friday_classes=count($friday_array);
		
		if($total_friday_classes == 0){
			echo '<td><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td> ';
			
			
		}else{
			
			for($m=0; $m < $total_friday_classes; $m++ ){ ?>
		<td><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($friday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($friday_array[$m]['end']) - intval($friday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$friday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($friday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($friday_array[$m]['end']))?>');"><?=substr(ucwords(strtolower($friday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$friday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($friday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($friday_array[$m]['end']))?>');">
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($friday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php } 
			
		}	
		
		?>
		
    	</tr>
    	</table>
    	 </td>
     <!-- / fri -->
    <!-- sta -->
    <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_satur_classes=count($saturday_array);
		
		if($total_satur_classes == 0){
			echo '<td><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td> ';
			
			
		}else{
				
		for($m=0; $m < $total_satur_classes; $m++ ){ ?>
		<td><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($saturday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($saturday_array[$m]['end']) - intval($saturday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$saturday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($saturday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($saturday_array[$m]['end']))?>');"><?=substr(ucwords(strtolower($saturday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$saturday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($saturday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($saturday_array[$m]['end']))?>');">
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($saturday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php }
			
		}	
	 	?>
    	</tr>
    	</table>
    	 </td>
     <!-- / sta -->
    <!-- sun -->
   <td rowspan="<?=$number_rowspan?>">
    	<table width="100%" cellspacing="0" cellpadding="0" class="inner_table">
        <tr>
    	<?php
    	$total_sunday_classes=count($sunday_array);
		
	
		if($total_sunday_classes == 0){			
			echo '<td><table width="100%" cellspacing="0" cellpadding="0">';
			for($calendar_td=$calander_start; $calendar_td <$calander_end; $calendar_td+=15 ){
				echo '<tr>
                	<td>&nbsp;</td>
              	</tr>';	
			}	
			echo '</table></td> ';
			
		}else{
			for($m=0; $m < $total_sunday_classes; $m++ ){ ?>
		<td><table width="100%" cellspacing="0" cellpadding="0">
			<?php			
			for($calendar_td=$calander_start; $calendar_td <=$calander_end; $calendar_td+=15 ){
				$start=0;
				$how_many=0;
								
				if(intval($sunday_array[$m]['start']) == $calendar_td){
					$start=1;
					$how_many=(intval($sunday_array[$m]['end']) - intval($sunday_array[$m]['start']))/15;	
				}
				
				if($start == 1){?>
				<tr class="hide_me">
                	<td style="border-color:#000 !important;" onclick="open_class('<?=$sunday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($sunday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($sunday_array[$m]['end']))?>');"><?=substr(ucwords(strtolower($sunday_array[$m]['class'])),0,10)?>...</td>
              	</tr>					
				<?php 
					for($y=1; $y < $how_many; $y++){ ?>
						<tr  class="hide_me" onclick="open_class('<?=$sunday_array[$m]['class_id']?>','<?=$general_func->show_hour_min(intval($sunday_array[$m]['start']))?>','<?=$general_func->show_hour_min(intval($sunday_array[$m]['end']))?>');">
				                <td>&nbsp;</td>
				         </tr>
					<?php }				
					$start=0;
					$calendar_td=intval($sunday_array[$m]['end']);
				}else{ ?>
				 <tr>
                	<td>&nbsp;</td>
              	</tr>		
					
				<?php }				
				 }	?>              
            </table></td>				
		<?php } 
			
		}	
		?>
		
    	</tr>
    	</table>
    	 </td>
     <!-- / sun -->
   
  </tr>	
			
		<?php }else{ ?>
		<tr>
    		<td class="head_td"><?=$general_func->show_hour_min($calendar);?></td>
  		</tr>	
			
		<?php }		
	}					
	
    ?>   
 
</table>