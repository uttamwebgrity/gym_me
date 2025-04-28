<?php
/*if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!="on"){
	header("location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}*/
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

$REQUEST_URI=@explode("/",$_SERVER['REQUEST_URI']);

if(in_array("forum",$REQUEST_URI))
	$path_depth="../";
else
	$path_depth="";
	
include_once($path_depth ."includes/configuration.php");

$q_string=basename($_SERVER['QUERY_STRING']);	

if(basename($_SERVER['PHP_SELF'])!="custom-page.php")
	$q_string="";


$dynamic_content=$db_Gym_Bid->static_page_content(basename($_SERVER['PHP_SELF']),$q_string);
$REQUEST_URI=explode("/",$_SERVER['REQUEST_URI']);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
	<title>
    <?=$dynamic_content['page_title']?>
    </title>
	<meta name="keywords" content="<?=$dynamic_content['page_keywords']?>" />
	<meta name="description" content="<?=$dynamic_content['page_description']?>" />
	<meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT"/>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache"/>
	<base href="<?=$general_func->site_url?>" />
	<link rel="Shortcut Icon" href="images/favicon.ico"/>
	<!-- main css -->
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css" />
	<!-- main css -->

	<!-- main js -->
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript" src="js/external.js"></script>
	<!--<link rel="stylesheet" href="css/jquery-ui.css">-->

	<!-- main js -->

	<!-- tab -->
	<script type="text/javascript" src="js/tabs.js"></script>
	<script type="text/javascript">
$(document).ready(function(){
$('#tabs a').tabs();
});


//$(function() {
//$( document ).tooltip();
//});


</script>
	<!-- tab -->

	<!-- zoom -->
	<link rel="stylesheet" type="text/css" href="css/zoom_style.css" />

	<!-- zoom -->

	<!-- scroller -->
	<script src="js/jquery.jcarousel.min.js" type="text/javascript" ></script>
	<script type="text/javascript">
function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};


    
    jQuery(document).ready(function() {
jQuery('#mycarousel_top').jcarousel({
auto: 0,
wrap: 'last',
initCallback: mycarousel_initCallback
});
});


    jQuery(document).ready(function() {
jQuery('#mycarousel_trainer').jcarousel({
auto: 0,
wrap: 'last',
initCallback: mycarousel_initCallback
});
});





</script>


	<link rel="stylesheet" type="text/css" href="css/skin.css" />
	<!-- scroller -->

	<!-- slider -->
	<script src="js/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#products_top').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				effect: 'slide, fade',
				crossfade: true,
				slideSpeed: 350,
				fadeSpeed: 500,
				generateNextPrev: true,
				generatePagination: false
			});
			
				$('#product_trainer').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				effect: 'slide, fade',
				crossfade: true,
				slideSpeed: 350,
				fadeSpeed: 500,
				generateNextPrev: true,
				generatePagination: false
			});
			
			
			
		});
		
		
		
		
		
	</script>
	<!-- slider -->

	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "ur-25813e41-6340-3a44-34eb-42e73292741", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<!-- equal height -->
	<script>
$(document).ready(function(){

    
        $('.membership_row').each(function(){  
            
            var highestBox = 0;
            $('.membership_block', this).each(function(){
            
                if($(this).height() > highestBox) 
                   highestBox = $(this).height(); 
            });  
            
            $('.membership_block',this).height(highestBox);
            
        
    });    
    
    
   

});

</script>

	<!-- equal height -->

	<!-- equal height -->

	<script type="text/javascript" src="js/jquery.equalheights.js"></script>
	<script>
$(window).load(function() {
	//$(".search_result_block").equalHeights();
	
$('.search_result_row').each(function(){  
            
            var highestBox = 0;
            $('.search_result_block .search_td', this).each(function(){
            
                if($(this).height() > highestBox) 
                   highestBox = $(this).height(); 
            });  
            
            $('.search_result_block .search_td',this).height(highestBox);
            
        
    });
	
	
	
	
	
	$('.search_result_row').each(function(){  
            var highestBox = 0;
          $('.search_result_block', this).each(function(){
            
               if($(this).height() > highestBox) 
                  highestBox = $(this).height(); 
          });  
            
         $('.search_result_block',this).height(highestBox);
            
        
 });
	
	
	
});
</script>
	<script>


</script>
<script type="text/javascript" src="includes/validator.js"></script>
<script type="text/javascript" src="includes/xmlhttp.js"></script>
	
	   
<script type="text/javascript">	

function gym_login_validate(){
						
	if(!validate_text(document.frmgymlogin.email_address,1,"Enter Email Address "))
		return false;
							
	if(!validate_text(document.frmgymlogin.password,1,"Enter Password"))
		return false;		
						
}
					
