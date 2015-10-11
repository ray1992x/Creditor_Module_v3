<?php
$link=mysql_connect("localhost","root","");
  $database='company';              // it is Database name that you created
  if (!$link)
  die('Failed to connect to Server'.mysql_error());
  $db=mysql_select_db($database, $link);
  session_start();
  if(!$db)
  die('Failed to select Data Base '.mysql_error());

date_default_timezone_set('Asia/Kuching');

function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

function endsWith($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
} 

function bankName($bankcode){
	$bankname;
	if (startsWith($bankcode,'RHB')){
		$bankname = "RHB Bank Bhd.";
	}else if (startsWith($bankcode,'HLB')){
		$bankname = "Hong Leong Bank Bhd.";
	}else if (startsWith($bankcode,'MB')){
		$bankname = "Malayan Banking Bhd.";
	}else
		$bankname = "";
	return $bankname;	
}   
?>