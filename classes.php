<?php 
include_once("includes/header.php");

$small="instructor/small/";
$original="instructor/";


if(isset($_GET['action']) && $_GET['action']=='delete'){	
	
	$sql="select photo_name from instructors where id=" . (int) $_REQUEST['id'] . " limit 1";
	$result=$db->fetch_all_array($sql);
	
	if(count($result) > 0){
		@unlink($small.$result[0]['photo_name']);
		@unlink($original.$result[0]['photo_name']);		
	}
		
	
	$db->query_delete("instructors","id='".$_REQUEST['id'] ."'");
	
	$_SESSION['user_message'] = "Your selected instructor deleted.";	   
	$general_func->header_redirect($general_func->site_url."instructors/");	
	
	
}
 
?>
<script language="JavaScript">

function validate_search(){
	if(!validate_text(document.frmsearch.cd,1,"Enter instructor name.")){
		return false;
	}
}

function del(id,name){
	var a=confirm("Are you sure, you want to delete instructors: '" + name +"'\nAnd all data related to it?")
    if (a){
    	location.href="<?=$_SERVER['PHP_SELF']?>?id="+id+"&action=delete";
    }  
} 
</script>			
<div class="main_container">
	<div class="main">
		<div class="text-content">
			<h1 style="float:left;">Instructors</h1>
            <div class="add_new_product_to_product_list"><a href="instructors-new/"><span></span>Add new class</a></div>
              
          	<?php          	
          	$sql="select id,name,description,photo_name,county,area,status  from instructors order by name ASc";
			$result=$db->fetch_all_array($sql);
			$total=count($result);
			for($j=0; $j<$total; $j++){ ?>			
			<div class="edit_product_list_row">
							
				<div class="edit_product_detail full_width_list_detail">
					<h4><a><?=$result[$j]['name']?></a></h4>
					<div class="edit_del_product"><div><a href="instructors-new/<?=$result[$j]['id']?>"><img src="images/edit_product_icon.png" /><span>Edit</span></a></div><div><a onclick="del('<?=$result[$j]['id']?>','<?=$result[$j]['name']?>')"><img src="images/del_product_icon.png" /><span>Delete</span></a></div></div>
					<div class="div_clear"></div>
					<h5>Description</h5>
					<p><?=substr($result[$j]['description'],0,100)?>...</p>
					<div class="edit_del_product_info">
						<ul>
							<li style="margin-top:5px;"><strong>Status</strong>: <?=$result[$j]['status']==1?'Active':'Inactive';?></li>
                            <li><div class="add_edit_schedule"><a><img src="images/schedule.png" />Add edit class schedule</a></div></li>
						</ul>
					</div>				
				</div>			
			</div>			
			<?php }	 ?>       
		</div>
	</div>
</div>
<?php include_once("includes/footer.php");?>