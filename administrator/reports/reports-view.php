<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";

    
 
$data=array();
$return_url=$_REQUEST['return_url'];


if(isset($_REQUEST['enter']) && $_REQUEST['enter']=="update_me"){
	$data['order_status']=$_REQUEST['order_status'];		
	$db->query_update("tbl_order_payment",$data,"order_id='".$_REQUEST['order_id'] ."'");
	$_SESSION['msg']="Order status successfully updated!";		
	$general_func->header_redirect($return_url);	
}	



if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){
	$sql_orders="select * from tbl_order_payment";
	$sql_orders .=" where order_id='" . $_REQUEST['order_id'] . "'  limit 1";	
	$result_orders=$db->fetch_all_array($sql_orders);  

	$button="Update";
}

?>

<style type="text/css">
.body_content-form table td{ background:#fff; }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg another_bg_color">Order Details :: P - 00<?=$result_orders[0]['order_id']?></td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
        <table width="883" border="0" align="left" cellpadding="4" cellspacing="0">
          <tr>
            <td colspan="4" height="5"></td>
          </tr>
           <tr>
           	<td width="41" align="left" valign="top"></td>
            <td colspan="3" height="30" class="body_content-form">
           <p class="txtOne" style="line-height: 23px;"><strong>Order Date:</strong> <?=date("D jS M, Y",strtotime($result_orders[0]['order_date']))?><br>
        <strong>Shipping Method:</strong> <?=$result_orders[0]['shipping_method']?><br>
        <strong>Order Amount:</strong> $<?=number_format($result_orders[0]['total_amount'],2)?><br>
          <strong>Order Status:</strong> <?=$general_func->order_status($result_orders[0]['order_status'])?></p>
          
          </td>
          </tr>
          
          <tr>
            <td width="41" align="left" valign="top"></td>
            <td width="384" align="left" valign="top"><table width="94%" border="0" cellspacing="0" cellpadding="8">
                 <tr>
                  <td width="36%" class="body_content-form"><u><strong>Billing Information</strong></u></td>
                  <td width="64%"></td>
                </tr>
                <tr>
                  <td width="36%" class="body_content-form"><strong>Name:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_billing_fname']." ".$result_orders[0]['checkout_billing_lname']?></td>
                </tr>
             
                <tr>
                  <td width="36%" class="body_content-form"><strong>Email Address:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_billing_email']?></td>
                </tr>
               
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Phone:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_billing_phone']?></td>
                </tr>
                 
                </tr>
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Address 1:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_billing_address1']?></td>
                </tr>
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Address 2:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_billing_address2']?></td>
                </tr>
                 <tr>
                  <td class="body_content-form"><strong>City:</strong></td>
                  <td ><?=$result_orders[0]['checkout_billing_city']?></td>
                </tr>
                 <tr>
                  <td  class="body_content-form"><strong>State:</strong></td>
                  <td ><?=$result_orders[0]['checkout_billing_state']?></td>
                </tr>
                 <tr>
                  <td  class="body_content-form"><strong>Zip:</strong></td>
                  <td ><?=$result_orders[0]['checkout_billing_zip']?></td>
                </tr>
                
                                
                 
              </table></td>
            <td width="1" align="left" valign="top">&nbsp;</td>
            <td width="429" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="8">
                <tr>
                  <td width="36%" class="body_content-form"><u><strong>Shipping Information</strong></u></td>
                  <td width="64%"></td>
                </tr>
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Name:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_delivery_fname']." ".$result_orders[0]['checkout_delivery_lname']?></td>
                </tr>        
               
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Shipping Phone:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_delivery_phone']?></td>
                </tr>
                 
                </tr>
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Shipping Address 1:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_delivery_address1']?></td>
                </tr>
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Shipping Address 2:</strong></td>
                  <td width="64%"><?=$result_orders[0]['checkout_delivery_address2']?></td>
                </tr>
                 <tr>
                  <td class="body_content-form"><strong>Shipping City:</strong></td>
                  <td ><?=$result_orders[0]['checkout_delivery_city']?></td>
                </tr>
                 <tr>
                  <td  class="body_content-form"><strong>Shipping State:</strong></td>
                  <td ><?=$result_orders[0]['checkout_delivery_state']?></td>
                </tr>
                 <tr>
                  <td  class="body_content-form"><strong>Shipping Zip:</strong></td>
                  <td ><?=$result_orders[0]['checkout_delivery_zip']?></td>
                </tr>      
                
              </table></td>
          </tr>
          <tr><td height="20px;"></td></tr>
             <tr>
           	<td width="41" align="left" valign="top"></td>
            <td colspan="3" height="30" class="body_content-form">
            
            <table width="700" border="0" cellspacing="1" cellpadding="8" style="background:#dda9c2;">
            <tr>
                <td width="400">Product</th>
                <td width="100" style="text-align:center">Quantity</td>
                <td width="100" style="text-align:center">Unit Price</td>
                <td width="100" style="text-align:center">Amount</td>
            </tr>
                    
            <?php
            $order_total=0;
			$sql_cart="select * from tbl_order_cart";
			$sql_cart .=" where order_id='" . $_REQUEST['order_id'] . "' order by add_date ASC";	
			$result_cart=$db->fetch_all_array($sql_cart);   
			$total_cart=count($result_cart);	
            
              for($cart=0; $cart < $total_cart; $cart++ ){
              	$price=$result_cart[$cart]['price'];
				$amount= $price * $result_cart[$cart]['qty'];				
				 $order_total +=$amount;
              	?>
              	<tr>
	                <td><?=$result_cart[$cart]['product_details']?></td>
	                <td style="text-align:center"><?=$result_cart[$cart]['qty']?></td>
	                <td style="text-align:center">$ <?=number_format($price,2)?></td>
	                <td style="text-align:center">$ <?=number_format($amount,2)?></td>
            	</tr>
				<?php }
			
            ?>	
            <tr>
	             
	         
	                <td  colspan="3" align="right"><strong>Order Subtotal:</strong></td>
	                <td style="text-align:center">$ <?=number_format($order_total,2)?></td>
            	</tr>
            	 <tr>
	                           
	                <td  colspan="3" align="right"><strong>Shipping Subtotal:</strong></td>
	                <td style="text-align:center"> $<?=number_format($result_orders[0]['shipping_price'],2)?></td>
            	</tr>
            	 <tr>
	              
	               
	                <td  colspan="3" align="right"><strong>Grand Total:</strong></td>
	                <td style="text-align:center">$ <?=number_format($result_orders[0]['total_amount'],2)?></td>
            	</tr>
            
        </table>
         
            </td>	
          </tr>
          
          <form name="frmorder" action="<?=$_SERVER['PHP_SELF']?>" method="post" autocomplete="off">
         <input type="hidden" name="enter" value="update_me" />
         <input type="hidden" name="order_id" value="<?=$_REQUEST['order_id']?>" />
         <input type="hidden" name="return_url" value="<?=$_REQUEST['return_url']?>" />
      
        
           <tr><td height="20px;"></td></tr>
           
            <tr><td width="41" align="left" valign="top"></td>
            <td colspan="3" height="30" class="body_content-form">
            <table width="700" border="0" cellspacing="0" cellpadding="8">
            <tr>
                <td width="100">Status</th>
                <td width="600" style="text-align:left"><select name="order_status">
                	<option value="0" <?=$result_orders[0]['order_status']==0?'selected="selected"':'';?>>Processing</option>
                	<option value="1" <?=$result_orders[0]['order_status']==1?'selected="selected"':'';?>>Shipped</option>
                	<option value="2" <?=$result_orders[0]['order_status']==2?'selected="selected"':'';?>>Cancelled</option>
                </select></td>
                
            </tr>
            </table></tr>
         
          <tr>
            <td colspan="4" height="30" align="center"><table width="879" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="31%"><table border="0" align="right" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                        <td align="left" valign="middle" class="body_tab-middilebg"><input name="submit" type="submit" class="submit1" value="Update Status" /></td>
                        <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                      </tr>
                  </table></td>
                  <td width="10%"></td>
                  <td width="5%"><table border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="5" align="left" valign="top"><img src="images/button-curve-left.png" alt="" width="5" height="22" /></td>
                        <td align="left" valign="middle" class="body_tab-middilebg"><input name="back" onClick="location.href='<?=$return_url?>'"  type="button" class="submit1" value="Back" /></td>
                        <td width="5" align="right" valign="top"><img src="images/button-curve-right.png" alt="" width="5" height="22" /></td>
                      </tr>
                    </table></td>
                  <td width="40%"></td>
                </tr>
              </table></td>
          </tr>
          </form>
          <tr>
            <td colspan="4" height="30"></td>
          </tr>
        </table>
      </td>
  </tr>
</table>
<?php
include("../foot.htm");
?>
