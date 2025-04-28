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
          <td align="left" valign="middle" class="body_tab-middilebg another_bg_color">Orders </td>
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
                      <td align="center" valign="top"><table width="483" border="0" align="center" cellpadding="0" cellspacing="0">
                          <form name="frmsearch"  method="post" action="<?=$_SERVER['PHP_SELF']?>">
                    <input type="hidden" name="enter" value="3" />
                    <tr>
                      <td width="98" align="left" valign="middle" class="content_employee" style="padding-right: 5px;"><strong>Order  From:</strong></td>
                      <td width="89" align="left" valign="middle"><input type="text" readonly="readonly" name="checkin_date"  id="checkin_date" value="<?=$_REQUEST['checkin_date']?>"  class="inputbox_employee-listing" style="width:75px;"></td>
                      <td width="39" align="left" valign="middle"><a href="javascript:NewCssCal('checkin_date','mmddyyyy')"><img src="images/calander-icon.jpg"  style="vertical-align:bottom;" alt="" width="27" height="23" border="0"  /></a></td>
                      <td width="44" align="right" valign="middle"  class="htext"><strong>To: </strong>&nbsp;&nbsp;</td>
                      <td width="87" align="left" valign="middle"><input type="text" readonly="readonly" name="checkout_date"  id="checkout_date" value="<?=$_REQUEST['checkout_date']?>"  class="inputbox_employee-listing"  style="width:75px;"></td>
                      <td width="47" align="left" valign="middle"><a href="javascript:NewCssCal('checkout_date','mmddyyyy')"><img src="images/calander-icon.jpg"  style="vertical-align:bottom;" alt="" width="27" height="23" border="0"  /></a></td>
                        <td width="79" align="left" valign="middle" class="body_tab-middilebg"><input name="checkout2" type="submit" class="submit1" value="Search" /></td>
                    </tr>
                  </form>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <?php
				//**************************************************************************************//
				$url=$_SERVER['PHP_SELF']."?".(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:'cc=cc');
				
				$query="where 1 ";
								
				if(isset($_REQUEST['checkin_date']) &&  trim($_REQUEST['checkin_date']) != NULL )
					$query .=" and DATE(order_date) >= '" . $general_func->display_date($_REQUEST['checkin_date'],6) . "'";	
			
				if(isset($_REQUEST['checkout_date']) &&  trim($_REQUEST['checkout_date']) != NULL )
					$query .=" and DATE(order_date) <= '" .$general_func->display_date($_REQUEST['checkout_date'],6) . "'";	
				
									
				$sql="select order_id,total_amount,order_status,shipping_method,DATE_FORMAT(order_date,'%a %b, %Y') as order_date,checkout_billing_email,checkout_billing_fname,checkout_billing_lname from tbl_order_payment";
				$sql .="  $query order by order_id + 0 DESC";	
				
								
				$total_count=$db->num_rows($sql);
				
				$result=$db->fetch_all_array($sql);
			//*******************************************************************************************************************//
			?>
        <tr>
          <td align="left" valign="top"><table width="800" align="center" border="0" 
cellpadding="5" cellspacing="1">
             
             <tr>
                <td colspan="14"  height="10">&nbsp;</td>
              </tr>
                     
              <tr>
                <td width="100"  align="left" valign="middle" class="table_heading">Order No.</td>               
                <td width="175"  align="left" valign="middle" class="table_heading">Customer Name</td>
                <td width="150"  align="left" valign="middle" class="table_heading">Customer Email</td>
                <td width="100"  align="left" valign="middle" class="table_heading">Order Amount</td>             
               <td width="100"  align="left" valign="middle" class="table_heading">Order Date</td>
               <td width="75"  align="center" valign="middle" class="table_heading">Status</td>               
                <td width="100"  align="center" valign="middle" class="table_heading">Action</td>
              </tr>
              <?php if($total_count == 0){?>
              <tr>
                <td colspan="7" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no orders found!</td>
              </tr>
              <?php }else{
					for($j=0;$j<$total_count;$j++){
						$line = '';
						?>
              <tr bgcolor="<?=$j%2==0?$general_func->color2:$general_func->color1;?>">
                <td align="left" valign="middle" class="table_content-blue">P - 00<?php echo $result[$j]['order_id']; ?></td>
               <td align="left" valign="middle" class="table_content-blue"><?php
               echo $result[$j]['checkout_billing_fname'] . " ".$result[$j]['checkout_billing_lname'];?></td>
               <td align="left" valign="middle" class="table_content-blue"><?=$result[$j]['checkout_billing_email']?></td>
                <td  align="left" valign="middle" class="table_content-blue">$<?php
                echo $result[$j]['total_amount'];?></td> 
                <td  align="left" valign="middle" class="table_content-blue"><?php 
                echo $result[$j]['order_date']; ?></td>
                 <td  align="center" valign="middle" class="table_content-blue"><?=$general_func->order_status($result[$j]['order_status'])?>
				</td>                
                 
                <td  align="center" valign="middle" class="table_content-blue">
                	<img src="images/view-details.png" onclick="location.href='<?=$general_func->admin_url?>reports/reports-view.php?order_id=<?=$result[$j]['order_id']?>&action=VIEW&return_url=<?=urlencode($url)?>'" style="cursor:pointer;"  title="VIEW" alt="VIEW" />&nbsp;&nbsp;&nbsp;
                	&nbsp;&nbsp;<a href="<?=$general_func->admin_url?>reports/print-booking.php?order_id=<?=$result[$j]['order_id']?>" target="_blank"><img src="images/printer.png" style="cursor:pointer;" border="0"  title="PRINT" alt="PRINT" /></a></td>
              </tr>
            	
			<?php
			}

			}
	  		?>
              <tr>
                <td colspan="14" align="center" valign="middle" height="18"></td>
              </tr>              
          </table></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
