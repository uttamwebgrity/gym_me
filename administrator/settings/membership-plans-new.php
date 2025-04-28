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
	$sql="select * from membership_plans where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);
	
	
	$type=$result[0]['type'];
	$plan_for=$result[0]['plan_for'];
	$type_value=$result[0]['type_value'];
	
	$amount=$result[0]['amount'];
	$details=$result[0]['details'];	
		
	$button="Update";
}else{
	$type="";
	$plan_for="";
	$type_value="";
	$amount="";
	$details="";

	$button="Add New";
}


if(isset($_POST['enter']) && $_POST['enter']=="yes"){
	$type=trim($_REQUEST['type']);
	$plan_for=trim($_REQUEST['plan_for']);	
	$type_value=trim($_REQUEST['type_value']);	
	$amount=trim($_REQUEST['amount']);
	$details=trim($_REQUEST['details']);

	
	if($_POST['submit']=="Add New"){
		if($db->already_exist_inset("membership_plans","type",$type,"plan_for",$plan_for,"type_value",$type_value)){
			$_SESSION['msg']="Sorry, your specified membership plan is already taken!";
		}else{
			$data['type']=$type;	
			$data['plan_for']=$plan_for;		
			$data['type_value']=$type_value;	
			$data['amount']=$amount;	
			$data['details']=$details;	
			$data['date_added']='now()';	
			$db->query_insert("membership_plans",$data);
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Membership plan successfully added!";
				
			$general_func->header_redirect($_SERVER['PHP_SELF']);
		}	

	}else{
		if($db->already_exist_update("membership_plans","id",$_REQUEST['id'],"plan_for",$plan_for,"type",$type,"type_value",$type_value)){
			$_SESSION['msg']="Sorry, your specified membership plan is already taken!";
		}else{
			$data['type']=$type;
			$data['plan_for']=$plan_for;			
			$data['type_value']=$type_value;	
			$data['amount']=$amount;	
			$data['details']=$details;				
		
			$db->query_update("membership_plans",$data,"id='".$_REQUEST['id'] ."'");
			
			if($db->affected_rows > 0)
				$_SESSION['msg']="Membership plan successfully updated!";
				
			$general_func->header_redirect($return_url);
		}

	}
}	


?>
<script language="javascript" type="text/javascript"> 
function validate(){
	if(document.ff.plan_for.selectedIndex == 0){
		alert("Please choose to whom you want to create subscription");	
		document.ff.plan_for.focus();
		return false;
	}
		
	if(document.ff.type.selectedIndex == 0){
		alert("Please choose a subscription type");	
		document.ff.type.focus();
		return false;
	}
	
	if(!validate_text(document.ff.type_value,1,"Enter subscription value"))
		return false;
			
	if(!validate_integer(document.ff.type_value,1,"Subscription value must be a number"))
		return false;
		
	if(parseInt(document.ff.type_value.value) <= 0){
		alert("Subscription value must be greater than one");	
		document.ff.type.focus();
		return false;		
	}	
		
	if(!validate_text(document.ff.amount,1,"Enter subscription price"))
		return false;
			
	if(!validate_price(document.ff.amount,1,"Enter a valid subscription price"))
		return false;		
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg"><?=$button?> Membership Plan</td>
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
                  <td width="20%" class="body_content-form" valign="top">Subscription For:<font class="form_required-field"> *</font></td>
                  <td width="80%" valign="top"><select name="plan_for"  class="inputbox_select" style="width: 150px;" >
                      <option value="">Choose One</option>
                      <option value="1" <?=$plan_for==1?'selected="selected"':'';?>>Gym</option>
                      <option value="2" <?=$plan_for==2?'selected="selected"':'';?>>Personal Trainers</option>
                    </select>
                   </td>
                </tr>               
                <tr>
                  <td width="20%" class="body_content-form" valign="top">Subscription Type:<font class="form_required-field"> *</font></td>
                  <td width="80%" valign="top"><select name="type"  class="inputbox_select" style="width: 150px;" >
                      <option value="">Choose One</option>
                      <option value="1" <?=$type==1?'selected="selected"':'';?>>Monthly</option>
                      <option value="2" <?=$type==2?'selected="selected"':'';?>>Yearly </option>
                    </select>
                   </td>
                </tr>               
                <tr>
                  <td  class="body_content-form" valign="top">Subscription Value:<font class="form_required-field"> *</font></td>
                  <td  valign="top"><input name="type_value" type="text" value="<?=$type_value?>" AUTOCOMPLETE=OFF class="form_inputbox" size="26" /></td>
                </tr>
                 <tr>
                  <td  class="body_content-form" valign="top">Subscription Price ($):<font class="form_required-field"> *</font></td>
                  <td  valign="top"><input name="amount" type="text" value="<?=$amount?>" AUTOCOMPLETE=OFF class="form_inputbox" size="26" /></td>
                </tr>
               
                <tr>
                  <td  class="body_content-form" valign="top">Details (if any):</td>
                  <td  valign="top"><input name="details" type="text" value="<?=$details?>" AUTOCOMPLETE=OFF class="form_inputbox" size="55" /></td>
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
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onclick="location.href='<?=$general_func->admin_url?>settings/membership-plans.php'"  type="button" class="submit1" value="Back" /></td>
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