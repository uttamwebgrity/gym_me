<?php 
include_once("includes/header.php");


if(isset($_REQUEST['enter']) && $_REQUEST['enter']=="contactus"){		
	
	$email_content='<tr>
						<td align="left" valign="top" style="padding:20px; margin:0; line-">
					    	<table width="700" cellspacing="3" cellpadding="6" border="0" align="center" style="line-height: 25px;">
					        	<tr>
					            	<td  width="700" colspan="2" align="left" style="font:normal 13px/22px Georgia," ><strong> Dear '.$_REQUEST['gym_name'].',</strong></td>
					               
					              </tr>	
					              <tr>
					            	<td  width="700" colspan="2" align="left" style="font:normal 13px/22px Georgia," ><strong>A GymMe user has made contact with you, see below for full message details.</strong></td>
					               
					              </tr>	
					        	
					        	<tr>
					            	<td width="100" align="left" style="font:normal 13px/22px Georgia," ><strong> First Name:</strong></td>
					                 <td width="600" align="left" style="font:normal 13px/22px Georgia,">' . $_REQUEST['fname'] . '</td>
					              </tr>
					              <tr>
					            	<td width="100" align="left" style="font:normal 13px/22px Georgia," ><strong> Last Name:</strong></td>
					                 <td width="600" align="left" style="font:normal 13px/22px Georgia,">' . $_REQUEST['lname'] . '</td>
					              </tr>							                               
					             <tr>
					                 <td align="left" style="font:normal 13px/22px Georgia, " ><strong>Email Address:</strong></td>
					                  <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['email'] . '</td>
					                </tr>	
					               	<tr>
					                 <td align="left" style="font:normal 13px/22px Georgia, " ><strong>Phone No.:</strong></td>
					                  <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['phone'] . '</td>
					                </tr>					               
					               	<tr>
					               		<td valign="top" align="left" style="font:normal 13px/22px Georgia, " ><strong>Message:</strong></td>
					                    <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['message'] . '</td>
					             	</tr>
					            </table>
					   		</td>
				  		</tr>';		
		
		//*******************  send email to employer *******************//
		$recipient_info=array();
		$recipient_info['recipient_subject']="A GymMe user has sent you a message!";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=$_REQUEST['gym_email'];		
		$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);	
		//***************************************************************//			
		
		$data=array();		
		$data['first_name']=trim($_REQUEST['fname']);							
		$data['last_name']=trim($_REQUEST['lname']);
		$data['gym_name']=$_REQUEST['gym_name'];		
		$data['email']=trim($_REQUEST['email']);			
		$data['phone']=trim($_REQUEST['phone']);		
		$data['message']=trim($_REQUEST['message']);		
		$data['added_date']='now()';			
		$db->query_insert("contact_gym_message",$data);
		
		
		$_SESSION['user_message'] ="Your contact details has been sent to '" . $_REQUEST['gym_name'] . "'.";
		
		$general_func->header_redirect($general_func->site_url."gym/".$_REQUEST['id']);
}



if(isset($_REQUEST['enter']) && $_REQUEST['enter']=="flag"){
		
	
	$email_content='<tr>
						<td align="left" valign="top" style="padding:20px; margin:0; line-">
					    	<table width="700" cellspacing="3" cellpadding="6" border="0" align="center" style="line-height: 25px;">
					        	<tr>
					            	<td  width="700" colspan="2" align="left" style="font:normal 13px/22px Georgia," ><strong> Dear Administrator,</strong></td>
					               
					              </tr>	
					              <tr>
					            	<td  width="700" colspan="2" align="left" style="font:normal 13px/22px Georgia," ><strong> A viewer of  '.$general_func->site_title .' flag this Gym.</strong></td>
					               
					              </tr>	
					        	
					        	<tr>
					            	<td width="100" align="left" style="font:normal 13px/22px Georgia," ><strong> Gym Name:</strong></td>
					                 <td width="600" align="left" style="font:normal 13px/22px Georgia,">' . $_REQUEST['gym_name'] . '</td>
					              </tr>
					              						                               
					             <tr>
					                 <td align="left" style="font:normal 13px/22px Georgia, " ><strong>Gym Email Address:</strong></td>
					                  <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['gym_email'] . '</td>
					                </tr>	
					               					               
					               	<tr>
					               		<td valign="top" align="left" style="font:normal 13px/22px Georgia, " ><strong>Viewer Message:</strong></td>
					                    <td align="left" style="font:normal 13px/22px Georgia, " >' . $_REQUEST['message'] . '</td>
					             	</tr>
					            </table>
					   		</td>
				  		</tr>';		
		
		//*******************  send email to employer *******************//
		$recipient_info=array();
		$recipient_info['recipient_subject']=$general_func->site_title ." viewer flag a Gym";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=$general_func->email;		
		$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);	
		//***************************************************************//			
		
		
		$_SESSION['user_message'] ="Your message has been sent to the site administrator.";		
		$general_func->header_redirect($general_func->site_url."gym/".$_REQUEST['id']);
}