function gym_passord_forgot_validate(){
						
	if(!validate_text(document.frmgym_password_forgot.email_address,1,"Enter Email Address "))
		return false;
								
	if(!validate_email(document.frmgym_password_forgot.email_address,1,"Enter a Valid Email Address"))
		return false;		
}

function trainer_login_validate(){
						
	if(!validate_text(document.frmtrainerlogin.email_address,1,"Enter Email Address "))
		return false;
							
	if(!validate_text(document.frmtrainerlogin.password,1,"Enter Password"))
		return false;		
						
}
					
function trainer_passord_forgot_validate(){
						
	if(!validate_text(document.frmtrainer_password_forgot.email_address,1,"Enter Email Address "))
		return false;
								
	if(!validate_email(document.frmtrainer_password_forgot.email_address,1,"Enter a Valid Email Address"))
		return false;		
}
	
					
					
</script>
	
	<script type="text/javascript">	
				
			function registration_validate(){
				
				if(!validate_text(document.frmgymregistration.name,1,"Enter Gym Name"))
					return false;	
				
				if(!validate_email(document.frmgymregistration.email_address,1,"Enter Email Address"))
					return false;	
					
				if(!validate_text(document.frmgymregistration.street_address,1,"Enter Street Address"))
					return false;	
				
				if(!validate_text(document.frmgymregistration.town,1,"Enter Gym Town"))
						return false;
					
				if(document.frmgymregistration.county.selectedIndex == 0){
					alert("Please select a county");
					document.frmgymregistration.county.focus();
					return false;
				}	
					
				if(document.frmgymregistration.area.selectedIndex == 0){
					alert("Please select an area");
					document.frmgymregistration.area.focus();
					return false;
				}	
					
				if(!validate_text(document.frmgymregistration.password,1,"Enter Password"))
					return false;
					
				if(!validate_text(document.frmgymregistration.cpassword,1,"Enter Confirm Password"))
					return false;	
					
				if(document.frmgymregistration.password.value != document.frmgymregistration.cpassword.value){
					alert("Your password and confirm password must be same");
					document.frmgymregistration.cpassword.focus();
					return false;	
				}	
			}
			
			
			
			
			function trainer_validate(){
				
				if(!validate_email(document.frmtrainerregistration.email_address,1,"Enter Email Address"))
					return false;	
				
				if(!validate_text(document.frmtrainerregistration.name,1,"Enter Trainer Name"))
					return false;	
				
				
				/*if(!validate_text(document.frmtrainerregistration.price_per_session,1,"Enter Trainer Price Per Session"))
					return false;
				
				
				if(!validate_price(document.frmtrainerregistration.price_per_session,1,"Enter a Valid Price Per Session"))
					return false; */
				
					
				if(!validate_text(document.frmtrainerregistration.street_address,1,"Enter Street Address"))
					return false;	
				
				if(!validate_text(document.frmtrainerregistration.town,1,"Enter Trainer Town"))
						return false;
					
				if(document.frmtrainerregistration.county.selectedIndex == 0){
					alert("Please select a county");
					document.frmtrainerregistration.county.focus();
					return false;
				}	
					
				if(document.frmtrainerregistration.area.selectedIndex == 0){
					alert("Please select an area");
					document.frmtrainerregistration.area.focus();
					return false;
				}	
					
				if(!validate_text(document.frmtrainerregistration.password,1,"Enter Password"))
					return false;
					
				if(!validate_text(document.frmtrainerregistration.cpassword,1,"Enter Confirm Password"))
					return false;	
					
				if(document.frmtrainerregistration.password.value != document.frmtrainerregistration.cpassword.value){
					alert("Your password and confirm password must be same");
					document.frmtrainerregistration.cpassword.focus();
					return false;	
				}	
			}			
					




		
</script>	


<script language="javascript" type="text/javascript">
	jQuery(window).load(function() {
	jQuery('#preloader').hide("fast");


});
</script>

	<!-- equal height -->

	</head>

<div id="preloader">
	<div class="preloader_container"><img src="images/loader.gif" id="preloader_image" ></div>
</div>

	<body>
		
		
		
		
