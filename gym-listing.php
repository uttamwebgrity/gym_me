<?php 
include_once("includes/header.php");




$county=$_REQUEST['county'];
$area=$_REQUEST['area'];


$query="";

if(trim($county) != NULL )
	$query .=" and county='" . trim($county) . "'";

if(trim($area) != NULL )
	$query .=" and area='" . trim($area) . "'";	



$sql="select name,seo_link,short_info,description,area,county,logo_name,membership_start,membership_end,membership_type	 from gyms where email_confirmed=1 and status=1 ";				
$sql .=" $query order by membership_type DESC,name ASC";
$result=$db->fetch_all_array($sql);

$total_gyms=count($result);


?>				
<div class="main_container">
	<div class="main">
		 <div class="tab_type_content_box">
      <div class="tab_type_content_head">
        <div class="tab_type_content_head_main">Search Result</div>
      </div>
      <div class="tab_type_content_area">         
        <!-- searc result -->
        <div class="search_result_box">
          <div class="search_result_head"><span><?=$total_gyms?> gym<?=$total_gyms > 1?'s':'';?> found</span></div>          
          <?php for($gym=0; $gym < $total_gyms; $gym++ ){ ?>
          	<div class="search_result_row">
            <div class="search_result_block search_result_image_block">
              <div class="search_tag">Gym Logo</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td">
                  	<?php                	
                	$img="gym_logo/small/".$result[$gym]['logo_name'];
											
					if(!file_exists($img) || trim($result[$gym]['logo_name']) == NULL)
						$img="images/gym-no-image.jpg";
					?>
					<img src="<?=$img?>" />
                  </td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_county_block">
              <div class="search_tag">Gym Info</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><h6><?=$result[$gym]['name']?></h6>
                    <h5><span><?=$result[$gym]['county']?></span></h5></td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_description_block">
              <div class="search_tag">Gym Description</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><p><?=substr(strip_tags($result[$gym]['description']),0,100)?>...</td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_area_block">
              <div class="search_tag">Gym Area</div>
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="search_td"><p><?=$result[$gym]['area']?></p></td>
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
                  <td class="search_td"><div class="view_search_profile"><a href="gym/<?=$result[$gym]['seo_link']?>">View Profile</a></div></td>
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