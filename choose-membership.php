<?php
include_once("includes/configuration.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
		
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}


if(isset($_POST['enter']) && ($_POST['enter']=="gym" || $_POST['enter']=="trainer" )){
	
	if(intval(trim($_REQUEST['membership_type'])) == 1){
		$_SESSION[$_SESSION['user_type'].'_membership_type']=1;	
		
		$table_name=trim($_SESSION['user_type']) =="trainer"?'personal_trainers':'gyms';
		$id=$_SESSION[$_SESSION['user_type'].'_id'];
		
		$db->query("update $table_name set membership_type=1 where  id='". $id ."'");
		
		$_SESSION['user_message'] = "Thank you for choosing your membership plan.";
		$general_func->header_redirect($general_func->site_url);
		
	}else if(intval(trim($_REQUEST['membership_type'])) == 2){		
		$general_func->header_redirect("upgrade-membership/");		
	}	
}	

 

?>
