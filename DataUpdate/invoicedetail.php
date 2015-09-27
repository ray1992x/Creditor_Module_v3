<?php 

require_once("../dhtmlx/connector_codebase/grid_connector.php");

$res2=mysql_connect("localhost","root","");
mysql_select_db("company"); 

session_start();

$invno=strip_tags($_SESSION['invnumber']);


$conn2 = new GridConnector($res2,"MySQL");

$conn2->dynamic_loading(30); // limited the loading data details

if($invno!=null)
{
$conn2->render_sql("Select * from `ivdetailtable`  where  `InvNumber`='$invno'","id","InvNumber,itemid,Description,UOM,Quantity,UnitPrice,ItemPrice");
}
else
{ 
$conn2->render_sql("Select * from `ivdetailtable`  where  `InvNumber`='0'","id","InvNumber,itemid,Description,UOM,Quantity,UnitPrice,ItemPrice");
//$conn2->render_table("ivdetailtable","id","InvNumber,itemid,Description,UOM,Quantity,UnitPrice,ItemPrice"); //"table ","id" for table,"data column" for table

$conn->sql->attach("DELETE","DELETE * FROM `ivdetailtable` WHERE `itemid` = 0" );
}
?>