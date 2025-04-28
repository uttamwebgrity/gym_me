<?php
include_once("includes/configuration.php");

$gold_gym="select name,seo_link,description,logo_name from gyms where email_confirmed=1 and status=1 and  membership_type=2 and (membership_end IS NULL or membership_end >=$today_date) order by RAND() limit 1";
$result_gold_gym=$db->fetch_all_array($gold_gym);
if(count($result_gold_gym) == 1){ ?>
	<div class="box_banner_img">
		<?php if(trim($result_gold_gym[0]['logo_name']) != NULL && file_exists("gym_logo/".$result_gold_gym[0]['logo_name'])){?>
        	<img src="gym_logo/<?=$result_gold_gym[0]['logo_name']?>" alt="<?=$result_gold_gym[0]['name']?>" />	
       <?php }else{
        	echo '<img src="images/big_no_image.jpg" alt="" />';
        }
        ?>
		</div>
    	<div class="box_banner_detail">
        <h6><?=$result_gold_gym[0]['name']?></h6>
        <p> <?=substr(strip_tags($result_gold_gym[0]['description']),0,200)?></p>
        <div class="inner_button"><a href="gym/<?=$result_gold_gym[0]['seo_link']?>">View Gym</a></div>
  	</div>
<?php } ?>