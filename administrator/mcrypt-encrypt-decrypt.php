<?php
//encrypt and decrypt
	/*private $_key="SADFo92jzVnzSj39IUYGvi6eL8v6RvJH8Cytuiouh547vCytdyUFl76R";

	public function encrypt_me($plaintext) {		
   		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_key, $plaintext, MCRYPT_MODE_ECB, $iv);
   		return $crypttext; 
	}
  
	public function decrypt_me($crypttext) { 
   		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_key, $crypttext, MCRYPT_MODE_ECB, $iv);
   		return trim($decrypttext); 
	}	*/
	
	//**************  valid IP *****************??
	

// if getenv results in something, proxy detected

/*if (getenv('HTTP_X_FORWARDED_FOR')) {
	$ip=getenv('HTTP_X_FORWARDED_FOR');
	//proxy dected
}else {
	$ip=getenv('REMOTE_ADDR');
	// real IP address
// print the IP address on screen


/*$license_key = 'LICENSE_KEY_HERE';
$ipaddress   = 'IP_ADDRESS_HERE';
$query = "https://minfraud.maxmind.com/app/ipauth_http?l=" . $license_key 
    . "&i=" . $ipaddress;
$score = file_get_contents($query);
echo $score;*/


//echo $ip;

//Detecting possible hacking attempts


//********* hacking detection *****************//
/*
&lt;?php
if(isset($_GET['input']))
{
$page = $_GET['input'];
$logfile = \"ip_log.txt\"; 
$file = fopen($logfile, 'a');
$ip = $_SERVER['REMOTE_ADDR']; //Get current IP
$curpage = $_SERVER['PHP_SELF']; //Get the page
$input = $_SERVER['QUERY_STRING']; //Get the query used
$writes = \"\nIP: \" . $ip . \"    Page: \" . $curpage . \"    Attempt: \" . $input;
if(strstr($page, '&lt;')) //Detect possible start of &lt;script&gt; or any other tag
 {
   fwrite($file, $writes); //Write IP,Page and attempt string
   fclose($file);
   die(\"Hacking attempt detected. IP logged\"); //Kill the script
 }
elseif(strstr($page, \"'\")) //Detect possible SQLi probe
 {
   fwrite($file, $writes);
   fclose($file);
   die(\"Hacking attempt detected. IP logged\");
 }
elseif(strstr($page, \"../\")) //Detect possible LFI's
 {
   fwrite($file, $writes);
   fclose($file);
   die(\"Hacking attempt detected. IP logged\");
 }
elseif(strstr($page, \"./\")) //Another possible LFI(Current directory transversal)
 {
   fwrite($file, $writes);
   fclose($file);
   die(\"Hacking attempt detected. IP logged\");
 }
elseif(strstr($page, \"http://\")) //Detect possible RFI
 {
   fwrite($file, $writes);
   fclose($file);
   die(\"Hacking attempt detected. IP logged\");
 }
elseif(strstr($page, \"https://\")) //Another possible RFI using secure HTTP
 {
   fwrite($file, $writes);
   fclose($file);
   die(\"Hacking attempt detected. IP logged\");
 }
else
 {
   echo $page;
 }
}
?&gt;
&lt;html&gt;
&lt;body&gt;
&lt;form name=\"input\" method=\"get\"&gt;
Text: &lt;input type=\"text\" name=\"input\" /&gt;
&lt;input type=\"submit\" value=\"Submit\" /&gt;
&lt;/form&gt; 
&lt;/body&gt;
&lt;/html&gt;
*/
//http://25yearsofprogramming.com/javascript/hackattemptidentifier.htm


//MYSQL : AES_ENCRYPT() and AES_DECRYPT() 

//PHP: mcrypt_ encrypt() and mcrypt_decrypt()




//http://dev.maxmind.com/proxy-detection/  

//http://forums.devshed.com/php-development-5/pgp-encryption-with-php-43362.html

//http://www.kelv.net/programming/pgp.php


echo base64_encode("21232f297a57a5a743894a0e4a801fc3");

?> 
	