$id=$_REQUEST['id'];
$sql="select *	from gyms where seo_link= '" . $id . "' and email_confirmed=1 and status=1 and membership_type=2 and (membership_end IS NULL or membership_end >=$today_date) limit 1";				
$result=$db->fetch_all_array($sql);


$sql_photos="select photo_name from gym_photos where gym_id ='" . $result[0]['id'] . "'";
$result_photos=$db->fetch_all_array($sql_photos);

$total_photos=count($result_photos);


$videos_links=array();
$videos_links=explode(",",$result[0]['youtube_videos']);

$video_array=array();


$total=count($videos_links);

$v_id=0;


for($i=0; $i <$total; $i++){
	if(trim($videos_links[$i]) != NULL ){	
		$video_array[$v_id]['link']="<iframe width=\"475\" height=\"372\" src=\"http://www.youtube.com/embed/" . str_replace("http://youtu.be/","", $videos_links[$i]) . "\" frameborder=\"0\" allowfullscreen></iframe>";	
		$video_array[$v_id++]['img']="http://img.youtube.com/vi/" . str_replace("http://youtu.be/","", $videos_links[$i]) . "/0.jpg";	
	}
}

/*
$monday_array=array();
$tuesday_array=array();
$wednesday_array=array();
$thursday_array=array();
$friday_array=array();
$saturday_array=array();
$sunday_array=array();

$sql_calendar="select working_day,name,start_time,end_time,s.class_id ";
$sql_calendar .=" from classes_scheduled s left join classes c on s.class_id=c.id where s.status=1 and s.gym_id='" . $result[0]['id'] . "' ";
$sql_calendar .=" order by working_day ASC,start_time + 0 ASC";

$result_calendar=$db->fetch_all_array($sql_calendar);
$total_calendar=count($result_calendar);


$mon=0;
$tue=0;
$wed=0;
$thu=0;
$fri=0;
$sat=0;
$sun=0;
 * */

/*

for($ca=0; $ca < $total_calendar; $ca++){	
	
	if(intval($result_calendar[$ca]['working_day']) == 1){
		$monday_array[$mon]['start']=intval($result_calendar[$ca]['start_time']);	
		$monday_array[$mon]['class']=$result_calendar[$ca]['name'];	
		$monday_array[$mon]['class_id']=$result_calendar[$ca]['class_id'];	
		$monday_array[$mon++]['end']=intval($result_calendar[$ca]['end_time']);	
	}else if(intval($result_calendar[$ca]['working_day']) == 2){
		$tuesday_array[$tue]['start']=intval($result_calendar[$ca]['start_time']);
		$tuesday_array[$tue]['class']=$result_calendar[$ca]['name'];	
		$tuesday_array[$tue]['class_id']=$result_calendar[$ca]['class_id'];			
		$tuesday_array[$tue++]['end']=intval($result_calendar[$ca]['end_time']);	
	}else if(intval($result_calendar[$ca]['working_day']) == 3){
		$wednesday_array[$wed]['start']=intval($result_calendar[$ca]['start_time']);
		$wednesday_array[$wed]['class']=$result_calendar[$ca]['name'];	
		$wednesday_array[$wed]['class_id']=$result_calendar[$ca]['class_id'];		
		$wednesday_array[$wed++]['end']=intval($result_calendar[$ca]['end_time']);	
	}else if(intval($result_calendar[$ca]['working_day']) == 4){
		$thursday_array[$thu]['start']=intval($result_calendar[$ca]['start_time']);	
		$thursday_array[$thu]['class']=$result_calendar[$ca]['name'];	
		$thursday_array[$thu]['class_id']=$result_calendar[$ca]['class_id'];
		
		$thursday_array[$thu++]['end']=intval($result_calendar[$ca]['end_time']);	
	}else if(intval($result_calendar[$ca]['working_day']) == 5){
		$friday_array[$fri]['start']=intval($result_calendar[$ca]['start_time']);
		$friday_array[$fri]['class']=$result_calendar[$ca]['name'];	
		$friday_array[$fri]['class_id']=$result_calendar[$ca]['class_id'];	
			
		$friday_array[$fri++]['end']=intval($result_calendar[$ca]['end_time']);	
	}else if(intval($result_calendar[$ca]['working_day']) == 6){
		$saturday_array[$sat]['start']=intval($result_calendar[$ca]['start_time']);	
		$saturday_array[$sat]['class']=$result_calendar[$ca]['name'];
		$saturday_array[$sat]['class_id']=$result_calendar[$ca]['class_id'];
		
		$saturday_array[$sat++]['end']=intval($result_calendar[$ca]['end_time']);	
	}else if(intval($result_calendar[$ca]['working_day']) == 7){
		$sunday_array[$sun]['start']=intval($result_calendar[$ca]['start_time']);
		$sunday_array[$sun]['class']=$result_calendar[$ca]['name'];	
		$sunday_array[$sun]['class_id']=$result_calendar[$ca]['class_id'];		
		$sunday_array[$sun++]['end']=intval($result_calendar[$ca]['end_time']);						
	}	
}


$calander_start=mysql_result(mysql_query("select MIN(start_time) as opening_time from classes_scheduled where gym_id ='" . $result[0]['id'] . "' and status=1"),0,0);
$calander_end=mysql_result(mysql_query("select MAX(end_time) as closing_time from classes_scheduled where gym_id ='" . $result[0]['id'] . "' and status=1"),0,0);

$start_reminder=$calander_start % 60;
if($start_reminder != 0 )
	$calander_start=$calander_start - $start_reminder;

$end_reminder=$calander_end % 60;
if($end_reminder != 0 )
	$calander_end=$calander_end - $end_reminder;
*/


