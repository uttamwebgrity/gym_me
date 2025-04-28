<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


$data=array();
$return_url=$_REQUEST['return_url'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
	$sql="select * from subscribers where id=" . (int) $_REQUEST['id'] . "";
	$result=$db->fetch_all_array($sql);
	
	$name=$result[0]['name'];	
	$email_address=$result[0]['email_address'];
	
	
	$button="Update";
}else{
	$name="";	
	$email_address="";
	
	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$name=$_REQUEST['name'];	
	$email_address=$_REQUEST['email_address'];

	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("subscribers","email_address",$email_address)){
			$_SESSION['msg']="Sorry, your specified email address is already taken!";
		}else{
			$data['name']=$name;			
			$data['email_address']=$email_address;
			$data['date_added']='now()';
			
			$db->query_insert("subscribers",$data);
			
			$_SESSION['msg']="Subscriber email address successfully added.";
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{
		if($db->already_exist_update("subscribers","id",$_REQUEST['id'],"email_address",$email_address)){
			$_SESSION['message']="Sorry, your specified email address is already taken!";
		}else{
			$data['name']=$name;			
			$data['email_address']=$email_address;
			
		
			$db->query_update("subscribers",$data,"id='".$_REQUEST['id'] ."'");
			$_SESSION['msg']="Subscriber email address successfully updated.";
			$general_func->header_redirect($return_url);
		}
	}
}	


?>
<script language="javascript" type="text/javascript"> 
function validate(){	
	if(!validate_text(document.ff.name,1,"Name should not be blank"))
		return false;		
	if(!validate_email(document.ff.email_address,1,"E-mail address should not be blank"))
		return false;	
}

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg another_bg_color"><?=$button?>
            Subscriber</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>        
      
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input type="hidden" name="return_url" value="<?php echo $_REQUEST['return_url']?>" />
        <table width="883" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
          	<td colspan="4" height="30"></td>
          </tr>
          <?php if(isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL){?>
          <tr>
            <td colspan="4" class="message_error"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></td>
          </tr>
          <tr>
            <td colspan="4" class="body_content-form" height="30"></td>
          </tr>
          <?php  } ?>
          
          <tr>
            <td width="93" align="left" valign="top"></td>
            <td width="380" align="left" valign="top" colspan="3"><table width="81%" border="0" cellspacing="0" cellpadding="5">
               
                <tr>
                  <td width="19%" class="body_content-form">Name:<font class="form_required-field"> *</font></td>
                  <td width="81%"><input name="name" value="<?=$name?>" type="text" AUTOCOMPLETE=OFF class="form_inputbox" size="35" /></td>
                </tr>                
                <tr>
                  <td width="19%" class="body_content-form">Email:<font class="form_required-field"> *</font></td>
                  <td width="81%"><input name="email_address"  value="<?=$email_address?>" type="text" AUTOCOMPLETE=OFF class="form_inputbox" size="35"  /></td>
                </tr>
            </table></td>
           
           
          </tr>
           <tr>
          	<td colspan="4" height="20"></td>
          </tr>
          <tr>
                  <td  class="body_content-form">&nbsp;</td>
                  <td ><table width="461" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="31%"><table border="0" align="right" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="submit" type="submit" class="submit1" value="<?=$button?>" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                          </table></td>
                        <td width="10%">&nbsp;</td>
                        <td width="59%">
                        	 <?php if($button !="Add New"){?>
                        	<table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onclick="location.href='<?=$return_url?>'"  type="button" class="submit1" value="Back" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                          </table>
                          <?php  }else 
							echo "&nbsp;";
						 ?>
                          </td>
                      </tr>
                    </table></td>
                </tr>          
           <tr>
          	<td colspan="4" height="30"></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
