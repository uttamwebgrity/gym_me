<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

$small=$path_depth ."gym_logo/small/";
$original=$path_depth ."gym_logo/";


$gym_small=$path_depth ."gym_photo/small/";
$gym_medium=$path_depth ."gym_photo/medium/";
$gym_original=$path_depth ."gym_photo/";



if(isset($_GET['action']) && $_GET['action']=='delete'){	
	
	$sql="select logo_name from gyms where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);
	
	if(count($result) > 0){
		@unlink($small.$result[0]['logo_name']);
		@unlink($original.$result[0]['logo_name']);		
	}
	
	
	$sql="select photo_name from gym_photos where gym_id=" . (int) $_REQUEST['id'] . "";
	$result=$db->fetch_all_array($sql);
	
	if(count($result) > 0){
		for($i=0; $i<count($result); $i++){
			@unlink($gym_small.$result[$i]['photo_name']);	
			@unlink($gym_medium.$result[$i]['photo_name']);	
			@unlink($gym_original.$result[$i]['photo_name']);
		}
	}
	
	@mysql_query("delete from  gym_photos  where gym_id=" . (int) $_REQUEST['id'] . "");
	
	$db->query_delete("gyms_outbound","gym_id='".$_REQUEST['id'] ."'");
	
	$db->query_delete("gyms","id='".$_REQUEST['id'] ."'");
	
	$_SESSION['msg']="Your selected gym deleted!";
	$general_func->header_redirect($_REQUEST['url']);
}
 
?>
<script language="JavaScript">

function validate_search(){
	if(!validate_text(document.frmsearch.cd,1,"Enter gym name.")){
		return false;
	}
}

function del(id,url,name){
	var a=confirm("Are you sure, you want to delete gym: '" + name +"'\nAnd all data related to it?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete&url="+url;
    }  
} 
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">Gyms</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><img src="images/spacer.gif" alt="" width="14" height="14" /></td>
              </tr>
              <?php if(isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL){?>
              <tr>
                <td class="message_error" align="center"><?=$_SESSION['msg']; $_SESSION['msg']="";?></td>
              </tr>
              <tr>
                <td  class="body_content-form" height="10"></td>
              </tr>
              <?php  } ?>
              <tr>
                <td align="left" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="top"><table width="501" border="0" align="center" cellpadding="0" cellspacing="0">
                          <form name="frmsearch"  method="post" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return validate_search();">
                            <input type="hidden" name="enter" value="3" />
                            <tr>
                              <td width="123" align="right" valign="middle" class="content_employee" style="padding-right: 5px;">Gym Name:</td>
                              <td width="240" align="left" valign="middle"><input type="text" name="cd"  value="<?=$_REQUEST['cd']?>" autocomplete="OFF" size="35" class="inputbox_employee-listing" /></td>
                              <td width="138" align="left" valign="middle"><table border="0" align="left" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                                    <td align="left" valign="middle" class="body_tab-middilebg"><input name="button" type="submit" class="submit1" value="Search" /></td>
                                    <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </form>
                        </table>
                        <p style="text-align:center;"><font class="text_numbering">
                          <?=$general_func->A_to_Z($_SERVER['PHP_SELF'])?>
                          </font></p></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <?php
				//**************************************************************************************//
				$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
				
				$recperpage=$general_func->admin_recoed_per_page;
				
				
				$order_by="";
				$display_oder_type="ASC";
		
	
				if(isset($_REQUEST['display_oder']) && trim($_REQUEST['display_oder']) != NULL){
					if(trim($_REQUEST['display_oder']) == "name"){//***********name
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="name ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="name DESC";
						}											
					}else if(trim($_REQUEST['display_oder']) == "status"){//***********status
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="status + 0 ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="status + 0 DESC";
						}		
						
					}else{
						$order_by .="name ASC";
					} 
					
				}else{
					$order_by .="name ASC";
				}

				
				$query="where 1";
				
				
				if(isset($_REQUEST['key']) && trim($_REQUEST['key']) != NULL)
					$query .=" and name LIKE '" .$_REQUEST['key']. "%'";
				else if(isset($_REQUEST['enter']) && (int)$_REQUEST['enter']==3)
					$query .=" and name LIKE '" .$_REQUEST['cd']. "%'";
				
				
				$sql="select id,seo_link,name,email_address,email_confirmed,town,area,street_address,membership_type,membership_start,membership_end,status,last_login_date from gyms ";				
				$sql .=" $query order by $order_by";
				
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
          <td align="left" valign="top"><table width="1000" align="center" border="0" 
