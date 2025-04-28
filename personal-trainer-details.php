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
		$data['email']=trim($_REQUEST['email']);			
		$data['phone']=trim($_REQUEST['phone']);		
		$data['message']=trim($_REQUEST['message']);
		$data['trainer_name']=$_REQUEST['gym_name'];		
		$data['added_date']='now()';			
		$db->query_insert("contact_trainer_message",$data);
		
		$_SESSION['user_message'] ="Your contact details has been sent to '" . $_REQUEST['gym_name'] . "'.";
		
		$general_func->header_redirect($general_func->site_url."personal-trainer/".$_REQUEST['id']);
}



if(isset($_REQUEST['enter']) && $_REQUEST['enter']=="flag"){
		
	
	$email_content='<tr>
						<td align="left" valign="top" style="padding:20px; margin:0; line-">
					    	<table width="700" cellspacing="3" cellpadding="6" border="0" align="center" style="line-height: 25px;">
					        	<tr>
					            	<td  width="700" colspan="2" align="left" style="font:normal 13px/22px Georgia," ><strong> Dear Administrator,</strong></td>
					               
					              </tr>	
					              <tr>
					            	<td  width="700" colspan="2" align="left" style="font:normal 13px/22px Georgia," ><strong> A viewer of  '.$general_func->site_title .' flag this personal trainer.</strong></td>
					               
					              </tr>	
					        	
					        	<tr>
					            	<td width="100" align="left" style="font:normal 13px/22px Georgia," ><strong> Trainer Name:</strong></td>
					                 <td width="600" align="left" style="font:normal 13px/22px Georgia,">' . $_REQUEST['gym_name'] . '</td>
					              </tr>
					              						                               
					             <tr>
					                 <td align="left" style="font:normal 13px/22px Georgia, " ><strong>Trainer Email Address:</strong></td>
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
		$recipient_info['recipient_subject']=$general_func->site_title ." viewer flag a personal trainer";
		$recipient_info['recipient_content']=$email_content;
		$recipient_info['recipient_email']=$general_func->email;		
		$sendmail -> send_email($recipient_info, $general_func->email,$general_func->site_title, $general_func->site_url);	
		//***************************************************************//			
		
		
		$_SESSION['user_message'] ="Your message has been sent to the site administrator.";		
		$general_func->header_redirect($general_func->site_url."personal-trainer/".$_REQUEST['id']);
}








$id=$_REQUEST['id'];
$sql="select *	from personal_trainers where seo_link= '" . $id . "' and email_confirmed=1 and status=1 and membership_type=2 and (membership_end IS NULL or membership_end >=$today_date) limit 1";				
$result=$db->fetch_all_array($sql);


$sql_photos="select photo_name from trainer_photos where trainer_id='" . $result[0]['id'] . "'";
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


?>


<script>


function check_validate(){
	if(!validate_text(document.frmcontactus.fname,1,"Blank space not allowed. Please Enter Your First  Name."))
		return false;	
	/*if(!validate_text(document.frmcontactus.lname,1,"Blank space not allowed. Please Enter Your Last Name."))
		return false;*/			
	if(!validate_email(document.frmcontactus.email,1,"Blank space not allowed. Enter Email Address"))
		return false;	

	/*if(!validate_text(document.frmcontactus.phone,1,"Blank space not allowed. Please Enter Contact Phone."))
		return false;		*/
	
	if(!validate_text(document.frmcontactus.message,1,"Blank space not allowed. Please Let us Know Your Message."))
	   return false;		
	
}

function flag_validate(){	
	
	if(!validate_text(document.frmflag.message,1,"Blank space not allowed. Please Let us Know Your Message."))
	   return false;		
	
}

