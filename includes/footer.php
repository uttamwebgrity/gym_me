<?php if(isset($_SESSION['user_message']) && trim($_SESSION['user_message']) != NULL){ ?>
	<div class="msg_pop_container">
<div class="msg_pop">
<div class="msg_pop_block">
<?=$_SESSION['user_message']?>
<div class="div_clear"></div>
<div class="exit_msg_cross">Ok</div>
</div>
</div>
</div>
<?php 
$_SESSION['user_message']="";
unset($_SESSION['user_message']);

}	?>


<!-- footer -->
<div class="footer">
      <div class="main_container">
    <div class="main"> 
          
          <!-- nav -->
          <div class="footer_nav">
        <div class="footer_block">
              <ul>
              	<li><a  href="<?=$general_func->site_url?>">Home</a></li>              	
           <?php
			$sql_footer_menu="select id,seo_link,page_heading,page_name,page_target,link_path from static_pages where parent_id=0 and page_position LIKE '%4%' order by display_order + 0 ASC";
			$result_footer_menu=$db->fetch_all_array($sql_footer_menu);
			$total_footer_menu=count($result_footer_menu);
			
			$first_menu=floor($total_footer_menu /2);
						
			for($footer=0; $footer < $first_menu; $footer++ ){
				$target=intval(trim($result_footer_menu[$footer]['page_target']))==2?'_blank':'_self';
							
				if(strlen(trim($result_footer_menu[$footer]['link_path'])) > 10){
					$link_path=trim($result_footer_menu[$footer]['link_path']);
				}else{
					$link_path=trim($result_footer_menu[$footer]['seo_link'])."/";								
				}
				?>
				<li><a  target="<?=$target?>" href="<?=$link_path?>"><?=trim($result_footer_menu[$footer]['page_heading'])?></a></li>
		<?php } ?>
          </ul>
            </div>
        <div class="footer_block">
              <ul>
            <?php
       	for($footer=$first_menu; $footer < $total_footer_menu; $footer++ ){
			$target=intval(trim($result_footer_menu[$footer]['page_target']))==2?'_blank':'_self';
							
			if(strlen(trim($result_footer_menu[$footer]['link_path'])) > 10){
				$link_path=trim($result_footer_menu[$footer]['link_path']);
			}else{
				$link_path=trim($result_footer_menu[$footer]['seo_link'])."/";									
			}
			?>
			<li><a  target="<?=$target?>" href="<?=$link_path?>"><?=trim($result_footer_menu[$footer]['page_heading'])?></a></li>
		<?php } ?>
          </ul>
            </div>
        <div class="footer_block">
              <h6>Follow us on</h6>
              <div class="footer_social"> <span>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td><a target="_blank" href="<?=$general_func->twitter?>"><img src="images/twitter.png" alt="Twitter" /></a></td>
                  </tr>
              </table>
                </span> <span>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td><a target="_blank"  href="<?=$general_func->facebook?>"><img src="images/facebook.png" alt="Facebook" /></a></td>
                  </tr>
                </table>
                </span> <span>
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                  <tr>
                    <td><a target="_blank"  href="<?=$general_func->youtube?>"><img src="images/youtube.png" alt="Youtube" /></a></td>
                  </tr>
                </table>
                </span> </div>
            </div>
      </div>      
          <div class="copy_right">Copyright gymme.ie All rights reserved</div>
        </div>
  </div>
    </div>

<?=$general_func->google_anylytic?>



</body>
</html>
