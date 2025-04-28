<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">Gyms Outbound Satistics</td>
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
              
            </table></td>
        </tr>
        <?php
				//**************************************************************************************//
				$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
				
				$recperpage=100;
				
				
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
					}else if(trim($_REQUEST['display_oder']) == "unique"){//***********status
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="count(DISTINCT user_ip) + 0 ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="count(DISTINCT user_ip) + 0 DESC";
						}
					}else if(trim($_REQUEST['display_oder']) == "total"){//***********status
						if(trim($_REQUEST['display_oder_type']) == "ASC"){
							$display_oder_type="DESC";
							$order_by .="count(*) + 0 ASC";
						}else{
							$display_oder_type="ASC";
							$order_by .="count(*) + 0 DESC";
						}			
						
					}else{
						$order_by .="count(*) + 0 DESC";
					} 
					 
				}else{
					$order_by .="count(*) + 0 DESC";
				}

												
				
				$sql="select name,seo_link,website_URL,count(*) as total_outbound, count(DISTINCT user_ip) as unique_outbound ";
  				$sql .=" from gyms_outbound go left join gyms g on go.gym_id=g.id where seo_link IS NOT NULL";
				$sql .=" group by seo_link ";
				$sql .=" order by $order_by";	
				
				
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
          <td align="left" valign="top"><table width="950" align="center" border="0" 
cellpadding="5" cellspacing="1">
              <tr>
                <td  class="text_numbering" colspan="4">&nbsp;</td>
              </tr> 
              <tr>
                <td width="205"  align="left" valign="middle" class="table_heading">
                <a href="gyms/gym-outbound-satistics.php?display_oder=name&display_oder_type=<?=$display_oder_type?>" class="header_link">Gym Name</a></td>
  				 <td width="300"  align="left" valign="middle" class="table_heading">Gym Link</td>
  				 <td width="270"  align="left" valign="middle" class="table_heading">Outbound website</td>  				 
  				 
                <td width="75"  align="left" valign="middle" class="table_heading">
                	 <a href="gyms/gym-outbound-satistics.php?display_oder=total&display_oder_type=<?=$display_oder_type?>" class="header_link">Total Outbound</a> </td>
                  <td width="75"  align="left" valign="middle" class="table_heading">
                  	 <a href="gyms/gym-outbound-satistics.php?display_oder=unique&display_oder_type=<?=$display_oder_type?>" class="header_link">Unique Outbound</a></td>                
              </tr>
              <?php if(count($result) == 0){?>
              <tr>
                <td colspan="5" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">No link has been visited yet!</td>
              </tr>
              <?php }else{
					for($j=0;$j<count($result);$j++){?>
              <tr bgcolor="<?=$j%2==0?$general_func->color2:$general_func->color1;?>">
                <td align="left" valign="middle" class="table_content-blue"><?=$result[$j]['name']?></td>
				<td align="left" valign="middle" class="table_content-blue"><?=$general_func->site_url."gym/".$result[$j]['seo_link']?></td>                
                 <td align="left" valign="middle" class="table_content-blue"><?=$result[$j]['website_URL']?></td>
                <td  align="center" valign="middle" class="table_content-blue"><?=$result[$j]['total_outbound']?></td>
                <td  align="center" valign="middle" class="table_content-blue"><?=$result[$j]['unique_outbound']?></td>                 
              </tr>
              <?php }
				}
			
			
	  		?>
              <tr>
                <td colspan="5" align="center" valign="middle" height="4"></td>
              </tr>
              <tr>
                <td colspan="5" align="center" valign="middle" height="30" class="table_content-blue"><?php 
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
                <td colspan="5" align="center" valign="middle" height="30" class="table_content-blue"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
