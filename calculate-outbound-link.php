<?php
include_once("includes/configuration.php");

$type=intval($_REQUEST['type']);
$id=intval($_REQUEST['id']);

$data=array();

if($type == 2){
	$data['trainer_id']=$id;
	$data['user_ip']=$general_func->get_ip();
	$data['date_visited']='now()';			
	$db->query_insert("trainer_outbound",$data);	
}else{
	$data['gym_id']=$id;
	$data['user_ip']=$general_func->get_ip();
	$data['date_visited']='now()';			
	$db->query_insert("gyms_outbound",$data);
}

?>