<!-- pop -->
<?php  if(isset($_SESSION['user_login']) && trim($_SESSION['user_login']) =="yes"){ ?>
	<!-- pop -->


<?php }else{ ?>
	
	<div class="pop"> </div>
<div class="popup">
      <div class="close_pop">
    <div class="cross"></div>
    <span>Close</span></div>
      <div class="pop_box">
    <div class="left_ring"></div>
    <div class="right_ring"></div>
    <div class="pop_main_container"> 
          
          <!-- select account -->
          <div class="select_account for_sign_up_type">
        <div class="type_block gym_type_block gym_type_block_up"> <img src="images/gym_type_image.png" />
              <div class="type_tag">Gym</div>
            </div>
        <div class="select_type_note">Select Account</div>
        <div class="type_block trainer_type_block trainer_type_block_up"> <img src="images/trainer_type_image.png" />
              <div class="type_tag">Personal Trainer</div>
            </div>
      </div>
          <!-- select account --> 
          
          <!-- select account -->
          <div class="select_account for_sign_in_type">
        <div class="type_block gym_type_block gym_type_block_in"> <img src="images/gym_type_image.png" />
              <div class="type_tag">Gym</div>
            </div>
        <div class="select_type_note">Select Account</div>
        <div class="type_block trainer_type_block trainer_type_block_in"> <img src="images/trainer_type_image.png" />
              <div class="type_tag">Personal Trainer</div>
            </div>
      </div>
          <!-- select account -->
          
          <div class="pop_main"> 
        
        <!-- gym log in -->
        <div class="pop_form gym_login">
              <div class="pop_head">
            <div class="pop_icon"><img src="images/gym_pop_icon.png" /></div>
            <div class="pop_name">
                  <h5>Gym</h5>
                  <h6>Login</h6>
                </div>
          </div>
           
              
             <form  method="post" name="frmgymlogin" action="<?=$general_func->site_url?>" onsubmit="return gym_login_validate();">
				
              <div class="tab_form normal_loin_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Email Address<span>*</span></label>
                <input type="text" name="email_address"  placeholder="Enter  email address" />
              </div>
                  <div class="tab_form_block">
                <label>Password<span>*</span></label>
                <input type="password" name="password" placeholder="Enter password" />
                <input type="hidden" name="submit" value="gym_login" />
              </div>
                </div>
            <!-- row -->
            
            <div class="tab_form_row" style="margin-top:0px;">
                  <input type="submit" value="Submit" />
                  <div class="forgot_pass">Forgot password?</div>
                </div>
          </div>
           </form> 
              
             <form name="frmgym_password_forgot" method="post" action="<?=$general_func->site_url?>" onsubmit="return gym_passord_forgot_validate();">
				
              <div class="tab_form forgot_pass_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Email Address<span>*</span></label>
                <input type="text" name="email_address" placeholder="Enter  email address" />
              </div>
                </div>
            <!-- row -->
            
            <div class="tab_form_row" style="margin-top:0px;">
                  <input type="submit" value="Submit" />
                  <input type="hidden" name="submit" value="gymforgot" />
                  <div class="again_login">Log In</div>
                </div>
          </div>
          </form>  
            
            </div>
        <!-- gym log in --> 
        
        <!-- gym registration -->
        <div class="pop_form gym_registration">
              <div class="pop_head">
            <div class="pop_icon"><img src="images/gym_pop_icon.png" /></div>
            <div class="pop_name">
                  <h5>Gym</h5>
                  <h6>Registration</h6>
                </div>
          </div>
              
		
              
              <!-- form -->
         	<form method="post" action="<?=$general_func->site_url?>"  name="frmgymregistration"   onsubmit="return registration_validate()">
        	<input type="hidden" name="enter" value="gymregistration" />
              
              
              <div class="tab_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Gym Name<span>*</span></label>
                <input type="text" name="name" value="<?=$_SESSION['gym_register']['name']?>" placeholder="Enter Gym Name" />
              </div>
                  <div class="tab_form_block">
                <label>Email Address<span>*</span></label>
                <input type="text"  name="email_address" value="<?=$_SESSION['gym_register']['email_address']?>" placeholder="Enter  email address" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Website URL</label>
                <input type="text" name="website_URL" value="<?=$_SESSION['gym_register']['website_URL']?>" placeholder="http://" />
              </div>
                  <div class="tab_form_block">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?=$_SESSION['gym_register']['phone']?>" placeholder="Enter  phone number" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Street Address<span>*</span></label>
                <input type="text"  name="street_address" value="<?=$_SESSION['gym_register']['street_address']?>" placeholder="Enter Street Address" />
              </div>
                  <div class="tab_form_block">
                <label>Town<span>*</span></label>
                <input type="text"  name="town" value="<?=$_SESSION['gym_register']['town']?>"  placeholder="Enter Town" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
            	 <div class="tab_form_block">
                <label>
                Area<span>*</span>
                <div title="It is said that what is area."></div>
                </label>
                <div class="select_box">
                      <select name="area">
                    <option value="" <?=$_SESSION['gym_register']['area']==""?'selected="selected"':'';?>>Select</option>
                    <option value="Dublin 1" <?=trim($_SESSION['gym_register']['area'])=="Dublin 1"?'selected="selected"':'';?>>Dublin 1</option>
                        <option value="Dublin 2" <?=trim($_SESSION['gym_register']['area'])=="Dublin 2"?'selected="selected"':'';?>>Dublin 2</option>
                        <option value="Dublin 3" <?=trim($_SESSION['gym_register']['area'])=="Dublin 3"?'selected="selected"':'';?>>Dublin 3</option>
                        <option value="Dublin 4" <?=trim($_SESSION['gym_register']['area'])=="Dublin 4"?'selected="selected"':'';?>>Dublin 4</option>
                        <option value="Dublin 5" <?=trim($_SESSION['gym_register']['area'])=="Dublin 5"?'selected="selected"':'';?>>Dublin 5</option>
                        <option value="Dublin 6" <?=trim($_SESSION['gym_register']['area'])=="Dublin 6"?'selected="selected"':'';?>>Dublin 6</option>
                        <option value="Dublin 6W" <?=trim($_SESSION['gym_register']['area'])=="Dublin 6W"?'selected="selected"':'';?>>Dublin 6W</option>
                        <option value="Dublin 7" <?=trim($_SESSION['gym_register']['area'])=="Dublin 7"?'selected="selected"':'';?>>Dublin 7</option>
                        <option value="Dublin 8" <?=trim($_SESSION['gym_register']['area'])=="Dublin 8"?'selected="selected"':'';?>>Dublin 8</option>
                        <option value="Dublin 9" <?=trim($_SESSION['gym_register']['area'])=="Dublin 9"?'selected="selected"':'';?>>Dublin 9</option>
                        <option value="Dublin 10" <?=trim($_SESSION['gym_register']['area'])=="Dublin 10"?'selected="selected"':'';?>>Dublin 10</option>
                        <option value="Dublin 11" <?=trim($_SESSION['gym_register']['area'])=="Dublin 11"?'selected="selected"':'';?>>Dublin 11</option>
                        <option value="Dublin 12" <?=trim($_SESSION['gym_register']['area'])=="Dublin 12"?'selected="selected"':'';?>>Dublin 12</option>
                        <option value="Dublin 13" <?=trim($_SESSION['gym_register']['area'])=="Dublin 13"?'selected="selected"':'';?>>Dublin 13</option>
                        <option value="Dublin 14" <?=trim($_SESSION['gym_register']['area'])=="Dublin 14"?'selected="selected"':'';?>>Dublin 14</option>
                        <option value="Dublin 15" <?=trim($_SESSION['gym_register']['area'])=="Dublin 15"?'selected="selected"':'';?>>Dublin 15</option>
                        <option value="Dublin 16" <?=trim($_SESSION['gym_register']['area'])=="Dublin 16"?'selected="selected"':'';?>>Dublin 16</option>
                        <option value="Dublin 17" <?=trim($_SESSION['gym_register']['area'])=="Dublin 17"?'selected="selected"':'';?>>Dublin 17</option>
                        <option value="Dublin 18" <?=trim($_SESSION['gym_register']['area'])=="Dublin 18"?'selected="selected"':'';?>>Dublin 18</option>
                        <option value="Dublin 19" <?=trim($_SESSION['gym_register']['area'])=="Dublin 19"?'selected="selected"':'';?>>Dublin 19</option>
                        <option value="Dublin 20" <?=trim($_SESSION['gym_register']['area'])=="Dublin 20"?'selected="selected"':'';?>>Dublin 20</option>
                        <option value="Dublin 21" <?=trim($_SESSION['gym_register']['area'])=="Dublin 21"?'selected="selected"':'';?>>Dublin 21</option>
                        <option value="Dublin 22" <?=trim($_SESSION['gym_register']['area'])=="Dublin 22"?'selected="selected"':'';?>>Dublin 22</option>
                        <option value="Dublin 23" <?=trim($_SESSION['gym_register']['area'])=="Dublin 23"?'selected="selected"':'';?>>Dublin 23</option>
                        <option value="Dublin 24" <?=trim($_SESSION['gym_register']['area'])=="Dublin 24"?'selected="selected"':'';?>>Dublin 24</option>
                        
                        <option value="Co. Dublin (North)" <?=trim($_SESSION['gym_register']['area'])=="Co. Dublin (North)"?'selected="selected"':'';?>>Co. Dublin (North)</option>
                        <option value="Co. Dublin (South)" <?=trim($_SESSION['gym_register']['area'])=="Co. Dublin (South)"?'selected="selected"':'';?>>Co. Dublin (South)</option>
                  </select>
                    </div>
              </div>
            	
            	
                  <div class="tab_form_block">
                <label>County<span>*</span></label>
                <div class="select_box">
                      <select name="county">
                    <option value="" <?=$_SESSION['gym_register']['county']==""?'selected="selected"':'';?>>Select</option>
                    <option value="Dublin" <?=$_SESSION['gym_register']['county']=="Dublin"?'selected="selected"':'';?>>Dublin</option>
                  </select>
                    </div>
              </div>
                 
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Password<span>*</span></label>
                <input type="password"  name="password" value="<?=$_SESSION['gym_register']['password']?>" placeholder="Enter password" />
              </div>
                  <div class="tab_form_block">
                <label>Confirm Password<span>*</span></label>
                <input type="password"  name="cpassword" value="<?=$_SESSION['gym_register']['cpassword']?>" placeholder="Enter confirmed password" />
              </div>
                </div>
            <!-- row -->
            
            <input type="submit" value="Submit" />
          </div>
          </form>
              <!-- form --> 
               <p class="special_form_note">* denotes that the field is mandatory</p>
            </div>
        <!-- gym registration --> 
        
        <!-- trainer login -->
        <div class="pop_form trainer_login">
              <div class="pop_head">
            <div class="pop_icon"><img src="images/trainer_pop_icon.png" /></div>
            <div class="pop_name">
                  <h5>Personal Trainer</h5>
                  <h6>Login</h6>
                </div>
          </div>
             <form  method="post" name="frmtrainerlogin" action="<?=$general_func->site_url?>" onsubmit="return trainer_login_validate();">
              <!-- form -->
              <div class="tab_form normal_loin_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Email Address<span>*</span></label>
                <input type="text" name="email_address" placeholder="Enter  email address" />
              </div>
                  <div class="tab_form_block">
                <label>Password<span>*</span></label>
                <input type="password" name="password" placeholder="Enter password" />
              </div>
                </div>
            <!-- row -->
            
            <div class="tab_form_row" style="margin-top:0px;">
                  <input type="submit" value="Submit" />
                  <input type="hidden" name="submit" value="trainer_login" />
                  <div class="forgot_pass">Forgot password?</div>
                </div>
          </div>
              <!-- form --> 
              
              <!-- form -->
              </form>
              <form name="frmtrainer_password_forgot" method="post" action="<?=$general_func->site_url?>" onsubmit="return trainer_passord_forgot_validate();">
              <div class="tab_form forgot_pass_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Email Address<span>*</span></label>
                <input type="text" name="email_address" placeholder="Enter  email address" />
              </div>
                </div>
            <!-- row -->
            
            <div class="tab_form_row" style="margin-top:0px;">
                  <input type="submit" value="Submit" />
                  <input type="hidden" name="submit" value="trainerforgot" />
                  <div class="again_login">Log In</div>
                </div>
          </div>
              <!-- form --> 
              </form> 
            </div>
        <!-- trainer login --> 
        
        <!-- trainer registration -->
        <div class="pop_form trainer_registration">
              <div class="pop_head">
            <div class="pop_icon"><img src="images/trainer_pop_icon.png" /></div>
            <div class="pop_name">
                  <h5>Personal Trainer</h5>
                  <h6>Registration</h6>
                </div>
          </div>
              
              <form method="post" action="<?=$general_func->site_url?>"  name="frmtrainerregistration"   onsubmit="return trainer_validate()">
        	<input type="hidden" name="enter" value="gymtrainer" />
              <div class="tab_form"> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Email Address<span>*</span></label>
                <input type="text" name="email_address" value="<?=$_SESSION['trainer_register']['email_addres']?>" placeholder="Enter  email address" />
              </div>
                  <div class="tab_form_block">
                <label>Trainer Name<span>*</span></label>
                <input type="text" name="name" value="<?=$_SESSION['trainer_register']['name']?>" placeholder="Enter trainer name" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Phone Number</label>
                <input type="text" name="phone"  value="<?=$_SESSION['trainer_register']['phone']?>" placeholder="Enter  phone number" />
              </div>
                  <div class="tab_form_block">
                <label>Price per Session (&euro;)</label>
                <input type="text" name="price_per_session" value="<?=$_SESSION['trainer_register']['price_per_session']?>" placeholder="Price per Session" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Street Address<span>*</span></label>
                <input type="text" name="street_address" value="<?=$_SESSION['trainer_register']['street_address']?>" placeholder="Enter Street Address" />
              </div>
                  <div class="tab_form_block">
                <label>Town<span>*</span></label>
                <input type="text" name="town" value="<?=$_SESSION['trainer_register']['town']?>" placeholder="Enter Town" />
              </div>
                </div>
            <!-- row --> 
            
            <!-- row -->
            <div class="tab_form_row">
            	 <div class="tab_form_block">
                <label>
                Area<span>*</span>
                <div title="It is said that what is area"></div>
                </label>
                <div class="select_box">
                     <select name="area">
                    <option value="" <?=$_SESSION['trainer_register']['area']==""?'selected="selected"':'';?>>Select</option>
                    <option value="Dublin 1" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 1"?'selected="selected"':'';?>>Dublin 1</option>
                        <option value="Dublin 2" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 2"?'selected="selected"':'';?>>Dublin 2</option>
                        <option value="Dublin 3" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 3"?'selected="selected"':'';?>>Dublin 3</option>
                        <option value="Dublin 4" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 4"?'selected="selected"':'';?>>Dublin 4</option>
                        <option value="Dublin 5" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 5"?'selected="selected"':'';?>>Dublin 5</option>
                        <option value="Dublin 6" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 6"?'selected="selected"':'';?>>Dublin 6</option>
                        <option value="Dublin 6W" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 6W"?'selected="selected"':'';?>>Dublin 6W</option>
                        <option value="Dublin 7" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 7"?'selected="selected"':'';?>>Dublin 7</option>
                        <option value="Dublin 8" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 8"?'selected="selected"':'';?>>Dublin 8</option>
                        <option value="Dublin 9" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 9"?'selected="selected"':'';?>>Dublin 9</option>
                        <option value="Dublin 10" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 10"?'selected="selected"':'';?>>Dublin 10</option>
                        <option value="Dublin 11" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 11"?'selected="selected"':'';?>>Dublin 11</option>
                        <option value="Dublin 12" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 12"?'selected="selected"':'';?>>Dublin 12</option>
                        <option value="Dublin 13" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 13"?'selected="selected"':'';?>>Dublin 13</option>
                        <option value="Dublin 14" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 14"?'selected="selected"':'';?>>Dublin 14</option>
                        <option value="Dublin 15" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 15"?'selected="selected"':'';?>>Dublin 15</option>
                        <option value="Dublin 16" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 16"?'selected="selected"':'';?>>Dublin 16</option>
                        <option value="Dublin 17" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 17"?'selected="selected"':'';?>>Dublin 17</option>
                        <option value="Dublin 18" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 18"?'selected="selected"':'';?>>Dublin 18</option>
                        <option value="Dublin 19" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 19"?'selected="selected"':'';?>>Dublin 19</option>
                        <option value="Dublin 20" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 20"?'selected="selected"':'';?>>Dublin 20</option>
                        <option value="Dublin 21" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 21"?'selected="selected"':'';?>>Dublin 21</option>
                        <option value="Dublin 22" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 22"?'selected="selected"':'';?>>Dublin 22</option>
                        <option value="Dublin 23" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 23"?'selected="selected"':'';?>>Dublin 23</option>
                        <option value="Dublin 24" <?=trim($_SESSION['trainer_register']['area'])=="Dublin 24"?'selected="selected"':'';?>>Dublin 24</option>
                        
                        <option value="Co. Dublin (North)" <?=trim($_SESSION['trainer_register']['area'])=="Co. Dublin (North)"?'selected="selected"':'';?>>Co. Dublin (North)</option>
                        <option value="Co. Dublin (South)" <?=trim($_SESSION['trainer_register']['area'])=="Co. Dublin (South)"?'selected="selected"':'';?>>Co. Dublin (South)</option>
                  </select>
                    </div>
              </div>
            	
                  <div class="tab_form_block">
                <label>County<span>*</span></label>
                <div class="select_box">
                      <select name="county">
                    <option value="" <?=$_SESSION['trainer_register']['county']==""?'selected="selected"':'';?>>Select</option>
                    <option value="Dublin" <?=$_SESSION['trainer_register']['county']=="Dublin"?'selected="selected"':'';?>>Dublin</option>
                  </select>
                    </div>
              </div>
                 
                </div>
            <!-- row -->              
           
            
            <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Password<span>*</span></label>
                <input type="password" name="password" value="<?=$_SESSION['trainer_register']['password']?>" placeholder="Enter password" />
              </div>
                  <div class="tab_form_block">
                <label>Confirm Password<span>*</span></label>
                <input type="password" name="cpassword" value="<?=$_SESSION['trainer_register']['cpassword']?>"  placeholder="Enter confirmed password" />
              </div>
                </div>
            <!-- row -->
             <!-- row -->
            <div class="tab_form_row">
                  <div class="tab_form_block">
                <label>Website URL</label>
                <input type="text" name="website_URL" value="<?=$_SESSION['trainer_register']['website_URL']?>" placeholder="http://" />
              </div>                
                </div>
            <!-- row --> 
            
            <input type="submit" value="Submit" />
          </div>
          </form>
              <!-- form --> 
              <p class="special_form_note">* denotes that the field is mandatory</p>  
            </div>
        <!-- trainer registration --> 
        
      </div>
        </div>
  </div>
    </div>
<!-- pop --> 
	
<?php }	 ?>