$result_classes_schedule=$db->fetch_all_array("select id,name,description from classes where status=1 and id IN(select DISTINCT(class_id) from classes_scheduled where status=1 and gym_id='" . $result[0]['id'] . "' and class_id <> 0 ) order by name ASC");
$total_classes_schedule=count($result_classes_schedule);
?>

<script>

function check_validate(){
	if(!validate_text(document.frmcontactus.fname,1,"Blank space not allowed. Please Enter Your First  Name."))
		return false;	
	/*if(!validate_text(document.frmcontactus.lname,1,"Blank space not allowed. Please Enter Your Last Name."))
		return false;	*/		
	if(!validate_email(document.frmcontactus.email,1,"Blank space not allowed. Enter Email Address"))
		return false;	

	/*if(!validate_text(document.frmcontactus.phone,1,"Blank space not allowed. Please Enter Contact Phone."))
		return false;	*/	
	
	if(!validate_text(document.frmcontactus.message,1,"Blank space not allowed. Please Let us Know Your Message."))
	   return false;		
	
}

function flag_validate(){	
	
	if(!validate_text(document.frmflag.message,1,"Blank space not allowed. Please Let us Know Your Message."))
	   return false;		
	
}


function show_instructor(iid){		
	var instructor_ids_array=document.frminstructors.instructor_ids.value.split(",");	
	var len=instructor_ids_array.length;
	
	for(var i=0; i < len; i++){				
		if(parseInt(iid) == parseInt(instructor_ids_array[i])){			
			document.getElementById("instructor_"+ parseInt(instructor_ids_array[i])).style.display="block";
				$(".class_profile_detail").animate(  
                  {   
                   opacity:1, 
                  }, 300);			
		}else{
			document.getElementById("instructor_"+ parseInt(instructor_ids_array[i])).style.display="none";	
			$(".class_profile_detail").css('opacity', '0');
		}
	}		  
}

function open_class(iid,start_timing){		
	var class_ids_array=document.frmclasses.class_ids.value.split(",");	
	var len=class_ids_array.length;
	
	
	
	for(var i=0; i < len; i++){	
		if(parseInt(iid) == parseInt(class_ids_array[i])){					
			document.getElementById("class_details_"+ parseInt(class_ids_array[i])).style.display="block";
			document.getElementById("duration_"+ parseInt(class_ids_array[i])).innerHTML=start_timing;	
				$(".class-detail").animate(  
                  {   
                   opacity:1, 
                  }, 300);
                  		
		}else{
			document.getElementById("class_details_"+ parseInt(class_ids_array[i])).style.display="none";
			document.getElementById("duration_"+ parseInt(class_ids_array[i])).innerHTML="";		
			$(".class-detail").css('opacity', '0');
		}
	}		  
}

function close_timetabletab_open_teamtaband_instructor(instructor_id,classid){//alert(instructor_id);	
	document.getElementById("classes-and-timetable-tab").className="";	
	document.getElementById("our-team-tab").className="selected";
	document.getElementById("class_details_"+ parseInt(classid)).style.display="none";
	document.getElementById("classes-and-timetable").style.display="none";
	document.getElementById("our-team").style.display="block";
			
	document.getElementById("instructor_"+ parseInt(instructor_id)).style.display="block";
	$(".class-detail").animate(  
                  {   
                   opacity:1, 
     }, 300);
	
}

function open_page(website){ 	
	xmlhttp.open("GET","<?=$general_func->site_url?>calculate-outbound-link.php?type=1&id="+<?=$result[0]['id']?>,false);
	xmlhttp.send();
	window.open(website,"_blank");
}

