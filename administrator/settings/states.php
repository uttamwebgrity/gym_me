<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


/*if((int)$_SESSION['admin_access_level'] == 2){		
    $_SESSION['message']="Sorry, you do not have the permission to access this page!";
	$general_func->header_redirect($general_func->admin_url."home.php");
}*/



if(isset($_GET['action']) && $_GET['action']=='delete'){
	$db->query("update employers set state_id=' ' where state_id='".$_REQUEST['state_id'] ."");
	$db->query("update physicians set state_id=' ' where state_id='".$_REQUEST['state_id'] ."");
	$db->query_delete("states","state_id='".$_REQUEST['state_id'] ."'");
	$_SESSION['msg']="Your selected state deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 

?>
<script language="JavaScript">

function validate_search(){
	if(!validate_text(document.frmsearch.cd,1,"Enter state name")){
		return false
	}
}

function del(id,url,weapon){
	var a=confirm("Are you sure, you want to delete state: '" + weapon +"'?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?state_id="+id+"&action=delete&url="+url;
    }  
} 
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">States</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><img src="images/spacer.gif" alt="" width="14" height="14" /></td>
              </tr>
              <?php if(isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL){?>
			<tr>
                  <td class="message_error"><?=$_SESSION['msg']; $_SESSION['msg']="";?></td>
            </tr>
             <tr>
                  <td  class="body_content-form" height="10"></td>
            </tr>
			 <?php  } ?>
              <tr>
                <td align="left" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="top">
                       
                        <table width="543" border="0" align="center" cellpadding="0" cellspacing="0">
                          <form name="frmsearch"  method="post" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return validate_search();">
                           <input type="hidden" name="enter" value="3" />
                          
                            <tr>
                              <td width="115" align="right" valign="middle" class="content_employee" style="padding-right: 5px;">State Name:</td>
                              <td width="219" align="left" valign="middle"><input type="text" name="cd"  value="<?=$_REQUEST['cd']?>" autocomplete="OFF" size="35" class="inputbox_employee-listing" /></td>
                              <td width="209" align="left" valign="middle">
                              <table border="0" align="left" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="button" type="submit" class="submit1" value="Search" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                        </table></td>
                            </tr>
                          </form>
                        </table>
                        <p style="text-align:center;"><font class="text_numbering"><?=$general_func->A_to_Z($_SERVER['PHP_SELF'])?></font></p>
                       </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
         <tr>
          <td align="left" valign="middle" height="10"></td>
         </tr> 
            <?php
				//**************************************************************************************//
				$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
				
				$recperpage=$general_func->admin_recoed_per_page;
				
				
				$order_by="";
				$display_oder_type="ASC";
		

	
				if(isset($_REQUEST['display_oder']) && trim($_REQUEST['display_oder']) != NULL){
					if(trim($_REQUEST['display_oder']) == "state"){//***********name
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="state ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="state DESC";
						}
					}else if(trim($_REQUEST['display_oder']) == "country_printable_name"){//***********display_order
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="country_printable_name ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="country_printable_name  DESC";
						}
					}else{
						$order_by .="state ASC";
					} 
					
				}else{
					$order_by .="state, country_printable_name ASC";
				}


				
				
				$query="where 1";
				
				
				if(isset($_REQUEST['key']) && trim($_REQUEST['key']) != NULL)
					$query .=" and  state LIKE '" .$_REQUEST['key']. "%'";
				else if(isset($_REQUEST['enter']) && (int)$_REQUEST['enter']==3)
					$query .=" and  state LIKE '" .$_REQUEST['cd']. "%'";
				else if(isset($_REQUEST['country_iso']) && strlen($_REQUEST['country_iso']) > 0)
					$query .=" and s.country_iso = '" . $_REQUEST['country_iso']. "'";
				
				$sql="select state_id,state,country_printable_name from states s left join countries c on s.country_iso=c.country_iso $query order by $order_by";
				
				//-	----------------------------------/Pagination------------------------------
				if(isset($_GET['in_page'])&& $_GET['in_page']!="")
					$page=$_GET['in_page'];
				else
					$page=1;
				
				$total_count=$db->num_rows($sql);
				$sql=$sql." limit ".(($page-1)*$recperpage).", $recperpage";
				
					if($page>1)
					{
						$url_prev=stristr($url,"&in_page=".$page)==FALSE?$url."&page=".($page-1):str_replace("&in_page=".$page,"&in_page=".($page-1),$url);
						$prev="&nbsp;<a href='$url_prev' class='nav'>Prev</a>";
					}
					else
						$prev="&nbsp;Prev";
						
					if((($page)*$recperpage)<$total_count)
					{
						$url_next=stristr($url,"&in_page=".$page)==FALSE?$url."&in_page=".($page+1):str_replace("&in_page=".$page,"&in_page=".($page+1),$url);
						$next="&nbsp;<a href='$url_next' class='nav'>Next</a>";
					}
					else
						$next="&nbsp;Next";
						
					$page_temp=(($page)*$recperpage);
					$page_temp=$page_temp<$total_count?$page_temp:$total_count;
					$showing=" Showing ".(($page-1)*$recperpage+1)." - ".$page_temp." of ".$total_count." | ";
				 
				//-----------------------------------/Pagination------------------------------
				//*************************************************************************************************//
				$result=$db->fetch_all_array($sql);
			//*******************************************************************************************************************//
        ?> 
        <tr>
          <td align="left" valign="top"><table width="621" align="center" border="0" 
