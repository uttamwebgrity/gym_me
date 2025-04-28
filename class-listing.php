<?php 
include_once("includes/header.php");


$query="";

$county=$_REQUEST['county'];
$area=$_REQUEST['area'];
$category=$_REQUEST['category'];

$working_day=$_REQUEST['working_day'];
$start_time=$_REQUEST['start_time'];
$end_time=$_REQUEST['end_time'];

if(isset($_REQUEST['working_day']) && trim($_REQUEST['working_day']) != NULL){
	$query .=" and working_day='" . $working_day . "' ";
} 

if(isset($_REQUEST['category']) && trim($_REQUEST['category']) != NULL){
	$query .=" and category_id='" . $category . "' ";
}

if(isset($_REQUEST['start_time']) && trim($_REQUEST['start_time']) != NULL && isset($_REQUEST['end_time']) && trim($_REQUEST['end_time']) != NULL){
	$query .=" and ($start_time BETWEEN  start_time AND end_time  OR $end_time BETWEEN  start_time AND end_time)";
} else if(isset($_REQUEST['start_time']) && trim($_REQUEST['start_time']) != NULL){
	$query .=" and $start_time BETWEEN  start_time AND end_time ";
	
} else if(isset($_REQUEST['end_time']) && trim($_REQUEST['end_time']) != NULL){
	$query .=" and  $end_time BETWEEN  start_time AND end_time";		
} 



/*$sql="select g.id as gymid,g.name as gym_name,g.seo_link as gym_seo_link,area,county,membership_start,membership_end,membership_type from gyms g where g.email_confirmed=1 and g.status=1 and g.area='" . trim($area) . "' and g.county='" . trim($county) . "'";
$sql .=" and g.id IN (select DISTINCT(gym_id)  from classes_scheduled s left join classes_categories c on s.class_id=c.class_id where category_id='" . $category. "' $query)";
echo $sql .="  order by g.membership_type DESC,g.name ASC";*/

$sql="select DISTINCT(g.id) as gymid,g.name as gym_name,g.seo_link as gym_seo_link,area,county,membership_start,membership_end,membership_type,cl.name as class_name,cl.description,cl.id as class_id";
$sql .=" from classes_scheduled s left join gyms g on s.gym_id=g.id";
$sql .=" left join classes_categories c on s.class_id=c.class_id ";
$sql .=" left join classes cl on s.class_id=cl.id ";
$sql .="  where g.email_confirmed=1 and g.status=1 and g.area='" . trim($area) . "'and cl.name IS NOT NULL and g.county='" . trim($county) . "'";
$sql .="  $query ";
$sql .="  order by g.membership_type DESC,g.name ASC";
$result=$db->fetch_all_array($sql);

$total_gyms=count($result);


?>				
<div class="main_container">
	<div class="main">
		 <div class="tab_type_content_box">
      <div class="tab_type_content_head">
        <div class="tab_type_content_head_main">Search Result </div>
      </div>
      <div class="tab_type_content_area">         
        <!-- searc result -->
        <div class="search_result_box">
          <div class="search_result_head"><span><?=$total_gyms?> class<?=$total_gyms > 1?'es':'';?> found</span></div>          
          <?php for($gym=0; $gym < $total_gyms; $gym++ ){ ?>
          	 <div class="search_result_row">
            <div class="search_result_block search_result_image_block for_pt_img_block">
              <div class="search_tag">Gym Info</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><h6><?=$result[$gym]['gym_name']?></h6></td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_view_block for_pt_county">
              <div class="search_tag">Class</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><h6><?=$result[$gym]['class_name']?></h6>
                    <h5><span><?=$result[$gym]['county']?></span></h5></td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_description_block for_pt_descrip">
              <div class="search_tag">Class description</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><p><?=substr(strip_tags($result[$gym]['description']),0,100)?>...</p></td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_area_block for_pt_area for_showing_date_time">
              <div class="search_tag">Day and Time</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td">                	
                  	<ul class="short_li">
                  	<?php
                  	$result_scheduled=$db->fetch_all_array("select working_day,start_time,end_time from classes_scheduled where class_id='" . $result[$gym]['class_id'] . "' and status=1 order by working_day ASC, start_time ASC");  
          			$total_result=count($result_scheduled);
          
					for($j=0;$j<$total_result;$j++){ ?>
					<li><?=substr($all_days_in_a_week[$result_scheduled[$j]['working_day']],0,3)?>: <?=$general_func->show_hour_min($result_scheduled[$j]['start_time'])?> - <?=$general_func->show_hour_min($result_scheduled[$j]['end_time'])?> </li>
					<?php }	?>
				</ul>
                      
                      </td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_price">
              <div class="search_tag">Gym Area</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><p style="font-size:14px;">
                  	<?php  
                  	if(trim($result[$gym]['area']) != NULL)
						echo trim($result[$gym]['area']);	
					?></p></td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_view_block">
              <div class="search_tag">View</div>
             <?php              
              if($result[$gym]['membership_type'] == 2 && (trim($result[$gym]['membership_end']) == NULL || strtotime(trim($result[$gym]['membership_end'])) >=$current_time_ms )){
              	?>
				 <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><div class="view_search_profile"><a href="gym/<?=$result[$gym]['gym_seo_link']?>">View Profile</a></div></td>
                </tr>
              </table>
             <?php } ?> 
            </div>
          </div>		
         <?php  } ?>
        </div>
      </div>
    </div>
	</div>
</div>
<?php include_once("includes/footer.php");?>