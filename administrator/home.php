<?php
include_once("head.htm");
$link_name = "Welcome";


?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg another_bg_color">Dashboard</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <?php if(isset($_SESSION['message']) && trim($_SESSION['message']) != NULL){?>
                <tr>
                  <td height="67" align="center" valign="middle" class="loginpage_alert"><?=$_SESSION['message']?></td>
                </tr>
                <?php
		 $_SESSION['message']="";	
		 } ?>
              
              
              
              <tr>
                <td align="left" valign="top"><img src="images/spacer.gif" alt="" width="14" height="14" /></td>
              </tr>
             <tr>
                <td align="left" valign="top" style="padding-left:10px;"><table width="900" border="0" cellspacing="1" cellpadding="6">
                    <tr>
                      <td width="239"  valign="top"><table width="216" border="0" cellspacing="1" cellpadding="6" bgcolor="#000000">
                          <tr bgcolor="#FFFFFF">
                            <td colspan="2"><strong>Quick Access</strong></td>
                          </tr>
                           <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="<?=$general_func->site_url?>" target="_blank" class="htext">Main Website</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                        
                          <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="settings/index.php" class="htext">General Settings</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                          <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="settings/administrator.php" class="htext">Administrator Settings</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                          <!--  <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="employers/employers.php" class="htext">Employers</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                           <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="physicians/physicians.php" class="htext">Physicians</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                           <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="settings/administrator.php" class="htext">Jobs</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                           <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="settings/membership-plans.php" class="htext">Membership Plans</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                          <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="banners/banners.php" class="htext">Home Page Banners</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>
                           <tr  bgcolor="#FFFFFF">
                            <td width="140" ><a href="banners/inner-page-banners.php" class="htext">Inner page Banners</a></td>
                            <td width="49" align="center">&nbsp;</td>
                          </tr>-->
                          
                          
                        </table>
                        
                       
                        
                        
                        
                        </td>
                      <td width="101">&nbsp;</td>
                      <td width="520" valign="top"><table width="356" border="0" cellspacing="1" cellpadding="6" bgcolor="#000000">
                          <tr bgcolor="#FFFFFF">
                            <td colspan="2"><strong>Icon Listing</strong></td>
                          </tr>
                          <tr  bgcolor="#FFFFFF">
                            <td width="22" align="center"><img src="images/edit.png"  style="cursor:pointer;" title="Edit a Record" alt="Edit a Record" /></td>
                            <td width="307">Edit a Record</td>
                          </tr>
                          <tr  bgcolor="#FFFFFF">
                            <td width="22" align="center"><img src="images/delete.png" style="cursor:pointer;" title="Delete a Record" alt="Delete a Record" /> </td>
                            <td width="307">Delete a Record</td>
                          </tr>
                           <tr  bgcolor="#FFFFFF">
                            <td width="22" align="center"><img src="images/view-details.png"  style="cursor:pointer;"  title="View a Record" alt="View a Record" /> </td>
                            <td width="307">View a Record</td>
                          </tr>
                          <tr  bgcolor="#FFFFFF">
                            <td width="22" align="center"><img src="images/calander-icon.jpg"  style="cursor:pointer;"  title="Calender" alt="Calender" /> </td>
                            <td width="307">Calender</td>
                          </tr>
                         
                        </table>
                        <br/>
                          <?php if((int)$_SESSION['admin_access_level'] == 1){?>
                        <table width="356" border="0" cellspacing="1" cellpadding="6" bgcolor="#000000">
                          <tr bgcolor="#FFFFFF">
                            <td ><strong>Admin Latest Login History</strong></td>
                          </tr>
                           <tr  bgcolor="#FFFFFF"> 
                           		 <td width="307" style="line-height: 20px;">
                          <?php
                          $sql_login_history="select * from admin_login_hostory order by login_date_time DESC limit 10";	 
                          $result_login_history=$db->fetch_all_array($sql_login_history);
                          $total_login_history=count($result_login_history);
						  
						  for($j=0;$j<$total_login_history;$j++){?>					  	
						  	                          
                           Login on <?=date("jS M Y h:i A",strtotime($result_login_history[$j]['login_date_time']))?> from IP - <?=$result_login_history[$j]['login_ip']?>
						<br/> <?php  }	?>
                          </td>
                          </tr>
                        </table>
                        <?php }?>
                         <br/>
                        
                      
                        </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td height="40" align="left" valign="middle">
          	<script>
		
		$(document).ready(function(){
        var s1 = [2, 6, 7, 10,16,12];
        var s2 = [7, 5, 3, 2,3,12];
        var s3 = [7, 5, 3, 2,15,12];
         var s4 = [7, 5, 3, 2,15,12];
        var ticks = ['Webgrity', 'unknown', 'Sanjay', 'Uttam','Tuhin','sujay'];
         
        plot2 = $.jqplot('chart2', [s1, s2,s3,s4], {
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
     
        $('#chart2').bind('jqplotDataHighlight',
            function (ev, seriesIndex, pointIndex, data) {
                $('#info2').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
             
        $('#chart2').bind('jqplotDataUnhighlight',
            function (ev) {
                $('#info2').html('Nothing');
            }
        );
    });
	</script>	
	    <div id="chart2" style="margin-top:20px; margin-left:20px; width:728px; height:350px;"></div>
          	
          	
          </td>
        </tr>
        <tr>
          <td align="left" valign="top">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
include("foot.htm");
?>
