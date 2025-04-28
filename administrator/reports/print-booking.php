<?php
include_once("../../includes/configuration.php");



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Order at <?=$general_func->site_title?></title>
</head>
<body onload="window.print(); window.close();"><?=mysql_result(mysql_query("select confirmation_email from  tbl_order_payment where order_id='" .$_REQUEST['order_id']. "'"),0,0)?>

</body>
</html>
</html>