<!-- header -->
<div class="header">
      <div class="main_container">
    <div class="main">
          <div class="logo"><a href="<?=$general_func->site_url?>"><img src="images/logo.png" alt="LOGO" /></a></div>
          
          <!-- nav -->
          <div class="nav">
        <ul>
              <li><a href="<?=$general_func->site_url?>">Home</a></li>
              <?php
			$sql_header_menu="select id,seo_link,page_heading,page_name,page_target,link_path from static_pages where parent_id=0 and page_position LIKE '%1%' order by display_order + 0 ASC";
			$result_header_menu=$db->fetch_all_array($sql_header_menu);
			$total_header_menu=count($result_header_menu);
						
			for($header=0; $header < $total_header_menu; $header++ ){
				$target=intval(trim($result_header_menu[$header]['page_target']))==2?'_blank':'_self';
	
				if(strlen(trim($result_header_menu[$header]['link_path'])) > 10){
					$link_path=trim($result_header_menu[$header]['link_path']);
				}else{
					$link_path=trim($result_header_menu[$header]['seo_link'])."/";								
				}
				?>
              <li><a  target="<?=$target?>" href="<?=$link_path?>" <?=(isset($_REQUEST['seo_link']) && trim($_REQUEST['seo_link']) == trim($result_header_menu[$header]['seo_link']))?'class="active"':'';?>>
                <?=trim($result_header_menu[$header]['page_heading'])?>
                </a>
            <?php
					$sql_headersub_menu="select id,seo_link,page_heading,page_name,page_target,link_path from static_pages where parent_id='" . $result_header_menu[$header]['id'] . "' and page_position LIKE '%1%' order by display_order + 0 ASC";
					$result_headersub_menu=$db->fetch_all_array($sql_headersub_menu);
					$total_headersub_menu=count($result_headersub_menu);
					if($total_headersub_menu > 0){
						echo "<ul>";
							
						for($headersub=0; $headersub < $total_headersub_menu; $headersub++ ){
							$target=intval(trim($result_headersub_menu[$headersub]['page_target']))==2?'_blank':'_self';
						
							if(strlen(trim($result_headersub_menu[$headersub]['link_path'])) > 10){
								$link_path=trim($result_headersub_menu[$headersub]['link_path']);
							}else{
								$link_path=trim($result_headersub_menu[$headersub]['seo_link']) ."/";									
							}?>
          <li><a  target="<?=$target?>" href="<?=$link_path?>">
            <?=trim($result_headersub_menu[$headersub]['page_heading'])?>
            </a>
            <?php }	
						
						echo "</ul>";
					}		
					?>
          </li>
              <?php } 
                            
        	if(isset($_SESSION['user_login']) && trim($_SESSION['user_login']) =="yes"){ ?>
              <div class="after_lo_pannel normal_after_lo_pannel">
            <table border="0" cellpadding="0" cellspacing="0">
                  <tr>
                <td>
                	<?php                	
                	if($_SESSION['user_type'] =="trainer"){
                		$img="trainer_logo/small/".$_SESSION['trainer_logo_name'];
						
						if(!file_exists($img) || trim($_SESSION['trainer_logo_name']) == NULL)
							$img="images/profile_image.jpg";
						
                	}else{
                		$img="gym_logo/small/".$_SESSION['gym_logo_name'];
						
						if(!file_exists($img) || trim($_SESSION['gym_logo_name']) == NULL)
							$img="images/profile_image.jpg";
					} 
					           	
                	?>
                	
                	<img src="<?=$img?>" /></td>
                <td><p class="after_log_name"><?=$_SESSION[$_SESSION['user_type'].'_name']?></p></td>
                <td><img src="images/after_log_menu_down_arrow.png" class="after_log_down_arrow" /></td>
              </tr>
                </table>
            <div class="after_log_pannel">
                  <ul>                
                <?php if(intval($_SESSION[$_SESSION['user_type'].'_membership_type']) ==0){ ?>
                	 <li><a href="<?=$_SESSION['user_type']?>-choose-account/">Choose membership</a></li>					
               <?php  }else{
               	
					$view_profile=$_SESSION['user_type'] == "gym"?'gym/'.$_SESSION['user_seo_link']:'personal-trainer/'.$_SESSION['user_seo_link'];	
				
				
				 ?>
                	<li><a  href="<?=$_SESSION['user_type']?>-account-setup/">Account setup</a></li>
                	<li><a  target="_blank" href="<?=$view_profile?>">View profile</a></li>
                	
                	
                	<!-- <li><a href="upgrade-membership/">Upgrade your membership</a></li> -->
               <?php if($_SESSION['user_type']=="gym"){ ?>
               			<li><a href="instructors/">Instructors</a></li>
               			<li><a href="gym-classes/">Classes</a></li>
						
               	 <?php }
               
                } ?>               
                <li><a href="change-password/">Change password</a></li>
                <li><a href="logout/">Logout</a></li>
              </ul>
                </div>
          </div>
              <?php }else{  ?>
              <li class="in_up"><a class="popclick sign_up_click">Sign Up</a><span class="active"></span></li>
              <li class="in_up"><a class="popclick sign_in_click">Sign In</a><span></span></li>
            </ul>
        <?php } ?>
      </div>
          <!-- nav --> 
          
        </div>
  </div>
      <!-- responsive second nav -->
      <div class="responsive_second_nav">
    <div class="respon_second_tab_menu">Menu</div>
    <ul>
          <li><a href="<?=$general_func->site_url?>">Home</a></li>
          <?php
			$sql_header_menu="select id,seo_link,page_heading,page_name,page_target,link_path from static_pages where parent_id=0 and page_position LIKE '%1%' order by display_order + 0 ASC";
			$result_header_menu=$db->fetch_all_array($sql_header_menu);
			$total_header_menu=count($result_header_menu);
						
			for($header=0; $header < $total_header_menu; $header++ ){
				$target=intval(trim($result_header_menu[$header]['page_target']))==2?'_blank':'_self';
	
				if(strlen(trim($result_header_menu[$header]['link_path'])) > 10){
					$link_path=trim($result_header_menu[$header]['link_path']);
				}else{
					$link_path=trim($result_header_menu[$header]['seo_link'])."/";								
				}
				?>
          <li><a  target="<?=$target?>" href="<?=$link_path?>" <?=(isset($_REQUEST['seo_link']) && trim($_REQUEST['seo_link']) == trim($result_header_menu[$header]['seo_link']))?'class="active"':'';?>>
            <?=trim($result_header_menu[$header]['page_heading'])?>
            </a>
        <?php
					$sql_headersub_menu="select id,seo_link,page_heading,page_name,page_target,link_path from static_pages where parent_id='" . $result_header_menu[$header]['id'] . "' and page_position LIKE '%1%' order by display_order + 0 ASC";
					$result_headersub_menu=$db->fetch_all_array($sql_headersub_menu);
					$total_headersub_menu=count($result_headersub_menu);
					if($total_headersub_menu > 0){
						echo "<ul>";
							
						for($headersub=0; $headersub < $total_headersub_menu; $headersub++ ){
							$target=intval(trim($result_headersub_menu[$headersub]['page_target']))==2?'_blank':'_self';
						
							if(strlen(trim($result_headersub_menu[$headersub]['link_path'])) > 10){
								$link_path=trim($result_headersub_menu[$headersub]['link_path']);
							}else{
								$link_path=trim($result_headersub_menu[$headersub]['seo_link']) ."/";									
							}?>
      <li><a  target="<?=$target?>" href="<?=$link_path?>">
        <?=trim($result_headersub_menu[$headersub]['page_heading'])?>
        </a>
        <?php }	
						
						echo "</ul>";
					}		
					?>
      </li>
          <?php } 
         if(isset($_SESSION['user_login']) && trim($_SESSION['user_login']) =="yes"){ ?>
          <div class="after_lo_pannel respon_after_lo_pannel">
        <table border="0" cellpadding="0" cellspacing="0">
              <tr>
            <td><?php                	
                	if($_SESSION['user_type'] =="trainer"){
                		$img="trainer_logo/small/".$_SESSION['trainer_logo_name'];
						
						if(!file_exists($img) || trim($_SESSION['trainer_logo_name']) == NULL)
							$img="images/profile_image.jpg";
						
                	}else{
                		$img="gym_logo/small/".$_SESSION['gym_logo_name'];
						
						if(!file_exists($img) || trim($_SESSION['gym_logo_name']) == NULL)
							$img="images/profile_image.jpg";
					} 
					           	
                	?>
                	
                	<img src="<?=$img?>" /></td>
            <td><p class="after_log_name"><?=$_SESSION[$_SESSION['user_type'].'_name']?></p></td>
            <td><img src="images/after_log_menu_down_arrow.png" class="after_log_down_arrow" /></td>
          </tr>
            </table>
        <div class="after_log_pannel">
                 <ul>                
                <?php if(intval($_SESSION[$_SESSION['user_type'].'_membership_type']) ==0){ ?>
                	 <li><a href="<?=$_SESSION['user_type']?>-choose-account/">Choose membership</a></li>					
               <?php  }else{
               	
					$view_profile=$_SESSION['user_type'] == "gym"?'gym/'.$_SESSION['user_seo_link']:'personal-trainer/'.$_SESSION['user_seo_link'];	
				
				
				 ?>
                	<li><a  href="<?=$_SESSION['user_type']?>-account-setup/">Account setup</a></li>
                	<li><a  target="_blank" href="<?=$view_profile?>">View profile</a></li>
                	
                	
                	<!--<li><a href="upgrade-membership/">Upgrade your membership</a></li>-->
               <?php if($_SESSION['user_type']=="gym"){ ?>
               			<li><a href="instructors/">Instructors</a></li>
               			<li><a href="gym-classes/">Classes</a></li>
						
               	 <?php }
               
                } ?>               
                <li><a href="change-password/">Change password</a></li>
                <li><a href="logout/">Logout</a></li>
              </ul>
            </div>
      </div>
          <?php }else{  ?>
          <li class="in_up"><a class="popclick sign_up_click">Sign Up</a><span class="active"></span></li>
          <li class="in_up"><a class="popclick sign_in_click">Sign In</a><span></span></li>
        </ul>
    <?php } ?>
  </div>
    </div>