</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=758905797457025";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="pop1"> </div>
<div class="popup1">
      <div class="close_pop1">
    <div class="cross"></div>
    <span>Close</span></div>
      <div class="pop_box1">
    <div class="left_ring"></div>
    <div class="right_ring"></div>
    <div class="pop_main_container1"> 
          <div class="pop_main1">
        
        <!-- contact gym -->
        <div class="pop_form contact_gym_pop">
        <form name="frmcontactus" method="post"  action="gym/<?=$_REQUEST['id']?>" onsubmit="return check_validate();">
		<input type="hidden" name="enter" value="contactus"  />
		<input type="hidden" name="gym_name"  value="<?=$result[0]['name']?>" />
		<input type="hidden" name="gym_email"  value="<?=$result[0]['email_address']?>" />		
        	
        	
              <div class="pop_head">
            <div class="pop_icon"><img src="images/contact_gym_image.png" /></div>
            <div class="pop_name">
                  <h5>Contact Gym</h5>
                  <h6><?=$result[0]['name']?></h6>
                </div>
          </div>
              
              <!-- form -->
              <div class="tab_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Your First Name<span>*</span></label>
                <input type="text" name="fname" placeholder="First Name" />
              </div>
                  <div class="tab_form_block">
                <label>Your Last Name</label>
                <input type="text" name="lname" placeholder="Last Name" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Your Email<span>*</span></label>
                <input type="text"  name="email" placeholder="Email" />
              </div>
                  <div class="tab_form_block">
                <label>Your Phone Number</label>
                <input type="text"   name="phone" placeholder="Phone Number" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block full_width_block">
                <label>Your Message<span style="color:#FFF;">*</span></label>
                <textarea   name="message" placeholder="Place your message here"></textarea>
              </div>
                </div>
            <!-- row -->
            
            <input type="submit" value="Submit" />
          </div>
              <!-- form --> 
             </form>
            </div>
        <!-- contact gym --> 
        
        <p class="special_form_note" style="color:#FFF !important;">* denotes that the field is mandatory</p>
        
      </div>
        </div>
  </div>
    </div>
    
<!-- pop --> 
<div class="row">
				
<div class="main_container">
      <div class="pnlOne"> 
    
    <!-- slider -->
    
    <div class="gym_detail_left for_anlts_block">
          <div class="gym_slider">
        <div class="container">
              <div class="products_example">
            <div class="products" id="products_top">
            	<?php
            	$total_photos=count($result_photos);				
				$total_gallery= count($video_array);
				
				
				
				if($total_photos == 0 && $total_gallery ==  0  && !file_exists("gym_logo/" .trim($result[0]['logo_name']))  ){				
					echo '<img src="images/big_no_image.jpg" alt="" />';
				 }else{ ?>
					<div class="slides_container"> 
						
						<?php
						if(trim($result[0]['logo_name']) != NULL){?>
							<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><img src='gym_logo/<?=trim($result[0]['logo_name'])?>' class="the_gallery_image" /></td>
                    </tr>
                  </table>
                  </span> </a> 
							
						<?php }
						
                	
                	
					for($photo=0; $photo < $total_photos; $photo++){ ?>
						<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><img src='gym_photo/<?=$result_photos[$photo]['photo_name']?>' class="the_gallery_image" /></td>
                    </tr>
                  </table>
                  </span> </a> 
						
				<?php }	
				reset($result_photos);
								
				 for($j=0; $j < $total_gallery; $j++){?>
				 	
				 	<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><?=$video_array[$j]['link']?></td>
                    </tr>
                  </table>
                  </span> </a> 				 	
				 <?php }	 	?>
                  
                </div>
                  
                  <!-- pagination -->
                  <div class="scroller">
                <div class=" jcarousel-skin-tango">
                      <div class="jcarousel-container jcarousel-container-horizontal">
                    <div class="jcarousel-clip jcarousel-clip-horizontal">
                          <ul id="mycarousel_top" class="pagination">
                          	<?php
						if(trim($result[0]['logo_name']) != NULL){?>
							<li><a><img src="gym_logo/small/<?=trim($result[0]['logo_name'])?>"></a></li>							
						<?php }
                          	
                               for($photo=0; $photo < $total_photos; $photo++){ ?>
                        	 <li><a><img src="gym_photo/medium/<?=$result_photos[$photo]['photo_name']?>"></a></li>
						 <?php }

						 for($j=0; $j < count($video_array); $j++){?>
						 	<li><a><img src="<?=$video_array[$j]['img']?>"></a></li>
						 <?php }	 	?>
                        
                            </ul>
                        </div>
                    <div class="jcarousel-prev jcarousel-prev-horizontal" style="display: block;" disabled="false"> </div>
                    <div class="jcarousel-next jcarousel-next-horizontal" style="display: block;" disabled="false"> </div>
                  </div>
                    </div>
              </div>
                  <!-- pagination --> 	
					
				<?php } ?>
                
                </div>
          </div>
            </div>
      </div>
        </div>
    
    <!-- slider -->
    
    <div class="halfPnl for_anlts_halfpn">
          <div class="dtlsPnl">
        <h3><?=$result[0]['name']?></h3>
        <p><?=$result[0]['area']?>, <?=$result[0]['county']?><br /></p>
        <?php
        $working_days="select working_day,opening_time,closing_time from gym_working_days where gym_id ='" . $result[0]['id'] . "' order by working_day ASC";
     	$result_working_days=$db->fetch_all_array($working_days);
		$total_working_days=count($result_working_days);
		
		if($total_working_days > 0){ ?> 
        <p><strong>Working Hours</strong></p>
        <div class="working_time_table">
        <?php
        
		for($days=0; $days < $total_working_days; $days++){ ?>
			<div class="working_table_block"><div><?=substr($all_days_in_a_week[$result_working_days[$days]['working_day']],0,3)?></div><div><?=$general_func->show_hour_min($result_working_days[$days]['opening_time']);?> to <?=$general_func->show_hour_min($result_working_days[$days]['closing_time']);?></div></div>
		<?php }   ?>        
        
        </div>
        <?php } ?>          
        <div class="div_clear"></div>
        <div class="inner_button"><a class="popclick1 contact_to_gym">Contact Gym</a></div>
        <div class="gym_share">
        
      
          <form name="frmflag" method="post"  action="gym/<?=$_REQUEST['id']?>" onsubmit="return flag_validate();">
		<input type="hidden" name="enter" value="flag"  />  
		<input type="hidden" name="gym_name"  value="<?=$result[0]['name']?>" />
		<input type="hidden" name="gym_email"  value="<?=$result[0]['email_address']?>" />	
        
        <div class="flag_form">
        <label>Enter your message for site administrator<span>*</span></label>
        <textarea name="message"></textarea>
        <input type="submit" value="Submit" />
         <input type="button" value="Close" class="flag_form_close" />
        </div>
        </form>
      
        
              <div class="gym_share_block gym_share_block_flag"><img src="images/flag.png" /><strong>Flag</strong></div>
              <div class="gym_share_block"><span class='st_sharethis_large' displayText='ShareThis'></span> <span class='st_facebook_large' displayText='Facebook'></span> <span class='st_twitter_large' displayText='Tweet'></span> <span class='st_linkedin_large' displayText='LinkedIn'></span> <span class='st_pinterest_large' displayText='Pinterest'></span> <span class='st_email_large' displayText='Email'></span></div>
              <div class="div_clear"></div>
               <div class="gym_share_block" style="height:auto; padding-top:7px; padding-bottom:7px;">
            		<div class="fb-like" data-href="http://gymme.ie/gym/<?=$_REQUEST['id']?>" data-layout="standard" data-action="recommend" data-show-faces="true" data-share="false"></div>
           		</div>
            </div>
      </div>
        </div>
        
        
     <div class="google_anlst"></div>   
        
  </div>
    </div>