function open_page(website){ 
	xmlhttp.open("GET","<?=$general_func->site_url?>calculate-outbound-link.php?type=2&id="+<?=$result[0]['id']?>,false);
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
        <form name="frmcontactus" method="post"  action="personal-trainer/<?=$_REQUEST['id']?>" onsubmit="return check_validate();">
		<input type="hidden" name="enter" value="contactus"  />
		<input type="hidden" name="gym_name"  value="<?=$result[0]['name']?>" />
		<input type="hidden" name="gym_email"  value="<?=$result[0]['email_address']?>" />		
        	
        	
              <div class="pop_head">
            <div class="pop_icon"><img src="images/contact_gym_image.png" /></div>
            <div class="pop_name">
                  <h5>Contact Personal Trainer</h5>
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
                <label>Your Message<span>*</span></label>
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
        
        <p class="special_form_note">* denotes that the field is mandatory</p>
        
      </div>
        </div>
  </div>
    </div>
<!-- pop --> 

	
<div class="row">
      <div class="main_container">
    <div class="pnlOne"> 
          
          <!-- slider -->
          
          <div class="gym_detail_left">
        <div class="gym_slider">
              <div class="container">
            <div class="products_example">
                  <div class="products" id="product_trainer">
                  	
                  <?php
            	$total_photos=count($result_photos);				
				$total_gallery= count($video_array);
				if($total_photos == 0 && $total_gallery ==  0 && trim($result[0]['logo_name']) == NULL){
					echo '<img src="images/big_no_image.jpg" alt="" />';					
				}else{ ?>
					<div class="slides_container"> 
                	<?php
						if(trim($result[0]['logo_name']) != NULL){?>
							<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><img src='trainer_logo/<?=trim($result[0]['logo_name'])?>' class="the_gallery_image" /></td>
                    </tr>
                  </table>
                  </span> </a> 
							
						<?php }             	
                	
					for($photo=0; $photo < $total_photos; $photo++){ ?>
						<a> <span class='zoom' id='ex1'>
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td><img src='trainer_photo/<?=$result_photos[$photo]['photo_name']?>' class="the_gallery_image" /></td>
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
                        <ul id="mycarousel_trainer" class="pagination">
                        <?php
						if(trim($result[0]['logo_name']) != NULL){?>
							<li><a><img src="trainer_logo/small/<?=trim($result[0]['logo_name'])?>"></a></li>							
						<?php }
                        	
                              for($photo=0; $photo < $total_photos; $photo++){ ?>
                        	 <li><a><img src="trainer_photo/medium/<?=$result_photos[$photo]['photo_name']?>"></a></li>
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
					
				<?php }	?>
                 
              </div>
                </div>
          </div>
            </div>
      </div>
          
          <!-- slider -->
          
          <div class="halfPnl">
        <div class="dtlsPnl">
              <h3><?=$result[0]['name']?></h3>
              <!--<h3 class="bio_of_trainer"></h3>-->
              <p><?=$result[0]['area']?>, <?=$result[0]['county']?></p>
              
            <?php if(trim($result[0]['price_per_session']) != NULL && intval($result[0]['price_per_session']) > 0){ ?>
            	 <p><strong>Price Per Session</strong></p>
              <h4>&euro; <?=trim($result[0]['price_per_session'])?></h4>
           <?php  }  ?>              
             
              <div class="div_clear"></div>
              <div class="inner_button"><a class="popclick1 contact_to_gym">Contact Trainer</a></div>
              <div class="gym_share">
                   <!-- flag form -->
           <form name="frmflag" method="post"  action="personal-trainer/<?=$_REQUEST['id']?>" onsubmit="return flag_validate();">
		<input type="hidden" name="enter" value="flag"  />  
		<input type="hidden" name="gym_name"  value="<?=$result[0]['name']?>" />
		<input type="hidden" name="gym_email"  value="<?=$result[0]['email_address']?>" />		      
        <div class="flag_form">
        <label>Enter your message for site administrator<span style="color:#FFF;">*</span></label>
        <textarea name="message"></textarea>
        <input type="submit" value="Submit" />
         <input type="button" value="Close" class="flag_form_close" />
          <p class="special_form_note" style="color:#FFF !important;">* denotes that the field is mandatory</p>
        </div>
        </form>
        <!-- flag form -->
              
            <div class="gym_share_block gym_share_block_flag"><img src="images/flag.png" /><strong>Flag</strong></div>
            <div class="gym_share_block"><span class='st_sharethis_large' displayText='ShareThis'></span> <span class='st_facebook_large' displayText='Facebook'></span> <span class='st_twitter_large' displayText='Tweet'></span> <span class='st_linkedin_large' displayText='LinkedIn'></span> <span class='st_pinterest_large' displayText='Pinterest'></span> <span class='st_email_large' displayText='Email'></span></div>
            <div class="div_clear"></div>
            <div class="gym_share_block" style="height:auto; padding-top:7px; padding-bottom:7px;">
                  <div class="fb-like" data-href="http://gymme.ie/personal-trainer/<?=$_REQUEST['id']?>" data-layout="standard" data-action="recommend" data-show-faces="true" data-share="false"></div>
                </div>
          </div>
            </div>
      </div>
        </div>
  </div>
    </div>
<div class="row">
      <div class="main_container">
      	
      	
      	
      	
    <div class="contentPnl">
    	
    		<?php
          	if(trim($result[0]['experience']) != NULL){
          		echo '<h1>About ' . $result[0]['name'] . '</h1>';
				echo '<p>' . trim($result[0]['experience']) . '</p>';
          	}
			
			if(trim($result[0]['short_info']) != NULL){
          		echo '<h1>Additional Info</h1>';
				echo '<p>' . trim($result[0]['short_info']) . '</p>';
          	}

			if(trim($result[0]['special_offers']) != NULL){
          		echo '<h1>Special Offers</h1>';
				echo '<p>' . trim($result[0]['special_offers']) . '</p>';
          	}
						
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
          	?>
        
    	<div class="normal_left_right_row">
          <div class="left">          	
          	
          	<?php
            	$qualification="";					
              	if(trim($result[0]['qualification1']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification1']) ."</li>";	
				if(trim($result[0]['qualification2']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification2']) ."</li>";	
				if(trim($result[0]['qualification3']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification3']) ."</li>";	
				if(trim($result[0]['qualification4']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification4']) ."</li>";	
				if(trim($result[0]['qualification5']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification5']) ."</li>";	
				
				
				if(trim($result[0]['qualification6']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification6']) ."</li>";	
				if(trim($result[0]['qualification7']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification7']) ."</li>";	
				if(trim($result[0]['qualification8']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification8']) ."</li>";	
				if(trim($result[0]['qualification9']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification9']) ."</li>";	
				if(trim($result[0]['qualification10']) != NULL)
					$qualification .="<li>" . trim($result[0]['qualification10']) ."</li>";	
				
			
			if(trim($qualification) != NULL){ ?>
				 <h1>Qualifications</h1>
       		 <ul>
              <?=$qualification?>
            </ul>
				
			<?php } ?>
          	
          	
       
      </div>
          <div class="right">
          	
          <?php
            	$specialty="";					
              	if(trim($result[0]['specialty1']) != NULL)
					$specialty .="<li>" . trim($result[0]['specialty1']) ."</li>";	
				if(trim($result[0]['specialty2']) != NULL)
					$specialty .="<li>" . trim($result[0]['specialty2']) ."</li>";	
				if(trim($result[0]['specialty3']) != NULL)
					$specialty .="<li>" . trim($result[0]['specialty3']) ."</li>";	
				if(trim($result[0]['specialty4']) != NULL)
					$specialty .="<li>" . trim($result[0]['specialty4']) ."</li>";	
				if(trim($result[0]['specialty5']) != NULL)
					$specialty .="<li>" . trim($result[0]['specialty5']) ."</li>";	
				
				
				if(trim($specialty) != NULL){?>
				<h1>Specialities</h1>
		        <ul><?=$specialty?></ul>	
				<?php }						
            ?>	
      </div>
      </div>
      
      
        </div>
  </div>
    </div>
<div class="main_container">
      <div class="main">
    <div class="social-feed">
          <div class="twitter-feed"><?=$result[0]['twitter_tweets_page_link']?></div>
          <div class="facebook-feed"><div class="fb-like-box" data-href="<?=$result[0]['facebook_fan_page_link']?>" data-width="676" data-height="369" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="true" data-show-border="true"></div></div>
        </div>
  </div>
    </div>

<?php include_once("includes/footer.php");?>