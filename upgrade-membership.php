<?php 
include_once("includes/header.php");

if(!isset($_SESSION['user_login']) || $_SESSION['user_login']!="yes"){
	$_SESSION['redirect_to_front_end']=basename($_SERVER['PHP_SELF']);
	$_SESSION['redirect_to_query_string']= $_SERVER['QUERY_STRING'];
		
	$_SESSION['user_message'] = "Please login to view this page!";	   
	$general_func->header_redirect($general_func->site_url);
}
?>			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1>Payment</h1>
            
            <!-- sep form -->
           
			<p>Card Holder's Details</p>
			 
			 <input type="hidden" name="enter" value="contactus"  />	
	        <ul class="contact-form column_form_container">
            <div class="column_form_row">
	          <li>
	            <label>First Name</label>
	            <input type="text" name="" value="" placeholder="Enter first name" />
	          </li>
	          <li>
	            <label>Last Name</label>
	            <input type="text" name="" value="" placeholder="Enter last name" />
	          </li>
              </div>
              <div class="column_form_row">
	          <li>
	            <label>Address</label>
	            <input type="text" name="" value="" placeholder="Enter address" />
	          </li>
	          <li>
	            <label>City</label>
	            <input type="text" name="" value="" placeholder="Enter city" />
	          </li>
              </div>
              
              <div class="column_form_row">
              
              <li>
	            <label>Country</label>
	            <div class="select_box">
                <select>
                <option>Select Country</option>
                </select>
                </div>
	          </li>
              
              <li>
	            <label>State</label>
	            <div class="select_box">
                <select>
                <option>Select State</option>
                </select>
                </div>
	          </li>
              </div>
              
              <div class="column_form_row">
              <li>
	            <label>Zipcode</label>
	            <input type="text" name="" value="" placeholder="Enter zipcode" />
	          </li>
              
              <li>
	            <label>Phone No.</label>
	            <input type="text" name="" value="" placeholder="Enter phone No." />
	          </li>
              </div>
  
	        </ul>
	  	
   
          <!-- sep form -->
          
          <p>Subscription Details</p>
          <ul class="contact-form column_form_container">            
            <div class="column_form_row">            
            <li>
	            <label>Choos Subscription Type</label>
	            <div class="select_box">
                <select>
                <option>Subscription Type</option>
                <?php
              	$plan_for=$_SESSION['user_type']=="gym"?1:2;	
               
                $sql="select type,type_value,amount from membership_plans where plan_for=$plan_for order by  type ASC,type_value ASC";
                $result=$db->fetch_all_array($sql);			
				$total=count($result);
				
				for($i=0; $i < $total;  $i++  ){ ?>
					<option value="">&euro; <?=$result[$i]['amount']?> for <?=$result[$i]['type_value']?> <?=$result[$i]['type']==1?'Month':'Year';?></option>
					
				<?php } ?>
                
                </select>
                </div>
	          </li>
              </div>
              </ul>
          
          <!-- sep form -->
   
			<p>Credit Card Details</p>
			 
			 <input type="hidden" name="enter" value="contactus"  />	
	        <ul class="contact-form column_form_container">
            
            <div class="column_form_row">
            
            <li>
	            <label>Card Type</label>
	            <div class="select_box">
                <select>
                <option>Select Card Type</option>
                </select>
                </div>
	          </li>
            
            <li>
	            <label>Credit card Number</label>
	            <input type="text" name="" value="" placeholder="Enter Credit card Number" />
	          </li>
              
              
               
              </div>
	
              
              <div class="column_form_row">
              
              
               <li>
	            <label>Expiray Date</label>
	            <div class="select_box mini_general_select_box">
                <select>
                <option>Month</option>
                </select>
                </div>
                <div class="select_box mini_general_select_box" style="float:right; margin-right:1px;">
                <select>
                <option>Year</option>
                </select>
                </div>
	          </li>
              
              
              <li>
	            <label>CVV Number</label>
	            <input type="text" name="" value="" placeholder="Enter CVV Number" />
                <img src="images/cvv.png" style="position:absolute; bottom:15px; right:15px;" />
	          </li>

              
              </div>
              
              
              
             
          
              
	          <li style="background:none;">
	            <!-- <input type="submit" value="Make Payment" /> -->
	            
	            <p style="color: #FF0000; font-size: 18px;">Realex payment option will be implemented here!</p>
	          </li>
	        </ul>
	   	
    
          <!-- sep form -->
          
          						      
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>