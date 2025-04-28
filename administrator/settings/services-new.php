<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}
*/


$data=array();

$return_url=$_REQUEST['return_url'];

if(isset($_REQUEST['action']) && $_REQUEST['action']=="EDIT"){
	$sql="select * from services where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);
	
	$name=$result[0]['name'];
	$display_order=$result[0]['display_order'];
		
	$button="Update";
}else{
	$name="";
	$display_order=$db->max_id("services","display_order") + 1;

	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$name=trim($_REQUEST['name']);
	$display_order=trim($_REQUEST['display_order']);
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("services","name",$name)){
			$_SESSION['msg']="Sorry, your specified service is already taken!";
		}else{
			$data['name']=$name;			
			$data['seo_link']=$general_func->create_seo_link($name);
			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_inset("services","seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$db->max_id("services","id") + 1 ."-".$data['seo_link'];
			}
			//*********************************************//
			
			$data['display_order']=$display_order;
			$db->query_insert("services",$data);
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Service successfully added!";
				
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{
		if($db->already_exist_update("services","id",$_REQUEST['id'],"name",$name)){
			$_SESSION['msg']="Sorry, your specified service is already taken!";
		}else{
			$data['name']=$name;			
			$data['seo_link']=$general_func->create_seo_link($name);			
			//*** check whether this name alreay exit ******//
			if($db->already_exist_update("services","id",$_REQUEST['id'],"seo_link",$data['seo_link'])){//******* exit
				$data['seo_link']=$_REQUEST['id'] ."-".$data['seo_link'];
			}
			//*********************************************//
			
			$data['display_order']=$display_order;
			
		
			$db->query_update("services",$data,"id='".$_REQUEST['id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Services successfully updated!";
				
			$general_func->header_redirect($return_url);
		}

	}
}	


?>
<script language="javascript" type="text/javascript"> 
function validate(){
	if(!validate_text(document.ff.name,1,"Enter service name"))
		return false;
	if(!validate_text(document.ff.display_order,1,"Enter service display order"))
		return false;	
	if(!validate_integer(document.ff.display_order,1,"Display order must be a number"))
		return false;	
		
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg"><?=$button?> Service</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
    <form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="id" value="<?=$_REQUEST['id']?>" />
        <input type="hidden" name="return_url" value="<?php echo $_REQUEST['return_url']?>" />
        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="3" class="body_content-form" height="30"></td>
          </tr>
          <?php if(isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL){?>
          <tr>
            <td colspan="3" class="message_error"><?=$_SESSION['msg'];$_SESSION['msg']=""; ?></td>
          </tr>
          <tr>
            <td colspan="3" class="body_content-form" height="30"></td>
          </tr>
          <?php  } ?>
          <tr>
            <td align="left" valign="top" colspan="3"><table width="79%" border="0"  align="center" cellspacing="2" cellpadding="6">
                <tr>
                  <td width="15%" class="body_content-form" valign="top">Service Name:<font class="form_required-field"> *</font></td>
                  <td width="85%" valign="top"><input name="name" type="text" value="<?=$name?>" AUTOCOMPLETE=OFF class="form_inputbox" size="55" /></td>
                </tr>
               
                <tr>
                  <td width="15%" class="body_content-form" valign="top">Display Order:<font class="form_required-field"> *</font></td>
                  <td width="85%" valign="top"><input name="display_order" type="text" value="<?=$display_order?>" AUTOCOMPLETE=OFF class="form_inputbox" size="15" /></td>
                </tr>
                <tr>
                  <td colspan="2" class="body_content-form" height="10"></td>
                </tr>
                <tr>
                  <td width="15%" class="body_content-form">&nbsp;</td>
                  <td width="85%"><table width="261" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="41%"><table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="submit" type="submit" class="submit1" value="<?=$button?>" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                          </table></td>
                        <td width="10%">&nbsp;</td>
                        <td width="49%"><table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onclick="location.href='<?=$general_func->admin_url?>settings/services.php'"  type="button" class="submit1" value="Back" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="32" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>