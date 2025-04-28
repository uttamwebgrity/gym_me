<?php 
include_once("includes/header.php");




$county=$_REQUEST['county'];
$area=$_REQUEST['area'];


$query="";

if(trim($county) != NULL )
	$query .=" and county='" . trim($county) . "'";

if(trim($area) != NULL )
	$query .=" and area='" . trim($area) . "'";	



$sql="select name,seo_link,experience,specialty1,specialty2,specialty3,specialty4,specialty5,area,county,price_per_session,logo_name,membership_start,membership_end,membership_type	 from personal_trainers where email_confirmed=1 and status=1 ";				
$sql .=" $query order by membership_type DESC,name ASC";
$result=$db->fetch_all_array($sql);

$total_trainer=count($result);


?>				
<div class="main_container">
  <div class="main"> 
    
    <!-- tab type content -->
    <div class="tab_type_content_box">
      <div class="tab_type_content_head">
        <div class="tab_type_content_head_main">Search Result</div>
      </div>
      <div class="tab_type_content_area"> 
        
        <!-- searc result -->
        <div class="search_result_box">
          <div class="search_result_head"><span><?=$total_trainer?> trainer<?=$total_trainer > 1?'s':'';?> found</span></div>
          
        <?php for($gym=0; $gym < $total_trainer; $gym++ ){ ?>
          <div class="search_result_row">
            <div class="search_result_block search_result_image_block for_pt_img_block for_class_schedule">
              <div class="search_tag">Classes</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td" style="text-align:left;">
                  <h6>Adam Thomas</h6>
                  <h5><span>Dublin</span></h5>                	
                </td>
                </tr>
              </table>
            </div>
            
            <div class="search_result_block search_result_description_block for_pt_descrip">
              <div class="search_tag">Class Description</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><p><?=substr(strip_tags($result[$gym]['experience']),0,100)?>...</p></td>
                </tr>
              </table>
            </div>
            
            
            <div class="search_result_block search_result_area_block for_pt_area">
              <div class="search_tag">Dat and Time</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td">                	
                  	<ul class="short_li">
                  						<li>Mon: 19:00 - 19:45 </li>
										<li>Wed: 19:00 - 19:45 </li>
										<li>Sat: 12:00 - 12:45 </li>
									</ul>
                      
                      </td>
                </tr>
              </table>
            </div>
            
            <div class="search_result_block search_result_county_block for_pt_county">
              <div class="search_tag">Categories</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><ul class="short_li">
					<li>Cate One</li> <li>Cat Two</li><li>Cat Three</li></ul></td>
                </tr>
              </table>
            </div>
            
            
            
            
            <div class="search_result_block search_price">
              <div class="search_tag">Instructors</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td">
                  <ul class="short_li">
                  						<li>Lorem Ipsum</li>
										<li>Dolor Emet</li>
										<li>Lorem Ipsum</li>
									</ul>
                  </td>
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
                  <td class="search_td"><div class="view_search_profile"><a href="personal-trainer/<?=$result[$gym]['seo_link']?>">View More</a></div></td>
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