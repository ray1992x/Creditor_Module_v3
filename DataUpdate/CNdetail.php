<?php 

require_once("../dhtmlx/connector_codebase/grid_connector.php");

$res1=mysql_connect("localhost","root","");
mysql_select_db("company"); 
session_start();

$crno=strip_tags($_SESSION['CRNoteNo']);


$conn1 = new GridConnector($res1,"MySQL");

$conn1->dynamic_loading(30); // limited the loading data details

if($crno!=null)
{
$conn1->render_sql("Select * from `cndetailtable`  where  `CNnumber`=$crno","id","CNnumber,itemid,ReferenceNumber,Narrative,Amount");
}
else
{
$conn1->render_sql("Select * from `cndetailtable`  where  `CNnumber`='0'","id","CNnumber,itemid,ReferenceNumber,Narrative,Amount");
$conn->sql->attach("DELETE","DELETE * FROM `cndetailtable` WHERE `itemid` = 0" );

}
?>