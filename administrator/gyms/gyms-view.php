<?php
$path_depth="../../";

include_once("../head.htm");
$link_name = "Welcome";




$data=array();
$return_url=$_REQUEST['return_url'];


$small=$path_depth . "employer_photo/small/";
$medium=$path_depth . "employer_photo/medium/";
$original=$path_depth . "employer_photo/";



if(isset($_REQUEST['action']) && $_REQUEST['action']=="VIEW"){
	$sql="select e.*,state,sp.name as specialty";
	$sql .=" from employers e left join states s on e.state_id=s.state_id left join specialty sp on e.specialty_id=sp.id";
	$sql .=" where e.id = '" . $_REQUEST['id'] . "'";
		
	$result=$db->fetch_all_array($sql);
	
	$button="Update";
}


//print_r ($outfitter_videos);






?>
<script type="text/javascript" src="<?=$general_func->site_url?>highslide/highslide.js"></script>
<link rel="stylesheet" type="text/css" href="<?=$general_func->site_url?>highslide/highslide.css" />
<script type="text/javascript">
	hs.graphicsDir = '<?=$general_func->site_url?>highslide/graphics/';
	hs.wrapperClassName = 'wide-border';
</script>

<script type="text/javascript">
function show_big_image(val,total){
	for(var i=0; i<total; i++ ){
		if(i==val){
			 document.getElementById(i).style.display = 'block';
		}else{
			document.getElementById(i).style.display = 'none';
		}
	}
}