<div class="row">
      <div class="main_container">
    <div class="contentPnl">
    	<?php if(trim($result[0]['description']) != NULL){ ?>
    		<h1>Description</h1>
          <p><?=$result[0]['description']?></p>
			
    	<?php } 
    	
    	if(trim($result[0]['website_URL']) != NULL){
          		echo '<h1>Website</h1>'; 
          		$pos=stripos(trim($result[0]['website_URL']),"http://");
				
          		if ($pos === false) {
          			$website="http://".trim($result[0]['website_URL']);
				}else{
					$website=trim($result[0]['website_URL']);					
				}
				
          		?>
          		<p><a onclick="open_page('<?=$website?>');"><?=trim($result[0]['website_URL'])?></a></p>
				<?php 
          	}
          								
				$map_address=$result[0]['area'].", ".$result[0]['street_address'].", ".$result[0]['town'].", Dublin, Ireland";							 
				$prepAddr = str_replace(' ','+',$map_address);
				
				if(trim($result[0]['geo_lat']) == NULL || trim($result[0]['geo_long']) == NULL){
					$result123=$general_func->getLnt($map_address);						
				}else{
					$result123['lat']=trim($result[0]['geo_lat']);	
					$result123['lng']=trim($result[0]['geo_long']); 
				}
				?>
				
		
			    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
			    <script>
			function initialize() {
			  var myLatlng = new google.maps.LatLng(<?=$result123['lat']?>,<?=$result123['lng']?>);
			  var mapOptions = {
			    zoom: 16,
			    center: myLatlng
			  }
			  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			
			  var marker = new google.maps.Marker({
			      position: myLatlng,
			      map: map,
			      title: '<?=addslashes($map_address)?>'
			  });
			}
			
			google.maps.event.addDomListener(window, 'load', initialize);
			
			    </script>
			  	<h1 style="margin-top: 5px;">Location</h1>
			    <div style="width: 100%; height: 450px; float: left; clear: both; margin-top: 5px;" id="map-canvas"></div>

		

           
          
        </div>
  </div>
    </div>


