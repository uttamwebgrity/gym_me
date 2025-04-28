<?php
include_once("includes/configuration.php");

session_unset();
session_destroy();
session_start();

$_SESSION['user_message'] = "You have successfully logged out!";
header("location:" . $general_func->site_url);
exit();
?>