</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="top"><table border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" align="left" valign="top"><img src="images/tab-curve-left.jpg" alt="" width="6" height="29" /></td>
          <td align="left" valign="middle" class="body_tab-middilebg">View Employer</td>
          <td width="6" align="right" valign="top"><img src="images/tab-curve-right.jpg" alt="" width="6" height="29" /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="body_whitebg">
        <table width="989" border="0" align="left" cellpadding="4" cellspacing="0">
          <tr>
            <td colspan="4" height="30"></td>
          </tr>
          <tr>
            <td width="32" align="left" valign="top"></td>
            <td width="497" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="12">
                <tr>
                  <td width="26%" class="body_content-form"><strong>Name of hospital/organization:</strong></td>
                  <td width="74%"><?=$result[0]['name_of_hospital_organization']?></td>
                </tr>
                  <tr>
                  <td width="26%" class="body_content-form"><strong>Name of Physician Recruiter:</strong></td>
                  <td width="74%"><?=$result[0]['name_of_physician_recruiter']?></td>
                </tr>
                <tr>
                  <td width="26%" class="body_content-form"><strong>Email Address:</strong></td>
                  <td width="74%"><?=$result[0]['email_address']?></td>
                </tr>
               
                 <tr>
                  <td width="36%" class="body_content-form"><strong>Password:</strong></td>
                  <td width="64%"><?=$EncDec->decrypt_me($result[0]['password'])?></td>
                </tr>
               
              
                <tr>
                  <td width="26%" class="body_content-form"><strong>Location:</strong></td>
                  <td width="74%"><?=$result[0]['location']?></td>
                </tr>
                  <tr>
                  <td width="26%" class="body_content-form"><strong>Address of Hospital:</strong></td>
                  <td width="74%"><?=$result[0]['address']?></td>
                </tr>
               <tr>
                  <td width="26%" class="body_content-form"><strong>Specific medical needs sought:</strong></td>
                  <td width="74%"><?=$result[0]['specific_medical_needs_sought']?></td>
                </tr>
                  
                 <tr>
                  <td width="26%" class="body_content-form"><strong>Salary/Benefits/School Loan forgiveness:</strong></td>
                  <td width="74%"><?=$result[0]['school_loan_forgiveness']?></td>
                </tr>
                
               
                
                
              </table></td>
            <td width="1" align="left" valign="top">&nbsp;</td>
            <td width="507" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="12">
              <tr>
                  <td width="30%" class="body_content-form"><strong>Country:</strong></td>
                  <td width="70%"><?=$result[0]['country_iso']?></td>
                </tr>
                <tr>
                  <td  class="body_content-form"><strong>State:</strong></td>
                  <td ><?=$result[0]['state']?></td>
                </tr>
                <tr>
                  <td  class="body_content-form"><strong>City:</strong></td>
                  <td><?=$result[0]['city']?></td>
                </tr>
                <tr>
                  <td  class="body_content-form"><strong>Zip Code:</strong></td>
                  <td><?=$result[0]['zip_code']?></td>
                </tr>
                <tr>
                  <td class="body_content-form"><strong>Phone No:</strong></td>
                  <td ><?=$result[0]['phone_no']?></td>
                </tr>
                <tr>
                  <td  class="body_content-form"><strong>Specialty:</strong></td>
                  <td ><?=$result[0]['specialty']?></td>
                </tr>
                <tr>
                  <td  class="body_content-form"><strong>Others Specialty:</strong></td>
                  <td ><?=$result[0]['others_specialty']?></td>
                </tr>
                
                 
                <tr>
                  <td  class="body_content-form"><strong> Draft?:</strong></td>
                  <td><?=$general_func->show_draft($result[0]['save_as_draft'])?></td>
                </tr>
                
                <tr>
                  <td class="body_content-form"><strong> Status:</strong></td>
                  <td ><?=$general_func->show_status($result[0]['status'])?></td>
                </tr>
                <?php if(trim($result[0]['membership_start']) == NULL || trim($result[0]['membership_end']) == NULL ){ ?>
                <tr>
                  <td class="body_content-form"><strong> Membership Type:</strong></td>
                  <td >Free</td>
                </tr>
					
              <?php  }else{
              		$time_now=time();
					$time_membership_end=strtotime($result[0]['membership_end'])
				
				 ?>
				  <tr>
                  <td class="body_content-form"><strong> Membership Type:</strong></td>
                  <td><?=$time_membership_end > $time_now?'Paid':'Free';?></td>
                </tr>
				 
              	 <tr>
                  <td class="body_content-form"><strong> Membership Period:</strong></td>
                  <td><?=$general_func->display_date(trim($result[0]['membership_start']),9)?> - <?=$general_func->display_date(trim($result[0]['membership_end']),9)?></td>
                </tr>
				
              <?php } ?>
               
               
                
                
              </table></td>
          </tr>
          
         
          
           <tr>
            <td colspan="4" height="20"><table width="932" border="0" align="center" cellpadding="8" cellspacing="0">
                <tr>
                  <td width="147"  class="body_content-form" align="left" style="padding-left:23px;" valign="top"><strong>Specific information Regarding Physician Position:</strong></td>
                  <td width="753" valign="top"><?=$result[0]['why_consider_working_there']?></td>
                </tr>
              </table></td>
          </tr>
          
          <tr>
            <td colspan="4" height="20"><table width="932" border="0" align="center" cellpadding="8" cellspacing="0">
                <tr>
                  <td width="147"  class="body_content-form" align="left" style="padding-left:23px;" valign="top"><strong>Logo:</strong></td>
                  <td width="753" valign="top">  <?php if(trim($result[0]['logo_name']) != NULL){?>
                    <a href="<?=$general_func->site_url.substr($original,6).$result[0]['logo_name']?>" class="highslide" onclick="return hs.expand(this)"><img src="<?=$general_func->site_url.substr($small,6).$result[0]['logo_name']?>" border="0" /></a><?php }?></td>
                </tr>
              </table></td>
          </tr>
          
          <tr>
            <td colspan="4" height="20"><p>&nbsp;</p></td>
          </tr>
          <tr>
            <td colspan="4" height="30" align="center"><table width="879" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="31%"></td>
                  <td width="10%">&nbsp;</td>
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
