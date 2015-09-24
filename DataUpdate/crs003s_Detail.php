<?php 

require_once("../dhtmlx/connector_codebase/grid_connector.php");

$res=mysql_connect("localhost","root","");
mysql_select_db("company"); 

session_start();

$potemp=strip_tags($_SESSION['number']);


$conn = new GridConnector($res,"MySQL");

$conn->dynamic_loading(30); // limited the loading data details

if($potemp!=null)
{

//$conn->sql->attach("INSERT","INSERT into `podetailtable` (`POtemp`) VALUES ($potemp)"); 
//$po_i=$_SESSION['i']+=intval(1));
//$conn->sql->attach("INSERT","INSERT into `podetailtable` (`itemid`,`POtemp`) VALUES ($po_i,$potemp)"); //each ponumber insert into the item dfor reference

$conn->render_sql("Select * from `podetailtable`  where  `POtemp`='$potemp'","id","POtemp,itemid,Description,booktitle,author,price");

}
else
{
//session_destroy();
$conn->render_sql("Select * from `podetailtable`  where  `POtemp`='0'","id","POtemp,itemid,Description,booktitle,author,price");//set default=-1
//$conn->render_table("podetailtable","id","POtemp,itemid,booktitle,author,price"); //"table ","id" for table,"data column" for table

$conn->sql->attach("DELETE","DELETE * FROM `podetailtable` WHERE `itemid` = 0" );
}
 
 
 
?>