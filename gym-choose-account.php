<?php
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes" || $_SESSION['user_type']!="gym"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
   	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
	
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}
?>

<script>
function choose_membership_validate(){
	if(document.frmmembership.membership_type[0].checked == false && document.frmmembership.membership_type[1].checked == false){
		alert("Please choose a membership plan");	
		return false;		
	}	
}	
</script>
<div class="pop pop_open"> </div>
<div class="popup poppup_open">
  <div class="pop_box">
    <div class="left_ring"></div>
    <div class="right_ring"></div>
    <div class="pop_main_container">
      <div class="pop_main open_popup_main"> 
        <div class="pop_form">
          <div class="pop_head">
            <div class="pop_icon"><img src="images/trainer_pop_icon.png" /></div>
            <div class="pop_name">
              <h5>Gym</h5>
              <h6>Choose a Membership plan</h6>
            </div>
          </div> 
          <div class="tab_form">
            <div class="membership_row">
              <form method="post" action="choose-membership.php" name="frmmembership"  onsubmit="return choose_membership_validate();">              	
              	<div class="membership_block">
                  <div class="member_ship_radio_block">
                    <input type="radio" name="membership_type" value="1" class="membership_radio" />
                  </div>
                  <div class="membership_detail">
                    <h6>FREE Membership</h6>
                    <p><?=$general_func->gym_free?></p>
                  </div>
                </div>
                <div class="membership_block">
                  <div class="member_ship_radio_block">
                    <input type="radio" name="membership_type" value="2" class="membership_radio" />
                  </div>
                  <div class="membership_detail">
                    <h6>Paid membership</h6>
                    <p><?=$general_func->gym_paid?></p>
                  </div>
                </div>
                <div class="membership_button_row">
                  <input type="button" value="Skip this" onclick="location.href='<?=$general_func->site_url?>'" />
                  <input type="hidden" name="enter" value="gym">
                  <input type="submit" value="Proceed" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<p style="height: 100px;"></p>
<?php include_once("includes/footer.php"); ?>