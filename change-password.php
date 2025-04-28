<?php 
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
		
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}


if(isset($_POST['enter']) && $_POST['enter']=="change_password"){	
	
	$table_name=trim($_SESSION['user_type']) =="trainer"?'personal_trainers':'gyms';
	$id=$_SESSION[$_SESSION['user_type'].'_id'];
		
	
	$sql="select id from $table_name where id='". $id ."' and password='". $EncDec->encrypt_me(trim($_REQUEST['old_password'])) ."' and status=1 limit 1";
	$result=$db->fetch_all_array($sql);
	if((int)count($result) == 1){
		$data=array();	
		$data['password']=$EncDec->encrypt_me(trim($_REQUEST['new_password']));
		$data['modified']='now()';

		$db->query_update($table_name,$data,"id='". $id  ."'");
				
		$_SESSION['user_message'] = "Your Password has been changed!";
		$general_func -> header_redirect($general_func->site_url);		
	}else{
		$_SESSION['user_message']="Sorry, your specified old password was wrong!";	
	}
}

?>	
<script type="text/javascript">

function validate_submit(){	
	if(!validate_text(document.ff.old_password,1,"Enter Your Old Password"))
		return false;
	
	if(!validate_text(document.ff.new_password,1,"Enter Your New Password"))
		return false;
		
	if(!validate_text(document.ff.confirm_password,1,"Enter Confirm New Password"))
		return false;
		
	if(document.ff.new_password.value != document.ff.confirm_password.value){
		alert("New Password and confirm new password must be same");
		document.ff.confirm_password.focus();
		return false;
	}	
}
	
</script>			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Change Password</h1>
			<p><?php echo trim($dynamic_content['file_data']); ?></p>
			 <form method="post" action="<?=$_SERVER['PHP_SELF']?>"  name="ff" onsubmit="return validate_submit()">					
					<input type="hidden" name="enter" value="change_password" />	
	        <ul class="contact-form">
	          <li>
	            <label>Old Password<span>*</span></label>
	            <input type="password" name="old_password" placeholder="Enter old password" />
	          </li>
	          <li>
	            <label>New Password<span>*</span></label>
	            <input type="password" name="new_password" placeholder="Enter new password" />
	          </li>
	          <li>
	            <label>Confirm Password<span>*</span></label>
	            <input type="password" name="confirm_password" placeholder="Confirm password" />
	          </li>
	          
	          <li style="background:none;">
	            <input type="submit" value="Update" />
	          </li>
	        </ul>
	      </form>							      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>