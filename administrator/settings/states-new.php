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
	$sql="select * from states where state_id=" . (int) $_REQUEST['state_id'] . " limit 1";
	$result=$db->fetch_all_array($sql);
	
	$country_iso=$result[0]['country_iso'];
	$state=$result[0]['state'];
		
	$button="Update";
}else{
	$country_iso="";
	$state="";

	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$country_iso=trim($_REQUEST['country_iso']);
	$state=trim($_REQUEST['state']);
	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("states","state",$state,"country_iso",$country_iso)){
			$_SESSION['msg']="Sorry, your specified state is already taken!";
		}else{
			$data['country_iso']=$country_iso;
			$data['state']=$state;
			$db->query_insert("states",$data);
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="State successfully added!";
				
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{
		if($db->already_exist_update("states","state_id",$_REQUEST['state_id'],"state",$state,"country_iso",$country_iso)){
			$_SESSION['msg']="Sorry, your specified state is already taken!";
		}else{
			$data['country_iso']=$country_iso;
			$data['state']=$state;
		
			$db->query_update("states",$data,"state_id='".$_REQUEST['state_id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="State successfully updated!";
				
			$general_func->header_redirect($return_url);
		}

	}
}	


?>
<script language="javascript" type="text/javascript"> 
function validate(){
	if(document.ff.country_iso.selectedIndex == 0){
		alert("Please select a country");	
		document.ff.country_iso.focus();
		return false;
	}
	
	if(!validate_text(document.ff.state,1,"Enter state name"))
		return false;
	
		
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg"><?=$button?> State</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
    <form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="ff" onsubmit="return validate()">
        <input type="hidden" name="enter" value="yes" />
        <input type="hidden" name="state_id" value="<?=$_REQUEST['state_id']?>" />
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
                  <td width="15%" class="body_content-form" valign="top">Country Name:<font class="form_required-field"> *</font></td>
                  <td width="85%" valign="top">
                  	<select name="country_iso"  class="inputbox_select" style="width: 300px; padding: 2px 1px 2px 0px;">
                      <option value="">Choose One</option>
                      <?php
					$country_sql="SELECT country_iso,country_printable_name FROM `countries` ORDER BY `country_printable_name` ASC";
					$result_country=$db->fetch_all_array($country_sql);
					$total_country=count($result_country);
					for($country=0;$country < $total_country; $country++){?>
						<option value="<?=$result_country[$country]['country_iso']?>" <?=$country_iso == $result_country[$country]['country_iso'] ? 'selected' : ''; ?>>
						<?=$result_country[$country]['country_printable_name']?>
					</option>					
                     
                      <?php }
                  ?>
                    </select>                  	
                  	</td>
                </tr>
                <tr>
                  <td width="15%" class="body_content-form" valign="top">State Name:<font class="form_required-field"> *</font></td>
                  <td width="85%" valign="top"><input name="state" type="text" value="<?=$state?>" AUTOCOMPLETE=OFF class="form_inputbox" size="55" /></td>
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
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onclick="location.href='<?=$general_func->admin_url?>settings/states.php'"  type="button" class="submit1" value="Back" /></td>
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