cellpadding="5" cellspacing="1">
              <tr>
                <td  class="text_numbering">
                	<?php if(isset($_SESSION['access_permission']['gyms']['add']) && intval($_SESSION['access_permission']['gyms']['add'])==1){ ?>
                	<table border="0"  cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                      <td align="left" valign="middle" class="body_tab-middilebg"><input name="button" type="button" class="submit1" value="Add New" onClick="location.href='<?=$general_func->admin_url?>gyms/gyms-new.php'" /></td>
                      <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                    </tr>
                  </table>
                  <?php }else echo "&nbsp;";?>
                  </td>
                  <td colspan="2"><img src="images/tick.png"> Varified Email</td>
                <td class="text_numbering" colspan="8" align="right"><?=$total_count?>
                  Gym(s) found.</td>
              </tr>
              <tr>
                <td width="150"  align="left" valign="middle" class="table_heading">
                <a href="gyms/gyms.php?display_oder=name&display_oder_type=<?=$display_oder_type?>" class="header_link">Gym Name</a></td>
  
                <td width="150"  align="left" valign="middle" class="table_heading">Email Address</td>
                <td width="50"  align="left" valign="middle" class="table_heading">Area </td>
                  <td width="150"  align="left" valign="middle" class="table_heading">Street Address</td> 
                <td width="60"  align="left" valign="middle" class="table_heading">Town</td>   
                <td width="90"  align="left" valign="middle" class="table_heading">Membership</td> 
                  <td width="90"  align="center" valign="middle" class="table_heading">Slug</td>  
                 <td width="70"  align="left" valign="middle" class="table_heading">
                 	
                 	 <a href="gyms/gyms.php?display_oder=status&display_oder_type=<?=$display_oder_type?>" class="header_link">Status</a></td>
                 	   <td width="100"  align="left" valign="middle" class="table_heading">Last Logged on</td>              
                <td width="80"  align="center" valign="middle" class="table_heading">Action</td>
              </tr>
              <?php if(count($result) == 0){?>
              <tr>
                <td colspan="10" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no gyms  found!</td>
              </tr>
              <?php }else{
					for($j=0;$j<count($result);$j++){?>
              <tr bgcolor="<?=$j%2==0?$general_func->color2:$general_func->color1;?>">
                <td align="left" valign="middle" class="table_content-blue"><?=$result[$j]['name']?></td>
				<td align="left" valign="middle" class="table_content-blue"><?php
				
				echo $result[$j]['email_address'];
				
				echo $result[$j]['email_confirmed']==1?'<img src="images/tick.png">':'';
				?>
					
					
					
				</td>                
                <td  align="left" valign="middle" class="table_content-blue"><?=$result[$j]['area']?></td>
                <td  align="left" valign="middle" class="table_content-blue"><?=$result[$j]['street_address']?></td>            
                <td  align="left" valign="middle" class="table_content-blue"><?=$result[$j]['town']?></td>
                  <td  align="left" valign="middle" class="table_content-blue"><?php                  
                  if(trim($result[$j]['membership_start']) == NULL || trim($result[$j]['membership_end']) == NULL ){
                  	 if($result[$j]['membership_type'] == 1 )
					 	echo "Free";
					else if($result[$j]['membership_type'] == 2 )
					 	echo "Paid";
					else 
						echo "Not yet chosed";                  	
				  }else{				  	
					$time_now=time();
					$time_membership_end=strtotime($result[$j]['membership_end']);
					echo $time_membership_end > $time_now?'Paid':'Free';
				}	 
                                    ?></td>
                                    
                   <td  align="left" valign="middle" class="table_content-blue"> <input type="text" onclick="this.select();" name="sulg" value="<?=trim($result[$j]['seo_link'])?>"  class="form_inputbox" size="20" />  </td>                 
                <td  align="left" valign="middle" class="table_content-blue"><?=$general_func->show_status($result[$j]['status'])?></td>
                 <td  align="left" valign="middle" class="table_content-blue"><?=$general_func->display_date($result[$j]['last_login_date'],3)?></td>
                <td  align="center" valign="middle" class="table_content-blue">
                	<?php if(isset($_SESSION['access_permission']['gyms']['edit']) && intval($_SESSION['access_permission']['gyms']['edit'])==1){ ?>
                	<img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>gyms/gyms-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="EDIT" alt="EDIT" />
                	<?php } ?>
                	<!--&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>gyms/gyms-view.php?id=<?=$result[$j]['id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />-->
                	<?php  if(isset($_SESSION['access_permission']['gyms']['delete']) && intval($_SESSION['access_permission']['gyms']['delete'])==1){ ?>
                	&nbsp;&nbsp;&nbsp;&nbsp; <img src="images/delete.png" title="DELETE" alt="DELETE" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>','<?=$result[$j]['name']?>')" style="cursor:pointer;" />
                	<?php } ?>
                	 </td>
              </tr>
              <?php }
				}
			
			
	  		?>
              <tr>
                <td colspan="10" align="center" valign="middle" height="4"></td>
              </tr>
              <tr>
                <td colspan="10" align="center" valign="middle" height="30" class="table_content-blue"><?php 
		if ($total_count>$recperpage) {
		?>
                  <table width="795" height="20" border="0"  cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="295" align="left" valign="bottom" class="htext">&nbsp;Jump to page
                        <select name="in_page" style="width:45px;" onChange="javascript:location.href='<?php echo str_replace("&in_page=".$page,"",$url);?>&in_page='+this.value;">
                          <?php for($m=1; $m<=ceil($total_count/$recperpage); $m++) {?>
                          <option value="<?php echo $m;?>" <?php echo $page==$m?'selected':''; ?>><?php echo $m;?></option>
                          <?php }?>
                        </select>
                        of <?php echo ceil($total_count/$recperpage); ?> </td>
                      <td width="467" align="right" valign="bottom" class="htext"><?php echo " ".$showing." ".$prev." ".$next." &nbsp;";?></td>
                    </tr>
                  </table>
                  <!-- / show category -->
                  <?php  }?></td>
              </tr>
              <tr>
                <td colspan="10" align="center" valign="middle" height="30" class="table_content-blue"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
