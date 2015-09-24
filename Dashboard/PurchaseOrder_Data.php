<?php
$con = mysql_connect("localhost","root","");

if (!$con) {
  die('Could not connect: ' . mysql_error());
}

mysql_select_db("company", $con);
/*
$sth = mysql_query("SELECT Month FROM purchase WHERE Month ='April'");
$rows = array();
$rows['name'] = 'Date';
while($r = mysql_fetch_array($sth)) { MONTH(PODate)=4
    $rows['data'][] = $r['Month'];
}*/

$sth = mysql_query("SELECT SUM(POAmount) AS PSOAmount FROM purchase WHERE  POType = 'PSO'");
$rows1 = array();
$rows1['name'] = 'PSO';
while($r1 = mysql_fetch_array($sth)) {
    $rows1['data'][] = $r1['PSOAmount'];
}

$sth = mysql_query("SELECT POAmount FROM purchase WHERE POType = 'MSO'");
$rows2 = array();
$rows2['name'] = 'MSO';
while($r2 = mysql_fetch_array($sth)) {
    $rows2['data'][] = $r2['POAmount'];
}

$sth = mysql_query("SELECT POAmount FROM purchase WHERE POType = 'LPO'");
$rows3 = array();
$rows3['name'] = 'LPO';
while($r3 = mysql_fetch_array($sth)) {
    $rows3['data'][] = $r3['POAmount'];
}

$result = array();
//array_push($result,$rows);
array_push($result,$rows1);
array_push($result,$rows2);
array_push($result,$rows3);


print json_encode($result, JSON_NUMERIC_CHECK);

mysql_close($con);
?>
