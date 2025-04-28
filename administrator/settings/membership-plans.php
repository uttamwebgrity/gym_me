<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";


if(isset($_GET['action']) && $_GET['action']=='delete'){
	$db->query_delete("membership_plans","id='".$_REQUEST['id'] ."'");
	$_SESSION['msg']="Your selected membership plan deleted!";
	$general_func->header_redirect($_REQUEST['url']);
} 

?>
<script language="JavaScript">



function del(id,url){
	var a=confirm("Are you sure, you want to delete membership plan?")
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
          <td align="left" valign="middle" class="body_tab-middilebg">Membership Plans</td>
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
					if(trim($_REQUEST['display_oder']) == "type"){//***********name
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="type ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="type DESC";
						}
					}else if(trim($_REQUEST['display_oder']) == "amount"){//***********display_order
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="amount + 0 ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="amount + 0 DESC";
						}
					}else if(trim($_REQUEST['display_oder']) == "plan_for"){//***********display_order
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="plan_for + 0 ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="plan_for + 0 DESC";
						}	
					}else{
						$order_by .="plan_for ASC,type ASC";
					} 
					
				}else{
					$order_by .="plan_for ASC,type ASC";
				}


				
				
				$query="where 1";
				
				
				if(isset($_REQUEST['key']) && trim($_REQUEST['key']) != NULL)
					$query .=" and  name LIKE '" .$_REQUEST['key']. "%'";
				else if(isset($_REQUEST['enter']) && (int)$_REQUEST['enter']==3)
					$query .=" and  name LIKE '" .$_REQUEST['cd']. "%'";
				
				
				$sql="select * from membership_plans $query order by $order_by";
				
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
                	<?php if(isset($_SESSION['access_permission']['membership-plans']['add']) && intval($_SESSION['access_permission']['membership-plans']['add'])==1){ ?>
                	<table border="0"  cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                              <td align="left" valign="middle" class="body_tab-middilebg"><input name="button" type="button" class="submit1" value="Add New" onclick="location.href='<?=$general_func->admin_url?>settings/membership-plans-new.php'" /></td>
                              <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                            </tr>
                   </table>
                    <?php }else echo "&nbsp;";?>
                   </td>
                <td class="text_numbering" align="right" colspan="4"><?=$total_count?> membership plans found.</td>
              </tr>
              <tr>
                <td width="20%" align="left" valign="middle" bgcolor="#35619c" class="table_heading">
                <a href="settings/membership-plans.php?display_oder=plan_for&display_oder_type=<?=$display_oder_type?>" class="header_link">Subscription For</a>
                
                </td>
               
                <td width="20%" align="left" valign="middle" bgcolor="#35619c" class="table_heading">
                <a href="settings/membership-plans.php?display_oder=type&display_oder_type=<?=$display_oder_type?>" class="header_link">Subscription Type</a>
                
                </td>
                 <td width="20%" align="left" valign="middle" bgcolor="#35619c" class="table_heading">Subscription Value</td>
                <td width="25%" align="center" valign="middle" bgcolor="#35619c" class="table_heading">
                <a href="settings/membership-plans.php?display_oder=amount&display_oder_type=<?=$display_oder_type?>" class="header_link">Subscription Price</a></td>
                
                <td width="15%" align="center" valign="middle" bgcolor="#35619c" class="table_heading">Action</td>
              </tr>
			
			<?php if(count($result) == 0){?>
                	<tr>
                		<td colspan="5" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no membership plans added yet!</td>
              		</tr>
				<?php }else{
					for($j=0;$j<count($result);$j++){?>
                     <tr bgcolor="<?=$j%2==0?$general_func->color2:$general_func->color1;?>">
                     	 <td align="left" valign="middle" class="table_content-blue"><?=$result[$j]['plan_for']==1?'Gym':'Personal Trainer';?></td>
                        <td align="left" valign="middle" class="table_content-blue"><?=$result[$j]['type']==1?'Monthly':'Yearly';?></td>
                       <td align="center" valign="middle" class="table_content-blue"><?=$result[$j]['type_value']?> <?=$result[$j]['type']==1?'Month(s)':'Year(s)';?></td>
                        <td align="center" valign="middle" class="table_content-blue">$<?=$result[$j]['amount']?></td>
                       
                       <td  align="center" valign="middle" class="table_content-blue">
                       	<?php if(isset($_SESSION['access_permission']['membership-plans']['edit']) && intval($_SESSION['access_permission']['membership-plans']['edit'])==1){ ?>
                       	
                       <img src="images/edit.png" onclick="location.href='<?=$general_func->admin_url?>settings/membership-plans-new.php?id=<?=$result[$j]['id']?>&action=EDIT&return_url=<?=urlencode($url)?>'" style="cursor:pointer;" />
                       <?php }  if(isset($_SESSION['access_permission']['membership-plans']['delete']) && intval($_SESSION['access_permission']['membership-plans']['delete'])==1){ ?>
                       &nbsp;&nbsp;&nbsp;&nbsp; <img src="images/delete.png" onclick="del('<?=$result[$j]['id']?>','<?=urlencode($url)?>')" style="cursor:pointer;" />        
                       	<?php } ?>
                       
                         </td>
            </tr>
			<?php }
				}
	  		?>
            <tr>
                <td colspan="5" align="center" valign="middle" height="4"></td>
            </tr> 
              <tr>
                <td colspan="5" align="center" valign="middle" height="30" class="table_content-blue"></td>
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