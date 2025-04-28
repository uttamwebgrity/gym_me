<?php 
include_once("includes/header.php");

?>
<script type="text/javascript">
function openme_gym(val){	
	xmlhttp.open("GET","<?=$general_func->site_url?>collect-gym-trainer-slug.php?type=gym&gym_id="+val,false);
	xmlhttp.send();	
	location.href="<?=$general_func->site_url?>gym/"+xmlhttp.responseText;
}	

function openme_trainer(val){
	xmlhttp.open("GET","<?=$general_func->site_url?>collect-gym-trainer-slug.php?type=trainer&trainer_id="+val,false);
	xmlhttp.send();	
	location.href="<?=$general_func->site_url?>personal-trainer/"+xmlhttp.responseText;
}	
</script>		    		

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>				
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<!--<h1><?php echo trim($dynamic_content['page_title']); ?></h1> -->
			<div class="row">
      			<div class="main_container">
    				<div class="contentPnl">
			    		<div  id="map-location" style="height:620px;width:950px;"></div>			    		
			    		<?php			    		
			    		$all_lat_lang="";
						$all_icons="";
										
						$gym_marker=1;
						
						$query="";
						
						if(isset($_REQUEST['search_type']) && trim($_REQUEST['search_type']) == "class_type" && intval($_REQUEST['class_type']) > 0 ){
							$query=" and id IN(select DISTINCT(gym_id) from classes_categories cc join  classes c on cc.class_id=c.id where category_id='" . intval($_REQUEST['class_type']) . "')";
						}	
						
									    		
						//*********************  gym pointer data ***************************//
						
			    		$sql_gyms="select id,name,seo_link,geo_lat,geo_long from gyms ";
						$sql_gyms .=" where  email_confirmed=1 and status=1 and membership_type= 2 and (membership_end IS NULL or DATE(membership_end) >= CURDATE()) and geo_lat IS NOT NULL and geo_long IS NOT NULL and name IS NOT NULL and seo_link IS NOT NULL $query";
						$result_gyms=$db->fetch_all_array($sql_gyms);
						$total_gyms=count($result_gyms);
						
						for($gyms=0; $gyms < $total_gyms ; $gyms++){							
							if(trim($result_gyms[$gyms]['geo_lat']) == NULL || trim($result_gyms[$gyms]['geo_long']) == NULL)
								continue;							
							
							$link='<a onclick=\'openme_gym(' . trim($result_gyms[$gyms]['id']) . ');\' > ' . trim($result_gyms[$gyms]['name']) . ' </a>';
												
						 	$all_lat_lang .= '["' .$link. '",' .trim($result_gyms[$gyms]['geo_lat']) . ', ' . trim($result_gyms[$gyms]['geo_long']) . '],';	
						 	$all_icons .= "'".$general_func->site_url."gym_map_icons/marker" .($gym_marker++) . ".png',";	
					 	}
						
						//*******************************************************************//
			    		
			    		
			    		if(!isset($_REQUEST['search_type'])){
				    		//*********************  trainer pointer data ***************************//
							$trainer_marker=1;
				    		$sql_trainers="select id,name,seo_link,geo_lat,geo_long from personal_trainers ";
							$sql_trainers .=" where  email_confirmed=1 and status=1 and membership_type= 2 and (membership_end IS NULL or DATE(membership_end) >= CURDATE()) and geo_lat IS NOT NULL and geo_long IS NOT NULL and name IS NOT NULL and seo_link IS NOT NULL";
							$result_trainers=$db->fetch_all_array($sql_trainers);
							$total_trainers=count($result_trainers);
							
							for($trainers=0; $trainers < $total_trainers ; $trainers++){							
								if(trim($result_trainers[$trainers]['geo_lat']) == NULL || trim($result_trainers[$trainers]['geo_long']) == NULL)
									continue;							
								
								$link='<a onclick=\'openme_trainer(' . trim($result_trainers[$trainers]['id']) . ');\' > ' . trim($result_trainers[$trainers]['name']) . ' </a>';
															
							 	$all_lat_lang .= '["' .$link. '",' .trim($result_trainers[$trainers]['geo_lat']) . ', ' . trim($result_trainers[$trainers]['geo_long']) . '],';	
							 	$all_icons .= "'".$general_func->site_url."trainer_map_icons/marker" .($trainer_marker++) . ".png',";	
						 	}
							
							//*******************************************************************//	
			    		}			    		
			    				    					    					    		
			    		
						$all_lat_lang=substr($all_lat_lang,0,-1); 										 
						$all_icons=substr($all_icons,0,-1);
					?>  
		     
		     			<script type="text/javascript">
						    // Define your locations: HTML content for the info window, latitude, longitude
						    var locations = [
						     <?=$all_lat_lang?>				     
						    ];
						    
						    // Setup the different icons and shadows
						    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
						    
						    var icons = [
						    <?=$all_icons?>
						    ]
						    var icons_length = icons.length;
						    
						    
						    var shadow = {
						      anchor: new google.maps.Point(15,33),
						      url: iconURLPrefix + 'msmarker.shadow.png'
						    };
						
						    var map = new google.maps.Map(document.getElementById('map-location'), {
						      zoom: 2,
						      center: new google.maps.LatLng(-6.2469336,53.3380655),
						      mapTypeId: google.maps.MapTypeId.ROADMAP,
						      mapTypeControl: false,
						      streetViewControl: false,
						      panControl: false,
						      zoomControlOptions: {
						         position: google.maps.ControlPosition.LEFT_BOTTOM
						      }
						    });
						
						    var infowindow = new google.maps.InfoWindow({
						      maxWidth: 660,
						      minWidth: 460
						    });
						
						    var marker;
						    var markers = new Array();
						    
						    var iconCounter = 0;
						    
						    // Add the markers and infowindows to the map
						    for (var i = 0; i < locations.length; i++) {  
						      marker = new google.maps.Marker({
						        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
						        map: map,
						        icon : icons[iconCounter],
						        shadow: shadow
						      });
						
						      markers.push(marker);
						
						      google.maps.event.addListener(marker, 'click', (function(marker, i) {
						        return function() {
						          infowindow.setContent(locations[i][0]);
						          infowindow.open(map, marker);
						        }
						      })(marker, i));
						      
						      iconCounter++;
						      // We only have a limited number of possible icon colors, so we may have to restart the counter
						      if(iconCounter >= icons_length){
						      	iconCounter = 0;
						      }
						    }
						
						    function AutoCenter() {
						      //  Create a new viewpoint bound
						      var bounds = new google.maps.LatLngBounds();
						      //  Go through each...
						      $.each(markers, function (index, marker) {
						        bounds.extend(marker.position);
						      });
						      //  Fit these bounds to the map
						      map.fitBounds(bounds);
						    }
						    AutoCenter();
						  </script>                  
		                  
	                  	<div class="legend">
	                  		<div><img src="gym_map_icons/blank.png" /><span>Gym</span></div>	                  
			                  <?php  if(!isset($_REQUEST['search_type'])){
			                  		echo '<div><img src="trainer_map_icons/blank.png" /><span>Personal Trainer</span></div>';
							   }
			                  ?>                
	                	</div>                  
        			</div>
  				</div>
    		</div>
		</div>
	</div>