cellpadding="5" cellspacing="1">
              <tr>
                <td  class="text_numbering">
                	<?php if(isset($_SESSION['access_permission']['settings']['add']) && intval($_SESSION['access_permission']['settings']['add'])==1){ ?>
                	<table border="0"  cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="button" type="button" class="submit1" value="Add New" onclick="location.href='<?=$general_func->admin_url?>settings/states-new.php'" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                   </table>
                   <?php }else echo "&nbsp;";?>
                   </td>
                   
                   <td>
                   		<select name="country_iso"  class="inputbox_select" style="width: 200px; padding: 2px 1px 2px 0px;" onchange="location.href='<?=$general_func->admin_url?>settings/states.php?country_iso=' + this.value" >
                      <option value="">All Countries</option>
                      <?php
					$country_sql="SELECT country_iso,country_printable_name FROM `countries` where country_iso IN (select DISTINCT(country_iso) from states) ORDER BY `country_printable_name` ASC";
					$result_country=$db->fetch_all_array($country_sql);
					$total_country=count($result_country);
					for($country=0;$country < $total_country; $country++){?>
						<option value="<?=$result_country[$country]['country_iso']?>" <?=$_REQUEST['country_iso'] == $result_country[$country]['country_iso'] ? 'selected' : ''; ?>>
						<?=$result_country[$country]['country_printable_name']?>
					</option>					
                     
                      <?php }
                  ?>
                    </select>         
                   	
                   </td>
                <td class="text_numbering" align="right" ><?=$total_count?> state found.</td>
              </tr>
              <tr>
               
                <td width="40%" align="left" valign="middle" bgcolor="#35619c" class="table_heading">
                <a href="settings/states.php?display_oder=state&display_oder_type=<?=$display_oder_type?>" class="header_link">State Name</a>
                
                </td>
                <td width="40%" align="left" valign="middle" bgcolor="#35619c" class="table_heading">
                <a href="settings/states.php?display_oder=country_printable_name&display_oder_type=<?=$display_oder_type?>" class="header_link">Country Name</a></td>
                
                <td width="20%" align="center" valign="middle" bgcolor="#35619c" class="table_heading">Action</td>
              </tr>
			
			<?php if(count($result) == 0){?>
                	<tr>
                		<td colspan="3" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no specialty added yet!</td>
              		</tr>
				<?php }else{
					for($j=0;$j<count($result);$j++){?>
                     <tr bgcolor="<?=$j%2==0?$general_func->color2:$general_func->color1;?>">
                        <td  align="left" valign="middle" class="table_content-blue"><?=$result[$j]['state']?></td>
                       <td  align="left" valign="middle" class="table_content-blue"><?=$result[$j]['country_printable_name']?></td>
                       <td  align="center" valign="middle" class="table_content-blue">
                       <?php if(isset($_SESSION['access_permission']['settings']['edit']) && intval($_SESSION['access_permission']['settings']['edit'])==1){ ?>
                       <img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/states-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;" />
                       <?php }  if(isset($_SESSION['access_permission']['settings']['delete']) && intval($_SESSION['access_permission']['settings']['delete'])==1){ ?>
                       &nbsp;&nbsp;&nbsp;&nbsp;   <img src="images/delete.png" onclick="del('<?=$result[$j]['state_id']?>','<?=urlencode($url)?>','<?=$result[$j]['state']?>')" style="cursor:pointer;" />         
                        <?php } ?>
                        </td>
            </tr>
			<?php }
				}
	  		?>
            <tr>
                <td colspan="3" align="center" valign="middle" height="4"></td>
            </tr> 
              <tr>
                <td colspan="3" align="center" valign="middle" height="30" class="table_content-blue"></td>
              </tr>
          </table></td>
        </tr>
                    <tr>
                <td colspan="3" align="center" valign="middle" height="30" class="table_content-blue">
                  <?php 
		if ($total_count>$recperpage) {
		?>
		<table width="715" height="20" border="0"  cellpadding="0" cellspacing="0">
<tr>
				<td width="295" align="left" valign="bottom" class="htext">
						&nbsp;Jump to page 
				<select name="in_page" style="width:45px;" onChange="javascript:location.href='<?php echo str_replace("&in_page=".$page,"",$url);?>&in_page='+this.value;">
				  <?php for($m=1; $m<=ceil($total_count/$recperpage); $m++) {?>
				  <option value="<?php echo $m;?>" <?php echo $page==$m?'selected':''; ?>><?php echo $m;?></option>
				  <?php }?>
				</select>
				of 
		  <?php echo ceil($total_count/$recperpage); ?>	  </td>
		  <td width="420" align="right" valign="bottom" class="htext"><?php echo " ".$showing." ".$prev." ".$next." &nbsp;";?></td>
		  </tr>
	  </table>

    <!-- / show category -->
		<?php  }?>                </td>
              </tr>

      </table>
    </td>
  </tr>
</table>
<?php
include("../foot.htm");
?>