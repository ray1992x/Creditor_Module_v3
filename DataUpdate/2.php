 <!DOCTYPE html>
<?php

include("../DatabaseConnect.php");

$PO_Allocation = "";
$PO_Date = "";
$PO_Number = "";
$PO_Type = "";
$PO_Amount = "";
$query="INSERT INTO ivdetailtable (itemid) SELECT itemid FROM podetailtable";
$records = mysql_query($query) or die(mysql_error());	


?>