<div class="tab_container tc-in">
      <div class="main_container">
    <div class="main">
          <div class="tab">
        <div id="tabs" class="htabs">
              <div class="tab_a_container"> <a id="classes-and-timetable-tab" href="#classes-and-timetable" class="hide_calss_profile">Classes and Timetable</a> <a  id="our-team-tab" href="#our-team" class="hide_class_table show_class_table_instructor">Our Team</a> </div>
            </div>
        
       
        <div id="classes-and-timetable" class="tab-content">
			<div class="search_result_box">
			
		<?php
		$total_classes_schedule=count($result_classes_schedule);
		
		for($schedule=0; $schedule < $total_classes_schedule; $schedule ++ ){ ?>
			
			 <div class="search_result_row" style="border-bottom: 1px solid #E2E2E2; border-top:none;">
            <div class="search_result_block search_result_image_block for_pt_img_block for_class_schedule">
              <div class="search_tag">Classes</div>
              <table border="0" cellpadding="0" cellspacing="0" style="border:none;">
                <tr>
                  <td class="search_td" style="text-align:left;">
                  <h6><?=$result_classes_schedule[$schedule]['name']?></h6>
                  <h5><span>Dublin</span></h5>                	
                </td>
                </tr>
              </table>
            </div>
            
            <div class="search_result_block search_result_description_block for_pt_descrip">
              <div class="search_tag">Class Description</div>
              <table border="0" cellpadding="0" cellspacing="0" style="border:none;">
                <tr>
                  <td class="search_td"><p><?=trim($result_classes_schedule[$schedule]['description']) != NULL? substr(trim($result_classes_schedule[$schedule]['description']),0,120)."...":''; ?></p></td>
                </tr>
              </table>
            </div>
            
            
            <div class="search_result_block search_result_area_block for_pt_area for_pt_area_class_list">
              <div class="search_tag">Day and Time</div>
              <table border="0" cellpadding="0" cellspacing="0" style="border:none;">
                <tr>
                  <td class="search_td">                	
                  	<ul class="short_li">
                  	<?php
                  	$class_all_scheduled="";
					
					
                  	
                  	$result_scheduled=$db->fetch_all_array("select working_day,start_time,end_time from classes_scheduled where class_id='" . $result_classes_schedule[$schedule]['id'] . "' and status=1 order by working_day ASC, start_time ASC");  
          			$total_result=count($result_scheduled);
          
					for($j=0;$j<$total_result;$j++){ 
						
						$class_all_scheduled .= "<li>" . substr($all_days_in_a_week[$result_scheduled[$j]['working_day']],0,3) ." : " . $general_func->show_hour_min($result_scheduled[$j]['start_time']) ." - " . $general_func->show_hour_min($result_scheduled[$j]['end_time']) . "</li>";
						?>
					<li><?=substr($all_days_in_a_week[$result_scheduled[$j]['working_day']],0,3)?>: <?=$general_func->show_hour_min($result_scheduled[$j]['start_time'])?> - <?=$general_func->show_hour_min($result_scheduled[$j]['end_time'])?> </li>
					<?php }	?>
					</ul>
                      
                      </td>
                </tr>
              </table>
            </div>
            
            <div class="search_result_block search_result_county_block for_pt_county">
              <div class="search_tag">Categories</div>
              <table border="0" cellpadding="0" cellspacing="0" style="border:none;">
                <tr>
                  <td class="search_td"><ul class="short_li">
					<?php
					
					
			      	$rs_cat=mysql_query("select id,name from category where id IN(select DISTINCT(category_id) from classes_categories where class_id='" . $result_classes_schedule[$schedule]['id'] . "')");
			        
					if(count($rs_cat) > 0){
						while($row=mysql_fetch_object($rs_cat)){ ?>						
							<li><?=$row->name?></li>
						<?php }
					} ?>
					</ul></td>
                </tr>
              </table>
            </div>
            
            
            
            
            <div class="search_result_block search_price">
              <div class="search_tag">Instructors</div>
              <table border="0" cellpadding="0" cellspacing="0" style="border:none;">
                <tr>
                  <td class="search_td">
                  <ul class="short_li">
                  	<?php
			      	$rs_instructor=mysql_query("select id,name from instructors where id IN(select DISTINCT(instructor_id) from classes_instructors where class_id='" . $result_classes_schedule[$schedule]['id']. "')");
			        
					if(count($rs_instructor) > 0){
						while($row=mysql_fetch_object($rs_instructor)){ ?>
							<li><?=$row->name?></li>
						<?php }						
					} ?>
					</ul>
                  </td>
                </tr>
              </table>
            </div>
            <div class="search_result_block search_result_view_block">
              <div class="search_tag">View</div>
      
				 <table border="0" cellpadding="0" cellspacing="0" style="border:none;">
                <tr>
                  <td class="search_td"><div class="view_search_profile"><a  href="<?=$general_func->site_url?>gym/<?=$_REQUEST['id']?>#aclass_<?=$result_classes_schedule[$schedule]['id']?>"  onclick="open_class('<?=$result_classes_schedule[$schedule]['id']?>','<?=$class_all_scheduled?>'); ">View More</a></div></td>
                </tr>
              </table>
          
            </div>
          </div>
		<?php } ?>	             
        </div>
            </div>
      
        <div id="our-team" class="tab-content">
              <div class="our-team">
            <ul>
            	<?php  
            	$instructor_ids="";
            	          	
            	$sql_instructors="select * from instructors where gym_id ='" . $result[0]['id'] . "' and status=1";
				$result_instructors=$db->fetch_all_array($sql_instructors);				
				$total_instructors=count($result_instructors);
				
				for($instructor=0; $instructor < $total_instructors;  $instructor++){ 
					$instructor_ids .=$result_instructors[$instructor]['id'].",";
					
					?>
					<li> <?php                	
                	$img="instructor/small/".$result_instructors[$instructor]['photo_name'];						
					if(!file_exists($img) || trim($result_instructors[$instructor]['photo_name']) == NULL)
							$img="images/instructor-no-image-small.jpg";
					?>
					<img src="<?=$img?>"  class="thumb" />
                	<div class="con">
                      <h3><?=$result_instructors[$instructor]['name']?></h3>
                      
                      <?php
                      $ins_classes=$db->fetch_all_array("select name from classes where id IN(select DISTINCT(class_id) from classes_instructors where instructor_id ='" . $result_instructors[$instructor]['id'] . "' )");
                      $total_ins_class=count($ins_classes);
                      if($total_ins_class > 0){?>
                      	 <p><span>Classes Taught :</span> 
                      	 	<?php
                      	 	$class_name="";
							for($c=0; $c < $total_ins_class;  $c++){
								$class_name .= $ins_classes[$c]['name'] .", ";	
							}								 
							echo substr($class_name, 0, -2);
                      	 	?>
                      	 	
                      	 	</p>
						
                    <?php  }  ?>
                    
                     
                      <a class="ip" href="<?=$general_func->site_url?>gym/<?=$_REQUEST['id']?>#ainstructor_<?=$result_instructors[$instructor]['id']?>" onclick="show_instructor('<?=$result_instructors[$instructor]['id']?>');">View Profile</a> </div>
              		</li>
				<?php }

				$instructor_ids=substr($instructor_ids,0,-1);
				 ?>
            	
                
               
                </ul>
                
                <form name="frminstructors"><input type="hidden" name="instructor_ids" value="<?=$instructor_ids?>" /></form>
                
            <div class="clear"></div>
          </div>
            </div>
      
        
      </div>
        </div>
  </div>
    </div>
    <?php
    $classes_sql="select * from classes where status=1 and id IN (select DISTINCT(class_id) from classes_scheduled where gym_id ='" . $result[0]['id'] . "' and status=1)";
      $result_classes=$db->fetch_all_array($classes_sql);
	 $total_classes=count($result_classes);
    ?>
    
    <script type="text/javascript">
	
	
	
	
		$(function(){
			<?php for($k=0; $k < $total_classes;  $k++){?> 
				$('#products_inner<?=$k?>').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				effect: 'slide, fade',
				crossfade: true,
				slideSpeed: 350,
				fadeSpeed: 500,
				generateNextPrev: true,
				generatePagination: false
			});	
			<?php }	?>
			
					
		});
		jQuery(document).ready(function() {
			<?php for($k=0; $k < $total_classes;  $k++){?> 
				jQuery('#mycarousel_inner<?=$k?>').jcarousel({
				auto: 0,
				wrap: 'last',
				initCallback: mycarousel_initCallback
				});
			<?php }	?>	
			
		});
		
		</script>
    
    


