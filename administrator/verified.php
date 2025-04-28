<?php
include_once("../includes/configuration.php");
$remember_me=(isset($_POST["remember_me"]) && (int)$_POST["remember_me"] == 1)?1:0;

if(isset($_POST['enter']) && (int)$_POST['enter']==1){  
	$sql="select * from admin where admin_user='". trim($_POST['username']) ."' and admin_pass='" . $EncDec->encode_me($_POST['pawd']) . "' limit 1";
	$result=$db->fetch_all_array($sql);
		
	if(count($result) == 1){		
		$_SESSION['admin_user_id']=$result[0]['admin_id'];
		$_SESSION['admin_name']=$result[0]['fname'] ." ".$result[0]['lname'];
		$_SESSION['admin_user']=$result[0]['admin_user'];
		$_SESSION['admin_email_address']=$result[0]['email_address'];
		$_SESSION['admin_access_level']=$result[0]['access_level'];
						
		$_SESSION['admin_login']="yes";
		$_SESSION['access_permission']=array();		
		
		if($_SESSION['admin_access_level'] ==2){//************** sub admin
			$sql_access_permission="select module_name,add_permission,edit_permission,delete_permission	 from access_permission p left join access_modules a on p.module_id=a.id where permission_admin_id=" . (int) $_SESSION['admin_user_id'] . "";
			$result_access_permission=$db->fetch_all_array($sql_access_permission);
			$total_access_permission=count($result_access_permission);
				
			for($access=0; $access < $total_access_permission; $access++ ){					
				$module_name=$result_access_permission[$access]['module_name'];
				$_SESSION['access_permission'][$module_name]['add']=$result_access_permission[$access]['add_permission'];
				$_SESSION['access_permission'][$module_name]['edit']=$result_access_permission[$access]['edit_permission'];
				$_SESSION['access_permission'][$module_name]['delete']=$result_access_permission[$access]['delete_permission'];
			}
		}else{//************  super admin
			$sql_access_permission="select module_name from access_modules order by display_order + 0 ASC";
			$result_access_permission=$db->fetch_all_array($sql_access_permission);
			$total_access_permission=count($result_access_permission);
			
			for($access=0; $access < $total_access_permission; $access++ ){					
				$module_name=$result_access_permission[$access]['module_name'];
				$_SESSION['access_permission'][$module_name]['add']=1;
				$_SESSION['access_permission'][$module_name]['edit']=1;
				$_SESSION['access_permission'][$module_name]['delete']=1;
			}			
		}
		
		
		
		if((int)$remember_me == 1){
	  		setcookie("cookie_user",$_POST['username']); 
			setcookie("cookie_pass",$_POST['pawd']);
	 	}else{
			setcookie("cookie_user",$_POST['username'],time()-3600);
			setcookie("cookie_pass",$_POST['pawd'],time()-3600);
		}
		
		
		//**********Save admin login history **********************//
		$data=array();
		$data['login_date_time']='now()';
		$data['login_ip']=$_SERVER['REMOTE_ADDR'];	
		$db->query_insert("admin_login_hostory",$data);			
		//*********************************************************//
		

		
		if(isset($_SESSION['redirect_to']) && trim($_SESSION['redirect_to'])!=NULL){
			$path=$_SESSION['redirect_to']."?".$_SESSION['redirect_to_query_string'];
			$general_func->header_redirect($path);		
		}else
			$general_func->header_redirect("home.php");		
		
	}else{
		$_SESSION['message']="Error: Your username and/or password was incorrect!<br/>Check your username and password and try again!";
		$general_func->header_redirect("index.php");
	}
}else{
	echo "Hacking Attempt !";
	exit();
}
?>