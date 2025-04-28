<?php
include_once("includes/configuration.php");

$type=trim($_REQUEST['type']);
$gym_id=intval($_REQUEST['gym_id']);
$trainer_id=intval($_REQUEST['trainer_id']);


if($type == "gym"){
	echo mysql_result(mysql_query("select seo_link from gyms where id=" . $gym_id . " limit 1"),0,0);	
}else{
	echo mysql_result(mysql_query("select seo_link from personal_trainers where id=" . $trainer_id . " limit 1"),0,0);	
}



