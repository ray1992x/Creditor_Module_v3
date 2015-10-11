<?php 

require_once("../dhtmlx/connector_codebase/grid_connector.php");

$res3=mysql_connect("localhost","root","");
mysql_select_db("company"); 

session_start();

$CR_Code=strip_tags($_SESSION['PCR_Code']);


$conn3 = new GridConnector($res3,"MySQL");

$conn3->dynamic_loading(30); // limited the loading data details

if($CR_Code!=null)
{
$conn3->render_sql("Select * from `paydetailtable`  where  `CRCode`='$CR_Code'","id","CRCode,No,date,period,invoice_no,po_number,invoice_amount,paid_period,payment_amount,Remark");
}
else
{ 
$conn3->render_sql("Select * from `paydetailtable`  where  `CRCode`='0'","id","CRCode,No,date,period,invoice_no,po_number,invoice_amount,paid_period,payment_amount,Remark");
//$conn2->render_table("ivdetailtable","id","InvNumber,itemid,Description,UOM,Quantity,UnitPrice,ItemPrice"); //"table ","id" for table,"data column" for table
}
?>


