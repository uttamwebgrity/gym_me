<?php
session_start();
error_reporting(0);
/*header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Length: " . strlen($_SESSION['print_doc_name']));
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$_SESSION['print_doc_name']);*/

header('Content-type: application/csv');
header("Content-Disposition: attachment; filename=".$_SESSION['print_doc_name']);
  
echo $_SESSION['print_doc'];
exit; 
?>
