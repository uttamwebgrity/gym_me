<?php
ob_start();
session_start();
error_reporting(0);


require_once("classes/database.class.php");
require_once("classes/database.Gym_Bid.class.php.php");


require_once("classes/general.class.php");
require_once("classes/validator.class.php");
include_once("classes/encrypt-decrypt.class.php");


include_once("classes/upload.class.php");
include_once("classes/send_mail.class.php");
include_once("classes/pagination.php");



//**************************************************************************************************************//
$db = new Database(); //******************  Database class
$db_Gym_Bid = new Gym_Bid(); //******************  HAPPYINSTYLE Database class





$general_func = new General(); //********* General class
$validator = new Validator(); //********* General class
$EncDec = new EncryptDecrypt(); //********* EncryptDecrypt class
/*echo $encrypted = $EncDec->encrypt_me("admin");

echo "<br/>";
echo $decrypted = $EncDec->decrypt_me($encrypted);
exit();*/



$upload = new uploadclass();
$sendmail = new send_mail();


//**********************  General value *******************************************//
$sql_general="select option_name,option_value from tbl_options where admin_admin_id=1 and (option_name='site_title' or  option_name='admin_recoed_per_page' or option_name='front_end_recoed_per_page'";
$sql_general .=" or option_name='opening_time' or option_name='closing_time' or option_name='facebook' or option_name='twitter' or option_name='admin_commission_on_bid' or option_name='linkedin'  or option_name='mail_us'  or  option_name='address' or option_name='phone' or option_name='email'";
$sql_general .=" or option_name='gym_free'  or option_name='gym_paid' or option_name='trainer_free'  or option_name='trainer_paid' or option_name='testimonials'  or option_name='home_page_video' or option_name='home_page_listing'  or option_name='global_meta_title' or option_name='global_meta_keywords'  or option_name='global_meta_description')";
$result_general=$db->fetch_all_array($sql_general);
$total_options=count($result_general); 


if( $total_options > 0){
	for($i=0; $i <$total_options; $i++){
		$$result_general[$i]['option_name']=trim($result_general[$i]['option_value']);
	}
}

$general_func->site_title=$site_title; 

$general_func->site_url="http://". $_SERVER['HTTP_HOST'] ."/gym_me/website/";
$general_func->admin_url="http://". $_SERVER['HTTP_HOST'] ."/gym_me/website/administrator/";

/*$general_func->site_url="http://". $_SERVER['HTTP_HOST'] ."/";
$general_func->admin_url="http://". $_SERVER['HTTP_HOST'] ."/administrator/";*/

$general_func->record_per_page=20;

$general_func->admin_recoed_per_page=$admin_recoed_per_page;
$general_func->front_end_recoed_per_page=$front_end_recoed_per_page;
$general_func->home_page_listing=$home_page_listing;

$general_func->global_meta_title=$global_meta_title;
$general_func->global_meta_keywords=$global_meta_keywords;
$general_func->global_meta_description=$global_meta_description;


$general_func->address=$address;
$general_func->phone=$phone;
$general_func->email=$email;

$general_func->facebook=$facebook;
$general_func->twitter=$twitter;
$general_func->youtube=$linkedin;

$general_func->mail_us=$mail_us;


$general_func->google_anylytic=$testimonials;
$general_func->home_page_video=$home_page_video;
$general_func->admin_commission_on_payment=$admin_commission_on_bid;


$general_func->opening_time=$opening_time;
$general_func->closing_time=$closing_time;


$general_func->gym_free=$gym_free;
$general_func->gym_paid=$gym_paid;
$general_func->trainer_free=$trainer_free;
$general_func->trainer_paid=$trainer_paid;


date_default_timezone_set("Australia/Melbourne");
$today_date_time=date("Y-m-d H:i:s");
$today_date=date("Y-m-d");

$current_time_ms=time();
//********************************************************************//

$all_days_in_a_week=array();
$all_days_in_a_week[1]="Monday";
$all_days_in_a_week[2]="Tuesday";
$all_days_in_a_week[3]="Wednesday";
$all_days_in_a_week[4]="Thursday";
$all_days_in_a_week[5]="Friday";
$all_days_in_a_week[6]="Saturday";
$all_days_in_a_week[7]="Sunday";


$days_in_a_week=array();
$days_in_a_week['monday']=1;
$days_in_a_week['tuesday']=2;
$days_in_a_week['wednesday']=3;
$days_in_a_week['thursday']=4;
$days_in_a_week['friday']=5;
$days_in_a_week['saturday']=6;
$days_in_a_week['sunday']=7;




function pr($var){
	
	echo "<pre>"; print_r($var); echo "</pre>";
	
}

?>