</div>
<?php
$sql_class_type="select DISTINCT(ca.id) as class_type_id,name from category ca LEFT JOIN  classes_categories cc on ca.id=cc.category_id ";
$sql_class_type .=" where ca.id IN (select DISTINCT(class_id) from classes_categories cd LEFT JOIN  classes c on cd.class_id=c.id ";
$sql_class_type .=" where c.gym_id IN(select DISTINCT(id) from  gyms where  email_confirmed=1 and status=1 and membership_type= 2 and (membership_end IS NULL or DATE(membership_end) >= CURDATE()) and geo_lat IS NOT NULL and geo_long IS NOT NULL and name IS NOT NULL and seo_link IS NOT NULL)) "; 
$sql_class_type .=" order by name ASC";	

$result_class_type=$db->fetch_all_array($sql_class_type);
$total_class_types=count($result_class_type);

if($total_class_types > 0){ ?>
<div class="map_search">
<form name="frmsearch" action="map/" method="post">
<div class="map_search_box">
	<span>Select a class type to see<br />where its on:</span>
	<select name="class_type">
		<option value="">All</option>
		<?php for($type=0; $type < $total_class_types; $type++ ){ ?>
			<option value="<?=$result_class_type[$type]['class_type_id']?>"><?=$result_class_type[$type]['name']?></option>
			
		<?php } ?>
		
	</select>
	<input type="submit" name="search" value="Find" />
	<input type="hidden" name="search_type" value="class_type" />
</div>
</form>		
<div class="map_search_button"></div>
<div class="map_search_button_close"></div>

</div>		
<?php } 
include_once("includes/footer.php");?>