<div class="main_container">

      <div class="main">
      <?php
      $class_ids="";
      
	 for($k=0; $k < $total_classes;  $k++){ 	
	 	
	 	$class_ids .= $result_classes[$k]['id'].",";
		
		$sql_photos="select photo_name from classes_photos where class_id='" . $result_classes[$k]['id'] . "' and photo_name IS NOT NULL";
		$result_photos=$db->fetch_all_array($sql_photos);		
		$total_photos=count($result_photos);
				
		$videos_links=array();
		$videos_links=explode(",",$result_classes[$k]['youtube_videos']);
		
		$video_array=array();
		
		
		$total=count($videos_links);
		
		$class_vid=0;
		
		for($i=0; $i <$total; $i++){
			if(trim($video_array[$i]) != NULL ){
				$video_array[$class_vid]['link']="<iframe width=\"475\" height=\"372\" src=\"http://www.youtube.com/embed/" . str_replace("http://youtu.be/","", $videos_links[$i]) . "\" frameborder=\"0\" allowfullscreen></iframe>";	
				$video_array[$class_vid++]['img']="http://img.youtube.com/vi/" . str_replace("http://youtu.be/","", $videos_links[$i]) . "/0.jpg";
			}
		}
	 	?>
	 	
	 	
	 	<div class="class-detail class_table_detail"  style="display: none;" id="class_details_<?=$result_classes[$k]['id']?>">
          	<a name="aclass_<?=$result_classes[$k]['id']?>"></a>
          
          <div class="close_class_detail"></div>
          <div class="left-side">
        <h3><a><?=$result_classes[$k]['name']?></a></h3>
        <h4>Class Description</h4>
        <p><?=nl2br($result_classes[$k]['description'])?></p>
        <?php
      	$rs_instructor=mysql_query("select id,name from instructors where id IN(select DISTINCT(instructor_id) from classes_instructors where class_id='" . $result_classes[$k]['id'] . "')");
        
		if(count($rs_instructor) > 0){?>
			<h4>Class Instructor(s)</h4>
			 <p>
			<?php
			$instructor="";
			while($row=mysql_fetch_object($rs_instructor)){
				$instructor .="<a onclick=\"close_timetabletab_open_teamtaband_instructor(" . $row->id . "," . $result_classes[$k]['id'] . ")\">" . $row->name . "</a>, ";
			}
			echo substr($instructor,0,-2);
			?></p>
		<?php } ?>
		
		<?php
      	$rs_cat=mysql_query("select id,name from category where id IN(select DISTINCT(category_id) from classes_categories where class_id='" . $result_classes[$k]['id'] . "')");
        
		if(count($rs_cat) > 0){?>
			<h4>Categories</h4>
			 <p>
			<?php
			$cat="";
			while($row=mysql_fetch_object($rs_cat)){
				$cat .= $row->name . ", ";
			}
			echo substr($cat,0,-2);
			?></p>
		<?php } ?>
		
        
        <h4>Class Time</h4>
         <ul class="short_li short_li_2" id="duration_<?=$result_classes[$k]['id']?>"></ul>
      
       
      </div>
          <div class="right-side"> 
    
        <div class="inner_frame_slider">
              <div class="gym_slider">
            <div class="container_inner">
                  <div class="products_example">
                  	<?php
                  	$total_photos=count($result_photos);
				
					
					if( $total_photos > 0 || count($video_array) > 0 ){ ?>
					<div class="products" id="products_inner<?=$k?>">
                      <div class="slides_container"> 
                      	
                      	<?php
                	
                	
					for($photo=0; $photo < $total_photos; $photo++){ ?>
						<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><img src='class_photo/<?=$result_photos[$photo]['photo_name']?>' class="the_gallery_image" /></td>
                    </tr>
                  </table>
                  </span> </a> 
						
				<?php }	
				reset($result_photos);
				
				 for($j=0; $j < count($video_array); $j++){?>
				 	
				 	<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><?=$video_array[$j]['link']?></td>
                    </tr>
                  </table>
                  </span> </a> 				 	
				 <?php }	 	?>
                      	
                      	</div>
                      
                      <!-- pagination -->
                      <div class="scroller">
                    <div class=" jcarousel-skin-tango">
                          <div class="jcarousel-container jcarousel-container-horizontal">
                        <div class="jcarousel-clip jcarousel-clip-horizontal">
                              <ul id="mycarousel_inner<?=$k?>" class="pagination">
                            <?php for($photo=0; $photo < $total_photos; $photo++){ ?>
                        	 <li><a><img src="<?=$general_func->site_ur?>class_photo/medium/<?=$result_photos[$photo]['photo_name']?>" /></a></li>
						 <?php }

						 for($j=0; $j < count($video_array); $j++){?>
						 	<li><a><img src="<?=$video_array[$j]['img']?>"></a></li>
						 <?php }	 	?>
                          </ul>
                            </div>
                        <div class="jcarousel-prev jcarousel-prev-horizontal" style="display: block;" disabled="false"> </div>
                        <div class="jcarousel-next jcarousel-next-horizontal" style="display: block;" disabled="false"> </div>
                      </div>
                        </div>
                  </div>
                      <!-- pagination --> 
                    </div>	
						
						
						
					<?php } ?>
                  	
                  	
                
              </div>
                </div>
          </div>
            </div>
       
      </div>
          <div class="clear"></div>
        </div>
		
	 <?php } 
	 


	 $class_ids=substr($class_ids,0,-1);
	 ?>	
      	
      	 <form name="frmclasses"><input type="hidden" name="class_ids" value="<?=$class_ids?>" /></form>
    
       <?php
       	reset($result_instructors);
       
     	for($instructor=0; $instructor < $total_instructors;  $instructor++){ ?>
     		
     		 <div class="class-detail class_profile_detail contentPnl" style="display: none;" id="instructor_<?=$result_instructors[$instructor]['id']?>">
           <a name="ainstructor_<?=$result_instructors[$instructor]['id']?>"></a>
          <div class="close_class_detail"></div>
          <!-- class profile -->
          <div class="class_profile">
        <div class="class_profile_info">
              <div class="class_profile_img_block">
              	 <?php                	
                	$img="instructor/".$result_instructors[$instructor]['photo_name'];						
					if(!file_exists($img) || trim($result_instructors[$instructor]['photo_name']) == NULL)
							$img="images/instructor-no-image-small.jpg";
					?>
					<img src="<?=$img?>"   />
              	
              	
              </div>
              <!--<h5>Area</h5>
              <h6><?=$result_instructors[$instructor]['area']?>, <?=$result_instructors[$instructor]['county']?></h6>-->
            </div>
        <div class="class_profile_detail_content">
              <h3><?=$result_instructors[$instructor]['name']?></h3>
              <h4>About</h4>
              <p><?=$result_instructors[$instructor]['description']?></p>
              <h4>Qualification</h4>
             <p><?=$result_instructors[$instructor]['qualification']?></p>          
            </div>
      </div>
          <!-- class profile -->
          <div class="clear"></div>
        </div>
			
		<?php } ?> 
        
   
  </div>
    </div>   
    
    
<div class="main_container">
      <div class="main">
    <div class="social-feed">
          <div class="twitter-feed"><?=$result[0]['twitter_tweets_page_link']?></div>
          <div class="facebook-feed">
          	<div class="fb-like-box" data-href="<?=$result[0]['facebook_fan_page_link']?>" data-width="476" data-height="369" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="true"></div>
          	</div>
        </div>
  </div>
    </div>
<?php include_once("includes/footer.php");?>